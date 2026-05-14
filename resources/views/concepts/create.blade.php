<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Add New Concept - InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Geist:wght@400;500;600&amp;family=JetBrains+Mono:wght@400&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary": "#ffffff","tertiary": "#684000","on-surface": "#151c27","on-secondary-container": "#00714d","on-primary-fixed": "#0f0069","tertiary-container": "#885500","secondary-fixed": "#6ffbbe","surface": "#f9f9ff","secondary": "#006c49","on-error-container": "#93000a","outline": "#777587","on-tertiary-fixed": "#2a1700","secondary-fixed-dim": "#4edea3","surface-tint": "#4d44e3","inverse-surface": "#2a313d","surface-variant": "#dce2f3","on-surface-variant": "#464555","surface-bright": "#f9f9ff","on-background": "#151c27","tertiary-fixed-dim": "#ffb95f","primary": "#3525cd","on-secondary-fixed-variant": "#005236","primary-fixed": "#e2dfff","background": "#f9f9ff","error": "#ba1a1a","tertiary-fixed": "#ffddb8","surface-container": "#e7eefe","error-container": "#ffdad6","primary-fixed-dim": "#c3c0ff","on-tertiary-fixed-variant": "#653e00","primary-container": "#4f46e5","on-primary-fixed-variant": "#3323cc","on-error": "#ffffff","surface-container-low": "#f0f3ff","inverse-on-surface": "#ebf1ff","surface-container-lowest": "#ffffff","on-primary-container": "#dad7ff","outline-variant": "#c7c4d8","on-tertiary-container": "#ffd4a4","on-tertiary": "#ffffff","secondary-container": "#6cf8bb","on-primary": "#ffffff","surface-container-high": "#e2e8f8","inverse-primary": "#c3c0ff","on-secondary-fixed": "#002113","surface-dim": "#d3daea","surface-container-highest": "#dce2f3"
                    },
                    "borderRadius": { "DEFAULT": "0.25rem","lg": "0.5rem","xl": "0.75rem","full": "9999px" },
                    "spacing": { "gutter": "1.5rem","stack-md": "1rem","margin-x": "2rem","container-max": "1280px","stack-sm": "0.5rem","stack-lg": "2rem" },
                    "fontFamily": { "headline-md": ["Inter"],"headline-lg": ["Inter"],"label-md": ["Geist"],"body-md": ["Inter"],"code": ["JetBrains Mono"],"display": ["Inter"],"body-lg": ["Inter"] },
                    "fontSize": { "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],"headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],"label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],"body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],"code": ["14px", {"lineHeight": "22px", "fontWeight": "400"}],"display": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],"body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}] }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #f9f9ff; color: #151c27; }
    </style>
</head>
<body class="font-body-md text-on-background">
<aside class="h-screen w-64 fixed left-0 top-0 border-r border-outline-variant bg-surface flex flex-col py-6 px-4 shadow-sm z-50">
<div class="mb-10 px-2"><h1 class="text-headline-md font-display font-bold text-primary">InterviewPrep</h1><p class="text-on-surface-variant font-label-md">Laravel Mastery</p></div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-high font-body-md rounded-lg" href="{{ route('dashboard') }}"><span class="material-symbols-outlined">dashboard</span>Dashboard</a>
<a class="flex items-center gap-3 px-3 py-2 text-primary font-bold bg-primary-container/10 font-body-md rounded-lg" href="{{ route('domains.index') }}"><span class="material-symbols-outlined">category</span>Domains</a>
<a class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-high font-body-md rounded-lg" href="{{ route('domains.archives') }}"><span class="material-symbols-outlined">archive</span>Archives</a>
</nav>
<div class="mt-auto">
<button class="w-full bg-primary text-on-primary py-3 px-4 rounded-xl font-bold flex items-center justify-center gap-2 hover:opacity-90 active:scale-95"><span class="material-symbols-outlined">auto_awesome</span>AI Generator</button>
<div class="mt-6 flex items-center gap-3 px-2"><div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center overflow-hidden"><img alt="User" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTsFAuwuquz3WDJ56vwrJ8yJgGKChwSvJ2qjMOO53y_nWz01qZZbMpE-jZ4nKvcyrqxBDf_8sp349BVGMxBLvwveU8zd_4mA7g1eMsuDLfYYHpMNKEXbujEJo03yAq-L_S_tgRTGyzXVG3l6IaDYwmVlP3Cm5SMGWslFaODHkAAlYAxggaytfaTkTh-M-qsNXaAWTxtfm0Ls4shOl_DvF2Y-sw_FbnMtB7NPM-WvtlZBYVgDmjp2GkLfLKS3vBiLA1L7iXmy_RqiU"/></div>
<div class="flex flex-col"><span class="font-label-md font-bold">{{ Auth::user()->name }}</span><span class="text-xs text-on-surface-variant">Senior Dev</span></div>
</div>
</div>
</aside>
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-surface/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center px-8 z-40">
<div class="flex items-center gap-4 flex-1"><div class="relative w-full max-w-md"><span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span><input class="w-full bg-surface-container-low border-none rounded-full pl-10 pr-4 py-2 text-label-md focus:ring-2 focus:ring-primary/20" placeholder="Search..." type="text"/></div></div>
<div class="flex items-center gap-6">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="material-symbols-outlined text-on-surface-variant hover:text-primary" title="Logout">logout</button>
</form>
</div>
</header>
<main class="ml-64 pt-24 pb-12 px-8">
<div class="max-w-6xl mx-auto">
<nav class="mb-4"><ol class="flex items-center gap-2 text-label-md text-on-surface-variant">
<li><a class="hover:text-primary" href="{{ route('domains.index') }}">Domains</a></li>
<li><span class="material-symbols-outlined text-xs">chevron_right</span></li>
<li><a class="hover:text-primary" href="{{ route('domains.show', $domain) }}">{{ $domain->name }}</a></li>
<li><span class="material-symbols-outlined text-xs">chevron_right</span></li>
<li class="text-primary font-bold">New Concept</li>
</ol></nav>
<header class="mb-8"><h2 class="font-headline-lg text-headline-lg text-on-surface">Add New Concept</h2><p class="text-on-surface-variant mt-1">Define a new technical building block for your interview preparation.</p></header>

