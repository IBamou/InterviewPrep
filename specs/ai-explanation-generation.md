# AI Explanation Generation

## 🎯 Feature Goal
Allow users to generate or improve concept explanations using AI.

---

## ✅ What I want

### US1 - Improve existing explanation
- User clicks "Improve with AI" on a concept with an existing explanation
- AI rewrites it to be concise (2-3 short sentences max)
- Suggestion shown with Accept/Reject options

### US2 - Generate from scratch
- If concept has no explanation, button shows "Generate with AI"
- AI generates an explanation based on concept title and difficulty
- Same Accept/Reject flow

### US3 - Generate during concept creation
- On `/domains/{domain}/concepts/create`, a "Generate with AI" button appears above the explanation textarea
- Button is disabled until user enters a concept title (min 3 characters)
- Generated explanation fills the textarea for editing before submission

---

## ❌ What I DON'T want
- No auto-apply (user must explicitly accept or manually edit)
- No version history of explanations
- No explanation formatting beyond plain text with line breaks

---

## 🧱 Technical Requirements

### Services
- `PromptBuilder::buildImproveConceptExplanationMessages()` for improve flow
- `PromptBuilder::buildGenerateConceptExplanationMessages()` for generate flow
- `AiService::improveConceptExplanation()` and `AiService::generateConceptExplanation()` (via `AiProvider`)

### Response Format
- AI returns `{"improved_explanation": "..."}` or `{"explanation": "..."}`
- JSON parsing with error handling

### Frontend
- `explanationImprover()` Alpine.js component for show page
- `explanationGenerator()` Alpine.js component for create page
- Fetch API for async requests
- Inline error display (no alerts)

---

## 🔄 Routes

- `POST /concepts/{concept}/improve-explanation` → ConceptController@improveExplanation
- `POST /concepts/{concept}/accept-explanation` → ConceptController@acceptExplanation
- `POST /domains/{domain}/concepts/generate-explanation` → ConceptController@generateExplanation

---

## 🧠 Business Rules
- Only the concept owner can improve/accept explanations
- Rate limited via `ai-actions` middleware
- Generate during creation does not save — user can edit before submitting
- Accepting replaces the existing explanation entirely

---

## 🖥️ Views
- `concepts/show.blade.php` → Explanation section with AI button and suggestion display
- `concepts/create.blade.php` → Explanation textarea with "Generate with AI" button
