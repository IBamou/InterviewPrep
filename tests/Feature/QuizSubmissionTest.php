<?php

use App\Enums\QuizStatus;
use App\Enums\Status;
use App\Models\Concept;
use App\Models\Domain;
use App\Models\GeneratedQuestion;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['onboarding_completed' => true]);

    $this->domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'Test Domain',
    ]);

    $this->concept = Concept::create([
        'domain_id' => $this->domain->id,
        'title' => 'Test Concept',
        'explanation' => 'Test explanation for the concept.',
        'status' => Status::InProgress,
    ]);

    $this->quiz = $this->user->quizzes()->create([
        'domain_id' => $this->domain->id,
        'time_limit_minutes' => 10,
        'started_at' => now(),
        'status' => QuizStatus::InProgress,
        'passed' => false,
    ]);

    $this->q1 = $this->quiz->questions()->create([
        'concept_id' => $this->concept->id,
        'question' => 'What is PHP?',
        'sort_order' => 0,
    ]);

    $this->q2 = $this->quiz->questions()->create([
        'concept_id' => $this->concept->id,
        'question' => 'What is Laravel?',
        'sort_order' => 1,
    ]);
});

it('submits a quiz and redirects to results', function () {
    $response = $this->actingAs($this->user)->post(route('quizzes.submit', $this->quiz), [
        'answers' => [
            0 => 'PHP is a programming language.',
            1 => 'Laravel is a PHP framework.',
        ],
        'ratings' => [
            0 => 3,
            1 => 4,
        ],
    ]);

    $response->assertRedirect(route('quizzes.results', $this->quiz));

    $this->quiz->refresh();
    expect($this->quiz->status)->toBe(QuizStatus::Submitted);
    expect($this->quiz->passed)->toBeTrue();
    expect($this->quiz->total_score)->toBeGreaterThan(0);
    expect($this->quiz->submitted_at)->not->toBeNull();
});

it('redirects to results if quiz already submitted', function () {
    $this->quiz->update(['status' => QuizStatus::Submitted, 'passed' => true]);

    $response = $this->actingAs($this->user)->post(route('quizzes.submit', $this->quiz), [
        'answers' => [0 => '', 1 => ''],
        'ratings' => [0 => 3, 1 => 3],
    ]);

    $response->assertRedirect(route('quizzes.results', $this->quiz));
});

it('aborts if quiz belongs to another user', function () {
    $other = User::factory()->create();
    $otherQuiz = $other->quizzes()->create([
        'domain_id' => $this->domain->id,
        'time_limit_minutes' => 10,
        'started_at' => now(),
        'status' => QuizStatus::InProgress,
        'passed' => false,
    ]);

    $response = $this->actingAs($this->user)->post(route('quizzes.submit', $otherQuiz), [
        'answers' => [0 => '', 1 => ''],
        'ratings' => [0 => 3, 1 => 3],
    ]);

    $response->assertStatus(403);
});

it('validates answers as required', function () {
    $response = $this->actingAs($this->user)->post(route('quizzes.submit', $this->quiz), [], [
        'Accept' => 'application/json',
    ]);

    $response->assertSessionHasErrors(['answers', 'ratings']);
});

it('validates answer format', function () {
    $response = $this->actingAs($this->user)->post(route('quizzes.submit', $this->quiz), [
        'answers' => 'not-an-array',
        'ratings' => [0 => 3, 1 => 3],
    ], ['Accept' => 'application/json']);

    $response->assertSessionHasErrors(['answers']);
});

it('validates rating values', function () {
    $response = $this->actingAs($this->user)->post(route('quizzes.submit', $this->quiz), [
        'answers' => [0 => 'Answer 1', 1 => 'Answer 2'],
        'ratings' => [0 => 0, 1 => 6],
    ], ['Accept' => 'application/json']);

    $response->assertSessionHasErrors(['ratings.0', 'ratings.1']);
});

it('submits with partial answers', function () {
    $response = $this->actingAs($this->user)->post(route('quizzes.submit', $this->quiz), [
        'answers' => [0 => 'Only first answer'],
        'ratings' => [0 => 3, 1 => 3],
    ]);

    $response->assertRedirect(route('quizzes.results', $this->quiz));

    $this->quiz->refresh();
    expect($this->quiz->status)->toBe(QuizStatus::Submitted);
    expect($this->quiz->passed)->toBeTrue();

    $this->q1->refresh();
    expect($this->q1->answer)->toBe('Only first answer');

    $this->q2->refresh();
    expect($this->q2->answer)->toBe('');
});

it('EnsureNoActiveQuiz middleware does not block quizzes.submit route', function () {
    // Verify the quiz is active
    expect($this->quiz->fresh()->status)->toBe(QuizStatus::InProgress);
    expect($this->quiz->fresh()->passed)->toBeFalse();

    // Submit the quiz
    $response = $this->actingAs($this->user)->post(route('quizzes.submit', $this->quiz), [
        'answers' => [0 => 'Answer 1', 1 => 'Answer 2'],
        'ratings' => [0 => 3, 1 => 4],
    ]);

    $response->assertStatus(302);

    // Should redirect to results, not back to active quiz
    $response->assertRedirect(route('quizzes.results', $this->quiz));

    // Verify the results page loads (no middleware redirect)
    $resultsResponse = $this->actingAs($this->user)->get($response->headers->get('Location'));
    $resultsResponse->assertStatus(200);
});

it('accessing results after submission does not trigger middleware redirect', function () {
    // First, submit the quiz
    $this->actingAs($this->user)->post(route('quizzes.submit', $this->quiz), [
        'answers' => [0 => 'A', 1 => 'B'],
        'ratings' => [0 => 3, 1 => 4],
    ]);

    // Try accessing results again
    $response = $this->actingAs($this->user)->get(route('quizzes.results', $this->quiz));
    $response->assertStatus(200);

    // Try accessing dashboard
    $dashboardResponse = $this->actingAs($this->user)->get(route('dashboard'));
    $dashboardResponse->assertStatus(200);
});

it('EnsureNoActiveQuiz middleware does not block quizzes.active route', function () {
    session()->put('quiz_domain_' . $this->quiz->id, 'Test Domain');

    $response = $this->actingAs($this->user)->get(route('quizzes.active', [
        'domain' => $this->domain,
        'quiz' => $this->quiz,
    ]));

    $response->assertStatus(200);
});
