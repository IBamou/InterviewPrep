# Quiz Configuration Guide

All quiz rules are configurable via `.env` variables. No code changes needed.

---

## Changing quiz readiness requirements

A concept must pass **all** of these checks to be eligible for a quiz:

| Variable | Default | What it controls |
|---|---|---|
| `QUIZ_REQUIRES_EXPLANATION` | `true` | Whether the concept must have a written explanation |
| `QUIZ_MIN_EVALUATED_SETS` | `1` | Minimum number of evaluated practice sets required |
| `QUIZ_MIN_AVG_RATING` | `2.5` | Minimum global average rating required |

**Example — require 2 evaluated sets and a 3.0+ rating:**

```dotenv
QUIZ_MIN_EVALUATED_SETS=2
QUIZ_MIN_AVG_RATING=3
```

**Example — skip the explanation requirement:**

```dotenv
QUIZ_REQUIRES_EXPLANATION=false
```

---

## Changing the domain threshold

| Variable | Default | What it controls |
|---|---|---|
| `QUIZ_MIN_READY_CONCEPTS` | `3` | Minimum ready concepts needed in a domain to start a quiz |

**Example — allow a quiz with only 2 concepts:**

```dotenv
QUIZ_MIN_READY_CONCEPTS=2
```

---

## Changing question count

| Variable | Default | What it controls |
|---|---|---|
| `QUIZ_QUESTIONS_PER_CONCEPT` | `3` | Multiplier: `concepts_selected × this` |
| `QUIZ_MIN_QUESTIONS` | `10` | Minimum total questions (clamped) |
| `QUIZ_MAX_QUESTIONS` | `15` | Maximum total questions (clamped) |

The final question count is: `min(max(count × per_concept, min), max)`

**Example — 5 questions per concept, 20 max:**

```dotenv
QUIZ_QUESTIONS_PER_CONCEPT=5
QUIZ_MAX_QUESTIONS=20
```

---

## Changing the timer

| Variable | Default | What it controls |
|---|---|---|
| `QUIZ_MINUTES_PER_QUESTION` | `1.5` | Minutes allocated per question |
| `QUIZ_MIN_MINUTES` | `10` | Minimum total timer (floored) |

**Example — 2 minutes per question, 15 min minimum:**

```dotenv
QUIZ_MINUTES_PER_QUESTION=2
QUIZ_MIN_MINUTES=15
```

---

## Step by step

1. Open `.env`
2. Add or change any of the variables above
3. Run `php artisan config:clear` to reload
4. Done — the UI, validation, and timer will all adapt automatically

> **Safety guarantees:**
> - Wrong or missing values fall back to safe defaults (never crash)
> - Timer is floored at `QUIZ_MIN_MINUTES` (never 0)
> - `QUIZ_MIN_READY_CONCEPTS` is floored at 1 (no division by zero)
> - Frontend Alpine.js receives these values via constructor args
