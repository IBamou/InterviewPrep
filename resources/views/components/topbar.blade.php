@props(['topbarActions' => ''])
<header class="fixed top-0 right-0 w-[calc(100%-14rem)] h-14 z-30 bg-white/80 backdrop-blur-md border-b border-outline-variant/50 flex justify-end items-center px-5">
<div class="flex items-center gap-2">
{!! $topbarActions !!}
<form method="POST" action="{{ route('logout') }}">@csrf
<button type="submit" class="w-8 h-8 flex items-center justify-center text-on-surface-variant/60 hover:text-primary hover:bg-surface-container rounded-lg transition-all" title="Logout">
<span class="material-symbols-outlined text-[18px]">logout</span>
</button></form>
</div>
</header>
