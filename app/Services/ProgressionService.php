<?php

namespace App\Services;

use App\Enums\Status;
use App\Models\Concept;

class ProgressionService
{
    protected const MID_UNLOCK_XP = 500;
    protected const SENIOR_UNLOCK_XP = 1000;
    protected const MIN_PRACTICE_SETS = 5;
    protected const MIN_AVG_RATING = 3.0;
    protected const MASTERED_AVG_RATING = 3.5;
    protected const MASTERED_SENIOR_XP = 300;

    protected const XP_PER_RATING = [
        0 => 0,
        1 => -10,
        2 => -5,
        3 => 5,
        4 => 10,
        5 => 20,
    ];

    public function calculateXpForRating(int $rating): int
    {
        return self::XP_PER_RATING[$rating] ?? 0;
    }

    public function awardXp(Concept $concept, int $xp, string $tier): Concept
    {
        $tierXp = $concept->tier_xp ?? ['junior' => 0, 'mid' => 0, 'senior' => 0];
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
        $tierXp = $concept->tier_xp ?? ['junior' => 0, 'mid' => 0, 'senior' => 0];
        $totalXp = array_sum($tierXp);
        $setsCompleted = $concept->practice_sets_completed;
        $globalAvg = $concept->getGlobalAvgRating();

        $meetsRequirements = $setsCompleted >= self::MIN_PRACTICE_SETS && $globalAvg >= self::MIN_AVG_RATING;

        if ($meetsRequirements && $totalXp >= self::SENIOR_UNLOCK_XP && !in_array('senior', $tiers)) {
            $tiers[] = 'senior';
            $concept->update([
                'unlocked_tiers' => $tiers,
                'practice_sets_completed' => 0,
            ]);
        } elseif ($meetsRequirements && $totalXp >= self::MID_UNLOCK_XP && !in_array('mid', $tiers)) {
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

        $tierXp = $concept->tier_xp ?? ['junior' => 0, 'mid' => 0, 'senior' => 0];
        $seniorXp = $tierXp['senior'] ?? 0;

        if ($globalAvg >= self::MASTERED_AVG_RATING && $allTiersUnlocked && $seniorXp >= self::MASTERED_SENIOR_XP) {
            $concept->update(['status' => Status::Mastered]);
        }

        return $concept;
    }

    public function calculateMasteryScore(Concept $concept): float
    {
        $evaluated = $concept->generatedQuestions()->whereNotNull('rating')->get();

        if ($evaluated->isEmpty()) {
            return 0;
        }

        $totalPossible = $evaluated->count() * 5;
        $totalEarned = $evaluated->sum('rating');

        return round(($totalEarned / $totalPossible) * 100, 2);
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
        $tierXp = $concept->tier_xp ?? ['junior' => 0, 'mid' => 0, 'senior' => 0];
        $totalXp = array_sum($tierXp);
        $setsCompleted = $concept->practice_sets_completed;
        $globalAvg = $concept->getGlobalAvgRating();

        if (!in_array('mid', $tiers)) {
            return [
                'tier' => 'mid',
                'xp_needed' => self::MID_UNLOCK_XP,
                'current_xp' => $totalXp,
                'sets_needed' => self::MIN_PRACTICE_SETS,
                'sets_completed' => $setsCompleted,
                'avg_rating_needed' => self::MIN_AVG_RATING,
                'current_avg_rating' => $globalAvg,
            ];
        }

        if (!in_array('senior', $tiers)) {
            return [
                'tier' => 'senior',
                'xp_needed' => self::SENIOR_UNLOCK_XP,
                'current_xp' => $totalXp,
                'sets_needed' => self::MIN_PRACTICE_SETS,
                'sets_completed' => $setsCompleted,
                'avg_rating_needed' => self::MIN_AVG_RATING,
                'current_avg_rating' => $globalAvg,
            ];
        }

        return null;
    }

    public function getMasteryProgress(Concept $concept): array
    {
        $tierXp = $concept->tier_xp ?? ['junior' => 0, 'mid' => 0, 'senior' => 0];
        $allTiersUnlocked = in_array('junior', $concept->unlocked_tiers ?? ['junior'])
            && in_array('mid', $concept->unlocked_tiers ?? [])
            && in_array('senior', $concept->unlocked_tiers ?? []);

        $globalAvg = $concept->getGlobalAvgRating();
        $tierAverages = [];
        foreach (['junior', 'mid', 'senior'] as $t) {
            $tierAverages[$t] = $concept->getTierAvgRating($t);
        }

        $seniorXp = $tierXp['senior'] ?? 0;

        return [
            'avg_rating_met' => $globalAvg >= self::MASTERED_AVG_RATING,
            'global_avg_rating' => $globalAvg,
            'tier_averages' => $tierAverages,
            'all_tiers_unlocked' => $allTiersUnlocked,
            'senior_xp_met' => $seniorXp >= self::MASTERED_SENIOR_XP,
            'senior_xp' => $seniorXp,
            'senior_xp_needed' => self::MASTERED_SENIOR_XP,
            'tier_xp' => $tierXp,
        ];
    }
}
