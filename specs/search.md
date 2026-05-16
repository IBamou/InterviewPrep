# Global Search

## 🎯 Feature Goal
Allow users to search across all their domains, concepts, and generated questions.

---

## ✅ What I want

### US1 - Search across all content
- Single search input searches domains, concepts, and questions
- Results grouped by type with counts
- Filter tabs: All, Domains, Concepts, Questions

### US2 - Domain results
- Shows domain name and concept count
- Click navigates to domain show page
- Domain icon displayed (primary color)

### US3 - Concept results
- Shows concept title, parent domain name, difficulty, and status
- Click navigates to concept show page
- Difficulty and status badges with color coding

### US4 - Question results
- Shows question text, parent concept, and domain
- Shows rating if evaluated
- Click navigates to concept practice page

### US5 - Empty state
- "No results found" message when search returns nothing
- Suggestion to try different keywords

---

## ❌ What I DON'T want
- No full-text search engine (Elasticsearch, Meilisearch)
- No search history or suggestions
- No advanced filters (date range, difficulty filter, etc.)
- No search across other users' data

---

## 🧱 Technical Requirements

### Controller
- `SearchController@index` handles search logic
- Uses Laravel's `where()` with `LIKE` for simple text matching
- Results scoped to authenticated user's data

### Query Strategy
- Domains: `where('name', 'like', "%{$query}%")`
- Concepts: `where('title', 'like', "%{$query}%")` with domain relation
- Questions: `where('question', 'like', "%{$query}%")` with concept and domain relations

### Frontend
- Search form with GET method (query in URL)
- Filter tabs with active state styling
- Results sections with consistent card layout
- Empty state with icon and message

---

## 🔄 Route

- `GET /search?q={query}&type={type}` → SearchController@index

---

## 🧠 Business Rules
- Search is scoped to authenticated user's data only
- Query parameter `type` filters results: `all`, `domains`, `concepts`, `questions`
- Results are ordered by relevance (simple `LIKE` match, no ranking)
- Minimum query length not enforced (empty query shows all results)

---

## 🖥️ Views
- `search/index.blade.php` → Search page with form, filter tabs, and results
