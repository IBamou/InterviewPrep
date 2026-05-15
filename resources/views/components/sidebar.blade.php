@props(['activeNav' => 'dashboard'])
<aside class="fixed left-0 top-0 h-screen w-56 z-40 bg-white border-r border-outline-variant flex flex-col">
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
<nav class="flex flex-col gap-0.5 flex-grow px-3">
<a class="relative flex items-center gap-3 py-2 px-3 rounded-lg text-[13px] font-medium transition-all duration-150 {{ $activeNav === 'dashboard' ? 'text-primary bg-primary-fixed font-semibold' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container' }}" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined text-[18px]">dashboard</span>
Dashboard
</a>
<a class="relative flex items-center gap-3 py-2 px-3 rounded-lg text-[13px] font-medium transition-all duration-150 {{ $activeNav === 'domains' ? 'text-primary bg-primary-fixed font-semibold' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container' }}" href="{{ route('domains.index') }}">
<span class="material-symbols-outlined text-[18px]">account_tree</span>
Domains
</a>
<a class="relative flex items-center gap-3 py-2 px-3 rounded-lg text-[13px] font-medium transition-all duration-150 {{ $activeNav === 'archives' ? 'text-primary bg-primary-fixed font-semibold' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-container' }}" href="{{ route('domains.archives') }}">
<span class="material-symbols-outlined text-[18px]">inventory_2</span>
Archives
</a>
</nav>
<div class="px-3 pb-4 mt-auto">
<div class="border-t border-outline-variant pt-3 space-y-0.5">
<a href="{{ route('profile.edit') }}" class="flex items-center gap-3 py-2 px-3 rounded-lg text-[13px] font-medium text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-all">
<span class="material-symbols-outlined text-[18px]">account_circle</span>
Profile
</a>
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="w-full flex items-center gap-3 py-2 px-3 rounded-lg text-[13px] font-medium text-error/70 hover:text-error hover:bg-error/5 transition-all">
<span class="material-symbols-outlined text-[18px]">logout</span>
Logout
</button>
</form>
</div>
</div>
</aside>
