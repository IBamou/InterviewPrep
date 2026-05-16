# AI Question Generation

## 🎯 Feature Goal
Generate exactly 5 mock interview questions for a concept, personalized to the user's profile.

---

## ✅ What I want

### US1 - Generate questions from concept
- User clicks "Generate Questions" on a concept's practice page
- AI generates exactly 5 questions at the concept's difficulty level
- Questions are contextualized to the concept's domain
- User profile (specialization, experience, tech stack, goal) influences question style

### US2 - Deduplication
- Last 15 previously generated questions are sent to AI as context
- AI must NOT repeat or rephrase existing questions
- Each generation creates a new "set" with incremented set_number

### US3 - Domain relevance check
- AI first checks if the concept is relevant to its parent domain
- If unrelated, returns error instead of questions
- User sees: "The concept is not relevant to this domain."

### US4 - Database persistence
- Questions are saved to `generated_questions` table BEFORE display
- Each question gets a `set_number` for grouping
- Redirect to practice page showing the new set

---

## ❌ What I DON'T want
- No question editing after generation
- No partial generation (always exactly 5)
- No caching of generated questions
- No question deletion (only via concept deletion)

---

## 🧱 Technical Requirements

### Services
- `PromptBuilder` builds system + user prompts with user context
- `GroqService` makes the API call and parses the JSON response
- User profile is passed through the entire chain

### Prompts
- System prompt: Role definition + relevance check instruction
- User prompt: Domain context + user profile + concept details + dedup list

### Response Handling
- AI returns `{"questions": ["Q1", "Q2", "Q3", "Q4", "Q5"]}`
- Or `{"error": "unrelated", "message": "..."}`
- JSON parsing wrapped in try/catch

### Rate Limiting
- `ai-actions` rate limiter: 10 requests per minute per user
- Applied via middleware on generation route

---

## 🔄 Route

- `POST /concepts/{concept}/generate-questions` → ConceptController@generateQuestions

---

## 🧠 Business Rules
- Questions are scoped to the authenticated user's concepts
- Set numbers are auto-incremented per concept
- User profile context is only injected if specialization is set
- Deduplication uses the 15 most recent questions for the concept

---

## 🖥️ Views
- Triggered from `concepts/show.blade.php` (Practice sidebar card)
- Redirects to `concepts/practice.blade.php` after generation
