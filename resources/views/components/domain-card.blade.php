@props(['domain', 'colorIndex' => 0])
@php
$pct = $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0;
$badgeColors = ['bg-rose-100 text-rose-700', 'bg-amber-100 text-amber-700', 'bg-emerald-100 text-emerald-700', 'bg-indigo-100 text-indigo-700'];
$barColors = ['bg-rose-500', 'bg-amber-500', 'bg-emerald-500', 'bg-indigo-500'];
$i = $colorIndex % 4;
@endphp
<div class="bg-white rounded-xl border border-outline-variant p-6 shadow-sm hover:shadow-md transition-shadow group">
<div class="flex justify-between items-start mb-4">
<div class="p-3 rounded-xl group-hover:scale-110 transition-transform" style="background-color: {{ $domain->color }}20;">
<span class="material-symbols-outlined" style="color: {{ $domain->color }};">database</span>
</div>
<span class="px-3 py-1 {{ $badgeColors[$i] }} text-xs font-bold rounded-full uppercase tracking-tight">{{ $pct >= 100 ? 'Mastered' : ($pct >= 50 ? 'In Progress' : 'To Review') }}</span>
</div>
<a href="{{ route('domains.show', $domain) }}">
<h3 class="font-display text-headline-md text-on-surface mb-1 hover:text-primary transition-colors">{{ $domain->name }}</h3>
</a>
<p class="text-on-surface-variant text-sm font-body-md mb-6 line-clamp-2">{{ $domain->description ?? 'No description provided.' }}</p>
<div class="space-y-3">
<div class="flex justify-between items-center text-xs font-label-md">
<span class="text-on-surface-variant">{{ $domain->mastered_count }}/{{ $domain->concepts_count }} Concepts Mastered</span>
<span class="text-on-surface font-bold">{{ $pct }}%</span>
</div>
<div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
<div class="{{ $barColors[$i] }} h-full" style="width: {{ $pct }}%;"></div>
</div>
</div>
<div class="mt-6 flex items-center justify-between">
<a href="{{ route('domains.show', $domain) }}" class="text-primary hover:underline font-label-md flex items-center gap-1">
{{ $pct >= 100 ? 'Review' : 'Continue' }} <span class="material-symbols-outlined text-sm">{{ $pct >= 100 ? 'visibility' : 'play_arrow' }}</span>
</a>
</div>
</div>