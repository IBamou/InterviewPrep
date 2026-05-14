<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Concept - InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400&amp;family=Geist:wght@500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface-bright": "#f9f9ff","on-surface-variant": "#464555","inverse-on-surface": "#ebf1ff","error": "#ba1a1a","inverse-surface": "#2a313d","tertiary-fixed": "#ffddb8","surface-container-highest": "#dce2f3","surface-variant": "#dce2f3","surface": "#f9f9ff","surface-container-low": "#f0f3ff","on-secondary": "#ffffff","secondary-fixed": "#6ffbbe","outline": "#777587","on-tertiary-container": "#ffd4a4","outline-variant": "#c7c4d8","primary-fixed-dim": "#c3c0ff","on-secondary-fixed-variant": "#005236","on-primary-container": "#dad7ff","background": "#f9f9ff","primary-container": "#4f46e5","on-primary-fixed": "#0f0069","inverse-primary": "#c3c0ff","on-tertiary": "#ffffff","tertiary-fixed-dim": "#ffb95f","on-primary-fixed-variant": "#3323cc","surface-container-high": "#e2e8f8","on-tertiary-fixed": "#2a1700","surface-container": "#e7eefe","on-tertiary-fixed-variant": "#653e00","on-secondary-container": "#00714d","surface-dim": "#d3daea","surface-container-lowest": "#ffffff","on-surface": "#151c27","error-container": "#ffdad6","on-secondary-fixed": "#002113","secondary": "#006c49","secondary-container": "#6cf8bb","surface-tint": "#4d44e3","tertiary-container": "#885500","secondary-fixed-dim": "#4edea3","primary-fixed": "#e2dfff","primary": "#3525cd","tertiary": "#684000","on-primary": "#ffffff"
            },
            "borderRadius": { "DEFAULT": "0.25rem","lg": "0.5rem","xl": "0.75rem","full": "9999px" },
            "spacing": { "container-max": "1280px","stack-sm": "0.5rem","stack-lg": "2rem","margin-x": "2rem","stack-md": "1rem","gutter": "1.5rem" },
            "fontFamily": { "display": ["Inter"],"code": ["JetBrains Mono"],"body-lg": ["Inter"],"label-md": ["Geist"],"body-md": ["Inter"],"headline-md": ["Inter"],"headline-lg": ["Inter"] },
            "fontSize": { "display": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em","fontWeight": "700"}],"code": ["14px", {"lineHeight": "22px","fontWeight": "400"}],"body-lg": ["18px", {"lineHeight": "28px","fontWeight": "400"}],"label-md": ["14px", {"lineHeight": "20px","letterSpacing": "0.01em","fontWeight": "500"}],"body-md": ["16px", {"lineHeight": "24px","fontWeight": "400"}],"headline-md": ["24px", {"lineHeight": "32px","fontWeight": "600"}],"headline-lg": ["32px", {"lineHeight": "40px","letterSpacing": "-0.01em","fontWeight": "600"}] }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-surface text-on-surface font-body-md">
<aside class="h-screen w-64 fixed left-0 top-0 border-r border-outline-variant shadow-sm bg-surface flex flex-col h-full py-6 px-4 z-50">
<div class="mb-8 px-2"><h1 class="text-headline-md font-display font-bold text-primary">InterviewPrep</h1><p class="font-body-md text-body-md text-on-surface-variant">Laravel Mastery</p></div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2 rounded-lg font-body-md text-body-md text-on-surface-variant hover:bg-surface-container-high group" href="{{ route('dashboard') }}"><span class="material-symbols-outlined">dashboard</span><span>Dashboard</span></a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg font-bold bg-primary-container/10 text-primary font-body-md text-body-md group" href="{{ route('domains.index') }}"><span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">category</span><span>Domains</span></a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg font-body-md text-body-md text-on-surface-variant hover:bg-surface-container-high group" href="{{ route('concepts.archives', $concept->domain) }}"><span class="material-symbols-outlined">archive</span><span>Archives</span></a>
</nav>
<div class="mt-auto px-2">
<button class="w-full flex items-center justify-center gap-2 bg-primary text-on-primary py-3 rounded-xl font-label-md hover:opacity-90 active:scale-95"><span class="material-symbols-outlined">auto_awesome</span><span>AI Generator</span></button>
</div>
</aside>
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-surface/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center h-16 px-8 ml-64">
<div class="flex items-center gap-4 flex-1"><div class="relative w-full max-w-md"><span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span><input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-label-md focus:ring-2 focus:ring-primary/20" placeholder="Search..." type="text"/></div></div>
<div class="flex items-center gap-6">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="material-symbols-outlined text-on-surface-variant hover:text-primary" title="Logout">logout</button>
</form>
</div>
</header>
<main class="ml-64 pt-24 pb-12 px-8 max-w-6xl mx-auto">
<nav class="flex items-center gap-2 text-label-md text-on-surface-variant mb-6">
<a class="hover:text-primary" href="{{ route('domains.index') }}">Domains</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<a class="hover:text-primary" href="{{ route('domains.show', $concept->domain) }}">{{ $concept->domain->name }}</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<span>Edit: {{ $concept->title }}</span>
</nav>

@if ($errors->any())
<div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-lg text-sm"><ul class="list-disc pl-4 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="grid grid-cols-12 gap-8">
<div class="col-span-8 space-y-8">
<section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-8 shadow-sm">
<div class="mb-8"><h2 class="text-headline-lg font-display text-on-surface mb-2">Edit Concept</h2><p class="text-body-md text-on-surface-variant">Update the core logic and study requirements for this technical topic.</p></div>
<form method="POST" action="{{ route('concepts.update', $concept) }}" class="space-y-6">
@csrf @method('PUT')
<div class="space-y-2">
<label class="text-label-md font-bold text-on-surface" for="title">Concept Title</label>
<input class="w-full bg-white border border-outline-variant rounded-lg p-3 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none @error('title') border-error @enderror" id="title" name="title" value="{{ old('title', $concept->title) }}" required/>
@error('title')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
</div>
<div class="grid grid-cols-2 gap-6">
<div class="space-y-3">
<label class="text-label-md font-bold text-on-surface">Difficulty</label>
<div class="flex flex-col gap-2">
@foreach (['junior' => ['Junior', 'Core fundamentals'], 'mid' => ['Mid', 'Practical optimization'], 'senior' => ['Senior', 'Architecture & scaling']] as $val => [$lbl, $desc])
<label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-surface-container-low transition-all {{ old('difficulty', $concept->difficulty->value) === $val ? 'border-2 border-primary bg-primary/5' : 'border-outline-variant' }}">
<input type="radio" name="difficulty" value="{{ $val }}" class="w-4 h-4 text-primary border-outline-variant focus:ring-primary" {{ old('difficulty', $concept->difficulty->value) === $val ? 'checked' : '' }}/>
<div class="flex flex-col"><span class="text-label-md font-bold {{ $val === 'junior' ? 'text-indigo-600' : ($val === 'mid' ? 'text-slate-700' : 'text-slate-900') }}">{{ $lbl }}</span><span class="text-[12px] text-on-surface-variant">{{ $desc }}</span></div>
</label>
@endforeach
</div>
</div>
<div class="space-y-3">
<label class="text-label-md font-bold text-on-surface">Status</label>
<div class="flex flex-col gap-2">
@foreach (['to_review' => ['À revoir', 'rose'], 'in_progress' => ['En cours', 'amber'], 'mastered' => ['Maîtrisé', 'emerald']] as $val => [$lbl, $clr])
@php $selected = old('status', $concept->status->value) === $val; @endphp
<label class="flex items-center gap-3 p-3 border rounded-lg cursor-pointer hover:bg-surface-container-low transition-all {{ $selected ? 'border-2 border-'.$clr.'-500 bg-'.$clr.'-500/5' : 'border-outline-variant' }}">
<input type="radio" name="status" value="{{ $val }}" class="w-4 h-4 text-{{ $clr }}-500 border-outline-variant focus:ring-{{ $clr }}-500" {{ $selected ? 'checked' : '' }}/>
<span class="px-2 py-0.5 rounded text-[12px] font-bold bg-{{ $clr }}-500/10 text-{{ $clr }}-600">{{ $lbl }}</span>
</label>
@endforeach
</div>
</div>
</div>
<div class="space-y-2">
<label class="text-label-md font-bold text-on-surface" for="explanation">Notes &amp; Context</label>
<textarea class="w-full bg-white border border-outline-variant rounded-lg p-4 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none min-h-[200px]" id="explanation" name="explanation" required>{{ old('explanation', $concept->explanation) }}</textarea>
@error('explanation')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
</div>
<div class="flex items-center justify-end gap-4 pt-4">
<a href="{{ route('concepts.show', $concept) }}" class="px-6 py-2.5 rounded-lg border border-outline-variant text-label-md font-bold text-on-surface-variant hover:bg-surface-container-high">Cancel</a>
<button class="px-8 py-2.5 rounded-lg bg-primary text-on-primary text-label-md font-bold shadow-lg hover:opacity-90 active:scale-95" type="submit">Save Concept</button>
</div>
</form>
</section>
</div>
<div class="col-span-4 space-y-6">
<section class="bg-surface-container border border-outline-variant rounded-xl overflow-hidden">
<div class="p-6">
<h3 class="text-label-md font-bold text-on-surface mb-1">Domain Context</h3>
<p class="text-headline-md font-display text-primary mb-4">{{ $concept->domain->name }}</p>
</div>
</section>
</div>
</div>
</main>
</body></html>
