@props(['topbarActions' => ''])
<header class="fixed top-0 right-0 w-[calc(100%-192px)] h-16 z-30 bg-surface border-b border-outline-variant shadow-sm flex justify-between items-center px-xl">
<div class="flex items-center flex-1 max-w-xl">
<div class="relative w-full group">
<span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
<input class="w-full bg-surface-container-low border border-outline-variant rounded-full py-sm pl-xl pr-md focus:ring-2 focus:ring-primary focus:border-primary outline-none text-body-sm" placeholder="Search concepts, domains..." type="text"/>
</div>
</div>
<div class="flex items-center gap-lg">
<div class="flex items-center gap-sm">
{!! $topbarActions !!}
</div>
<div class="h-8 w-px bg-outline-variant mx-sm"></div>
<form method="POST" action="{{ route('logout') }}">@csrf
<button type="submit" class="p-sm text-on-surface-variant hover:bg-surface-container rounded-full transition-all flex items-center justify-center">
<span class="material-symbols-outlined">logout</span>
</button></form>
</div>
</header>