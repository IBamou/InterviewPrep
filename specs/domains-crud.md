# Domains CRUD

## 🎯 Feature Goal

Allow an authenticated user to manage their technical domains (e.g., PHP, Laravel, MySQL) to organize their interview preparation.

---

## ✅ What I want

- The user can create a domain with:
  - name (string, required, min:3, max:255)
  - description (text, optional)

- The user can:
  - view a list of their domains
  - view domain detail with concepts list
  - edit a domain
  - delete a domain (soft delete)
  - restore deleted domains
  - permanently delete (force delete)

- Each domain:
  - belongs to a user
  - is only accessible by its owner

- In the domains list, display:
  - domain name
  - description
  - total number of concepts
  - number of mastered concepts
  - mastery percentage with progress bar

- AI description improvement:
  - "Improve with AI" button if description exists
  - "Generate with AI" button if description is empty
  - Accept/Reject flow for suggestions

---

## ❌ What I DON'T want

- No color field (removed — inconsistent with design system)
- No access to other users' domains
- No SPA or frontend frameworks
- No complex UI (simple Blade templates only)

---

## 🧱 Technical Requirements

- Use Laravel Breeze for authentication
- All routes protected by `auth` and `onboarding` middleware
- Use a Resource Controller: `DomainController`
- Use Eloquent ORM (no raw SQL)
- Use Form Request classes for validation

### Relationships
- User → hasMany Domain
- Domain → belongsTo User
- Domain → hasMany Concept

### Soft Deletes
- `SoftDeletes` trait on Domain model
- Archived domains accessible via `/domains/archives`
- Restore and force-delete actions available

---

## 🗃️ Database Structure

### Table: domains
- id (primary key)
- user_id (foreign key → users.id)
- name (string)
- description (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)
- deleted_at (timestamp, nullable - SoftDeletes)

---

## ✅ Validation Rules

- name:
  - required
  - string
  - min:3
  - max:255

- description:
  - nullable
  - string

---

## 🔄 Routes

- `GET /domains` → index
- `GET /domains/create` → create
- `POST /domains` → store
- `GET /domains/{domain}` → show
- `GET /domains/{domain}/edit` → edit
- `PUT /domains/{domain}` → update
- `DELETE /domains/{domain}` → destroy (soft delete)
- `GET /domains/archives` → archives
- `POST /domains/{domain}/restore` → restore
- `DELETE /domains/{domain}/force` → forceDelete
- `POST /domains/{domain}/improve-description` → AI improvement
- `POST /domains/{domain}/accept-description` → Accept AI suggestion

---

## 🧠 Business Rules

- A user can only see their own domains
- A user cannot edit or delete another user's domain
- Soft-deleted domains are hidden from normal views
- Restoring a domain does not restore its concepts (handled separately)

---

## 🖥️ Views

- `domains/index.blade.php` → list domains with stats
- `domains/create.blade.php` → create form
- `domains/edit.blade.php` → edit form
- `domains/show.blade.php` → domain detail with concepts list and description AI section
- `domains/archives.blade.php` → soft deleted domains (restore + forceDelete)
- `components/domain-card.blade.php` → reusable domain card
