<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Concept;
use App\Models\GeneratedQuestion;

class ProgressionService
{
    public function calculateXpForRating(int $rating): int
    {
        $map = config('gamification.xp_per_rating');
        return $map[$rating] ?? 0;
    }

    public function awardXp(Concept $concept, int $xp, string $tier): Concept
    {
        $tierXp = $concept->tier_xp ?? config('gamification.default_tier_xp');
        $tierXp[$tier] = ($tierXp[$tier] ?? 0) + $xp;
        $concept->update(['tier_xp' => $tierXp]);

        $totalXp = array_sum($tierXp);
        $concept->update(['xp' => $totalXp]);
        $concept->refresh();

        $this->checkTierUnlocks($concept);

        return $concept;
    }

    public function recordPracticeSet(Concept $concept, float $avgRating): Concept
    {
        $concept->increment('practice_sets_completed');
        $concept->increment('total_rating_sum', $avgRating);
        $concept->refresh();

        return $concept;
    }

    public function checkTierUnlocks(Concept $concept): Concept
    {
        $tiers = $concept->unlocked_tiers ?? ['junior'];
        $tierXp = $concept->tier_xp ?? config('gamification.default_tier_xp');
        $totalXp = array_sum($tierXp);
        $setsCompleted = $concept->practice_sets_completed;
        $globalAvg = $concept->getGlobalAvgRating();

        $minSets = config('gamification.min_practice_sets');
        $minAvg = config('gamification.min_avg_rating');
        $meetsRequirements = $setsCompleted >= $minSets && $globalAvg >= $minAvg;

        if ($meetsRequirements && $totalXp >= config('gamification.senior_unlock_xp') && !in_array('senior', $tiers)) {
            $tiers[] = 'senior';
            $concept->update([
                'unlocked_tiers' => $tiers,
                'practice_sets_completed' => 0,
            ]);
        } elseif ($meetsRequirements && $totalXp >= config('gamification.mid_unlock_xp') && !in_array('mid', $tiers)) {
            $tiers[] = 'mid';
            $concept->update([
                'unlocked_tiers' => $tiers,
                'practice_sets_completed' => 0,
            ]);
        }

        return $concept;
    }

    public function updateAutoStatus(Concept $concept): Concept
    {
        $sessions = $concept->practice_sessions ?? [];

        if (empty($sessions)) {
            $concept->update(['status' => Status::ToReview]);
            return $concept;
        }

        $concept->update(['status' => Status::InProgress]);

        $globalAvg = $concept->getGlobalAvgRating();
        $allTiersUnlocked = in_array('junior', $concept->unlocked_tiers ?? ['junior'])
            && in_array('mid', $concept->unlocked_tiers ?? [])
            && in_array('senior', $concept->unlocked_tiers ?? []);

        $tierXp = $concept->tier_xp ?? config('gamification.default_tier_xp');
        $seniorXp = $tierXp['senior'] ?? 0;

        $masteredAvg = config('gamification.mastered_avg_rating');
        $masteredSeniorXp = config('gamification.mastered_senior_xp');

        if ($globalAvg >= $masteredAvg && $allTiersUnlocked && $seniorXp >= $masteredSeniorXp) {
            $concept->update(['status' => Status::Mastered]);
        }

        return $concept;
    }

    public function calculateMasteryScore(Concept $concept): float
    {
        $sessions = $concept->practice_sessions ?? [];

        if (empty($sessions)) {
            return 0;
        }

        $weights = config('gamification.mastery_weights');
        $recentSessions = collect($sessions)->sortByDesc('date')->values();
        $weightedSum = 0;
        $totalWeight = 0;

        foreach ($recentSessions as $i => $session) {
            $weight = match (true) {
                $i < $weights['recent_count'] => $weights['recent_weight'],
                $i < $weights['normal_count'] => $weights['normal_weight'],
                default => $weights['stale_weight'],
            };
            $weightedSum += ($session['avg_rating'] ?? 0) * $weight;
            $totalWeight += $weight;
        }

        $weightedAvg = $totalWeight > 0 ? $weightedSum / $totalWeight : 0;

        return round(($weightedAvg / 5) * 100, 2);
    }

    public function getMasteryTier(float $score): array
    {
        $tiers = [
            ['min' => 0, 'max' => 25, 'label' => 'Beginner', 'color' => 'text-error', 'bg' => 'bg-error/10'],
            ['min' => 26, 'max' => 50, 'label' => 'Learning', 'color' => 'text-amber-600', 'bg' => 'bg-amber-50'],
            ['min' => 51, 'max' => 75, 'label' => 'Proficient', 'color' => 'text-orange-600', 'bg' => 'bg-orange-50'],
            ['min' => 76, 'max' => 90, 'label' => 'Skilled', 'color' => 'text-secondary', 'bg' => 'bg-secondary/10'],
            ['min' => 91, 'max' => 100, 'label' => 'Mastered', 'color' => 'text-primary', 'bg' => 'bg-primary/10'],
        ];

        foreach ($tiers as $tier) {
            if ($score >= $tier['min'] && $score <= $tier['max']) {
                return $tier;
            }
        }

        return $tiers[0];
    }

