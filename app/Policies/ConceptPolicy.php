<?php

namespace App\Policies;

use App\Models\Concept;
use App\Models\User;

class ConceptPolicy
{
    public function view(User $user, Concept $concept): bool
    {
        return $concept->domain()->where('user_id', $user->id)->exists();
    }

    public function update(User $user, Concept $concept): bool
    {
        return $concept->domain()->where('user_id', $user->id)->exists();
    }

    public function delete(User $user, Concept $concept): bool
    {
        return $concept->domain()->where('user_id', $user->id)->exists();
    }

    public function restore(User $user, Concept $concept): bool
    {
        return $concept->domain()->where('user_id', $user->id)->exists();
    }

    public function forceDelete(User $user, Concept $concept): bool
    {
        return $concept->domain()->where('user_id', $user->id)->exists();
    }
}