@if ($errors->any())
<div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-lg text-sm"><ul class="list-disc pl-4 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="grid grid-cols-12 gap-8 items-start">
<section class="col-span-12 lg:col-span-8 space-y-6">
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-8 shadow-sm">
<form method="POST" action="{{ route('concepts.store', $domain) }}" class="space-y-8">
@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="space-y-2">
<label class="font-label-md font-bold text-on-surface" for="title">Concept Title</label>
<input class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg p-3 text-body-md @error('title') border-error @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Dependency Injection" type="text" required/>
@error('title')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
</div>
<div class="space-y-2">
<label class="font-label-md font-bold text-on-surface">Domain</label>
<div class="w-full border-outline-variant rounded-lg p-3 text-body-md bg-surface-container-low">{{ $domain->name }}</div>
</div>
</div>
<div class="space-y-2">
<label class="font-label-md font-bold text-on-surface">Difficulty Level</label>
<div class="flex gap-2">
@foreach (['junior' => 'Junior', 'mid' => 'Mid', 'senior' => 'Senior'] as $val => $label)
<label class="flex-1 cursor-pointer group">
<input type="radio" name="difficulty" value="{{ $val }}" class="hidden peer" {{ old('difficulty', 'junior') === $val ? 'checked' : '' }}/>
<div class="text-center p-3 rounded-lg border border-outline-variant peer-checked:border-primary peer-checked:bg-primary-fixed-dim/20 transition-all group-hover:bg-surface-container">
<span class="text-label-md font-medium">{{ $label }}</span>
</div>
</label>
@endforeach
</div>
@error('difficulty')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
</div>
<div class="space-y-2">
<label class="font-label-md font-bold text-on-surface" for="explanation">Initial Notes &amp; Definition</label>
<textarea class="w-full border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg p-4 text-body-md @error('explanation') border-error @enderror" id="explanation" name="explanation" rows="10" placeholder="### Key Definition&#10;Explain the concept in detail..." required>{{ old('explanation') }}</textarea>
@error('explanation')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
</div>
<div class="flex justify-end items-center gap-4 pt-4 border-t border-outline-variant">
<a href="{{ route('domains.show', $domain) }}" class="px-6 py-2 rounded-lg border border-primary text-primary font-label-md hover:bg-primary/5">Cancel</a>
<button class="px-8 py-2 rounded-lg bg-primary text-on-primary font-label-md hover:opacity-90" type="submit">Create Concept</button>
</div>
</form>
</div>
</section>
<aside class="col-span-12 lg:col-span-4 space-y-6">
<div class="bg-surface border border-outline-variant rounded-xl p-6">
<div class="flex items-center gap-3 mb-4"><span class="material-symbols-outlined text-primary">lightbulb</span><h3 class="font-headline-md text-lg">Guidelines</h3></div>
<ul class="space-y-4">
<li class="flex gap-3"><span class="text-primary font-bold">01.</span><div><p class="font-label-md font-bold text-on-surface">Concise Naming</p><p class="text-xs text-on-surface-variant">Use common industry terminology.</p></div></li>
<li class="flex gap-3"><span class="text-primary font-bold">02.</span><div><p class="font-label-md font-bold text-on-surface">The 'Why' First</p><p class="text-xs text-on-surface-variant">Explain the problem before the solution.</p></div></li>
<li class="flex gap-3"><span class="text-primary font-bold">03.</span><div><p class="font-label-md font-bold text-on-surface">Interview Context</p><p class="text-xs text-on-surface-variant">Include common gotchas interviewers ask.</p></div></li>
</ul>
</div>
</aside>
</div>
</div>
</main>
</body></html>
