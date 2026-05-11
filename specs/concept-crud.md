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

### US7 - View concept detail
- Show title, full explanation, difficulty, status
- Show generated interview questions (from AI)

### US8 - Edit a concept
- Edit title, explanation, difficulty, or status

### US9 - Quick status change
- Change status directly from list (to_review → in_progress → mastered)
- No need to open edit form

### US10 - Delete a concept
- Delete a concept

---

## ❌ What I DON'T want

- No AI generation in this spec (US11-13 separate)
- No API routes (web routes only)
- No SPA or frontend frameworks
- No complex UI (simple Blade templates only)
- No access to other users' concepts

---

## 🧱 Technical Requirements

- Use Laravel Breeze for authentication
- All routes must be protected by `auth` middleware
- Use a Resource Controller: `ConceptController`
- Use Eloquent ORM (no raw SQL)

### Relationships
- Domain → hasMany Concept
- Concept → belongsTo Domain
- Concept → hasMany GeneratedQuestion

### Enums (strict values) - Using PHP 8.1+ Enums
- `difficulty`: 'junior', 'mid', 'senior' (App\Enums\Difficulty)
- `status`: 'to_review', 'in_progress', 'mastered' (App\Enums\Status)
- Model uses custom `App\Casts\EnumCast` casting for automatic conversion (PHP 8.4 / Laravel 13)

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
  - max:255

- explanation:
  - required
  - string

- difficulty:
  - required
  - in:junior,mid,senior

- status:
  - required
  - in:to_review,in_progress,mastered
  - default: to_review

---

## 🔄 Expected Routes (Explicit)

- GET    /domains/{domain}/concepts              → index (with filters)
- GET    /domains/{domain}/concepts/create       → create
- POST   /domains/{domain}/concepts             → store
- GET    /concepts/{concept}                    → show
- GET    /concepts/{concept}/edit                → edit
- PUT    /concepts/{concept}                    → update
- PATCH  /concepts/{concept}/status              → updateStatus (quick change)
- DELETE /concepts/{concept}                     → archive (soft delete)
- POST   /concepts/{concept}/restore            → restore
- DELETE /concepts/{concept}/force              → forceDelete (permanent)
- GET    /domains/{domain}/concepts/archives   → archives (list archived)

---

## 🧠 Business Rules

- A user can only see concepts of their own domains
- A user cannot access other users' concepts
- Status changes: to_review → in_progress → mastered (cycling or direct)
- Soft delete: concepts go to "trash" before permanent deletion

---

## 🖥️ Views (Blade)

- concepts/index.blade.php → list concepts with status/difficulty filters
- concepts/create.blade.php → create form
- concepts/edit.blade.php → edit form + archive button
- concepts/show.blade.php → concept detail + placeholder for generated questions
- concepts/archives.blade.php → soft deleted concepts (restore + forceDelete)
- components/concept-card.blade.php → reusable concept card

---

## 🧪 Notes for AI (important)

- Keep controllers simple and readable
- Use Form Request classes for validation
- Use route model binding (`Concept $concept`)
- Always filter by domain AND user ownership
- Use enum casting for difficulty/status

---

## 🔄 Workflow (AI Agent)

Pour chaque composant de cette feature, suivre ce cycle:

1. **Create Branch** - Créer une nouvelle branche pour le composant
2. **Add Work** - Implémenter le composant (migration, model, controller, routes, views, etc.)
3. **Review** - Soumettre le travail pour review (pas de commit/push)
4. **Commit & Push** - Après validation, commiter et pousser (sur instruction explicite)

### Branches créées pour cette feature:

- `feature/concept-migration` - ✅ Migration table concepts
- `feature/concept-model` - ✅ Model Concept avec SoftDeletes
- `feature/concept-enums` - ✅ PHP Enums Difficulty & Status
- `feature/concept-routes` - ✅ Routes avec soft delete actions
- `feature/concept-controller` - ✅ Controller avec CRUD + status change
- `feature/concept-policy` - ✅ Policies DomainPolicy & ConceptPolicy
- `feature/concept-form-request` - ✅ Form requests avec enum validation
- `feature/concept-views` - ✅ Views + ConceptCard component

### Notes
- US11-13 (Groq API) non implémenté - placeholder dans show.blade.php et controller
- Filter combiné (status + difficulty) implémenté dans index