<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Archives - InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Geist:wght@400;500;600&amp;family=JetBrains+Mono:wght@400&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "surface-container-lowest": "#ffffff","on-surface-variant": "#464555","outline-variant": "#c7c4d8","background": "#f9f9ff","tertiary-container": "#885500","primary-container": "#4f46e5","on-secondary-container": "#00714d","secondary-fixed-dim": "#4edea3","error-container": "#ffdad6","on-surface": "#151c27","surface-tint": "#4d44e3","surface-dim": "#d3daea","on-secondary-fixed-variant": "#005236","secondary-container": "#6cf8bb","tertiary-fixed": "#ffddb8","error": "#ba1a1a","surface-container-low": "#f0f3ff","outline": "#777587","primary": "#3525cd","on-primary-fixed": "#0f0069","secondary": "#006c49","on-background": "#151c27","on-primary-container": "#dad7ff","secondary-fixed": "#6ffbbe","inverse-on-surface": "#ebf1ff","inverse-primary": "#c3c0ff","primary-fixed": "#e2dfff","inverse-surface": "#2a313d","surface": "#f9f9ff","on-primary": "#ffffff","surface-variant": "#dce2f3","surface-container-highest": "#dce2f3","surface-container-high": "#e2e8f8","tertiary-fixed-dim": "#ffb95f","primary-fixed-dim": "#c3c0ff","on-primary-fixed-variant": "#3323cc","surface-container": "#e7eefe","surface-bright": "#f9f9ff","on-secondary": "#ffffff","tertiary": "#684000"
              },
              "borderRadius": { "DEFAULT": "0.25rem","lg": "0.5rem","xl": "0.75rem","full": "9999px" },
              "spacing": { "margin-x": "2rem","stack-lg": "2rem","container-max": "1280px","stack-md": "1rem","gutter": "1.5rem","stack-sm": "0.5rem" },
              "fontFamily": { "body-lg": ["Inter"],"display": ["Inter"],"label-md": ["Geist"],"headline-md": ["Inter"],"headline-lg": ["Inter"],"code": ["JetBrains Mono"],"body-md": ["Inter"] },
              "fontSize": { "body-lg": ["18px", {"lineHeight": "28px","fontWeight": "400"}],"display": ["48px", {"lineHeight": "56px","letterSpacing": "-0.02em","fontWeight": "700"}],"label-md": ["14px", {"lineHeight": "20px","letterSpacing": "0.01em","fontWeight": "500"}],"headline-md": ["24px", {"lineHeight": "32px","fontWeight": "600"}],"headline-lg": ["32px", {"lineHeight": "40px","letterSpacing": "-0.01em","fontWeight": "600"}],"code": ["14px", {"lineHeight": "22px","fontWeight": "400"}],"body-md": ["16px", {"lineHeight": "24px","fontWeight": "400"}] }
            },
          },
        }
    </script>
<style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-background text-on-background font-body-md">
<aside class="h-screen w-64 fixed left-0 top-0 border-r border-outline-variant bg-surface shadow-sm flex flex-col py-6 px-4 z-50">
<div class="mb-10 px-2"><h1 class="text-headline-md font-display font-bold text-primary">InterviewPrep</h1><p class="text-on-surface-variant font-label-md">Laravel Mastery</p></div>
<nav class="flex-1 space-y-2">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-high transition-colors font-body-md" href="{{ route('dashboard') }}"><span class="material-symbols-outlined">dashboard</span><span>Dashboard</span></a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-high transition-colors font-body-md" href="{{ route('domains.index') }}"><span class="material-symbols-outlined">category</span><span>Domains</span></a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary font-bold bg-primary-container/10 transition-colors font-body-md" href="{{ route('concepts.archives', $domain) }}"><span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">archive</span><span>Archives</span></a>
</nav>
<div class="mt-auto space-y-4">
<button class="w-full bg-primary text-on-primary py-3 px-4 rounded-xl font-bold flex items-center justify-center gap-2 transition-transform active:scale-95 shadow-md"><span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>AI Generator</button>
</div>
</aside>
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-surface/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center h-16 px-8">
<div class="flex items-center gap-6 flex-1"><div class="relative w-full max-w-md"><span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span><input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 focus:ring-2 focus:ring-primary/20 text-body-md" placeholder="Search archives..." type="text"/></div></div>
<div class="flex items-center gap-4">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="material-symbols-outlined text-on-surface-variant hover:text-primary" title="Logout">logout</button>
</form>
</div>
</header>
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
<div class="max-w-[1280px] mx-auto">
<div class="mb-10 flex justify-between items-end">
<div>
<div class="flex items-center gap-3 mb-2">
<h2 class="font-headline-lg text-headline-lg text-on-surface">Archived Concepts</h2>
<span class="bg-surface-container-high text-on-surface-variant px-3 py-1 rounded-full text-label-md font-bold">{{ $concepts->count() }} Items</span>
</div>
<p class="text-on-surface-variant font-body-md max-w-2xl">Manage concepts temporarily removed from your active study plan in <strong>{{ $domain->name }}</strong>.</p>
</div>
<div class="flex gap-2">
<a href="{{ route('domains.show', $domain) }}" class="flex items-center gap-2 border border-outline-variant px-4 py-2 rounded-lg text-label-md font-bold hover:bg-surface-container transition-colors">&larr; Back to Domain</a>
</div>
</div>

