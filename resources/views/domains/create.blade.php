<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Create Domain - InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400&amp;family=Geist:wght@500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-tint": "#4d44e3",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#dad7ff",
                        "secondary-container": "#6cf8bb",
                        "primary-fixed": "#e2dfff",
                        "on-error-container": "#93000a",
                        "on-secondary": "#ffffff",
                        "surface-variant": "#dce2f3",
                        "on-secondary-container": "#00714d",
                        "surface-container-lowest": "#ffffff",
                        "inverse-primary": "#c3c0ff",
                        "secondary": "#006c49",
                        "on-surface-variant": "#464555",
                        "on-secondary-fixed": "#002113",
                        "surface-dim": "#d3daea",
                        "inverse-on-surface": "#ebf1ff",
                        "tertiary": "#684000",
                        "tertiary-container": "#885500",
                        "outline-variant": "#c7c4d8",
                        "background": "#f9f9ff",
                        "surface-container-high": "#e2e8f8",
                        "on-tertiary-container": "#ffd4a4",
                        "on-tertiary-fixed": "#2a1700",
                        "inverse-surface": "#2a313d",
                        "secondary-fixed-dim": "#4edea3",
                        "secondary-fixed": "#6ffbbe",
                        "primary-fixed-dim": "#c3c0ff",
                        "outline": "#777587",
                        "on-primary": "#ffffff",
                        "surface-container-low": "#f0f3ff",
                        "surface-container-highest": "#dce2f3",
                        "on-tertiary-fixed-variant": "#653e00",
                        "tertiary-fixed-dim": "#ffb95f",
                        "surface-bright": "#f9f9ff",
                        "surface": "#f9f9ff",
                        "on-background": "#151c27",
                        "on-surface": "#151c27",
                        "on-primary-fixed": "#0f0069",
                        "primary": "#3525cd",
                        "error-container": "#ffdad6",
                        "on-primary-fixed-variant": "#3323cc",
                        "tertiary-fixed": "#ffddb8",
                        "surface-container": "#e7eefe",
                        "primary-container": "#4f46e5",
                        "error": "#ba1a1a",
                        "on-error": "#ffffff",
                        "on-secondary-fixed-variant": "#005236"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "stack-sm": "0.5rem",
                        "container-max": "1280px",
                        "stack-md": "1rem",
                        "margin-x": "2rem",
                        "stack-lg": "2rem",
                        "gutter": "1.5rem"
                    },
                    "fontFamily": {
                        "code": ["JetBrains Mono"],
                        "body-md": ["Inter"],
                        "label-md": ["Geist"],
                        "headline-lg": ["Inter"],
                        "headline-md": ["Inter"],
                        "display": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "code": ["14px", {"lineHeight": "22px", "fontWeight": "400"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "display": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .active-icon {
            font-variation-settings: 'FILL' 1;
        }
    </style>
</head>
<body class="bg-background font-body-md text-on-background">
<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 border-r border-outline-variant bg-surface flex flex-col py-6 px-4 shadow-sm z-50">
<div class="mb-10 px-2">
<h1 class="text-headline-md font-display font-bold text-primary">InterviewPrep</h1>
<p class="text-on-surface-variant font-label-md text-sm mt-1">Laravel Mastery</p>
</div>
<nav class="flex-1 space-y-2">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-high transition-colors scale-95 active:scale-90 transition-transform" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="font-body-md">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary font-bold bg-primary-container/10 scale-95 active:scale-90 transition-transform" href="{{ route('domains.index') }}">
<span class="material-symbols-outlined active-icon" data-icon="category" style="font-variation-settings: 'FILL' 1;">category</span>
<span class="font-body-md">Domains</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-high transition-colors scale-95 active:scale-90 transition-transform" href="{{ route('domains.archives') }}">
<span class="material-symbols-outlined" data-icon="archive">archive</span>
<span class="font-body-md">Archives</span>
</a>
</nav>
<div class="mt-auto px-2">
<button class="w-full py-4 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-opacity">
<span class="material-symbols-outlined" data-icon="auto_awesome">auto_awesome</span>
                AI Generator
            </button>
<div class="mt-6 flex items-center gap-3 px-2 border-t border-outline-variant pt-6">
<div class="w-10 h-10 rounded-full bg-surface-container-highest overflow-hidden border border-outline-variant">
<img alt="User profile avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBAquv7Fch-_enapVKEULYJUQJe5HZpU1hps3CfpxvhqMKd3ShqG2ovq5GGu81C4MOIuNxRgA8Hw7l6vbm0Lfnjw-Ia2vn-m5G8P_TE4B02dA8rOywsnUMkOJ3nhHaMSV8pWNreSR582pMh18X2boiMNiGLKIyQHYYUGVkpOeZ41TyVBevEUWZmvMR8OKViEEpGZ7VxeqI-_1AEWdIqD6gIrIKvYNhTVBZEkP8z9Ks2Yjm5DIvCK4h1IW8eW6SB08gaqPuaCGPpECI"/>
</div>
<div class="overflow-hidden">
<p class="font-label-md text-on-surface truncate">{{ Auth::user()->name }}</p>
<p class="text-xs text-on-surface-variant truncate">Lead Developer</p>
</div>
</div>
</div>
</aside>
<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-surface/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center h-16 px-8">
<div class="flex items-center gap-4 flex-1">
<div class="relative w-full max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant" data-icon="search">search</span>
<input class="w-full bg-surface-container-low border-none rounded-full pl-10 pr-4 py-2 text-label-md focus:ring-2 focus:ring-primary/20" placeholder="Search concepts..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-4 border-r border-outline-variant pr-6">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="text-on-surface-variant hover:text-primary transition-all p-2 rounded-full hover:bg-surface-container" title="Logout">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
</button>
</form>
</div>
<div class="flex items-center gap-3">
<a href="{{ route('domains.create') }}" class="text-primary font-label-md hover:underline decoration-2 underline-offset-4">Add Domain</a>

</div>
</div>
</header>
<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
<div class="max-w-container-max mx-auto">
<header class="mb-8">
<div class="flex items-center gap-2 text-on-surface-variant mb-2">
<a class="hover:text-primary flex items-center gap-1 font-label-md" href="{{ route('domains.index') }}">
<span class="material-symbols-outlined text-sm" data-icon="arrow_back">arrow_back</span>
                        Back to Domains
                    </a>
</div>
<h2 class="font-headline-lg text-headline-lg text-on-surface">Create New Domain</h2>
<p class="text-on-surface-variant font-body-md">Define a new specialized area of technical expertise for interview evaluation.</p>
</header>

@if ($errors->any())
<div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-lg text-sm">
<ul class="list-disc pl-4 space-y-1">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<div class="grid grid-cols-12 gap-gutter items-start">
<!-- Form Section -->
<div class="col-span-8 bg-surface-container-lowest border border-outline-variant rounded-xl p-8 shadow-sm">
<form method="POST" action="{{ route('domains.store') }}" class="space-y-stack-lg">
@csrf
<!-- Basic Info Group -->
<div class="grid grid-cols-2 gap-stack-lg">
<div class="space-y-stack-sm">
<label class="font-label-md text-on-surface-variant block" for="name">Domain Name</label>
<input class="w-full border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary bg-surface font-body-md px-4 py-3 @error('name') border-error @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. AWS Architecture" type="text" required/>
@error('name')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<div class="space-y-stack-sm">
<label class="font-label-md text-on-surface-variant block" for="color">Accent Color</label>
<input class="w-full border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary bg-surface font-body-md px-4 py-3 @error('color') border-error @enderror" id="color" name="color" value="{{ old('color', '#3525cd') }}" placeholder="#3525cd" type="text" required/>
@error('color')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
</div>
<!-- Description -->
<div class="space-y-stack-sm">
<label class="font-label-md text-on-surface-variant block" for="description">Technical Boundaries</label>
<textarea class="w-full border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary bg-surface font-body-md px-4 py-3" id="description" name="description" placeholder="Describe the specific technologies, libraries, and best practices included in this domain..." rows="4">{{ old('description') }}</textarea>
</div>
<!-- Footer Actions -->
<div class="flex items-center justify-end gap-4 pt-6 border-t border-outline-variant">
<a href="{{ route('domains.index') }}" class="px-6 py-2 rounded-lg border border-outline-variant text-on-surface-variant font-label-md hover:bg-surface-container transition-colors">Cancel</a>
<button class="px-8 py-2 rounded-lg bg-primary text-on-primary font-label-md shadow-md hover:opacity-90 transition-opacity" type="submit">Create Domain</button>
</div>
</form>
</div>
<!-- Sidebar -->
<div class="col-span-4 space-y-stack-lg">
<div class="bg-surface-container-low border border-outline-variant rounded-xl p-6">
<h3 class="font-label-md text-on-surface-variant uppercase tracking-wider mb-4">Live Preview</h3>
<div class="bg-white border border-outline-variant rounded-xl p-5 shadow-sm">
<div class="flex items-start justify-between mb-4">
<div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
<span class="material-symbols-outlined text-3xl" data-icon="cloud">cloud</span>
</div>
<span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full border border-indigo-200">Junior</span>
</div>
<h4 class="text-xl font-bold text-on-surface mb-2" id="preview-name">New Domain</h4>
<p class="text-sm text-on-surface-variant line-clamp-2 mb-4" id="preview-desc">Enter a name and description...</p>
<div class="flex items-center gap-4 text-xs font-label-md text-on-surface-variant">
<span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm" data-icon="menu_book">menu_book</span> 0 Concepts</span>
</div>
</div>
</div>
<div class="bg-surface-container-highest border border-outline-variant rounded-xl p-6">
<div class="flex items-center gap-2 text-primary mb-3">
<span class="material-symbols-outlined" data-icon="lightbulb">lightbulb</span>
<h3 class="font-bold">Creation Tips</h3>
</div>
<ul class="space-y-3 text-sm text-on-surface-variant">
<li class="flex gap-2"><span class="text-primary font-bold">01.</span><span>Focus on <strong>high-impact</strong> concepts that are frequently tested in technical interviews.</span></li>
<li class="flex gap-2"><span class="text-primary font-bold">02.</span><span>Keep boundaries <strong>tight</strong>. Don't mix unrelated stacks in one domain.</span></li>
<li class="flex gap-2"><span class="text-primary font-bold">03.</span><span>Use proper hex colors matching your domain's visual identity.</span></li>
</ul>
</div>
</div>
</div>
</div>
</main>
</body></html>
