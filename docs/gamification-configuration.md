# Gamification Configuration Guide

All XP values, tier thresholds, unlock requirements, and bonus rules are defined in `config/gamification.php`. Unlike quiz rules, these are **not** exposed via `.env` — edit the file directly.

---

## XP Per Rating

Awarded per question based on the AI rating after evaluation.

```php
'xp_per_rating' => [
    0 => 2,   // no answer / blank
    1 => 3,   // completely wrong
    2 => 5,   // partially correct
    3 => 10,  // basic understanding
    4 => 15,  // strong answer
    5 => 25,  // expert-level
],
```

---

## Tiers

Three difficulty tiers control which questions are generated and which UI styles are used.

```php
'tiers' => ['junior', 'mid', 'senior'],
```

Each tier has Tailwind color classes used across practice and show views:

```php
'tier_colors' => [
    'junior' => [
        'bg'         => 'bg-primary/10',
        'text'       => 'text-primary',
        'border'     => 'border-primary/20',
        'bar'        => 'bg-primary',
        'activeBg'   => 'bg-primary',
        'activeText' => 'text-white',
    ],
    'mid' => [...],
    'senior' => [...],
],
```

Default values for new concepts (no XP, no ratings):

```php
'default_tier_xp'     => ['junior' => 0, 'mid' => 0, 'senior' => 0],
'default_tier_ratings' => [
    'junior' => ['sum' => 0, 'count' => 0],
    'mid'    => ['sum' => 0, 'count' => 0],
    'senior' => ['sum' => 0, 'count' => 0],
],
```

---

## Tier Unlock Thresholds

A concept starts with the `junior` tier unlocked. The `mid` and `senior` tiers unlock when **all** conditions are met:

| Config key | Default | What it controls |
|---|---|---|
| `mid_unlock_xp` | `300` | Total XP across all tiers needed for mid |
| `senior_unlock_xp` | `1000` | Total XP across all tiers needed for senior |
| `min_practice_sets` | `3` | Minimum evaluated sets per current tier |
| `min_avg_rating` | `2.5` | Minimum average rating per current tier |

Example — lower mid to 200 XP and 1 set:

```php
'mid_unlock_xp' => 200,
'min_practice_sets' => 1,
```

---

## Mastery Thresholds

A concept's status auto-updates to **Mastered** when both are met:

```php
'mastered_avg_rating' => 3.5,  // global average rating
'mastered_senior_xp'  => 300,  // XP in the senior tier
```

---

## Bonus XP

Awarded on top of rating XP for special conditions:

| Config key | Default | Trigger |
|---|---|---|
| `bonus_first_today` | `15` | First practice of the day |
| `bonus_perfect_set` | `25` | All questions in a set rated 4+ |
| `bonus_rating_improvement` | `15` | Average rating increased vs previous set |
| `bonus_explanation` | `10` | Writing or improving an explanation |
| `bonus_streak_milestone_7` | `50` | 7-day streak milestone |
| `bonus_streak_milestone_30` | `200` | 30-day streak milestone |

---

## Streak Bonuses (per question)

Additional XP per question on top of rating XP:

| Config key | Default | When active |
|---|---|---|
| `streak_bonus_active` | `2` | Streak ≥ 2 days |
| `streak_bonus_veteran` | `5` | Streak ≥ 7 days |

---

## Mastery Score Decay

The mastery score weights recent sessions more heavily:

```php
'mastery_weights' => [
    'recent_weight' => 2.0,   // multiplier for last N sessions
    'normal_weight' => 1.0,   // multiplier for middle sessions
    'stale_weight'  => 0.5,   // multiplier for old sessions
    'recent_count'  => 2,     // how many sessions are "recent"
    'normal_count'  => 10,    // how many are "normal" (beyond = stale)
],
```

---

## Step by step

1. Open `config/gamification.php`
2. Change any value
3. **No cache clear needed** — Laravel loads config files fresh on every request in local env
4. If you've run `php artisan config:cache` in production, re-run it after editing

> **Safety guarantees:**
> - All config reads use `??` fallbacks to defaults if a key is missing
> - `config:clear` is only needed in production after `config:cache` was run
> - UI color classes reference standard Tailwind tokens — invalid tokens silently apply nothing
