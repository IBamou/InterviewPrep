<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>@yield('title', 'InterviewPrep') | InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "surface-container-high": "#E8EDF2","on-primary-container": "#004E7A","secondary-fixed": "#B2DFDB","tertiary": "#FF6B6B","surface-container-low": "#F8FAFC","tertiary-container": "#FF8A8A","surface-tint": "#0077B6","surface-container-lowest": "#ffffff","surface-dim": "#D6DBE1","inverse-on-surface": "#F8FBFF","primary-fixed-dim": "#B2EBF2","primary": "#0077B6","surface": "#FFFFFF","on-tertiary-container": "#C62828","on-tertiary": "#ffffff","on-error": "#ffffff","surface-container": "#F0F4F8","outline": "#90A4AE","on-secondary-fixed": "#004D40","on-surface-variant": "#546E7A","on-secondary-fixed-variant": "#00695C","on-surface": "#1A1A2E","on-primary": "#ffffff","secondary-container": "#B2DFDB","primary-container": "#00B4D8","surface-bright": "#ffffff","secondary": "#00A896","tertiary-fixed-dim": "#EF9A9A","inverse-primary": "#00B4D8","on-secondary-container": "#004D40","tertiary-fixed": "#FFCDD2","on-tertiary-fixed": "#B71C1C","surface-container-highest": "#E0E5EB","error": "#E63946","outline-variant": "#CFD8DC","secondary-fixed-dim": "#80CBC4","primary-fixed": "#E0F7FA","inverse-surface": "#1A1A2E","error-container": "#FFEBEE","background": "#F8FBFF","on-secondary": "#ffffff","surface-variant": "#E8EDF2","on-background": "#1A1A2E","on-primary-fixed": "#004E7A","on-primary-fixed-variant": "#0077B6","on-tertiary-fixed-variant": "#D32F2F","on-error-container": "#C62828"
      },
      borderRadius: { DEFAULT: "0.5rem", lg: "0.625rem", xl: "0.875rem", full: "9999px" },
      spacing: { gutter: "1.25rem", stack: "1rem", "stack-lg": "1.5rem", "stack-sm": "0.5rem", "margin-x": "1.5rem", "container-max": "1200px" },
      fontFamily: { display: ["Inter"], "body-lg": ["Inter"], "headline-md": ["Inter"], "body-md": ["Inter"], "headline-lg": ["Inter"], code: ["JetBrains Mono"], "label-md": ["Inter"] },
      fontSize: { display: ["28px", { lineHeight: "36px", letterSpacing: "-0.02em", fontWeight: "700" }], "body-lg": ["14px", { lineHeight: "21px", fontWeight: "400" }], "headline-md": ["18px", { lineHeight: "26px", fontWeight: "600" }], "body-md": ["14px", { lineHeight: "21px", fontWeight: "400" }], "headline-lg": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "600" }], code: ["13px", { lineHeight: "20px", fontWeight: "400" }], "label-md": ["13px", { lineHeight: "18px", letterSpacing: "0.01em", fontWeight: "500" }] }
    },
  },
}
</script>
<style>
.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; vertical-align: middle; }
body { background-color: #F8FBFF; }
@stack('styles')
</style>
</head>
<body class="bg-surface text-on-surface font-body-md overflow-x-hidden">
<!-- Sidebar -->
<aside class="flex flex-col h-screen w-56 fixed left-0 top-0 bg-white border-r border-outline-variant z-50">
<div class="px-5 pt-6 pb-4">
<div class="flex items-center gap-2.5">
<div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary to-primary-container flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings: 'FILL' 1;">school</span>
</div>
<div>
<h1 class="text-[15px] font-bold text-on-surface tracking-tight">InterviewPrep</h1>
<p class="text-[10px] text-on-surface-variant/70 font-medium">Knowledge Tracker</p>
</div>
</div>
</div>
<nav class="flex-1 px-3 space-y-0.5">
<a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg text-[13px] font-medium transition-all {{ $activeNav === 'dashboard' ? 'text-primary bg-primary-fixed font-semibold' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container' }}">
<span class="material-symbols-outlined text-[18px]">dashboard</span>
<span>Dashboard</span>
</a>
<a href="{{ route('domains.index') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg text-[13px] font-medium transition-all {{ $activeNav === 'domains' ? 'text-primary bg-primary-fixed font-semibold' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container' }}">
<span class="material-symbols-outlined text-[18px]">account_tree</span>
<span>Domains</span>
</a>
<a href="{{ route('domains.archives') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg text-[13px] font-medium transition-all {{ $activeNav === 'archives' ? 'text-primary bg-primary-fixed font-semibold' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container' }}">
<span class="material-symbols-outlined text-[18px]">inventory_2</span>
<span>Archives</span>
</a>
</nav>
<div class="px-3 pb-4 mt-auto border-t border-outline-variant pt-3">
<a href="{{ route('profile.edit') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg text-[13px] font-medium text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-all">
<span class="material-symbols-outlined text-[18px]">account_circle</span>
<span>Profile</span>
</a>
</div>
</aside>
<!-- Topbar -->
<header class="flex justify-between items-center h-14 px-5 ml-56 fixed top-0 right-0 w-[calc(100%-14rem)] z-40 bg-white/80 backdrop-blur-md border-b border-outline-variant/50">
<div class="flex items-center gap-4 flex-1">
<div class="relative w-full max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant/50 text-[18px]">search</span>
<input class="w-full bg-surface-container/60 border-0 rounded-lg py-1.5 pl-10 pr-3 text-[13px] focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Search..." type="text"/>
</div>
</div>
<div class="flex items-center gap-2">
@yield('topbar-actions')
<div class="flex items-center gap-2 border-l border-outline-variant/50 pl-3">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="w-8 h-8 flex items-center justify-center text-on-surface-variant/60 hover:text-primary hover:bg-surface-container rounded-lg transition-all" title="Logout">
<span class="material-symbols-outlined text-[18px]">logout</span>
</button>
</form>
</div>
</div>
</header>
<!-- Main Content -->
<main class="ml-56 pt-16 pb-6 px-5 min-h-screen">
@if (session('success'))
<div class="mb-4 p-3 bg-secondary/5 border border-secondary/20 text-secondary rounded-lg text-sm flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">check_circle</span>{{ session('success') }}</div>
@endif
@yield('content')
</main>
</body>
</html>
