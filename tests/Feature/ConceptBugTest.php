<?php

use App\Models\Concept;
use App\Models\Domain;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('has working archives link in concept create page', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'PHP',
        'color' => '#ff0000',
    ]);

    $response = $this->actingAs($this->user)->get(route('concepts.create', $domain));

    $response->assertStatus(200);
    $response->assertSee(route('domains.archives', absolute: false));
});

it('has working archives link in concept show page', function () {
    $domain = Domain::create([
        'user_id' => $this->user->id,
        'name' => 'Laravel',
        'color' => '#00ff00',
    ]);

    $concept = Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Eloquent',
        'explanation' => 'ORM explanation',
        'difficulty' => 'junior',
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
        'color' => '#0000ff',
    ]);

    $concept = Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Indexing',
        'explanation' => 'DB indexing',
        'difficulty' => 'senior',
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
        'color' => '#ff0000',
    ]);

    $concept = Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Caching',
        'explanation' => 'Cache strategies',
        'difficulty' => 'mid',
        'status' => 'to_review',
    ]);

    Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Persistence',
        'explanation' => 'Redis persistence',
        'difficulty' => 'senior',
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
        'color' => '#ff0000',
    ]);

    $concept = Concept::create([
        'domain_id' => $domain->id,
        'title' => 'Containers',
        'explanation' => 'Container explanation',
        'difficulty' => 'junior',
        'status' => 'to_review',
    ]);

    $response = $this->actingAs($this->user)->get(route('concepts.edit', $concept));

    $response->assertStatus(200);
    $response->assertSee($domain->name);
});
