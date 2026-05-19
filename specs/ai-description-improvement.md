# AI Description Improvement

## 🎯 Feature Goal
Allow users to improve or generate domain descriptions using AI.

---

## ✅ What I want

### US1 - Improve existing description
- User clicks "Improve with AI" on a domain with an existing description
- AI rewrites it to be concise (1-2 sentences max)
- Suggestion is shown with Accept/Reject options
- Accepting saves the suggestion to the database

### US2 - Generate from scratch
- If domain has no description, button shows "Generate with AI"
- AI generates a description based on the domain name
- Same Accept/Reject flow

### US3 - Conditional button
- Empty description → "Generate with AI" (secondary color, sparkle icon)
- Existing description → "Improve with AI" (primary color, wand icon)

---

## ❌ What I DON'T want
- No auto-apply (user must explicitly accept)
- No version history of descriptions
- No markdown or rich text in descriptions

---

## 🧱 Technical Requirements

### Services
- `PromptBuilder::buildImproveDomainDescriptionMessages()` builds prompts
- `AiService::improveDomainDescription()` makes API call (via `AiProvider`)
- System prompt instructs AI to generate from scratch if description is empty

### Response Format
- AI returns `{"improved_description": "..."}`
- JSON parsing with error handling

### Frontend
- Alpine.js component `descriptionImprover()`
- Fetch API for async request
- Suggestion displayed in styled box with Accept/Dismiss buttons
- Accept submits a hidden form with the suggestion value

---

## 🔄 Routes

- `POST /domains/{domain}/improve-description` → DomainController@improveDescription
- `POST /domains/{domain}/accept-description` → DomainController@acceptDescription

---

## 🧠 Business Rules
- Only the domain owner can improve/accept descriptions
- Rate limited via `ai-actions` middleware
- Accepting replaces the existing description entirely

---

## 🖥️ Views
- `domains/show.blade.php` → Description section with AI button and suggestion display
