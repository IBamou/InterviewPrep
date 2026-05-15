@props(['topbarActions' => '', 'showSearch' => true])
<header class="fixed top-0 right-0 w-[calc(100%-14rem)] h-14 z-30 bg-white/80 backdrop-blur-md border-b border-outline-variant/50 flex justify-between items-center px-5">
@if($showSearch)
<div class="flex items-center flex-1 max-w-md">
<div class="relative w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant/50 text-[18px]">search</span>
<input class="w-full bg-surface-container/60 border-0 rounded-lg py-1.5 pl-10 pr-3 text-[13px] placeholder:text-on-surface-variant/40 focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none transition-all" placeholder="Search..." type="text"/>
</div>
</div>
@endif
<div class="flex items-center gap-2">
{!! $topbarActions !!}
<form method="POST" action="{{ route('logout') }}">@csrf
<button type="submit" class="w-8 h-8 flex items-center justify-center text-on-surface-variant/60 hover:text-primary hover:bg-surface-container rounded-lg transition-all" title="Logout">
<span class="material-symbols-outlined text-[18px]">logout</span>
</button></form>
</div>
</header>
