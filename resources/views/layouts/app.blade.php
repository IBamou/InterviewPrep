<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>@yield('title', 'InterviewPrep') | InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono&amp;family=Geist:wght@400;500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "surface-container-high": "#e2e8f8","on-primary-container": "#dad7ff","secondary-fixed": "#6ffbbe","tertiary": "#684000","surface-container-low": "#f0f3ff","tertiary-container": "#885500","surface-tint": "#4d44e3","surface-container-lowest": "#ffffff","surface-dim": "#d3daea","inverse-on-surface": "#ebf1ff","primary-fixed-dim": "#c3c0ff","primary": "#3525cd","surface": "#f9f9ff","on-tertiary-container": "#ffd4a4","on-tertiary": "#ffffff","on-error": "#ffffff","surface-container": "#e7eefe","outline": "#777587","on-secondary-fixed": "#002113","on-surface-variant": "#464555","on-secondary-fixed-variant": "#005236","on-surface": "#151c27","on-primary": "#ffffff","secondary-container": "#6cf8bb","primary-container": "#4f46e5","surface-bright": "#f9f9ff","secondary": "#006c49","tertiary-fixed-dim": "#ffb95f","inverse-primary": "#c3c0ff","on-secondary-container": "#00714d","tertiary-fixed": "#ffddb8","on-tertiary-fixed": "#2a1700","surface-container-highest": "#dce2f3","error": "#ba1a1a","outline-variant": "#c7c4d8","secondary-fixed-dim": "#4edea3","primary-fixed": "#e2dfff","inverse-surface": "#2a313d","error-container": "#ffdad6","background": "#f9f9ff","on-secondary": "#ffffff","surface-variant": "#dce2f3","on-background": "#151c27","on-primary-fixed": "#0f0069","on-primary-fixed-variant": "#3323cc","on-tertiary-fixed-variant": "#653e00","on-error-container": "#93000a"
      },
      borderRadius: { DEFAULT: "0.25rem", lg: "0.5rem", xl: "0.75rem", full: "9999px" },
      spacing: { gutter: "1.5rem", stack: "1rem", "stack-lg": "2rem", "stack-sm": "0.5rem", "margin-x": "2rem", "container-max": "1280px" },
      fontFamily: { display: ["Inter"], "body-lg": ["Inter"], "headline-md": ["Inter"], "body-md": ["Inter"], "headline-lg": ["Inter"], code: ["JetBrains Mono"], "label-md": ["Geist"] },
      fontSize: { display: ["48px", { lineHeight: "56px", letterSpacing: "-0.02em", fontWeight: "700" }], "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }], "headline-md": ["24px", { lineHeight: "32px", fontWeight: "600" }], "body-md": ["16px", { lineHeight: "24px", fontWeight: "400" }], "headline-lg": ["32px", { lineHeight: "40px", letterSpacing: "-0.01em", fontWeight: "600" }], code: ["14px", { lineHeight: "22px", fontWeight: "400" }], "label-md": ["14px", { lineHeight: "20px", letterSpacing: "0.01em", fontWeight: "500" }] }
    },
  },
}
</script>
<style>
.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
body { background-color: #f9f9ff; }
@stack('styles')
</style>
</head>
<body class="bg-surface text-on-surface font-body-md overflow-x-hidden">
<!-- Sidebar -->
<aside class="flex flex-col h-screen w-56 fixed left-0 top-0 bg-surface border-r border-outline-variant shadow-sm z-50 py-4 px-3">
<div class="mb-6 px-2">
<h1 class="text-headline-md font-display font-bold text-primary">InterviewPrep</h1>
<p class="font-label-md text-[12px] text-on-surface-variant">Laravel Mastery</p>
</div>
<nav class="flex-1 space-y-1">
<a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm {{ $activeNav === 'dashboard' ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
<span class="material-symbols-outlined text-[20px]">dashboard</span>
<span>Dashboard</span>
</a>
<a href="{{ route('domains.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm {{ $activeNav === 'domains' ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
<span class="material-symbols-outlined text-[20px]">category</span>
<span>Domains</span>
</a>
<a href="{{ route('domains.archives') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm {{ $activeNav === 'archives' ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface-variant hover:bg-surface-container-high' }}">
<span class="material-symbols-outlined text-[20px]">archive</span>
<span>Archives</span>
</a>
</nav>
<div class="mt-auto space-y-3">
<button class="w-full flex items-center justify-center gap-2 bg-primary text-on-primary py-2.5 rounded-xl text-sm font-bold active:scale-95 transition-transform">
<span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">bolt</span>
AI Generator
</button>
<div class="flex items-center gap-2.5 p-2 rounded-xl bg-surface-container-low border border-outline-variant">
<div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-primary text-[18px]">person</span>
</div>
<div class="overflow-hidden min-w-0">
<p class="text-[11px] font-bold truncate text-on-surface">{{ Auth::user()->name }}</p>
<p class="text-[9px] text-on-surface-variant truncate">Developer</p>
</div>
</div>
</div>
</aside>
<!-- Topbar -->
<header class="flex justify-between items-center h-14 px-6 ml-56 fixed top-0 right-0 w-[calc(100%-14rem)] z-40 bg-surface/80 backdrop-blur-md border-b border-outline-variant">
<div class="flex items-center gap-4 flex-1">
<div class="relative w-full max-w-sm">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
<input class="w-full bg-surface-container-low border-none rounded-full py-1.5 pl-9 pr-4 text-sm focus:ring-2 focus:ring-primary/20" placeholder="Search concepts..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
@yield('topbar-actions')
<div class="flex items-center gap-3 border-l border-outline-variant pl-3">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors text-[20px]" title="Logout">logout</button>
</form>
</div>
</div>
</header>
<!-- Main Content -->
<main class="ml-56 pt-16 pb-8 px-6 min-h-screen">
@if (session('success'))
<div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
@endif
@yield('content')
</main>
</body>
</html>