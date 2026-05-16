<x-app-layout activeNav="search" title="Search">
    <div class="max-w-3xl mx-auto">
        <h2 class="font-display-lg text-display-lg text-on-surface mb-6">Search</h2>

        <form method="GET" action="{{ route('search') }}" class="mb-6">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant/50 text-[20px]">search</span>
                <input type="text" name="q" value="{{ $query }}" class="w-full bg-white border border-outline-variant rounded-xl py-3 pl-12 pr-24 text-[14px] placeholder:text-on-surface-variant/40 focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all" placeholder="Search domains, concepts, questions..." autofocus/>
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">Search</button>
            </div>
        </form>

        @if ($query)
        <div class="flex items-center gap-1 mb-6 border-b border-outline-variant/50">
            <a href="{{ route('search', ['q' => $query, 'type' => 'all']) }}" class="px-4 py-2.5 text-[13px] font-medium border-b-2 transition-colors {{ $type === 'all' ? 'border-primary text-primary' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:bg-surface-container/50 rounded-t-lg' }}">
                All ({{ $totalResults }})
            </a>
            <a href="{{ route('search', ['q' => $query, 'type' => 'domains']) }}" class="px-4 py-2.5 text-[13px] font-medium border-b-2 transition-colors {{ $type === 'domains' ? 'border-primary text-primary' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:bg-surface-container/50 rounded-t-lg' }}">
                Domains ({{ $domains->count() }})
            </a>
            <a href="{{ route('search', ['q' => $query, 'type' => 'concepts']) }}" class="px-4 py-2.5 text-[13px] font-medium border-b-2 transition-colors {{ $type === 'concepts' ? 'border-primary text-primary' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:bg-surface-container/50 rounded-t-lg' }}">
                Concepts ({{ $concepts->count() }})
            </a>
            <a href="{{ route('search', ['q' => $query, 'type' => 'questions']) }}" class="px-4 py-2.5 text-[13px] font-medium border-b-2 transition-colors {{ $type === 'questions' ? 'border-primary text-primary' : 'border-transparent text-on-surface-variant hover:text-on-surface hover:bg-surface-container/50 rounded-t-lg' }}">
                Questions ({{ $questions->count() }})
            </a>
        </div>

        @if ($totalResults === 0)
        <div class="bg-white border border-outline-variant/50 rounded-xl p-8 text-center">
            <span class="material-symbols-outlined text-[48px] text-on-surface-variant/30 mb-3">search_off</span>
            <h3 class="text-[16px] font-semibold text-on-surface mb-1">No results found</h3>
            <p class="text-[13px] text-on-surface-variant/60">Try different keywords or broaden your search.</p>
        </div>
        @else
        @if (($type === 'all' || $type === 'domains') && $domains->isNotEmpty())
        <section class="mb-8">
            <h3 class="text-[14px] font-semibold text-on-surface-variant/70 uppercase tracking-wide mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">account_tree</span>
                Domains
            </h3>
            <div class="space-y-2">
                @foreach ($domains as $domain)
                <a href="{{ route('domains.show', $domain) }}" class="block bg-white border border-outline-variant/50 rounded-xl p-4 hover:border-primary/50 hover:bg-primary-fixed/20 transition-all">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full" style="background-color: {{ $domain->color }}"></span>
                            <span class="text-[14px] font-medium text-on-surface">{{ $domain->name }}</span>
                        </div>
                        <span class="text-[12px] text-on-surface-variant/50">{{ $domain->concepts_count }} concept{{ $domain->concepts_count !== 1 ? 's' : '' }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        @if (($type === 'all' || $type === 'concepts') && $concepts->isNotEmpty())
        <section class="mb-8">
            <h3 class="text-[14px] font-semibold text-on-surface-variant/70 uppercase tracking-wide mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">lightbulb</span>
                Concepts
            </h3>
            <div class="space-y-2">
                @foreach ($concepts as $concept)
                <a href="{{ route('concepts.show', $concept) }}" class="block bg-white border border-outline-variant/50 rounded-xl p-4 hover:border-primary/50 hover:bg-primary-fixed/20 transition-all">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[14px] font-medium text-on-surface">{{ $concept->title }}</span>
                                <span class="text-[11px] text-on-surface-variant/40">in</span>
                                <span class="text-[12px] text-primary font-medium">{{ $concept->domain->name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-1.5 py-0.5 rounded text-[10px] font-medium {{ $concept->difficulty->value === 'junior' ? 'bg-secondary/10 text-secondary' : ($concept->difficulty->value === 'mid' ? 'bg-amber-50 text-amber-600' : 'bg-error/5 text-error') }}">
                                    {{ ucfirst($concept->difficulty->value) }}
                                </span>
                                <span class="px-1.5 py-0.5 rounded text-[10px] font-medium {{ $concept->status->value === 'to_review' ? 'bg-error/5 text-error' : ($concept->status->value === 'mastered' ? 'bg-secondary/10 text-secondary' : 'bg-amber-50 text-amber-600') }}">
                                    {{ $concept->status->label() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        @if (($type === 'all' || $type === 'questions') && $questions->isNotEmpty())
        <section class="mb-8">
            <h3 class="text-[14px] font-semibold text-on-surface-variant/70 uppercase tracking-wide mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">quiz</span>
                Questions
            </h3>
            <div class="space-y-2">
                @foreach ($questions as $question)
                <a href="{{ route('concepts.practice', $question->concept) }}" class="block bg-white border border-outline-variant/50 rounded-xl p-4 hover:border-primary/50 hover:bg-primary-fixed/20 transition-all">
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-full bg-primary/10 text-primary text-[11px] font-semibold flex items-center justify-center shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[14px]">quiz</span>
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] font-medium text-on-surface mb-1">{{ $question->question }}</p>
                            <div class="flex items-center gap-2 text-[11px] text-on-surface-variant/50">
                                <span>{{ $question->concept->title }}</span>
                                <span>·</span>
                                <span>{{ $question->concept->domain->name }}</span>
                                @if ($question->rating)
                                <span>·</span>
                                <span class="flex items-center gap-0.5">
                                    <span class="material-symbols-outlined text-[12px] text-amber-500" style="font-variation-settings: 'FILL' 1;">star</span>
                                    {{ $question->rating }}/5
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
        @endif
        @endif
    </div>
</x-app-layout>
