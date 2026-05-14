<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Dashboard | InterviewPrep</title>
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
                        "primary-fixed-dim": "#c3c0ff",
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
                        "on-primary-fixed": "#0f0069",
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
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .status-badge { @apply px-3 py-1 rounded-full text-xs font-semibold; }
        .badge-review { background-color: rgba(225, 29, 72, 0.1); color: #e11d48; }
        .badge-progress { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .badge-mastered { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
        .difficulty-tag { @apply border px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider; }
        .tag-junior { border-color: #818cf8; color: #4f46e5; background-color: rgba(129, 140, 248, 0.05); }
        .tag-mid { border-color: #334155; color: #334155; }
        .tag-senior { border-color: #0f172a; color: #0f172a; border-width: 2px; }
    </style>
</head>
<body class="bg-surface text-on-surface font-body-md overflow-x-hidden">
<!-- SideNavBar -->
<aside class="flex flex-col h-full py-6 px-4 h-screen w-64 fixed left-0 top-0 bg-surface dark:bg-inverse-surface border-r border-outline-variant dark:border-outline shadow-sm z-[60]">
<div class="mb-8 px-2">
<h1 class="text-headline-md font-display font-bold text-primary dark:text-inverse-primary">InterviewPrep</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Laravel Mastery</p>
</div>
<nav class="flex-1 space-y-2">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-primary dark:text-inverse-primary font-bold bg-primary-container/10 dark:bg-primary-fixed-dim/10" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined">dashboard</span>
<span>Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant scale-95 active:scale-90" href="{{ route('domains.index') }}">
<span class="material-symbols-outlined">category</span>
<span>Domains</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant scale-95 active:scale-90" href="{{ route('domains.archives') }}">
    <span class="material-symbols-outlined">archive</span>
    <span>Archives</span>
</a>
</nav>
<div class="mt-auto space-y-4">
<button class="w-full py-3 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg transition-transform active:scale-95">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">bolt</span>
                AI Generator
            </button>
<div class="flex items-center gap-3 p-2 rounded-xl bg-surface-container-low border border-outline-variant">
<img alt="User profile avatar" class="w-10 h-10 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB0viPcs19AoDiCrwoXV3QfXpBKCEKRO736XlhT7zTjUqNqvkC3dJnMifpGL5DbiC6ldN9vUPDoFV-8kofnIY9AvLBWTSWdFHJrWS0wmSxrJvRyD0ouC01wfqK4d31nHSySxG2HVqdeiOsdV6PKYPLatz847ibx-_ikrhUqpbCjp5axTBizS5bxIF28y_0gLDKS7LKE2WF71gH4Nyy51yDS0VkwQPrb47rmNGOMn8Y-AQyo40PSqvSOVqueL-dvztJG3316_gZhNTs"/>
<div class="overflow-hidden">
<p class="text-xs font-bold truncate">{{ Auth::user()->name }}</p>
<p class="text-[10px] text-on-surface-variant truncate">Premium Member</p>
</div>
</div>
</div>
</aside>
<!-- TopAppBar -->
<header class="flex justify-between items-center h-16 px-8 ml-64 fixed top-0 right-0 w-[calc(100%-16rem)] z-50 bg-surface/80 dark:bg-surface-dim/80 backdrop-blur-md border-b border-outline-variant dark:border-outline">
<div class="flex items-center bg-surface-container px-4 py-2 rounded-full w-96 border border-outline-variant">
<span class="material-symbols-outlined text-outline">search</span>
<input class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-outline font-label-md" placeholder="Search concepts or domains..." type="text"/>
</div>
<div class="flex items-center gap-6">
<div class="flex gap-4">
<a href="{{ route('domains.create') }}" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-all">Add Domain</a>
                            @php $firstDomain = Auth::user()->domains()->first(); @endphp
                            @if ($firstDomain)
                            <a href="{{ route('concepts.create', $firstDomain->id) }}" class="font-label-md text-label-md bg-primary-container text-on-primary px-4 py-1.5 rounded-lg hover:opacity-80 transition-opacity">Create Concept</a>
                            @endif
</div>
<div class="flex items-center gap-4 text-outline border-l border-outline-variant pl-4">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="material-symbols-outlined hover:text-primary transition-colors" title="Logout">logout</button>
</form>
</div>
</div>
</header>
<!-- Main Content -->
<main class="ml-64 mt-16 p-gutter max-w-container-max mx-auto">
<!-- Welcome Header -->
<div class="mb-stack-lg">
<h2 class="text-headline-lg font-display text-on-surface">System Overview</h2>
<p class="text-on-surface-variant font-body-md mt-1">Ready for your next architectural deep-dive, {{ Auth::user()->name }}?</p>
</div>
<!-- Bento Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter mb-stack-lg">
<!-- Total Concepts -->
<div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-primary/10 rounded-lg">
<span class="material-symbols-outlined text-primary">data_object</span>
</div>
</div>
<p class="text-on-surface-variant text-sm font-label-md uppercase tracking-wide">Total Concepts</p>
<h3 class="text-display font-display text-on-surface mt-1">{{ $totalConcepts }}</h3>
</div>
<!-- Mastery Rate -->
<div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow col-span-1">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-secondary/10 rounded-lg">
<span class="material-symbols-outlined text-secondary">verified</span>
</div>
</div>
<p class="text-on-surface-variant text-sm font-label-md uppercase tracking-wide">Mastery Rate</p>
<div class="flex items-end gap-2 mt-1">
<h3 class="text-display font-display text-on-surface">{{ $masteryRate }}</h3>
<span class="text-headline-md font-display mb-1.5">%</span>
</div>
<div class="w-full bg-surface-container-high h-1.5 rounded-full mt-4 overflow-hidden">
<div class="bg-secondary h-full" style="width: {{ $masteryRate }}%;"></div>
</div>
</div>
<!-- Most Mastered -->
<div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-amber-500/10 rounded-lg">
<span class="material-symbols-outlined text-amber-600">military_tech</span>
</div>
</div>
<p class="text-on-surface-variant text-sm font-label-md uppercase tracking-wide">Top Domain</p>
<h3 class="text-headline-md font-display text-on-surface mt-1 leading-tight">{{ $topDomain?->name ?? 'N/A' }}</h3>
<p class="text-xs text-on-surface-variant mt-2 font-bold uppercase">{{ $topDomain && $topDomain->concepts_count > 0 ? round(($topDomain->mastered_count / $topDomain->concepts_count) * 100) : 0 }}% Completion</p>
</div>
<!-- To Review -->
<div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-error/10 rounded-lg">
<span class="material-symbols-outlined text-error">priority_high</span>
</div>
</div>
<p class="text-on-surface-variant text-sm font-label-md uppercase tracking-wide">Review Needed</p>
<h3 class="text-headline-md font-display text-on-surface mt-1 leading-tight">{{ $reviewConcepts->first()?->domain?->name ?? 'None' }}</h3>
<p class="text-xs text-error mt-2 font-bold uppercase">{{ $reviewConcepts->count() }} Pending Items</p>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
<!-- Next in Queue Section -->
<div class="lg:col-span-2 space-y-stack-md">
<div class="flex items-center justify-between">
<h3 class="text-headline-sm font-display flex items-center gap-2">
<span class="material-symbols-outlined text-primary">play_circle</span>
                        Next in Queue
                    </h3>
</div>
<div class="space-y-4">
@forelse ($reviewConcepts as $concept)
<div class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl flex items-center gap-4 group hover:border-primary/50 transition-all cursor-pointer">
<div class="w-12 h-12 bg-surface rounded-lg flex items-center justify-center border border-outline-variant group-hover:bg-primary group-hover:text-white transition-colors">
<span class="material-symbols-outlined">key</span>
</div>
<div class="flex-1">
<div class="flex items-center gap-2 mb-1">
<span class="difficulty-tag tag-{{ $concept->difficulty->value }}">{{ ucfirst($concept->difficulty->value) }}</span>
<span class="status-badge badge-review">À revoir</span>
</div>
<h4 class="font-bold text-on-surface">{{ $concept->title }}</h4>
<p class="text-xs text-on-surface-variant">Last session: {{ $concept->updated_at->diffForHumans() }}</p>
</div>
<a href="{{ route('concepts.show', $concept) }}" class="material-symbols-outlined text-outline group-hover:translate-x-1 transition-transform">chevron_right</a>
</div>
@empty
<div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl text-center">
<p class="text-on-surface-variant">No concepts need review. Great job!</p>
</div>
@endforelse
</div>
<!-- Domain Distribution (Simplified Chart) -->
<div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl mt-stack-lg">
<h3 class="text-headline-sm font-display mb-6">Performance by Domain</h3>
<div class="space-y-6">
@forelse ($domains as $domain)
@php
$pct = $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0;
$barColor = $pct >= 70 ? 'bg-secondary' : ($pct >= 40 ? 'bg-primary' : 'bg-error');
@endphp
<div>
<div class="flex justify-between text-xs font-bold mb-2">
<span>{{ $domain->name }}</span>
<span>{{ $pct }}%</span>
</div>
<div class="h-2 bg-surface-container-high rounded-full">
<div class="h-full {{ $barColor }} rounded-full" style="width: {{ $pct }}%;"></div>
</div>
</div>
@empty
<div class="text-center py-4 text-on-surface-variant">No domains yet.</div>
@endforelse
</div>
</div>
</div>
<!-- Recent Activity Side Panel -->
<div class="lg:col-span-1 space-y-stack-md">
<div class="flex items-center justify-between">
<h3 class="text-headline-sm font-display flex items-center gap-2">
<span class="material-symbols-outlined text-secondary">history</span>
                        Recent Activity
                    </h3>
</div>
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl divide-y divide-outline-variant overflow-hidden">
@forelse ($domains->take(5) as $domain)
<div class="p-4 hover:bg-surface-container-low transition-colors">
<div class="flex gap-4">
<div class="mt-1 w-2 h-2 rounded-full bg-secondary shrink-0"></div>
<div>
<p class="text-sm font-medium text-on-surface">Domain: <span class="font-bold">{{ $domain->name }}</span></p>
<p class="text-[10px] text-outline mt-1 uppercase font-bold">{{ $domain->concepts_count }} concepts • {{ $domain->mastered_count }} mastered</p>
</div>
</div>
</div>
@empty
<div class="p-4 text-center text-on-surface-variant text-sm">No activity yet.</div>
@endforelse
</div>
<!-- Mini Promotion Card -->
<div class="bg-primary p-6 rounded-xl text-on-primary relative overflow-hidden shadow-lg">
<div class="relative z-10">
<h4 class="font-display font-bold text-lg mb-2 leading-tight">Master API Security</h4>
<p class="text-xs opacity-90 mb-4">Personalized learning path based on your recent 'Review' triggers.</p>
<button class="bg-white text-primary px-4 py-2 rounded-lg text-xs font-bold shadow-sm hover:bg-opacity-90">Start Focus Path</button>
</div>
<div class="absolute -right-4 -bottom-4 opacity-20">
<span class="material-symbols-outlined text-[120px]" style="font-variation-settings: 'FILL' 1;">security</span>
</div>
</div>
</div>
</div>
</main>
<!-- FAB -->
<button class="fixed bottom-8 right-8 w-14 h-14 bg-primary-container text-on-primary rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-transform z-[100]">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">school</span>
</button>
</body></html>
