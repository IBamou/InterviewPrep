# Quiz Mode

## 🎯 Feature Goal
Allow users to test their knowledge with timed, AI-generated mock interview quizzes across multiple concepts within a domain.

---

## ✅ What I want

### US1 - Quiz creation from domain concepts
- User selects a domain and at least `QUIZ_MIN_READY_CONCEPTS` (default: 3) quiz-ready concepts
- A concept is "quiz-ready" when it passes ALL checks in `config('quiz.requirements')`:
  - Has an explanation written (if `requires_explanation` is true)
  - `min_evaluated_sets`+ practice sets completed with AI evaluation
  - Global average rating >= `min_avg_rating`
- Questions are generated via AI (12-15 per quiz, configurable)
- Questions are saved to `quiz_questions` table before display

### US2 - Timed quiz with auto-submit
- Timer calculated as `max(questions * minutes_per_question, min_minutes)`
- Timer runs client-side via Alpine.js with server timestamp sync
- Auto-submits via fetch POST when timer expires
- Draft autosave to localStorage — restored on page refresh
- Keyboard navigation: Left/Right arrows to move between questions

### US3 - AI answer evaluation
- On submission, each concept's answers are sent to the AI in batches for evaluation
- Evaluation includes: rating (0-5), feedback, and model answer
- If AI fails, falls back to user self-rating with "Evaluation unavailable." feedback
- Results are persisted in `quiz_questions` table immediately

### US4 - Results & history
- Results page shows percentage, score breakdown, per-question feedback and model answers
- XP is calculated per question based on `gamification.xp_per_rating` config
- History page with status filter (In Progress / Submitted)
- Per-domain quiz listing page

### US5 - Active quiz enforcement
- **EnsureNoActiveQuiz** middleware redirects users to their active quiz when they try to access other pages
- Excluded routes: `quizzes.active`, `quizzes.submit`, `quizzes.results`
- Applied to all authenticated routes including auth actions (login, logout, etc.)

---

## 🏗 Architecture

### New Models
- `Quiz` — `user_id`, `domain_id`, `time_limit_minutes`, `started_at`, `submitted_at`, `status` (QuizStatus enum), `total_score`, `max_score`
- `QuizQuestion` — `quiz_id`, `concept_id`, `question`, `answer`, `rating`, `feedback`, `model_answer`, `sort_order`

### New Enum
- `App\Enums\QuizStatus` — `InProgress` (`'in_progress'`), `Submitted` (`'submitted'`)

### New Middleware
- `EnsureNoActiveQuiz` — checks for `in_progress` quizzes and redirects

### Configuration (`config/quiz.php`)
- All quiz rules configurable via `.env` (see `docs/quiz-configuration.md`)
- Questions per concept, min/max per quiz, timer settings, domain threshold

---

## 🗄 Database Changes

### `quizzes` table
- `id`, `user_id`, `domain_id`, `time_limit_minutes`, `started_at`, `submitted_at`, `status`, `total_score`, `max_score`, `timestamps`

### `quiz_questions` table
- `id`, `quiz_id`, `concept_id`, `question`, `answer`, `rating`, `feedback`, `model_answer`, `sort_order`, `timestamps`

---

## 🔒 Security & Multi-tenancy
- All quiz queries scoped to `auth()->user()->quizzes()`
- Domain ownership verified in `StoreQuizRequest` validation
- Route model binding with `scopeBindings()` for domain-quiz relationship
- Soft-delete awareness: quizzes orphaned when domain/concept deleted (cascade)

---

## 📂 Files to create

```
app/Enums/QuizStatus.php
app/Http/Controllers/QuizController.php
app/Http/Middleware/EnsureNoActiveQuiz.php
app/Http/Requests/StoreQuizRequest.php
app/Models/Quiz.php
app/Models/QuizQuestion.php
config/quiz.php
database/migrations/2026_05_17_160000_create_quizzes_table.php
database/migrations/2026_05_17_160001_create_quiz_questions_table.php
resources/views/quizzes/create.blade.php
resources/views/quizzes/active-quizze.blade.php
resources/views/quizzes/results.blade.php
resources/views/quizzes/by-domain.blade.php
resources/views/quizzes/history.blade.php
resources/views/components/quiz-domain-card.blade.php
docs/quiz-configuration.md
```

## 📂 Files to modify

```
app/Models/User.php              → Add quizzes() HasMany relationship
app/Models/Concept.php           → Add isQuizReady(), getQuizStatus(), getQuizMessage(), getEvaluatedSetCount()
app/Services/AiService.php       → Add generateQuizQuestions(), evaluateAnswers() (via provider)
app/Services/PromptBuilder.php   → Add buildQuizMessages()
bootstrap/app.php                → Register 'active-quiz' middleware alias
routes/web.php                   → Add quiz routes
routes/auth.php                  → Add 'active-quiz' middleware to auth group
resources/views/components/sidebar.blade.php → Add Quiz Mode nav item
resources/views/components/confirm-modal.blade.php → Global confirm callback fix
```
