# Gamification System — Current State

## Overview

InterviewPrep uses a tier-based progression system to encourage users to practice interview questions and build mastery over technical concepts. Each concept can be practiced independently, with its own XP, tier unlocks, and mastery score.

---

## Core Mechanics

### 1. Tier System (Junior → Mid → Senior)

Each concept starts with **Junior** unlocked. Higher tiers (**Mid**, **Senior**) are locked until the user meets XP, practice set, and average rating requirements. Questions generated for a concept use the user's highest unlocked tier to determine difficulty level.

### 2. XP (Experience Points)

**XP per rating:**

| Rating | Label | XP |
|--------|-------|----|
| 0 | Blank / No answer | 0 |
| 1 | Completely wrong | -10 |
| 2 | Partially correct | -5 |
| 3 | Basic understanding | +5 |
| 4 | Strong answer | +10 |
| 5 | Expert-level | +20 |

XP is awarded per question after AI evaluation. Total XP is the sum of all tier XP buckets.

**Source:** `app/Services/ProgressionService.php` — `XP_PER_RATING` constant

### 3. Tier Unlock Requirements

| Unlock | XP Needed | Practice Sets | Avg Rating |
|--------|-----------|---------------|------------|
| Mid    | 500 XP    | 5             | ≥ 3.0      |
| Senior | 1000 XP   | 5             | ≥ 3.0      |

When a tier unlocks, `practice_sets_completed` resets to 0 (the counter is shared across unlocks, not per-tier).

**Source:** `app/Services/ProgressionService.php` — `MID_UNLOCK_XP`, `SENIOR_UNLOCK_XP`, `MIN_PRACTICE_SETS`, `MIN_AVG_RATING` constants

### 4. Mastery Score

Calculated as: `(sum of all ratings) / (total questions × 5) × 100`

Ranges from 0 (no answers) to 100 (all answers rated 5/5).

### 5. Auto-Status Flow

| Condition | Status Set |
|-----------|------------|
| No practice sessions recorded | `To Review` |
| At least one session recorded | `In Progress` |
| Global avg ≥ 3.5 + all tiers unlocked + ≥ 300 XP in Senior tier | `Mastered` |

### 6. Mastery Tiers (Display Only)

| Score Range | Label |
|-------------|-------|
| 0–25 | Beginner |
| 26–50 | Learning |
| 51–75 | Proficient |
| 76–90 | Skilled |
| 91–100 | Mastered |

### 7. Practice Sessions

Each evaluation records a session entry with:
- `date` — date of practice
- `avg_rating` — average rating for the session
- `xp_gained` — total XP earned in the session

Sessions are stored as a JSON array on the concept (`practice_sessions` column).

---

## Data Storage

| Column | Type | Purpose |
|--------|------|---------|
| `xp` | integer | Total XP across all tiers |
| `tier_xp` | JSON | Per-tier XP breakdown: `{ junior: 0, mid: 0, senior: 0 }` |
| `tier_ratings` | JSON | Per-tier rating aggregates: `{ junior: { sum, count }, ... }` |
| `unlocked_tiers` | JSON | Array of unlocked tier names: `["junior", "mid"]` |
| `mastery_score` | decimal | 0–100 mastery percentage |
| `practice_sessions` | JSON | Array of session records |
| `practice_sets_completed` | integer | Counter for unlock requirements |
| `total_rating_sum` | decimal | Sum of all session avg ratings |

**Source Model:** `app/Models/Concept.php`

---

## Key Service Constants

All constants are defined in `app/Services/ProgressionService.php`:

| Constant | Value | Purpose |
|----------|-------|---------|
| `MID_UNLOCK_XP` | 500 | XP needed to unlock Mid tier |
| `SENIOR_UNLOCK_XP` | 1000 | XP needed to unlock Senior tier |
| `MIN_PRACTICE_SETS` | 5 | Practice sets needed for unlock |
| `MIN_AVG_RATING` | 3.0 | Global avg rating needed for unlock |
| `MASTERED_AVG_RATING` | 3.5 | Avg rating needed for Mastered status |
| `MASTERED_SENIOR_XP` | 300 | Senior XP needed for Mastered status |
| `ALL_TIERS` | `['junior', 'mid', 'senior']` | Ordered tier list |
| `DEFAULT_TIER_XP` | `{ junior: 0, mid: 0, senior: 0 }` | Default tier XP |
| `DEFAULT_TIER_RATINGS` | `{ junior: { sum: 0, count: 0 }, ... }` | Default tier ratings |
| `XP_PER_RATING` | Rating → XP mapping | Awarded per evaluated question |
| `TIER_COLORS` | Tier → Tailwind classes | Used by views for visual styling |
