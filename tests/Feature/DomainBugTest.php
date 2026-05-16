<?php

use App\Models\Concept;
use App\Models\Domain;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('returns correct concepts_count and mastered_count in index', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'PHP',
    ]);

    Concept::create(['domain_id' => $domain->id, 'title' => 'C1', 'explanation' => 'E1', 'difficulty' => 'junior', 'status' => 'mastered']);
    Concept::create(['domain_id' => $domain->id, 'title' => 'C2', 'explanation' => 'E2', 'difficulty' => 'junior', 'status' => 'mastered']);
    Concept::create(['domain_id' => $domain->id, 'title' => 'C3', 'explanation' => 'E3', 'difficulty' => 'junior', 'status' => 'to_review']);

    $response = $this->actingAs($this->user)->get(route('domains.index'));

    $response->assertStatus(200);

    $domainFromView = $response->viewData('domains')->first();

    expect($domainFromView->concepts_count)->toBe(3)
        ->and($domainFromView->mastered_count)->toBe(2);
});

it('can restore a soft-deleted domain', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'Laravel',
    ]);

    $domain->delete();
    expect(Domain::count())->toBe(0);

    $response = $this->actingAs($this->user)->post(route('domains.restore', $domain));

    $response->assertRedirect(route('domains.archives'));
    expect(Domain::count())->toBe(1);
});

it('can force-delete a soft-deleted domain', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'MySQL',
    ]);

    $domain->delete();
    expect(Domain::count())->toBe(0);

    $response = $this->actingAs($this->user)->delete(route('domains.forceDelete', $domain));

    $response->assertRedirect(route('domains.archives'));
    expect(Domain::withTrashed()->count())->toBe(0);
});

it('hides create concept button when user has no domains', function () {
    $response = $this->actingAs($this->user)->get(route('domains.index'));

    $response->assertStatus(200);
    $response->assertDontSee('Create Concept');
});

it('shows create concept button when user has domains', function () {
    Domain::create([
        'user_id' => $this->user->id,
        'name' => 'Docker',
    ]);

    $response = $this->actingAs($this->user)->get(route('domains.index'));

    $response->assertStatus(200);
    $response->assertSee('Create Concept');
});

it('has working archives link in sidebar', function () {
    $response = $this->actingAs($this->user)->get(route('domains.index'));

    $response->assertStatus(200);
    $response->assertSee(route('domains.archives', absolute: false));
});

it('can restore a soft-deleted concept', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'Redis',
    ]);

    $concept = Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Caching',
        'explanation' => 'Cache strategies',
        'difficulty' => 'mid',
        'status' => 'to_review',
    ]);

    $concept->delete();
    expect(Concept::count())->toBe(0);

    $response = $this->actingAs($this->user)->post(route('concepts.restore', $concept));

    $response->assertStatus(302);
    expect(Concept::count())->toBe(1);
});

it('can force-delete a soft-deleted concept', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'PostgreSQL',
    ]);

    $concept = Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Indexing',
        'explanation' => 'DB indexing',
        'difficulty' => 'senior',
        'status' => 'in_progress',
    ]);

    $concept->delete();
    expect(Concept::count())->toBe(0);

    $response = $this->actingAs($this->user)->delete(route('concepts.forceDelete', $concept));

    $response->assertStatus(302);
    expect(Concept::withTrashed()->count())->toBe(0);
});
