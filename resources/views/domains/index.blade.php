<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Domains | InterviewPrep</title>
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
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #F9FAFB;
        }
    </style>
</head>
<body class="font-body-md text-on-surface">
<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-surface dark:bg-inverse-surface border-r border-outline-variant dark:border-outline shadow-sm flex flex-col py-6 px-4 z-50">
<div class="mb-10 px-2">
<h1 class="text-headline-md font-display font-bold text-primary dark:text-inverse-primary">InterviewPrep</h1>
<p class="font-label-md text-on-surface-variant text-xs">Laravel Mastery</p>
</div>
<nav class="flex-grow space-y-2">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors group" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined group-hover:text-primary" data-icon="dashboard">dashboard</span>
<span class="font-body-md">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary dark:text-inverse-primary font-bold bg-primary-container/10 dark:bg-primary-fixed-dim/10 transition-colors" href="{{ route('domains.index') }}">
<span class="material-symbols-outlined" data-icon="category">category</span>
<span class="font-body-md">Domains</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors group" href="{{ route('domains.archives') }}">
<span class="material-symbols-outlined group-hover:text-primary" data-icon="archive">archive</span>
<span class="font-body-md">Archives</span>
</a>
</nav>
<div class="mt-auto space-y-4">
<button class="w-full flex items-center justify-center gap-2 bg-primary-container text-white py-3 rounded-xl font-label-md active:scale-95 transition-transform">
<span class="material-symbols-outlined" data-icon="bolt" style="font-variation-settings: 'FILL' 1;">bolt</span>
                AI Generator
            </button>
<div class="flex items-center gap-3 px-2 py-3 border-t border-outline-variant">
<img alt="User profile avatar" class="w-10 h-10 rounded-full border-2 border-primary-container/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBZoYi-wHCuHWGL_EJPgMauZfmL2KlhfuyPfULaHB7R-RfbvO8VqI6RDlaE1vVq0DXpR9uEKFGpnBfEVTC1hsEUBccSZ5LD2hEEoiyACf-_tVxK1gaRmMeiF1yLu9KFFQZRSHWAacuYidruOuS33DKIp9Q8IPQ6JFn0eCU4FRefgTPP68ZbX7rF9V-IdS9k0QkQFxWMVO0jy_bphdDoxyw6sQbed5VvKLtXmrj2uzaD3KNW6yXNZUZyiMKJhtzW1dImBnoK_2-p0gg"/>
<div class="overflow-hidden">
<p class="font-label-md text-on-surface truncate">{{ Auth::user()->name }}</p>
<p class="text-[10px] text-on-surface-variant truncate">Premium Member</p>
</div>
</div>
</div>
</aside>
<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-surface/80 dark:bg-surface-dim/80 backdrop-blur-md border-b border-outline-variant dark:border-outline flex justify-between items-center h-16 px-8 ml-64">
<div class="flex items-center gap-4 flex-1">
<div class="relative w-full max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg" data-icon="search">search</span>
<input class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-full text-label-md focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" placeholder="Search domains..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<div class="flex items-center gap-2">
<a href="{{ route('domains.create') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg text-primary font-label-md hover:bg-primary/5 active:opacity-80 transition-all">
<span class="material-symbols-outlined" data-icon="add">add</span>
                    Add Domain
                </a>
@php $firstDomain = Auth::user()->domains()->first(); @endphp
                @if ($firstDomain)
                <a href="{{ route('concepts.create', $firstDomain) }}" class="bg-primary text-white px-5 py-2 rounded-lg font-label-md hover:shadow-lg active:opacity-80 transition-all">
                    Create Concept
                </a>
                @endif
