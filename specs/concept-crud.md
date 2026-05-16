# Concepts CRUD

## 🎯 Feature Goal

Allow an authenticated user to manage concepts within their domains - each concept represents a technical topic they need to master for interviews.

---

## ✅ What I want

### US5 - List concepts in a domain
- View all concepts of a domain
- Display: title, difficulty (Junior/Mid/Senior), status (To Review/In Progress/Mastered)
- Filter by status AND by difficulty (combined filter)

### US6 - Create a concept
- title: name of the technical concept (e.g., "Eloquent N+1 Problem")
- explanation: what it is, how it works, why it's important - written in user's own words
- difficulty: junior / mid / senior
- status: to_review (default)
- AI "Generate with AI" button for explanation (requires title, min 3 chars)
- AI "Verify" button for title (detects typos, suggests corrections, rejects gibberish)

### US7 - View concept detail
- Show title, full explanation, difficulty, status
- Show generated interview questions (from AI) grouped by set
- AI "Improve with AI" / "Generate with AI" button for explanation
- Practice sidebar card

### US8 - Edit a concept
- Edit title, explanation, difficulty, or status

### US9 - Quick status change
- Change status directly from list (to_review → in_progress → mastered)
- No need to open edit form

### US10 - Delete a concept
- Delete a concept (soft delete)
- Restore and force-delete from archives

---

## ❌ What I DON'T want

- No auto-generation of concepts
- No API routes (web routes only)
- No SPA or frontend frameworks
- No complex UI (simple Blade templates only)
- No access to other users' concepts

---

## 🧱 Technical Requirements

- Use Laravel Breeze for authentication
- All routes protected by `auth` and `onboarding` middleware
- Use a Resource Controller: `ConceptController`
- Use Eloquent ORM (no raw SQL)
- Use Form Request classes for validation

### Relationships
- Domain → hasMany Concept
- Concept → belongsTo Domain
- Concept → hasMany GeneratedQuestion

### Enums (PHP 8.1+ backed enums)
- `difficulty`: 'junior', 'mid', 'senior' (`App\Enums\Difficulty`)
- `status`: 'to_review', 'in_progress', 'mastered' (`App\Enums\Status`)

### Soft Deletes
- Implement `SoftDeletes` trait on Concept model

---

## 🗃️ Database Structure

### Table: concepts
- id (primary key)
- domain_id (foreign key → domains.id)
- title (string)
- explanation (text)
- difficulty (enum: junior, mid, senior)
- status (enum: to_review, in_progress, mastered)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, nullable - SoftDeletes)

---

## ✅ Validation Rules

- title:
  - required
  - string
  - min:3
  - max:255

- explanation:
  - required
  - string

- difficulty:
  - required
  - enum: junior, mid, senior

- status:
  - required
  - enum: to_review, in_progress, mastered
  - default: to_review

---

## 🔄 Routes

- `GET /domains/{domain}/concepts` → index (with filters)
- `GET /domains/{domain}/concepts/create` → create
- `POST /domains/{domain}/concepts` → store
- `POST /domains/{domain}/concepts/verify-title` → AI title verification
- `POST /domains/{domain}/concepts/generate-explanation` → AI explanation generation
- `GET /concepts/{concept}` → show
- `GET /concepts/{concept}/practice` → practice
- `GET /concepts/{concept}/edit` → edit
- `PUT /concepts/{concept}` → update
- `PATCH /concepts/{concept}/status` → updateStatus (quick change)
- `DELETE /concepts/{concept}` → archive (soft delete)
- `POST /concepts/{concept}/restore` → restore
- `DELETE /concepts/{concept}/force` → forceDelete (permanent)
- `POST /concepts/{concept}/improve-explanation` → AI improvement
- `POST /concepts/{concept}/accept-explanation` → Accept AI suggestion
- `POST /concepts/{concept}/generate-questions` → AI question generation
- `POST /concepts/{concept}/submit-answers` → AI answer evaluation
- `GET /domains/{domain}/concepts/archives` → archives (list archived)

---

## 🧠 Business Rules

- A user can only see concepts of their own domains
- A user cannot access other users' concepts
- Status changes: to_review → in_progress → mastered (cycling or direct)
- Soft delete: concepts go to "trash" before permanent deletion
- Title verification is optional — user can submit without verifying
- AI-generated explanations during creation are not auto-saved

---

## 🖥️ Views

- `concepts/index.blade.php` → list concepts with status/difficulty filters
- `concepts/create.blade.php` → create form with AI generate/verify buttons
- `concepts/edit.blade.php` → edit form + archive button
- `concepts/show.blade.php` → concept detail with collapsible question sets and evaluations
- `concepts/practice.blade.php` → practice form with pagination
- `concepts/archives.blade.php` → soft deleted concepts (restore + forceDelete)
- `components/concept-card.blade.php` → reusable concept card
