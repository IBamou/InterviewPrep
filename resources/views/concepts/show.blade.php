<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400&amp;family=Geist:wght@500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                    "surface-container-lowest": "#ffffff",
                    "surface-dim": "#d3daea",
                    "inverse-on-surface": "#ebf1ff",
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
                    "on-secondary-fixed-variant": "#005236",
                    "on-surface": "#151c27",
                    "on-primary": "#ffffff",
                    "secondary-container": "#6cf8bb",
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
      .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
      body { background-color: #f9f9ff; }
    </style>
</head>
<body class="font-body-md text-on-surface">
<!-- SideNav -->
<aside class="flex flex-col h-full py-6 px-4 h-screen w-64 fixed left-0 top-0 bg-surface dark:bg-inverse-surface border-r border-outline-variant dark:border-outline shadow-sm z-50">
<div class="mb-8 px-2">
<h1 class="text-headline-md font-display font-bold text-primary dark:text-inverse-primary">InterviewPrep</h1>
<p class="font-label-md text-on-surface-variant">Laravel Mastery</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2 rounded-xl text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors group" href="{{ route('dashboard') }}"><span class="material-symbols-outlined">dashboard</span><span>Dashboard</span></a>
<a class="flex items-center gap-3 px-3 py-2 rounded-xl text-primary dark:text-inverse-primary font-bold bg-primary-container/10 dark:bg-primary-fixed-dim/10 transition-colors group" href="{{ route('domains.index') }}"><span class="material-symbols-outlined">category</span><span>Domains</span></a>
<a class="flex items-center gap-3 px-3 py-2 rounded-xl text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors group" href="{{ route('domains.archives') }}"><span class="material-symbols-outlined">archive</span><span>Archives</span></a>
</nav>
<div class="mt-auto px-2">
<button class="w-full py-3 px-4 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 active:scale-95 transition-transform"><span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>AI Generator</button>
<div class="mt-6 flex items-center gap-3 pt-6 border-t border-outline-variant">
<div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center overflow-hidden"><img alt="User" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCheQ4w8osK_-r7D08rXlA-3_wjdlSbc1R96d61wsfZc0FFrYeQfTq5JOJlozk1mDp1hn3dMgLF6YImEQBxH-QhC_3Xe0fJN6xL0ze_BbbClgzc6lYVc3rOy0ru7q-mp46iWAuSQ7VKvDxNYn2hW4XeFJTiJIsvkzkm6rwVDxaamH323nDoyeHR38MUqFEdnJRSpQFcMnt5bLxfA_2JdD7BmthZ-CzFYS90hKaAI-lLPRhXsv1ToERYd6uy-ssP4UyQY-0oPcfIRzU"/></div>
<div class="flex flex-col"><span class="font-label-md font-bold">{{ Auth::user()->name }}</span><span class="text-[12px] text-on-surface-variant">Pro Member</span></div>
</div>
</div>
</aside>
<!-- TopBar -->
<header class="flex justify-between items-center h-16 px-8 ml-64 fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-surface/80 backdrop-blur-md border-b border-outline-variant">
<div class="flex items-center gap-4 flex-1">
<div class="relative w-64 group">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary">search</span>
<input class="w-full bg-surface-container-low border-none rounded-full pl-10 pr-4 py-1.5 text-label-md focus:ring-2 focus:ring-primary/20" placeholder="Search concepts..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-3">
<a href="{{ route('concepts.edit', $concept) }}" class="px-4 py-2 border border-primary text-primary rounded-lg font-label-md hover:bg-primary/5 transition-colors">Edit</a>
<form method="POST" action="{{ route('concepts.archive', $concept) }}" onsubmit="return confirm('Archive this concept?')">
@csrf @method('DELETE')
<button type="submit" class="px-4 py-2 bg-error text-on-error rounded-lg font-label-md hover:opacity-90">Archive</button>
</form>
</div>
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="material-symbols-outlined text-on-surface-variant hover:text-primary ml-2" title="Logout">logout</button>
</form>
</div>
</header>
<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 max-w-[1440px] mx-auto">
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
<div class="space-y-4">
<nav class="flex items-center gap-2 text-on-surface-variant font-label-md">
<a class="hover:text-primary" href="{{ route('domains.index') }}">Domains</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<a class="hover:text-primary" href="{{ route('domains.show', $concept->domain) }}">{{ $concept->domain->name }}</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<span class="text-on-surface font-bold">{{ $concept->title }}</span>
</nav>
<h2 class="text-display font-display text-on-surface">{{ $concept->title }}</h2>
<div class="flex items-center gap-3">
@php
$dc = ['junior' => 'border-indigo-600 text-indigo-600 bg-indigo-50', 'mid' => 'border-slate-700 text-slate-700 bg-slate-50', 'senior' => 'border-slate-900 text-slate-900 bg-slate-100'];
$sc = ['to_review' => 'bg-rose-50 text-rose-700', 'in_progress' => 'bg-amber-50 text-amber-700', 'mastered' => 'bg-emerald-50 text-emerald-700'];
$sl = ['to_review' => 'À revoir', 'in_progress' => 'En cours', 'mastered' => 'Maîtrisé'];
@endphp
<span class="px-3 py-1 rounded-full border font-label-md font-semibold {{ $dc[$concept->difficulty->value] ?? '' }}">{{ ucfirst($concept->difficulty->value) }}</span>
<span class="px-3 py-1 rounded-full font-label-md font-semibold {{ $sc[$concept->status->value] ?? '' }}">{{ $sl[$concept->status->value] ?? $concept->status->label() }}</span>
</div>
</div>
</div>

<div class="grid grid-cols-12 gap-8">
<div class="col-span-12 lg:col-span-8 space-y-8">
<div class="bg-surface-container-lowest border border-outline-variant p-8 rounded-xl shadow-sm">
<h3 class="text-headline-md font-display text-on-surface mb-6">Introduction</h3>
<div class="space-y-6 text-on-surface-variant leading-relaxed">
<div class="text-body-lg">{!! nl2br(e($concept->explanation)) !!}</div>
</div>
</div>
</div>
<div class="col-span-12 lg:col-span-4 space-y-8">
<div class="bg-primary text-on-primary rounded-xl p-8 shadow-lg relative overflow-hidden group">
<div class="absolute -right-12 -top-12 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all"></div>
<div class="relative z-10">
<div class="flex items-center gap-3 mb-4">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
<h3 class="text-headline-sm font-display font-bold">AI Interview Prep</h3>
</div>
<p class="text-on-primary-container mb-8 font-body-md opacity-90">Test your knowledge with custom-tailored technical questions generated from this concept.</p>
<span class="block w-full py-4 bg-white/20 text-on-primary rounded-xl font-bold text-center opacity-60">Generate Questions (Coming Soon)</span>
</div>
</div>
<!-- Domain Context -->
<div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant">
<h4 class="text-label-md font-bold mb-4">Domain</h4>
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center"><span class="material-symbols-outlined text-on-primary">category</span></div>
<div>
<a href="{{ route('domains.show', $concept->domain) }}" class="font-bold text-primary hover:underline">{{ $concept->domain->name }}</a>
<p class="text-xs text-on-surface-variant">{{ $concept->domain->concepts_count }} concepts</p>
</div>
</div>
</div>
<!-- Status Actions -->
<div class="flex flex-col gap-3">
<form method="POST" action="{{ route('concepts.updateStatus', $concept) }}">
@csrf @method('PATCH')
<button type="submit" class="w-full py-3 px-4 bg-secondary-container text-on-secondary-container rounded-xl font-bold hover:opacity-90 transition-all">Advance Status</button>
</form>
<a href="{{ route('concepts.edit', $concept) }}" class="w-full py-3 px-4 border border-outline-variant text-on-surface-variant rounded-xl font-bold text-center hover:bg-surface-container transition-all">Edit Concept</a>
</div>
</div>
</div>
</main>
</body></html>
