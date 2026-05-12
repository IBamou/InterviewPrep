<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Domain - InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400&amp;family=Geist:wght@500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-bright": "#f9f9ff",
                        "on-surface-variant": "#464555",
                        "inverse-on-surface": "#ebf1ff",
                        "error": "#ba1a1a",
                        "inverse-surface": "#2a313d",
                        "tertiary-fixed": "#ffddb8",
                        "surface-container-highest": "#dce2f3",
                        "surface-variant": "#dce2f3",
                        "surface": "#f9f9ff",
                        "surface-container-low": "#f0f3ff",
                        "on-secondary": "#ffffff",
                        "secondary-fixed": "#6ffbbe",
                        "outline": "#777587",
                        "on-tertiary-container": "#ffd4a4",
                        "on-error-container": "#93000a",
                        "outline-variant": "#c7c4d8",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-secondary-fixed-variant": "#005236",
                        "on-primary-container": "#dad7ff",
                        "on-error": "#ffffff",
                        "background": "#f9f9ff",
                        "primary-container": "#4f46e5",
                        "on-primary-fixed": "#0f0069",
                        "on-background": "#151c27",
                        "inverse-primary": "#c3c0ff",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed-dim": "#ffb95f",
                        "on-primary-fixed-variant": "#3323cc",
                        "surface-container-high": "#e2e8f8",
                        "on-tertiary-fixed": "#2a1700",
                        "surface-container": "#e7eefe",
                        "on-tertiary-fixed-variant": "#653e00",
                        "on-secondary-container": "#00714d",
                        "surface-dim": "#d3daea",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#151c27",
                        "error-container": "#ffdad6",
                        "on-secondary-fixed": "#002113",
                        "secondary": "#006c49",
                        "secondary-container": "#6cf8bb",
                        "surface-tint": "#4d44e3",
                        "tertiary-container": "#885500",
                        "secondary-fixed-dim": "#4edea3",
                        "primary-fixed": "#e2dfff",
                        "primary": "#3525cd",
                        "tertiary": "#684000",
                        "on-primary": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "container-max": "1280px",
                        "stack-sm": "0.5rem",
                        "stack-lg": "2rem",
                        "margin-x": "2rem",
                        "stack-md": "1rem",
                        "gutter": "1.5rem"
                    },
                    "fontFamily": {
                        "display": ["Inter"],
                        "code": ["JetBrains Mono"],
                        "body-lg": ["Inter"],
                        "label-md": ["Geist"],
                        "body-md": ["Inter"],
                        "headline-md": ["Inter"],
                        "headline-lg": ["Inter"]
                    },
                    "fontSize": {
                        "display": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "code": ["14px", {"lineHeight": "22px", "fontWeight": "400"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}]
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
            background-color: #f9f9ff;
        }
    </style>
</head>
<body class="font-body-md text-on-surface">
<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 border-r border-outline-variant dark:border-outline bg-surface dark:bg-inverse-surface shadow-sm flex flex-col h-full py-6 px-4 z-50">
<div class="mb-10 px-2">
<h1 class="text-headline-md font-display font-bold text-primary dark:text-inverse-primary">InterviewPrep</h1>
<p class="font-label-md text-label-md text-on-surface-variant opacity-70">Laravel Mastery</p>
</div>
<nav class="flex-1 space-y-2">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors text-on-surface-variant dark:text-surface-variant" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="font-body-md">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-primary dark:text-inverse-primary font-bold bg-primary-container/10 dark:bg-primary-fixed-dim/10 transition-colors" href="{{ route('domains.index') }}">
<span class="material-symbols-outlined" data-icon="category" style="font-variation-settings: 'FILL' 1;">category</span>
<span class="font-body-md">Domains</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-surface-container-high dark:hover:bg-surface-variant transition-colors text-on-surface-variant dark:text-surface-variant" href="{{ route('domains.archives') }}">
<span class="material-symbols-outlined" data-icon="archive">archive</span>
<span class="font-body-md">Archives</span>
</a>
</nav>
<div class="mt-auto px-2">
<button class="w-full bg-primary text-on-primary py-3 px-4 rounded-xl font-bold flex items-center justify-center gap-2 active:scale-95 transition-transform">
<span class="material-symbols-outlined" data-icon="auto_awesome">auto_awesome</span>
                AI Generator
            </button>
