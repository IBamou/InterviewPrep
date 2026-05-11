# Domains CRUD

## 🎯 Feature Goal

Allow an authenticated user to manage their technical domains (e.g., PHP, Laravel, MySQL) in order to organize their interview preparation.

---

## ✅ What I want

- The user can create a domain with:
  - name (string, required)
  - color (string, required)

- The user can:
  - view a list of their domains
  - edit a domain
  - delete a domain

- Each domain:
  - belongs to a user
  - is only accessible by its owner

- In the domains list, display:
  - domain name
  - color (as a badge or simple styled text)
  - total number of concepts in the domain
  - number of mastered concepts (status = "maîtrisé")

---

## ❌ What I DON'T want

- No AI usage in this feature
- No API routes (web routes only)
- No SPA or frontend frameworks (no Vue, React, etc.)
- No complex UI (simple Blade templates only)
- No unnecessary features (pagination optional, not required)
- No access to other users' domains

---

## 🧱 Technical Requirements

- Use Laravel Breeze for authentication
- All routes must be protected by `auth` middleware
- Use a Resource Controller: `DomainController`
- Use Eloquent ORM (no raw SQL)

### Relationships
- User → hasMany Domain
- Domain → belongsTo User
- Domain → hasMany Concept

---

## 🗃️ Database Structure

### Table: domains
- id (primary key)
- user_id (foreign key → users.id)
- name (string)
- color (string)
- created_at (timestamp)
- updated_at (timestamp)

---

## ✅ Validation Rules

- name:
  - required
  - string
  - max:255

- color:
  - required
  - string
  - max:50

---

## 🔄 Expected Routes (Resource)

- GET /domains → index
- GET /domains/create → create
- POST /domains → store
- GET /domains/{domain}/edit → edit
- PUT /domains/{domain} → update
- DELETE /domains/{domain} → destroy

---

## 🧠 Business Rules

- A user can only see their own domains
- A user cannot edit or delete another user’s domain
- When a domain is deleted, related concepts can remain or be handled later (no cascade required now)

---

## 🖥️ Views المتوقع (Blade)

- domains/index.blade.php → list domains
- domains/create.blade.php → create form
- domains/edit.blade.php → edit form

---

## 🧪 Notes for AI (important)

- Keep controllers simple and readable
- Use `$request->validate()` for validation
- Use route model binding (`Domain $domain`)
- Always filter domains by `auth()->id()`
- Do not generate unnecessary services or repositories

---

## 🔄 Workflow (AI Agent)

Pour chaque composant de cette feature, suivre ce cycle:

1. **Create Branch** - Créer une nouvelle branche pour le composant
2. **Add Work** - Implémenter le composant (modèle, controller, routes, views, etc.)
3. **Review** - Soumettre le travail pour review (pas de commit/push)
4. **Commit & Push** - Après validation, commiter et pousser (sur instruction explicite)

### Branches créées pour cette feature:

- `feature/domain-migration` - ✅ Migration table domains
- `feature/domain-model` - ✅ Model Domain
- `feature/domain-routes` - 🔄 Routes & Controller (en cours)
- `feature/domain-views` - À faire (Blade templates)
