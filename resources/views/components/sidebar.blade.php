@props(['activeNav' => 'dashboard'])
<aside class="fixed left-0 top-0 h-screen w-48 z-40 bg-surface-container-lowest border-r border-outline-variant shadow-sm flex flex-col py-lg px-md gap-xl">
<div>
<h1 class="font-headline-md text-headline-md font-bold text-primary tracking-tight">InterviewPrep</h1>
<p class="font-body-sm text-body-sm text-on-surface-variant">Knowledge Tracker</p>
</div>
<nav class="flex flex-col gap-sm flex-grow">
<a class="flex items-center gap-md p-md {{ $activeNav === 'dashboard' ? 'text-primary font-semibold bg-primary-fixed rounded-lg scale-95 active:scale-90 transition-transform' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors duration-200 rounded-lg' }}" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-body-sm text-body-sm">Dashboard</span>
</a>
<a class="flex items-center gap-md p-md {{ $activeNav === 'domains' ? 'text-primary font-semibold bg-primary-fixed rounded-lg scale-95 active:scale-90 transition-transform' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors duration-200 rounded-lg' }}" href="{{ route('domains.index') }}">
<span class="material-symbols-outlined">account_tree</span>
<span class="font-body-sm text-body-sm">Domains</span>
</a>
<a class="flex items-center gap-md p-md {{ $activeNav === 'archives' ? 'text-primary font-semibold bg-primary-fixed rounded-lg scale-95 active:scale-90 transition-transform' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors duration-200 rounded-lg' }}" href="{{ route('domains.archives') }}">
<span class="material-symbols-outlined">inventory_2</span>
<span class="font-body-sm text-body-sm">Archives</span>
</a>
</nav>
<div class="mt-auto flex flex-col gap-sm">
<button class="w-full bg-primary-container text-white py-sm px-md rounded-lg font-semibold scale-95 active:scale-90 transition-transform flex items-center justify-center gap-xs">
<span class="material-symbols-outlined text-[18px]">auto_awesome</span>
AI Generator
</button>
<div class="flex items-center gap-md p-md text-on-surface-variant hover:bg-surface-container-high transition-colors duration-200 rounded-lg">
<span class="material-symbols-outlined">account_circle</span>
<span class="font-body-sm text-body-sm">Profile</span>
</div>
</div>
</aside>