</div>
</aside>
<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-surface/80 dark:bg-surface-dim/80 backdrop-blur-md border-b border-outline-variant dark:border-outline flex justify-between items-center h-16 px-8 ml-64">
<div class="flex items-center bg-surface-container-low px-4 py-2 rounded-full w-96">
<span class="material-symbols-outlined text-on-surface-variant mr-2" data-icon="search">search</span>
<input class="bg-transparent border-none focus:ring-0 text-label-md w-full" placeholder="Search concepts..." type="text"/>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-4 text-on-surface-variant">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="material-symbols-outlined hover:text-primary transition-all" title="Logout" data-icon="logout">logout</button>
</form>
</div>
<div class="h-8 w-px bg-outline-variant"></div>
<div class="flex items-center gap-3">
<a href="{{ route('concepts.create', $domain) }}" class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-md active:opacity-80 transition-opacity">Create Concept</a>
<img alt="User Profile" class="w-10 h-10 rounded-full border-2 border-primary/20 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCLVqUGlE-saxvG5-DH1BdDF1Lja_T0F2qI2PTnxIUnm2bDXVkx7n-rd9eFoMv_FlsUUFANxU5a1JOES3ijeD652TEC-NPboZmT9xYdFOecxXS-FbvEd8a9m6iF6-Gds0HayzBf9HWBfRw7qzuWvHfwLK_b69bo9xK5stu4RrurWggFlpakmkB6ocGelSkTLzkts6bNf8kjYCWZ2UtYyjwpW93qxpkp1ce--kgm8smmsYUHRwQfzTPINPuVcD0JJ0CgCvCrPxjy3CY"/>
</div>
</div>
</header>
<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-12 min-h-screen bg-surface-bright">
<div class="max-w-4xl mx-auto">
<!-- Breadcrumbs -->
<nav class="flex items-center gap-2 text-on-surface-variant mb-6 font-label-md">
<a class="hover:text-primary" href="{{ route('domains.index') }}">Domains</a>
<span class="material-symbols-outlined text-[16px]" data-icon="chevron_right">chevron_right</span>
<span class="text-on-surface font-bold">Edit Domain</span>
</nav>

@if ($errors->any())
<div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-lg text-sm">
<ul class="list-disc pl-4 space-y-1">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- Form Section -->
<div class="lg:col-span-8">
<div class="bg-white rounded-xl border border-outline-variant shadow-sm overflow-hidden">
<div class="p-8 border-b border-outline-variant bg-surface-container-lowest">
<h2 class="text-headline-lg font-display text-on-surface">Domain Configuration</h2>
<p class="text-on-surface-variant mt-1">Define the technical boundaries and mastery metrics for this curriculum.</p>
</div>
<form method="POST" action="{{ route('domains.update', $domain) }}" class="p-8 space-y-6">
@csrf
@method('PUT')
<div class="space-y-2">
<label class="block font-label-md text-on-surface-variant" for="name">Domain Name</label>
<input class="w-full px-4 py-3 rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md @error('name') border-error @enderror" id="name" name="name" placeholder="e.g. System Design" type="text" value="{{ old('name', $domain->name) }}" required/>
@error('name')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<div class="space-y-2">
<label class="block font-label-md text-on-surface-variant" for="color">Accent Color</label>
<input class="w-full px-4 py-3 rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md @error('color') border-error @enderror" id="color" name="color" placeholder="#3525cd" type="text" value="{{ old('color', $domain->color) }}" required/>
@error('color')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<div class="space-y-2">
<label class="block font-label-md text-on-surface-variant" for="description">Description</label>
<textarea class="w-full px-4 py-3 rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all font-body-md" id="description" name="description" placeholder="Provide a brief overview of the topics covered in this domain..." rows="4">{{ old('description', $domain->description) }}</textarea>
</div>
<div class="pt-8 flex justify-end gap-4 border-t border-outline-variant">
<a href="{{ route('domains.index') }}" class="px-6 py-3 rounded-lg font-bold border border-outline-variant text-on-surface-variant hover:bg-surface-container-high transition-all">Discard Changes</a>
<button class="px-8 py-3 rounded-lg font-bold bg-primary text-on-primary hover:opacity-90 active:scale-95 transition-all shadow-md" type="submit">Update Domain</button>
</div>
</form>
</div>
</div>
<!-- Sidebar -->
<div class="lg:col-span-4 space-y-6">
<div class="bg-white rounded-xl border border-outline-variant p-6 shadow-sm">
<h3 class="font-display font-bold text-on-surface mb-4">Domain Preview</h3>
<div class="bg-surface-container-low rounded-lg p-4 flex items-center gap-4">
<div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center text-on-primary">
<span class="material-symbols-outlined" data-icon="terminal">terminal</span>
</div>
<div>
<h4 class="font-bold text-on-surface">{{ $domain->name }}</h4>
</div>
</div>
<div class="mt-4 text-label-md text-on-surface-variant leading-relaxed">
This domain currently contains <span class="text-on-surface font-bold">{{ $domain->concepts_count }}</span> concepts.
</div>
</div>
<div class="bg-inverse-surface text-inverse-on-surface rounded-xl p-6 shadow-lg overflow-hidden relative">
<div class="relative z-10">
<h3 class="font-display font-bold mb-2">Curriculum Insights</h3>
<p class="text-sm opacity-80 mb-4">Update your domain configuration to refine your study focus.</p>
</div>
<div class="absolute -right-4 -bottom-4 opacity-10">
<span class="material-symbols-outlined text-[120px]" data-icon="insights">insights</span>
</div>
</div>
</div>
</div>
</div>
</main>
</body></html>
