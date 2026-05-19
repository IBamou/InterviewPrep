# Practice & Evaluation

## 🎯 Feature Goal
Allow users to answer generated interview questions and receive AI-powered feedback with ratings.

---

## ✅ What I want

### US1 - Practice interface
- User navigates to `/concepts/{concept}/practice`
- Displays one set of 5 generated questions at a time
- Textarea for each question to write an answer
- Submit all answers at once

### US2 - AI evaluation
- After submission, AI evaluates each answer
- For each question-answer pair, AI provides:
  - Rating from 1 to 5 (integer)
  - Brief constructive feedback
  - A model answer that would score 5/5

### US3 - Results display
- Shows star rating (1-5) for each answer
- Displays user's answer, AI feedback, and model answer
- Progress tracking (answered/total, average rating)

### US4 - Set navigation
- Multiple sets are grouped by `set_number`
- User can navigate between sets via pagination
- Collapsible sections for each set on the concept show page

---

## ❌ What I DON'T want
- No partial submission (all 5 answers at once)
- No re-evaluation of the same answers
- No editing answers after submission
- No saving of incomplete answers

---

## 🧱 Technical Requirements

### Database
- `generated_questions` table stores:
  - `question` (the AI-generated question)
  - `answer` (user's submitted answer, nullable)
  - `rating` (1-5, nullable)
  - `feedback` (AI feedback text, nullable)
  - `model_answer` (ideal answer, nullable)
  - `set_number` (groups questions into sets)

### Services
- `PromptBuilder::buildEvaluateAnswersMessages()` builds evaluation prompts
- `AiService::evaluateAnswers()` makes API call (via `AiProvider`)
- System prompt defines evaluation criteria and response format

### Response Format
- AI returns `{"evaluations": [{"question_index": 0, "rating": 4, "feedback": "...", "model_answer": "..."}, ...]}`
- Results are saved to database before display

### Frontend
- `concepts/practice.blade.php` → Practice form with textareas
- `concepts/show.blade.php` → Collapsible question sets with evaluation results
- Star rating display using Material Symbols

---

## 🔄 Routes

- `GET /concepts/{concept}/practice` → ConceptController@practice
- `POST /concepts/{concept}/submit-answers` → ConceptController@submitAnswers

---

## 🧠 Business Rules
- Only the concept owner can practice and submit answers
- Rate limited via `ai-actions` middleware
- Evaluation results are persisted — user can revisit anytime
- Questions without answers show "Not yet answered" with link to practice

---

## 🖥️ Views
- `concepts/practice.blade.php` → Practice form with pagination
- `concepts/show.blade.php` → Concept detail with collapsible question sets and evaluations