@if (session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
@endif

@if ($concepts->isEmpty())
<div class="flex flex-col items-center justify-center py-24 text-center">
<div class="w-48 h-48 mb-8 relative"><div class="absolute inset-0 bg-primary/5 rounded-full blur-3xl"></div><img class="w-full h-full object-contain relative z-10 grayscale opacity-40" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCDP0UsT3oQd_vhpswR9Hj0lqLQpwYwETm12zmRY-k31EAwWmKArT5Yx5GLLDJiOqeNTgZuHy_HKwhjmkkIqZhSAkEph5GpR-f92UpjHn6eNlW3yu9NccZ-CrM_KCQY8NZ10CZRfZJfj7aMat5J9J27kFQAZNCTNpjTRfwBAXN2G7VPT_u59DgIpMXfXadEoIkBO4-vdHngqE9z3Nba1DC2hQu7ZZtD1aYn77CIjSk89n4LgjE3nUuvSKZAOGVNrI5gYZP7ZjRWMxc"/></div>
<h3 class="text-headline-md text-on-surface mb-2">No archived concepts</h3>
<p class="text-on-surface-variant max-w-sm mx-auto">Your archive is currently empty. Concepts you remove from your study plan will appear here.</p>
<a href="{{ route('domains.show', $domain) }}" class="mt-8 text-primary font-bold hover:underline">Return to Domain</a>
</div>
@else
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-gutter">
@foreach ($concepts as $concept)
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow group relative">
<div class="mb-4">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-secondary-container/20 text-on-secondary-container border border-secondary-container/30 mb-2">{{ $domain->name }}</span>
<h3 class="font-headline-md text-headline-sm text-on-surface group-hover:text-primary transition-colors">{{ $concept->title }}</h3>
</div>
<div class="flex items-center gap-4 mb-6">
<span class="flex items-center gap-1 text-label-md text-on-surface-variant"><span class="material-symbols-outlined text-[16px]">calendar_month</span>Archived {{ $concept->deleted_at->diffForHumans() }}</span>
<span class="px-2 py-0.5 rounded border border-slate-700 text-slate-700 bg-slate-50 text-[12px] font-bold">{{ ucfirst($concept->difficulty->value) }}</span>
</div>
<div class="flex gap-2 pt-4 border-t border-outline-variant">
<form method="POST" action="{{ route('concepts.restore', $concept) }}" class="flex-1">
@csrf
<button type="submit" class="w-full flex items-center justify-center gap-2 bg-primary/10 text-primary py-2 rounded-lg font-bold text-label-md hover:bg-primary hover:text-white transition-all"><span class="material-symbols-outlined text-[18px]">settings_backup_restore</span>Restore</button>
</form>
<form method="POST" action="{{ route('concepts.forceDelete', $concept) }}" onsubmit="return confirm('Permanently delete this concept? This cannot be undone.')" class="w-12">
@csrf @method('DELETE')
<button type="submit" class="w-full flex items-center justify-center border border-error/20 text-error rounded-lg hover:bg-error hover:text-white transition-all aspect-square"><span class="material-symbols-outlined text-[20px]">delete_forever</span></button>
</form>
</div>
</div>
@endforeach
</div>
@endif
</div>
</main>
</body></html>
