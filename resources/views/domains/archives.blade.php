<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Domain Archives | InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;family=JetBrains+Mono:wght@400&amp;family=Geist:wght@500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-surface": "#151c27",
                        "tertiary-fixed-dim": "#ffb95f",
                        "primary": "#3525cd",
                        "on-primary-fixed": "#0f0069",
                        "surface-tint": "#4d44e3",
                        "surface-container-high": "#e2e8f8",
                        "secondary-fixed-dim": "#4edea3",
                        "on-surface-variant": "#464555",
                        "tertiary": "#684000",
                        "on-error-container": "#93000a",
                        "surface-variant": "#dce2f3",
                        "on-secondary": "#ffffff",
                        "secondary-fixed": "#6ffbbe",
                        "tertiary-container": "#885500",
                        "on-tertiary-fixed-variant": "#653e00",
                        "surface-dim": "#d3daea",
                        "outline-variant": "#c7c4d8",
                        "primary-container": "#4f46e5",
                        "on-primary": "#ffffff",
                        "error": "#ba1a1a",
                        "surface-container-lowest": "#ffffff",
                        "outline": "#777587",
                        "tertiary-fixed": "#ffddb8",
                        "on-primary-fixed-variant": "#3323cc",
                        "on-error": "#ffffff",
                        "primary-fixed": "#e2dfff",
                        "on-tertiary-fixed": "#2a1700",
                        "on-secondary-container": "#00714d",
                        "surface-container": "#e7eefe",
                        "secondary": "#006c49",
                        "inverse-surface": "#2a313d",
                        "surface": "#f9f9ff",
                        "on-tertiary-container": "#ffd4a4",
                        "surface-container-highest": "#dce2f3",
                        "on-primary-container": "#dad7ff",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-tertiary": "#ffffff",
                        "surface-bright": "#f9f9ff",
                        "on-secondary-fixed": "#002113",
                        "background": "#f9f9ff",
                        "on-background": "#151c27",
                        "surface-container-low": "#f0f3ff",
                        "inverse-primary": "#c3c0ff",
                        "error-container": "#ffdad6",
                        "on-secondary-fixed-variant": "#005236",
                        "secondary-container": "#6cf8bb",
                        "inverse-on-surface": "#ebf1ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-x": "2rem",
                        "container-max": "1280px",
                        "stack-sm": "0.5rem",
                        "gutter": "1.5rem",
                        "stack-lg": "2rem",
                        "stack-md": "1rem"
                    },
                    "fontFamily": {
                        "display": ["Inter"],
                        "headline-lg": ["Inter"],
                        "code": ["JetBrains Mono"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "label-md": ["Geist"],
                        "headline-md": ["Inter"]
                    },
                    "fontSize": {
                        "display": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "code": ["14px", {"lineHeight": "22px", "fontWeight": "400"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}]
                    }
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #f9f9ff;
        }
    </style>
</head>
<body class="font-body-md text-on-surface">
<!-- SideNavBar -->
<aside class="flex flex-col h-full py-6 px-4 h-screen w-64 fixed left-0 top-0 bg-surface dark:bg-inverse-surface border-r border-outline-variant dark:border-outline shadow-sm z-[60]">
<div class="mb-8 px-2">
<h1 class="text-headline-md font-display font-bold text-primary dark:text-inverse-primary">InterviewPrep</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Laravel Mastery</p>
</div>
<nav class="flex-1 space-y-2">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant scale-95 active:scale-90" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined">dashboard</span>
<span>Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant scale-95 active:scale-90" href="{{ route('domains.index') }}">
<span class="material-symbols-outlined">category</span>
<span>Domains</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-primary dark:text-inverse-primary font-bold bg-primary-container/10 dark:bg-primary-fixed-dim/10" href="{{ route('domains.archives') }}">
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
                <a href="{{ route('concepts.create', $firstDomain) }}" class="font-label-md text-label-md bg-primary-container text-on-primary px-4 py-1.5 rounded-lg hover:opacity-80 transition-opacity">Create Concept</a>
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

@if (session('success'))
<div class="mb-6 p-4 bg-secondary-container/30 border border-secondary/20 text-on-secondary-container rounded-lg text-sm">
{{ session('success') }}
</div>
@endif

<!-- Page Header -->
<div class="flex justify-between items-end mb-stack-lg">
<div>
<h2 class="text-headline-lg font-display text-on-surface">Domain Archives</h2>
<p class="text-on-surface-variant font-body-md mt-1">
@if ($domains->isEmpty())
                    No archived domains
@else
                    Showing {{ $domains->count() }} {{ Str::plural('archived domain', $domains->count()) }}
@endif
</p>
</div>
</div>

@if ($domains->isEmpty())
<!-- Empty State -->
<div class="flex flex-col items-center justify-center py-24 text-center">
<div class="w-64 h-64 bg-surface-container rounded-full flex items-center justify-center mb-8">
<span class="material-symbols-outlined text-8xl text-outline-variant">inventory_2</span>
</div>
<h3 class="text-headline-md font-display text-on-surface">Your archive is empty</h3>
<p class="text-on-surface-variant mt-2 max-w-sm">Archived domains will appear here. When you delete a domain, it's moved to this archive.</p>
<a href="{{ route('domains.index') }}" class="mt-8 px-6 py-3 bg-primary text-on-primary rounded-lg font-bold shadow-lg shadow-primary/20 hover:scale-105 transition-transform">Return to Domains</a>
</div>
@else
<!-- Bento-style Grid for Archived Items -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
@foreach ($domains as $domain)
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant p-6 shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between h-full">
<div>
<div class="flex justify-between items-start mb-4">
<div class="p-3 rounded-lg" style="background-color: {{ $domain->color }}20;">
<span class="material-symbols-outlined text-3xl" style="color: {{ $domain->color }};">folder</span>
</div>
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-surface-container-high text-on-surface-variant">
<span class="material-symbols-outlined text-xs mr-1">archive</span>
                                Archived
                            </span>
</div>
<h3 class="font-headline-md text-headline-md mb-2">{{ $domain->name }}</h3>
@if ($domain->description)
<p class="text-on-surface-variant text-sm mb-4 line-clamp-2">{{ $domain->description }}</p>
@endif
<div class="space-y-4">
<div class="flex items-center gap-2 text-on-surface-variant font-label-md">
<span class="material-symbols-outlined text-sm">calendar_today</span>
<span>Deleted {{ $domain->deleted_at->diffForHumans() }}</span>
</div>
</div>
</div>
<div class="mt-8 pt-6 border-t border-outline-variant flex items-center justify-between">
<form method="POST" action="{{ route('domains.restore', $domain) }}" class="inline">
@csrf
<button type="submit" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-label-md hover:opacity-90 active:scale-95 transition-all">
                                Restore
                            </button>
</form>
<form method="POST" action="{{ route('domains.forceDelete', $domain) }}" class="inline" onsubmit="return confirm('Permanently delete this domain? All associated concepts will also be lost.')">
@csrf
@method('delete')
<button type="submit" class="p-2 text-error hover:bg-error/10 rounded-full transition-colors" title="Delete Permanently">
<span class="material-symbols-outlined">delete</span>
</button>
</form>
</div>
</div>
@endforeach
</div>
@endif
</main>
</body></html>
