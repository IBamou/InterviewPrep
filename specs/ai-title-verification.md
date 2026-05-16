# AI Title Verification

## 🎯 Feature Goal
Validate concept titles before generation to catch typos, gibberish, or unrelated concepts.

---

## ✅ What I want

### US1 - Verify concept title
- User enters a concept title and clicks "Verify"
- AI checks if the title is a valid technical term for the domain
- Three possible outcomes:
  1. **Valid**: Green confirmation "Looks good! Ready to generate."
  2. **Typo detected**: Amber suggestion "Did you mean 'Type Casting'?" with Apply button
  3. **Invalid**: Red error "This doesn't appear to be a valid technical concept for this domain."

### US2 - Typo tolerance
- AI is lenient with typos (e.g., "type castng" → "Type Casting")
- User can click "Apply" to auto-correct the title field

### US3 - Gibberish rejection
- Random characters or nonsense are rejected
- Completely unrelated concepts (e.g., "Photosynthesis" in "Laravel" domain) are rejected

### US4 - Minimum input requirement
- Verify button disabled until title has 3+ characters
- Prevents wasting API calls on empty or too-short input

---

## ❌ What I DON'T want
- No auto-correction without user confirmation
- No blocking of concept creation (user can still submit invalid titles)
- No history of verification attempts

---

## 🧱 Technical Requirements

### Services
- `PromptBuilder::buildVerifyConceptTitleMessages()` builds prompts
- `GroqService::verifyConceptTitle()` makes API call (low temperature 0.2, 100 max tokens)

### Response Format
- Valid: `{"valid": true}`
- Typo: `{"valid": false, "suggestion": "Corrected Title", "message": "Did you mean 'Corrected Title'?"}`
- Invalid: `{"valid": false, "message": "..."}`

### Frontend
- `explanationGenerator()` Alpine.js component manages state
- `titleValid` (boolean|null), `titleSuggestion` (string), `titleInvalid` (boolean), `titleMessage` (string)
- Three conditional display states with distinct styling
- "Apply" button auto-fills suggestion and marks as valid

---

## 🔄 Route

- `POST /domains/{domain}/concepts/verify-title` → ConceptController@verifyTitle

---

## 🧠 Business Rules
- Only the domain owner can verify titles
- Rate limited via `ai-actions` middleware
- Verification is optional — user can skip and submit directly
- Low temperature (0.2) ensures consistent verification results

---

## 🖥️ Views
- `concepts/create.blade.php` → Title field with Verify button and conditional feedback banners
