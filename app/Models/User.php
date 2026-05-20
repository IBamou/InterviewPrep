<?php

namespace App\Models;

use App\Enums\ExperienceLevel;
use App\Enums\InterviewGoal;
use App\Enums\Specialization;
use App\Enums\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

#[Fillable(['name', 'email', 'password', 'status', 'specialization', 'experience_years', 'tech_stack', 'interview_goal', 'onboarding_completed'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    protected static function booted(): void
    {
        static::deleting(function (User $user) {
            try {
                DB::beginTransaction();
                $domainIds = $user->domains()->pluck('id');
                $conceptIds = Concept::whereIn('domain_id', $domainIds)->pluck('id');
                GeneratedQuestion::whereIn('concept_id', $conceptIds)->delete();
                Concept::whereIn('domain_id', $domainIds)->delete();
                $user->domains()->delete();
                $user->quizzes()->delete();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tech_stack' => 'array',
            'onboarding_completed' => 'boolean',
            'status' => UserStatus::class,
            'specialization' => Specialization::class,
            'experience_years' => ExperienceLevel::class,
            'interview_goal' => InterviewGoal::class,
        ];
    }
}
