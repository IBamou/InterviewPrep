# Bugfix: N+1 Query Problem

## 🎯 Problem

Laravel applications can suffer from N+1 query problems when loading related models in loops. This causes multiple database queries instead of a single optimized query with eager loading.

---

## 🔍 Identified Issues

### 1. DomainController::show()
**File:** `app/Http/Controllers/DomainController.php`

**Before:**
```php
public function show(Domain $domain)
{
    $this->authorize('view', $domain);
    return view('domains.show', compact('domain'));
}
```

**Problem:** The view (`domains/show.blade.php`) accesses `$domain->concepts` in a loop:
```blade
@foreach ($domain->concepts as $concept)
```

→ 1 query for domain + N queries for each concept

---

### 2. ConceptController::show()
**File:** `app/Http/Controllers/ConceptController.php`

**Before:**
```php
public function show(Concept $concept)
{
    $this->authorize('view', $concept);
    return view('concepts.show', compact('concept'));
}
```

**Problem:** The view (`concepts/show.blade.php`) accesses `$concept->domain`:
```blade
<a href="{{ route('concepts.index', $concept->domain) }}">
```

→ 1 query for concept + 1 query for domain = 2 queries per request

---

## ✅ Solution

Use Laravel's eager loading with `load()` method:

### 1. DomainController::show()
```php
public function show(Domain $domain)
{
    $this->authorize('view', $domain);

    $domain->load('concepts');

    return view('domains.show', compact('domain'));
}
```

### 2. ConceptController::show()
```php
public function show(Concept $concept)
{
    $this->authorize('view', $concept);

    $concept->load('domain');

    return view('concepts.show', compact('concept'));
}
```

---

## 📊 Impact

| Before | After |
|--------|-------|
| 1 + N queries | 1 query with JOIN |
| Slow for large datasets | Optimized |

---

## 🧪 Controllers Already Optimized

- `DomainController::index()` - Uses `withCount`, no relation access in loop
- `ConceptController::index()` - Uses `withCount`, concept-card doesn't access domain

---

## 🔄 Workflow

Branch: `bugfix/fix-n-plus-one`
Status: ✅ Fixed

---

## 📝 Notes

- Always check views for relation access (`$model->relation`)
- Use `load()` for eager loading on single models
- Use `with()` for eager loading on collections
- Use `withCount()` for counting related records without loading them