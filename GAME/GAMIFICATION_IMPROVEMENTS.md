# Gamification Improvements — Proposal

## Why Change?

The current system has good bones (tier progression, auto-status, visual feedback) but suffers from **four root problems** that actively work against learning:

1. **Negative XP punishes trying** — Getting a hard question wrong costs you XP, which incentivises skipping difficult sets
2. **No reward for consistency** — Daily practice has no special benefit over cramming once a week
3. **Grind-heavy unlock curves** — Unlocking Mid requires ~20 practice sets at average performance, which feels like a chore
4. **No memory retention loop** — Once a concept is "Mastered," there's no reason to revisit it

---

## Improvement 1: Eliminate Negative XP

**File:** `app/Services/ProgressionService.php` — `XP_PER_RATING` constant

| Rating | Current XP | Proposed XP | Rationale |
|--------|-----------|-------------|-----------|
| 0 (blank) | 0 | **+2** | Submitting any answer should feel better than skipping |
| 1 (wrong) | -10 | **+3** | Being wrong is part of learning — never punish effort |
| 2 (partial) | -5 | **+5** | Partial knowledge still deserves positive reinforcement |
| 3 (basic) | +5 | **+10** | Baseline correct answer |
| 4 (strong) | +10 | **+15** | Good depth |
| 5 (expert) | +20 | **+25** | Mastery |

**Min XP per question:** +2 (up from 0)

---

## Improvement 2: Soften Unlock Curves

**File:** `app/Services/ProgressionService.php` — threshold constants

| Threshold | Current | Proposed |
|-----------|---------|----------|
| Mid XP needed | 500 | **300** |
| Mid sets needed | 5 | **3** |
| Mid avg rating | 3.0 | **2.5** |
| Senior XP needed | 1000 | 1000 (unchanged) |
| Senior sets needed | 5 | **3** |
| Senior avg rating | 3.0 | **3.0** |

## Improvement 3: Add Streak System

### Storage

New column on `concepts` table (or `users` table for global streaks):

```php
$table->json('practice_streak')->nullable();
```

JSON structure:

```json
{
  "current": 3,
  "longest": 12,
  "last_practice": "2026-05-17"
}
```

### Bonus Logic (in `ProgressionService`)

```php
public function getStreakBonus(Concept $concept): int
{
    $streak = $concept->practice_streak ?? ['current' => 0];
    $days = $streak['current'] ?? 0;

    if ($days >= 7) return 5;  // +5 XP per question for veteran streak
    if ($days >= 2) return 2;  // +2 XP per question for active streak
    return 0;
}
```

### Streak Reset Rule

- `last_practice === today` → no change (already practiced)
- `last_practice === yesterday` → increment `current` by 1
- `last_practice < yesterday` → reset `current` to 1 (lost streak)

### Visual Feedback

- **Dashboard:** Show streak count with flame icon (🔥) when `current ≥ 2`
- **Practice page:** Show streak status + bonus XP indicator per question
- **Concept show:** Show per-concept streak alongside XP bar

---

## Improvement 4: Add Multiple XP Sources

**File:** `app/Services/ProgressionService.php` (+ `submitAnswers` in `ConceptController`)

| Source | XP | When |
|--------|----|------|
| **First practice today** *(any concept)* | +15 | Once per day, first set submitted |
| **Perfect set** *(all 5 questions rated 4+)* | +25 | On evaluation |
| **Rating improvement** *(same set, re-practiced)* | +15 | If set avg improved by ≥ 1.0 from previous best |
| **Concept explanation written** | +10 | On store/update if `explanation` is non-empty |
| **Streak milestone** *(7 days)* | +50 | One-time when streak reaches 7 |
| **Streak milestone** *(30 days)* | +200 | One-time when streak reaches 30 |

**Implementation notes:**
- "First practice today" requires checking `practice_sessions` for today's date
- "Perfect set" detected during `submitAnswers` evaluation loop
- "Rating improvement" requires comparing against `tier_ratings` stored values
- Milestones tracked via a new JSON column `streak_milestones` to prevent re-awarding

---

## Improvement 5: Weighted Mastery Score (Decay)

**File:** `app/Services/ProgressionService.php` — `calculateMasteryScore()`

### Current Formula
```php
$totalEarned / ($evaluated->count() * 5) * 100
```

Flat average — old ratings still count as much as recent ones.

### Proposed Formula (Exponential Decay)

```php
$weights = [2.0, 2.0, 1.0, 1.0, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5];

return round(
    ($weightedSum / $maxWeightedPossible) * 100,
    2
);
```

- Last 2 sessions: weight × 2.0 (most recent matters most)
- Sessions 3–10: weight × 1.0
- Sessions 10+: weight × 0.5 (stale knowledge decays)

This prevents a Mastered concept from showing 95% when the user hasn't touched it in 6 months and has forgotten everything.

---

## Improvement 6: Micro-Visuals for Motivation

### Daily Goal Ring (Show Page Sidebar)
```
┌────────────────────┐
│  ○ 1/1 set done   │  ← green checkmark if daily goal met
│  Daily Goal        │
└────────────────────┘
```

- Goal: practice at least 1 set per day
- Checked against `practice_sessions` last entry date

### Tier Progress to Next Unlock (Show Page)
```
Junior ████████████░░░░  80%  (400/500 XP)
Sets  ██████░░░░░░░░░░  40%  (2/5 done)
Rating ██████████████░░  3.2  (need 3.0)
```

Replace the current abstract "Next Unlock" section with this concrete, tier-by-tier breakdown.

### Streak Badge
Show a streak badge in the topbar for the user's global streak:

```
🔥 5-day streak
```

---

## Implementation Plan

| Step | What | Files | Est. Time |
|------|------|-------|-----------|
| 1 | Update `XP_PER_RATING` values | `ProgressionService.php` | 5 min |
| 2 | Update unlock thresholds | `ProgressionService.php` | 5 min |
| 3 | Add weighted mastery scoring | `ProgressionService.php` | 30 min |
| 4 | Create streak migration + column | Migration + `Concept.php` | 20 min |
| 5 | Add streak bonus logic | `ProgressionService.php`, `ConceptController` | 1 hr |
| 6 | Add daily/first-practice bonus | `ProgressionService.php`, `ConceptController` | 30 min |
| 7 | Add perfect set bonus | `ConceptController::submitAnswers` | 20 min |
| 8 | Add rating improvement bonus | `ConceptController::submitAnswers` | 30 min |
| 9 | Update unlock visuals on show page | `show.blade.php` | 1 hr |
| 10 | Add streak UI to dashboard | `dashboard.blade.php` | 30 min |
| 11 | Add daily goal indicator | `show.blade.php` | 30 min |

**Total estimated time:** ~5 hours

---

## Risks & Considerations

1. **Existing users**: XP values change retroactively. A user with 1000 XP today would have had much more under the new scale. Consider recalculating or leaving existing scores untouched and applying new values going forward.

2. **Streak anxiety**: Some users find streaks stressful. Make the streak feature optional or purely additive (no penalty for losing it beyond the bonus).

3. **Weighted mastery confusion**: Ensure the "old score decay" is explained in the UI so users understand why their mastery score dropped without practicing.

4. **Game-ability**: Avoid mechanics that encourage gaming the system (e.g., spamming blank answers for easy XP). The current rating-dependent system largely prevents this since bad answers = low XP.
