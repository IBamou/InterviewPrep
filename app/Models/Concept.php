<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concept extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['domain_id', 'title', 'explanation', 'status', 'xp', 'unlocked_tiers', 'mastery_score', 'practice_sessions', 'practice_sets_completed', 'total_rating_sum', 'tier_xp', 'tier_ratings', 'practice_streak', 'streak_milestones'];

    protected static function booted(): void
    {
        static::deleting(function (Concept $concept) {
            $concept->generatedQuestions()->delete();
        });
    }

    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = ucfirst(trim($value));
    }

    protected $casts = [
        'status' => Status::class,
        'mastery_score' => 'decimal:2',
        'practice_sessions' => 'array',
        'unlocked_tiers' => 'array',
        'xp' => 'integer',
        'practice_sets_completed' => 'integer',
        'total_rating_sum' => 'decimal:2',
        'tier_xp' => 'array',
        'tier_ratings' => 'array',
        'practice_streak' => 'array',
        'streak_milestones' => 'array',
    ];

    public function getTierXp(string $tier): int
    {
        $tierXp = $this->tier_xp ?? config('gamification.default_tier_xp');
        return $tierXp[$tier] ?? 0;
    }

    public function getTierAvgRating(string $tier): float
    {
        $tierRatings = $this->tier_ratings ?? config('gamification.default_tier_ratings');
        $data = $tierRatings[$tier] ?? ['sum' => 0, 'count' => 0];
        return $data['count'] > 0 ? round($data['sum'] / $data['count'], 1) : 0;
    }

    public function getGlobalAvgRating(): float
    {
        $tierRatings = $this->tier_ratings ?? config('gamification.default_tier_ratings');
        $totalSum = 0;
        $totalCount = 0;
        foreach ($tierRatings as $data) {
            $totalSum += $data['sum'] ?? 0;
            $totalCount += $data['count'] ?? 0;
        }
        return $totalCount > 0 ? round($totalSum / $totalCount, 1) : 0;
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function generatedQuestions(): HasMany
    {
        return $this->hasMany(GeneratedQuestion::class);
    }

    public function hasTierUnlocked(string $tier): bool
    {
        return in_array($tier, $this->unlocked_tiers ?? ['junior']);
    }

    public function getHighestUnlockedTier(): string
    {
        $tiers = $this->unlocked_tiers ?? ['junior'];
        if (in_array('senior', $tiers)) return 'senior';
        if (in_array('mid', $tiers)) return 'mid';
        return 'junior';
    }

    public function getEvaluatedSetCount(): int
    {
        return $this->generatedQuestions()
            ->whereNotNull('rating')
            ->distinct('set_number')
            ->count('set_number');
    }

    public function isQuizReady(): bool
    {
        $reqs = config('quiz.requirements', []);
        $hasExplanation = !($reqs['requires_explanation'] ?? true) || !empty(trim($this->explanation ?? ''));
        $evaluatedSets = $this->getEvaluatedSetCount();
        $avgRating = $this->getGlobalAvgRating();
        return $hasExplanation && $evaluatedSets >= ($reqs['min_evaluated_sets'] ?? 1) && $avgRating >= ($reqs['min_avg_rating'] ?? 2.5);
    }

    public function getQuizStatus(): string
    {
        $reqs = config('quiz.requirements', []);
        if (($reqs['requires_explanation'] ?? true) && empty(trim($this->explanation ?? ''))) return 'locked';
        if ($this->getEvaluatedSetCount() < ($reqs['min_evaluated_sets'] ?? 1)) return 'needs_practice';
        if ($this->getGlobalAvgRating() < ($reqs['min_avg_rating'] ?? 2.5)) return 'needs_improvement';
        return 'ready';
    }

    public function getQuizMessage(): string
    {
        $reqs = config('quiz.requirements', []);
        $minSets = $reqs['min_evaluated_sets'] ?? 1;
        $minRating = $reqs['min_avg_rating'] ?? 2.5;
        return match ($this->getQuizStatus()) {
            'locked' => 'Write an explanation first',
            'needs_practice' => 'Complete at least ' . $minSets . ' practice set' . ($minSets > 1 ? 's' : ''),
            'needs_improvement' => 'Average rating needs to be &ge; ' . $minRating . ' (currently ' . $this->getGlobalAvgRating() . ')',
            'ready' => 'Ready for quiz',
        };
    }
}