</div>
<div class="h-6 w-[1px] bg-outline-variant mx-2"></div>
<div class="flex items-center gap-2">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container-high transition-colors" title="Logout">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="logout">logout</span>
</button>
</form>
</div>
</div>
</header>
<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 max-w-[1440px]">
<!-- Session Messages -->
@if (session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
@endif
<!-- Welcome & Stats Section -->
<section class="mb-10 flex flex-col md:flex-row justify-between items-end gap-6">
<div>
<h2 class="font-display text-headline-lg text-on-surface mb-2">Technical Domains</h2>
<p class="text-on-surface-variant font-body-md max-w-2xl">Manage your specialized knowledge areas. Track your mastery levels across backend architectures, language internals, and database optimization.</p>
</div>
<div class="flex gap-4">
<div class="bg-surface-container-lowest p-4 rounded-xl border border-outline-variant flex items-center gap-4 shadow-sm">
<div class="bg-primary/10 p-3 rounded-lg text-primary">
<span class="material-symbols-outlined" data-icon="school">school</span>
</div>
<div>
<p class="text-xs text-on-surface-variant font-label-md uppercase tracking-wider">Overall Progress</p>
<p class="text-headline-md font-bold text-on-surface">{{ $domains->sum('concepts_count') > 0 ? round(($domains->sum('concepts_count') > 0 ? $domains->sum('mastered_count') / $domains->sum('concepts_count') : 0) * 100) : 0 }}%</p>
</div>
</div>
</div>
</section>
<!-- Bento Grid Layout for Domains -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
@forelse ($domains as $domain)
@php
$pct = $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0;
$colorClasses = ['bg-rose-50', 'bg-amber-50', 'bg-emerald-50', 'bg-indigo-50'];
$iconColors = ['text-rose-600', 'text-amber-600', 'text-emerald-600', 'text-indigo-600'];
$badgeColors = ['bg-rose-100 text-rose-700', 'bg-amber-100 text-amber-700', 'bg-emerald-100 text-emerald-700', 'bg-indigo-100 text-indigo-700'];
$barColors = ['bg-rose-500', 'bg-amber-500', 'bg-emerald-500', 'bg-indigo-500'];
$i = $loop->index % 4;
@endphp
<div class="bg-white rounded-xl border border-outline-variant p-6 shadow-sm hover:shadow-md transition-shadow group">
<div class="flex justify-between items-start mb-4">
<div class="p-3 {{ $colorClasses[$i] }} rounded-xl group-hover:scale-110 transition-transform">
<span class="material-symbols-outlined {{ $iconColors[$i] }}" data-icon="database">database</span>
</div>
<span class="px-3 py-1 {{ $badgeColors[$i] }} text-xs font-bold rounded-full uppercase tracking-tight">{{ $pct >= 100 ? 'Maîtrisé' : ($pct >= 50 ? 'En cours' : 'À revoir') }}</span>
</div>
<a href="{{ route('domains.show', $domain) }}">
<h3 class="font-display text-headline-md text-on-surface mb-1 hover:text-primary transition-colors">{{ $domain->name }}</h3>
</a>
<p class="text-on-surface-variant text-sm font-body-md mb-6 line-clamp-2">{{ $domain->description ?? 'No description provided.' }}</p>
<div class="space-y-3">
<div class="flex justify-between items-center text-xs font-label-md">
<span class="text-on-surface-variant">{{ $domain->mastered_count }}/{{ $domain->concepts_count }} Concepts Mastered</span>
<span class="text-on-surface font-bold">{{ $pct }}%</span>
</div>
<div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
<div class="{{ $barColors[$i] }} h-full w-[{{ $pct }}%] rounded-full"></div>
</div>
</div>
<div class="mt-8 flex items-center justify-between">
<span class="text-xs font-label-md text-indigo-600 px-2 py-1 bg-indigo-50 border border-indigo-200 rounded">Junior</span>
<a href="{{ route('domains.show', $domain) }}" class="text-primary hover:underline font-label-md flex items-center gap-1">
                        {{ $pct >= 100 ? 'Review' : 'Continue' }} <span class="material-symbols-outlined text-sm" data-icon="{{ $pct >= 100 ? 'visibility' : 'play_arrow' }}">{{ $pct >= 100 ? 'visibility' : 'play_arrow' }}</span>
</a>
</div>
</div>
@empty
<!-- Empty State -->
<div class="lg:col-span-2 relative overflow-hidden rounded-xl border border-dashed border-primary/40 p-8 flex flex-col items-center justify-center text-center bg-primary/5 min-h-[300px]">
<div class="relative z-10">
<div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg mb-6 mx-auto">
<span class="material-symbols-outlined text-primary text-3xl" data-icon="library_add">library_add</span>
</div>
<h3 class="text-headline-md font-display text-primary mb-2">Expand Your Expertise</h3>
<p class="text-on-surface-variant max-w-md mx-auto mb-8 font-body-md">Missing a critical skill? Create a new technical domain to start tracking your professional growth and preparation.</p>
<a href="{{ route('domains.create') }}" class="bg-primary text-white px-8 py-3 rounded-xl font-label-md flex items-center gap-2 mx-auto hover:shadow-xl active:scale-95 transition-all">
<span class="material-symbols-outlined" data-icon="add_circle" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                        Add New Domain
                    </a>
</div>
<div class="absolute -right-20 -bottom-20 w-64 h-64 bg-primary/10 rounded-full blur-3xl"></div>
<div class="absolute -left-10 -top-10 w-48 h-48 bg-primary/5 rounded-full blur-2xl"></div>
</div>
@endforelse
</div>
</main>
</body></html>
