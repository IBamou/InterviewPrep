<x-app-layout activeNav="domains" title="{{ $domain->name }}">
    <x-slot:topbar-actions>
        <a href="{{ route('concepts.archives', $domain) }}" class="px-3 py-1.5 bg-surface-container text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container-high transition-all flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">archive</span>
            Archived Concepts
        </a>
        <a href="{{ route('concepts.create', $domain) }}" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">+ Add Concept</a>
    </x-slot:topbar-actions>

    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">Domains</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface font-medium">{{ $domain->name }}</span>
    </nav>

    <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-6">
        <div>
            <h2 class="font-display-lg text-display-lg text-on-surface">{{ $domain->name }}</h2>
            <p class="font-body-md text-body-md text-on-surface-variant/70 mt-0.5">{{ $domain->description ?? 'No description provided.' }}</p>
        </div>
        <div class="w-full md:w-56">
            <div class="flex justify-between items-center mb-1">
                <span class="text-[11px] text-on-surface-variant/60 font-medium uppercase">Progress</span>
                <span class="text-[14px] font-bold text-primary">{{ $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0 }}%</span>
            </div>
            <div class="h-2 w-full bg-surface-container rounded-full">
                <div class="h-full bg-primary rounded-full transition-all" style="width: {{ $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0 }}%"></div>
            </div>
        </div>
    </div>

    <section class="bg-white border border-outline-variant/50 rounded-xl overflow-hidden mb-6">
        <div class="px-4 py-3 border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="text-[14px] font-semibold text-on-surface">Concepts</h3>
            <span class="bg-primary/10 text-primary text-[11px] font-medium px-2 py-0.5 rounded-full">{{ $domain->concepts_count }}</span>
        </div>
        <div class="divide-y divide-outline-variant/20">
            @forelse ($domain->concepts as $concept)
            @php
            $statusColors = ['to_review' => ['dot' => 'bg-error', 'text' => 'text-error', 'bg' => 'bg-error/5'], 'in_progress' => ['dot' => 'bg-amber-500', 'text' => 'text-amber-600', 'bg' => 'bg-amber-50'], 'mastered' => ['dot' => 'bg-secondary', 'text' => 'text-secondary', 'bg' => 'bg-secondary/5']];
            $diffColors = ['junior' => 'text-secondary', 'mid' => 'text-amber-600', 'senior' => 'text-error'];
            $diffLabels = ['junior' => 'Junior', 'mid' => 'Mid', 'senior' => 'Senior'];
            $statusLabels = ['to_review' => 'To Review', 'in_progress' => 'In Progress', 'mastered' => 'Mastered'];
            $sc = $statusColors[$concept->status->value];
            @endphp
            <a href="{{ route('concepts.show', $concept) }}" class="px-4 py-3 flex items-center gap-4 hover:bg-surface-container/50 transition-all group">
                <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center shrink-0 group-hover:bg-primary/10 transition-colors">
                    <span class="material-symbols-outlined text-on-surface-variant/50 group-hover:text-primary text-[16px] transition-colors">description</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-[13px] font-medium text-on-surface group-hover:text-primary transition-colors truncate">{{ $concept->title }}</div>
                    <div class="text-[12px] text-on-surface-variant/50 line-clamp-1 mt-0.5">{{ Str::limit($concept->explanation, 50) }}</div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-[10px] font-medium {{ $diffColors[$concept->difficulty->value] ?? '' }}">{{ $diffLabels[$concept->difficulty->value] ?? '' }}</span>
                    <span class="flex items-center gap-1.5 {{ $sc['text'] }} {{ $sc['bg'] }} px-2 py-0.5 rounded text-[10px] font-medium">
                        <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
                        {{ $statusLabels[$concept->status->value] ?? $concept->status->label() }}
                    </span>
                    <span class="text-[11px] text-on-surface-variant/40 hidden md:block">{{ $concept->updated_at->diffForHumans() }}</span>
                    <span class="material-symbols-outlined text-outline-variant/50 group-hover:text-primary transition-colors text-[16px]">chevron_right</span>
                </div>
            </a>
            @empty
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <div class="w-12 h-12 rounded-xl bg-primary/5 flex items-center justify-center mb-3">
                    <span class="material-symbols-outlined text-primary text-[24px]">library_books</span>
                </div>
                <h4 class="text-[14px] font-medium text-on-surface mb-1">No concepts yet</h4>
                <p class="text-[12px] text-on-surface-variant/60 mb-3">Add your first concept to start learning.</p>
                <a href="{{ route('concepts.create', $domain) }}" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[12px] font-medium hover:bg-primary/90 transition-all inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">add</span>
                    Add Concept
                </a>
            </div>
            @endforelse
        </div>
    </section>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-[13px] font-semibold text-on-surface">Mastery</h4>
                <span class="material-symbols-outlined text-primary text-[18px]">trending_up</span>
            </div>
            <div class="flex items-baseline gap-2 mb-2">
                <span class="text-2xl font-bold text-primary">{{ $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0 }}%</span>
                <span class="text-[12px] text-on-surface-variant/60">{{ $domain->mastered_count }}/{{ $domain->concepts_count }}</span>
            </div>
            <div class="h-1.5 bg-surface-container rounded-full">
                <div class="h-full bg-primary rounded-full transition-all" style="width: {{ $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0 }}%"></div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-primary to-primary-container rounded-xl p-4 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-bl-full -mr-4 -mt-4"></div>
            <div class="relative z-10">
                <h4 class="text-[13px] font-semibold mb-1">AI Questions</h4>
                <p class="text-[12px] text-white/70 mb-3">Generate practice questions from your concepts.</p>
                @php $firstConcept = $domain->concepts->first(); @endphp
                @if ($firstConcept)
                <a href="{{ route('concepts.show', $firstConcept) }}" class="inline-flex items-center gap-1 bg-white text-primary px-3 py-1.5 rounded-lg text-[12px] font-medium hover:bg-white/90 transition-all">
                    Start
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
                @else
                <span class="inline-flex items-center gap-1 bg-white/30 text-white/50 px-3 py-1.5 rounded-lg text-[12px] font-medium cursor-not-allowed">
                    No concepts yet
                </span>
                @endif
            </div>
        </div>
        <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
            <h4 class="text-[13px] font-semibold text-on-surface mb-3">Overview</h4>
            <div class="grid grid-cols-2 gap-2">
                <div class="p-2.5 bg-primary/5 rounded-lg">
                    <div class="text-[16px] font-bold text-primary">{{ $domain->concepts_count }}</div>
                    <div class="text-[10px] text-on-surface-variant/60 font-medium">Total</div>
                </div>
                <div class="p-2.5 bg-secondary/5 rounded-lg">
                    <div class="text-[16px] font-bold text-secondary">{{ $domain->mastered_count }}</div>
                    <div class="text-[10px] text-on-surface-variant/60 font-medium">Mastered</div>
                </div>
                <div class="p-2.5 bg-amber-50 rounded-lg">
                    <div class="text-[16px] font-bold text-amber-600">{{ $domain->concepts->where('status', 'in_progress')->count() }}</div>
                    <div class="text-[10px] text-on-surface-variant/60 font-medium">In Progress</div>
                </div>
                <div class="p-2.5 bg-error/5 rounded-lg">
                    <div class="text-[16px] font-bold text-error">{{ $domain->concepts->where('status', 'to_review')->count() }}</div>
                    <div class="text-[10px] text-on-surface-variant/60 font-medium">To Review</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
