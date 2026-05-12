<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>InterviewPrep - {{ $domain->name }} Mastery</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono&amp;family=Geist:wght@400;500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "surface-container-high": "#e2e8f8",
                      "on-primary-container": "#dad7ff",
                      "secondary-fixed": "#6ffbbe",
                      "tertiary": "#684000",
                      "surface-container-low": "#f0f3ff",
                      "tertiary-container": "#885500",
                      "surface-tint": "#4d44e3",
                      "on-tertiary-fixed-variant": "#653e00",
                      "surface-container-lowest": "#ffffff",
                      "surface-dim": "#d3daea",
                      "inverse-on-surface": "#ebf1ff",
                      "on-primary-fixed-variant": "#3323cc",
                      "primary": "#3525cd",
                      "surface": "#f9f9ff",
                      "on-tertiary-container": "#ffd4a4",
                      "on-tertiary": "#ffffff",
                      "on-error": "#ffffff",
                      "surface-container": "#e7eefe",
                      "outline": "#777587",
                      "on-secondary-fixed": "#002113",
                      "on-surface-variant": "#464555",
                      "on-background": "#151c27",
                      "on-secondary-fixed-variant": "#005236",
                      "on-surface": "#151c27",
                      "on-primary": "#ffffff",
                      "secondary-container": "#6cf8bb",
                      "on-primary-fixed": "#002113",
                      "primary-container": "#4f46e5",
                      "surface-bright": "#f9f9ff",
                      "secondary": "#006c49",
                      "tertiary-fixed-dim": "#ffb95f",
                      "inverse-primary": "#c3c0ff",
                      "on-secondary-container": "#00714d",
                      "tertiary-fixed": "#ffddb8",
                      "on-tertiary-fixed": "#2a1700",
                      "surface-container-highest": "#dce2f3",
                      "error": "#ba1a1a",
                      "outline-variant": "#c7c4d8",
                      "on-error-container": "#93000a",
                      "secondary-fixed-dim": "#4edea3",
                      "primary-fixed": "#e2dfff",
                      "inverse-surface": "#2a313d",
                      "error-container": "#ffdad6",
                      "background": "#f9f9ff",
                      "on-secondary": "#ffffff",
                      "surface-variant": "#dce2f3"
              },
              "borderRadius": {
                      "DEFAULT": "0.25rem",
                      "lg": "0.5rem",
                      "xl": "0.75rem",
                      "full": "9999px"
              },
              "spacing": {
                      "gutter": "1.5rem",
                      "stack-lg": "2rem",
                      "margin-x": "2rem",
                      "container-max": "1280px",
                      "stack-md": "1rem",
                      "stack-sm": "0.5rem"
              },
              "fontFamily": {
                      "display": ["Inter"],
                      "body-lg": ["Inter"],
                      "headline-md": ["Inter"],
                      "body-md": ["Inter"],
                      "headline-lg": ["Inter"],
                      "code": ["JetBrains Mono"],
                      "label-md": ["Geist"]
              },
              "fontSize": {
                      "display": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                      "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                      "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                      "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                      "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                      "code": ["14px", {"lineHeight": "22px", "fontWeight": "400"}],
                      "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}]
              }
            },
          },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .difficulty-junior { border: 1px solid #6366f1; color: #6366f1; background-color: rgba(99, 102, 241, 0.05); }
        .difficulty-mid { border: 1px solid #334155; color: #334155; background-color: rgba(51, 65, 85, 0.05); }
        .difficulty-senior { border: 1px solid #0f172a; color: #0f172a; font-weight: 700; background-color: rgba(15, 23, 42, 0.05); }
        
        .status-revoir { background-color: rgba(225, 29, 72, 0.1); color: #e11d48; }
        .status-cours { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .status-maitrise { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
    </style>
</head>
<body class="bg-background text-on-background font-body-md">
<!-- Side Navigation -->
<aside class="flex flex-col h-full py-6 px-4 h-screen w-64 fixed left-0 top-0 bg-surface dark:bg-inverse-surface border-r border-outline-variant dark:border-outline shadow-sm z-50">
<div class="mb-8 px-2">
<h1 class="text-headline-md font-display font-bold text-primary dark:text-inverse-primary">InterviewPrep</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Laravel Mastery</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-body-md">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-primary dark:text-inverse-primary font-bold bg-primary-container/10 dark:bg-primary-fixed-dim/10 transition-colors" href="{{ route('domains.index') }}">
<span class="material-symbols-outlined">category</span>
<span class="font-body-md">Domains</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors" href="{{ route('domains.archives') }}">
<span class="material-symbols-outlined">archive</span>
<span class="font-body-md">Archives</span>
</a>
</nav>
<div class="mt-auto px-2">
<button class="w-full py-3 px-4 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 active:scale-95 transition-transform">
<span class="material-symbols-outlined">bolt</span>
                AI Generator
            </button>
</div>
</aside>
<!-- Top App Bar -->
<header class="flex justify-between items-center h-16 px-8 ml-64 fixed top-0 right-0 w-[calc(100%-16rem)] z-50 bg-surface/80 dark:bg-surface-dim/80 backdrop-blur-md border-b border-outline-variant dark:border-outline">
<div class="flex items-center gap-4 flex-1">
<div class="relative w-96">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
<input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 focus:ring-2 focus:ring-primary/20 text-body-md" placeholder="Search concepts..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-2">
<a href="{{ route('domains.create') }}" class="px-4 py-2 text-primary font-bold hover:bg-primary/5 rounded-lg transition-colors">Add Domain</a>
<a href="{{ route('concepts.create', $domain) }}" class="px-4 py-2 bg-primary text-on-primary font-bold rounded-lg shadow-sm hover:opacity-90 active:opacity-80 transition-all">Create Concept</a>
</div>
<div class="flex items-center gap-4 border-l border-outline-variant pl-6">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-all" title="Logout">logout</button>
</form>
</div>
</div>
</header>
<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
<!-- Breadcrumbs & Header -->
<div class="max-w-container-max mx-auto mb-8">
<nav class="flex items-center gap-2 text-label-md font-label-md text-on-surface-variant mb-2">
<a class="hover:text-primary" href="{{ route('domains.index') }}">Domains</a>
<span class="material-symbols-outlined text-sm">chevron_right</span>
<span class="text-on-surface">{{ $domain->name }}</span>
</nav>
<div class="flex items-end justify-between">
<div>
<h2 class="font-display text-display text-on-surface">{{ $domain->name }}</h2>
<p class="text-body-lg text-on-surface-variant max-w-2xl">{{ $domain->description ?? 'No description provided.' }}</p>
</div>
<div class="flex gap-4">
@php $pct = $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0; @endphp
<div class="text-right">
<p class="text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Overall Progress</p>
<div class="flex items-center gap-3">
<span class="font-display text-headline-md text-primary">{{ $pct }}%</span>
<div class="w-32 h-2 bg-surface-container-highest rounded-full overflow-hidden">
<div class="h-full bg-primary w-[{{ $pct }}%]"></div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Concepts Table -->
<div class="max-w-container-max mx-auto">
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden shadow-sm">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant">
<th class="px-6 py-4 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Concept Title</th>
<th class="px-6 py-4 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Difficulty</th>
<th class="px-6 py-4 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Status</th>
<th class="px-6 py-4 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider">Last Activity</th>
<th class="px-6 py-4 text-label-md font-label-md text-on-surface-variant uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant">
@forelse ($domain->concepts as $concept)
<tr class="hover:bg-surface-container-low/50 transition-colors">
<td class="px-6 py-5">
<div class="flex flex-col">
<a href="{{ route('concepts.show', $concept) }}" class="font-bold text-on-surface hover:text-primary transition-colors">{{ $concept->title }}</a>
<span class="text-sm text-on-surface-variant">{{ Str::limit($concept->explanation, 60) }}</span>
</div>
</td>
<td class="px-6 py-5">
<span class="px-2 py-1 rounded-md text-xs difficulty-{{ $concept->difficulty->value }} uppercase tracking-tight {{ $concept->difficulty->value === 'senior' ? 'font-bold' : '' }}">{{ ucfirst($concept->difficulty->value) }}</span>
</td>
<td class="px-6 py-5">
@php
$statusMap = ['to_review' => 'revoir', 'in_progress' => 'cours', 'mastered' => 'maitrise'];
$iconMap = ['to_review' => 'error', 'in_progress' => 'pending', 'mastered' => 'check_circle'];
@endphp
<span class="flex items-center gap-2 px-3 py-1.5 rounded-full text-sm status-{{ $statusMap[$concept->status->value] }} font-medium">
<span class="material-symbols-outlined text-[18px]">{{ $iconMap[$concept->status->value] }}</span>
{{ $concept->status->label() }}
</span>
</td>
<td class="px-6 py-5">
<span class="text-sm text-on-surface-variant">{{ $concept->updated_at->diffForHumans() }}</span>
</td>
<td class="px-6 py-5 text-right">
<a href="{{ route('concepts.show', $concept) }}" class="text-primary font-bold hover:underline transition-all">View Details</a>
</td>
</tr>
@empty
<tr>
<td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
No concepts in this domain yet. <a href="{{ route('concepts.create', $domain) }}" class="text-primary font-bold hover:underline">Create one</a>.
</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
<!-- Bento Stats Section -->
<div class="max-w-container-max mx-auto mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="p-6 bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm">
<h4 class="text-label-md font-label-md text-on-surface-variant uppercase tracking-widest mb-4">Focus Area</h4>
<div class="space-y-4">
<div class="flex items-center justify-between">
<span class="text-body-md">Mastery Progress</span>
<span class="text-primary font-bold">{{ $pct }}%</span>
</div>
<div class="w-full h-1.5 bg-surface-container-highest rounded-full overflow-hidden">
<div class="h-full bg-primary w-[{{ $pct }}%]"></div>
</div>
<div class="flex items-center justify-between">
<span class="text-body-md">Concepts</span>
<span class="text-primary font-bold">{{ $domain->mastered_count }}/{{ $domain->concepts_count }}</span>
</div>
<div class="w-full h-1.5 bg-surface-container-highest rounded-full overflow-hidden">
<div class="h-full bg-primary w-[{{ $domain->concepts_count > 0 ? ($domain->mastered_count / $domain->concepts_count) * 100 : 0 }}%]"></div>
</div>
</div>
</div>
<div class="p-6 bg-primary-container text-on-primary-container rounded-xl shadow-sm relative overflow-hidden group">
<div class="relative z-10">
<h4 class="text-label-md font-label-md text-on-primary-container/70 uppercase tracking-widest mb-2">Practice Challenge</h4>
<p class="text-headline-sm font-display font-bold mb-4">Master {{ $domain->name }}</p>
<a href="{{ route('concepts.create', $domain) }}" class="inline-block px-4 py-2 bg-on-primary-container text-primary font-bold rounded-lg hover:opacity-90 active:scale-95 transition-all">Add Concept</a>
</div>
<span class="material-symbols-outlined text-[120px] absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">bolt</span>
</div>
<div class="p-6 bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm flex flex-col justify-between">
<div>
<h4 class="text-label-md font-label-md text-on-surface-variant uppercase tracking-widest mb-2">Study Overview</h4>
<p class="text-headline-md font-display font-bold text-on-surface">{{ $domain->concepts_count }} Concepts</p>
<p class="text-xs text-on-surface-variant mt-1">{{ $domain->mastered_count }} mastered &middot; {{ $domain->concepts_count - $domain->mastered_count }} in progress</p>
</div>
</div>
</div>
</main>
<!-- Floating Action -->
<a href="{{ route('concepts.create', $domain) }}" class="fixed right-8 bottom-8 w-14 h-14 bg-primary text-on-primary rounded-full shadow-lg flex items-center justify-center hover:scale-110 active:scale-90 transition-all z-50">
<span class="material-symbols-outlined">add</span>
</a>
</body></html>
