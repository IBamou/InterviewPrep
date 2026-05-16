<?php

use App\Models\Concept;
use App\Models\Domain;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['onboarding_completed' => true]);
});

it('has working archives link in concept create page', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'PHP',
    ]);

    $response = $this->actingAs($this->user)->get(route('concepts.create', $domain));

    $response->assertStatus(200);
    $response->assertSee(route('domains.archives', absolute: false));
});

it('has working archives link in concept show page', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'Laravel',
    ]);

    $concept = Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Eloquent',
        'explanation' => 'ORM explanation',
        'status' => 'to_review',
    ]);

    $response = $this->actingAs($this->user)->get(route('concepts.show', $concept));

    $response->assertStatus(200);
    $response->assertSee(route('domains.archives', absolute: false));
});

it('has working archives link in concept edit page', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'MySQL',
    ]);

    $concept = Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Indexing',
        'explanation' => 'DB indexing',
        'status' => 'in_progress',
    ]);

    $response = $this->actingAs($this->user)->get(route('concepts.edit', $concept));

    $response->assertStatus(200);
    $response->assertSee(route('domains.archives', absolute: false));
});

it('show page displays concepts count without triggering extra query', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'Redis',
    ]);

    $concept = Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Caching',
        'explanation' => 'Cache strategies',
        'status' => 'to_review',
    ]);

    Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Persistence',
        'explanation' => 'Redis persistence',
        'status' => 'mastered',
    ]);

    $response = $this->actingAs($this->user)->get(route('concepts.show', $concept));

    $response->assertStatus(200);

    $response->assertSee('2 concepts');
});

it('edit page loads domain without error', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'Docker',
    ]);

    $concept = Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Containers',
        'explanation' => 'Container explanation',
        'status' => 'to_review',
    ]);

    $response = $this->actingAs($this->user)->get(route('concepts.edit', $concept));

    $response->assertStatus(200);
    $response->assertSee($domain->name);
});