    public function getNextUnlockThreshold(Concept $concept): ?array
    {
        $tiers = $concept->unlocked_tiers ?? ['junior'];
        $tierXp = $concept->tier_xp ?? config('gamification.default_tier_xp');
        $totalXp = array_sum($tierXp);
        $setsCompleted = $concept->practice_sets_completed;
        $globalAvg = $concept->getGlobalAvgRating();

        if (!in_array('mid', $tiers)) {
            return [
                'tier' => 'mid',
                'xp_needed' => config('gamification.mid_unlock_xp'),
                'current_xp' => $totalXp,
                'sets_needed' => config('gamification.min_practice_sets'),
                'sets_completed' => $setsCompleted,
                'avg_rating_needed' => config('gamification.min_avg_rating'),
                'current_avg_rating' => $globalAvg,
            ];
        }

        if (!in_array('senior', $tiers)) {
            return [
                'tier' => 'senior',
                'xp_needed' => config('gamification.senior_unlock_xp'),
                'current_xp' => $totalXp,
                'sets_needed' => config('gamification.min_practice_sets'),
                'sets_completed' => $setsCompleted,
                'avg_rating_needed' => config('gamification.min_avg_rating'),
                'current_avg_rating' => $globalAvg,
            ];
        }

        return null;
    }

    public function getMasteryProgress(Concept $concept): array
    {
        $tierXp = $concept->tier_xp ?? config('gamification.default_tier_xp');
        $allTiersUnlocked = in_array('junior', $concept->unlocked_tiers ?? ['junior'])
            && in_array('mid', $concept->unlocked_tiers ?? [])
            && in_array('senior', $concept->unlocked_tiers ?? []);

        $globalAvg = $concept->getGlobalAvgRating();
        $tierAverages = [];
        foreach (config('gamification.tiers') as $t) {
            $tierAverages[$t] = $concept->getTierAvgRating($t);
        }

        $seniorXp = $tierXp['senior'] ?? 0;
        $masteredSeniorXp = config('gamification.mastered_senior_xp');

        return [
            'avg_rating_met' => $globalAvg >= config('gamification.mastered_avg_rating'),
            'global_avg_rating' => $globalAvg,
            'tier_averages' => $tierAverages,
            'all_tiers_unlocked' => $allTiersUnlocked,
            'senior_xp_met' => $seniorXp >= $masteredSeniorXp,
            'senior_xp' => $seniorXp,
            'senior_xp_needed' => $masteredSeniorXp,
            'tier_xp' => $tierXp,
        ];
    }

    public function updateStreak(Concept $concept): Concept
    {
        $streak = $concept->practice_streak ?? ['current' => 0, 'longest' => 0, 'last_practice' => null];
        $today = now()->toDateString();

        if ($streak['last_practice'] === $today) {
            return $concept;
        }

        $yesterday = now()->subDay()->toDateString();

        if ($streak['last_practice'] === $yesterday) {
            $streak['current']++;
        } else {
            $streak['current'] = 1;
        }

        $streak['longest'] = max($streak['longest'], $streak['current']);
        $streak['last_practice'] = $today;

        $concept->update(['practice_streak' => $streak]);

        return $concept;
    }

    public function getStreakBonus(Concept $concept): int
    {
        $streak = $concept->practice_streak ?? ['current' => 0];
        $days = $streak['current'] ?? 0;

        if ($days >= 7) return config('gamification.streak_bonus_veteran');
        if ($days >= 2) return config('gamification.streak_bonus_active');
        return 0;
    }

    public function isFirstPracticeToday(Concept $concept): bool
    {
        $sessions = $concept->practice_sessions ?? [];
        $today = now()->toDateString();

        foreach ($sessions as $session) {
            if (($session['date'] ?? null) === $today) {
                return false;
            }
        }

        return true;
    }

    public function isPerfectSet(array $evaluations): bool
    {
        if (empty($evaluations)) {
            return false;
        }

        foreach ($evaluations as $eval) {
            if (($eval['rating'] ?? 0) < 4) {
                return false;
            }
        }

        return true;
    }

    public function isFirstSetEver(Concept $concept): bool
    {
        return empty($concept->practice_sessions);
    }

    public function hasRatingImproved(Concept $concept, string $tier, int $setNumber, array $evaluations): bool
    {
        $existing = GeneratedQuestion::where('concept_id', $concept->id)
            ->where('tier', $tier)
            ->where('set_number', $setNumber)
            ->whereNotNull('rating')
            ->get();

        if ($existing->isEmpty()) {
            return false;
        }

        $oldAvg = (float) $existing->avg('rating');
        $newRatings = collect($evaluations)->pluck('rating')->filter(function ($r) {
            return $r !== null;
        });

        if ($newRatings->isEmpty()) {
            return false;
        }

        $newAvg = $newRatings->avg();

        return $newAvg >= $oldAvg + 1.0;
    }

    public function checkStreakMilestone(Concept $concept): int
    {
        $streak = $concept->practice_streak ?? ['current' => 0];
        $days = $streak['current'] ?? 0;
        $milestones = $concept->streak_milestones ?? [];

        if ($days >= 30 && !in_array(30, $milestones, true)) {
            $milestones[] = 30;
            $concept->update(['streak_milestones' => $milestones]);
            return config('gamification.bonus_streak_milestone_30');
        }

        if ($days >= 7 && !in_array(7, $milestones, true)) {
            $milestones[] = 7;
            $concept->update(['streak_milestones' => $milestones]);
            return config('gamification.bonus_streak_milestone_7');
        }

        return 0;
    }

    public function awardExplanationXp(Concept $concept): Concept
    {
        $xp = config('gamification.bonus_explanation');
        $tierXp = $concept->tier_xp ?? config('gamification.default_tier_xp');
        $tierXp['junior'] = ($tierXp['junior'] ?? 0) + $xp;
        $concept->update(['tier_xp' => $tierXp]);

        $totalXp = array_sum($tierXp);
        $concept->update(['xp' => $totalXp]);
        $concept->refresh();

        return $concept;
    }
}
