<?php

return [

    /*
    |--------------------------------------------------------------------------
    | XP Per Rating
    |--------------------------------------------------------------------------
    | XP awarded per question based on AI rating (0-5).
    */
    'xp_per_rating' => [
        0 => 2,
        1 => 3,
        2 => 5,
        3 => 10,
        4 => 15,
        5 => 25,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tier Names & Visual Colors
    |--------------------------------------------------------------------------
    | Tailwind CSS classes for each tier.
    */
    'tiers' => ['junior', 'mid', 'senior'],

    'tier_colors' => [
        'junior' => ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'border' => 'border-primary/20', 'bar' => 'bg-primary', 'activeBg' => 'bg-primary', 'activeText' => 'text-white'],
        'mid' => ['bg' => 'bg-secondary/10', 'text' => 'text-secondary', 'border' => 'border-secondary/20', 'bar' => 'bg-secondary', 'activeBg' => 'bg-secondary', 'activeText' => 'text-white'],
        'senior' => ['bg' => 'bg-tertiary/10', 'text' => 'text-tertiary', 'border' => 'border-tertiary/20', 'bar' => 'bg-tertiary', 'activeBg' => 'bg-tertiary', 'activeText' => 'text-white'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Tier Values (for new concepts)
    |--------------------------------------------------------------------------
    */
    'default_tier_xp' => ['junior' => 0, 'mid' => 0, 'senior' => 0],

    'default_tier_ratings' => [
        'junior' => ['sum' => 0, 'count' => 0],
        'mid' => ['sum' => 0, 'count' => 0],
        'senior' => ['sum' => 0, 'count' => 0],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tier Unlock Thresholds
    |--------------------------------------------------------------------------
    | Requirements to unlock Mid and Senior tiers.
    */
    'mid_unlock_xp' => 300,
    'senior_unlock_xp' => 1000,
    'min_practice_sets' => 3,
    'min_avg_rating' => 2.5,

    /*
    |--------------------------------------------------------------------------
    | Mastery Thresholds
    |--------------------------------------------------------------------------
    | Requirements to auto-set a concept's status to "Mastered".
    */
    'mastered_avg_rating' => 3.5,
    'mastered_senior_xp' => 300,

    /*
    |--------------------------------------------------------------------------
    | Bonus XP Sources
    |--------------------------------------------------------------------------
    */
    'bonus_first_today' => 15,
    'bonus_perfect_set' => 25,
    'bonus_rating_improvement' => 15,
    'bonus_explanation' => 10,
    'bonus_streak_milestone_7' => 50,
    'bonus_streak_milestone_30' => 200,

    /*
    |--------------------------------------------------------------------------
    | Streak Bonuses (per question on top of rating XP)
    |--------------------------------------------------------------------------
    */
    'streak_bonus_active' => 2,
    'streak_bonus_veteran' => 5,

    /*
    |--------------------------------------------------------------------------
    | Mastery Score Decay Weights
    |--------------------------------------------------------------------------
    | Weight multipliers for recent vs old practice sessions.
    */
    'mastery_weights' => [
        'recent_weight' => 2.0,
        'normal_weight' => 1.0,
        'stale_weight' => 0.5,
        'recent_count' => 2,
        'normal_count' => 10,
    ],
];
