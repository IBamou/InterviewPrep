<x-app-layout activeNav="domains" title="{{ $concept->title }}">
    <x-slot:topbar-actions>
        <a href="{{ route('concepts.practice', $concept) }}" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">Practice</a>
        <a href="{{ route('concepts.edit', $concept) }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container transition-all">Edit</a>
        <button type="button" onclick="showConfirmModal('Archive Concept', 'Are you sure you want to archive this concept?', () => { document.getElementById('archive-form').submit(); })" class="px-3 py-1.5 border border-outline-variant text-error rounded-lg text-[13px] font-medium hover:bg-error/5 transition-all">Archive</button>
        <form id="archive-form" method="POST" action="{{ route('concepts.archive', $concept) }}" class="hidden">
            @csrf @method('DELETE')
        </form>
    </x-slot:topbar-actions>

    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">Domains</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('domains.show', $concept->domain) }}">{{ $concept->domain->name }}</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface font-medium">{{ $concept->title }}</span>
    </nav>

    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h2 class="font-display-lg text-display-lg text-on-surface">{{ $concept->title }}</h2>
            <div class="flex items-center gap-2 mt-2">
                <span class="px-2 py-0.5 rounded text-[11px] font-medium {{ $concept->difficulty->value === 'junior' ? 'bg-secondary/10 text-secondary' : ($concept->difficulty->value === 'mid' ? 'bg-amber-50 text-amber-600' : 'bg-error/5 text-error') }}">
                    {{ ucfirst($concept->difficulty->value) }}
                </span>
                <span class="px-2 py-0.5 rounded text-[11px] font-medium {{ $concept->status->value === 'to_review' ? 'bg-error/5 text-error' : ($concept->status->value === 'mastered' ? 'bg-secondary/10 text-secondary' : 'bg-amber-50 text-amber-600') }}">
                    {{ $concept->status->label() }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-5">
            <section class="bg-white border border-outline-variant/50 rounded-xl p-5">
                <h3 class="text-[14px] font-semibold text-on-surface mb-3 pb-3 border-b border-outline-variant/30">Explanation</h3>
                <div class="text-[14px] text-on-surface-variant/80 leading-relaxed">{!! nl2br(e($concept->explanation)) !!}</div>
            </section>

            @if ($questionSets->isNotEmpty())
                @foreach ($questionSets as $setNumber => $questions)
                    @php $evaluatedCount = $questions->whereNotNull('rating')->count(); @endphp
                    <section class="bg-white border border-outline-variant/50 rounded-xl overflow-hidden">
                        <details class="group">
                            <summary class="px-5 py-3 border-b border-outline-variant/30 flex items-center justify-between bg-surface-container/30 cursor-pointer hover:bg-surface-container/50 transition-colors">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px]">auto_awesome</span>
                                    <h3 class="text-[14px] font-semibold text-on-surface">Practice Set {{ $setNumber }}</h3>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-[11px] text-on-surface-variant/50">{{ $evaluatedCount }}/{{ $questions->count() }} evaluated</span>
                                    <span class="material-symbols-outlined text-on-surface-variant/50 group-open:rotate-180 transition-transform">expand_more</span>
                                </div>
                            </summary>
                            <div class="p-5 space-y-5">
                                @foreach ($questions as $q)
                                <div class="pb-5 {{ !$loop->last ? 'border-b border-outline-variant/20' : '' }}">
                                    <div class="flex gap-3 mb-3">
                                        <span class="w-6 h-6 rounded-full bg-primary/10 text-primary text-[11px] font-semibold flex items-center justify-center shrink-0 mt-0.5">{{ $loop->iteration }}</span>
                                        <div class="flex-1">
                                            <p class="text-[13px] font-medium text-on-surface">{{ $q->question }}</p>
                                        </div>
                                    </div>

                                    @if ($q->rating !== null)
                                        <div class="ml-9 space-y-3">
                                            <div class="flex items-center gap-2">
                                                <div class="flex gap-0.5">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                    <span class="material-symbols-outlined text-[16px] {{ $i <= $q->rating ? 'text-amber-500' : 'text-outline-variant' }}" style="font-variation-settings: 'FILL' 1;">star</span>
                                                    @endfor
                                                </div>
                                                <span class="text-[11px] font-medium text-on-surface-variant/60">{{ $q->rating }}/5</span>
                                            </div>

                                            @if ($q->answer)
                                            <div>
                                                <p class="text-[11px] font-medium text-on-surface-variant/50 mb-1">Your answer:</p>
                                                <div class="text-[12px] text-on-surface-variant/80 bg-surface-container/50 rounded-lg px-3 py-2">{{ $q->answer }}</div>
                                            </div>
                                            @endif

                                            @if ($q->feedback)
                                            <div>
                                                <p class="text-[11px] font-medium text-on-surface-variant/50 mb-1">Feedback:</p>
                                                <div class="text-[12px] text-on-surface-variant/80 bg-primary-fixed/20 rounded-lg px-3 py-2">{{ $q->feedback }}</div>
                                            </div>
                                            @endif

                                            @if ($q->model_answer)
                                            <div>
                                                <p class="text-[11px] font-medium text-on-surface-variant/50 mb-1">Model answer:</p>
                                                <div class="text-[12px] text-on-surface-variant/80 bg-secondary/5 border border-secondary/20 rounded-lg px-3 py-2">{{ $q->model_answer }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="ml-9">
                                            <p class="text-[12px] text-on-surface-variant/40 italic">Not yet answered — <a href="{{ route('concepts.practice', $concept) }}" class="text-primary hover:underline">go to practice</a></p>
                                        </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </details>
                    </section>
                @endforeach
            @endif
        </div>

        <div class="space-y-4">
            <div class="bg-gradient-to-br from-primary to-primary-container rounded-xl p-4 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-bl-full -mr-3 -mt-3"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-1.5 mb-2">
                        <span class="material-symbols-outlined text-white/70 text-[16px]">auto_awesome</span>
                        <span class="text-[10px] font-semibold text-white/60 uppercase">Practice</span>
                    </div>
                    <h4 class="text-[13px] font-semibold mb-1">Start Practicing</h4>
                    <p class="text-[12px] text-white/70 mb-3">Answer questions and get AI feedback on your responses.</p>
                    <a href="{{ route('concepts.practice', $concept) }}" class="block w-full bg-white text-primary px-3 py-1.5 rounded-lg text-[12px] font-medium hover:bg-white/90 transition-all text-center">
                        Go to Practice
                    </a>
                </div>
            </div>

            @if ($questionSets->isNotEmpty())
            <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h4 class="text-[13px] font-semibold text-on-surface mb-3">Your Progress</h4>
                @php
                    $total = $concept->generatedQuestions->count();
                    $evaluated = $concept->generatedQuestions->whereNotNull('rating')->count();
                    $avgRating = $concept->generatedQuestions->whereNotNull('rating')->avg('rating');
                @endphp
                <div class="space-y-3">
                    <div class="flex justify-between text-[12px]">
                        <span class="text-on-surface-variant/60">Questions answered</span>
                        <span class="font-medium">{{ $evaluated }}/{{ $total }}</span>
                    </div>
                    @if ($evaluated > 0)
                    <div class="w-full bg-surface-container h-1.5 rounded-full">
                        <div class="bg-primary h-full rounded-full" style="width: {{ ($evaluated / $total) * 100 }}%"></div>
                    </div>
                    <div class="flex justify-between text-[12px]">
                        <span class="text-on-surface-variant/60">Average rating</span>
                        <span class="font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-amber-500 text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            {{ number_format($avgRating, 1) }}/5
                        </span>
                    </div>
                    @endif
                    <div class="flex justify-between text-[12px]">
                        <span class="text-on-surface-variant/60">Sets completed</span>
                        <span class="font-medium">{{ $questionSets->count() }}</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h4 class="text-[13px] font-semibold text-on-surface mb-3">Status</h4>
                <form method="POST" action="{{ route('concepts.updateStatus', $concept) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="w-full px-3 py-2 bg-primary text-white rounded-lg text-[12px] font-medium hover:bg-primary/90 transition-all flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">trending_up</span>
                        Advance Status
                    </button>
                </form>
            </div>

            <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h4 class="text-[13px] font-semibold text-on-surface mb-3">Details</h4>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center">
                        <span class="text-[12px] text-on-surface-variant/60">Domain</span>
                        <a href="{{ route('domains.show', $concept->domain) }}" class="text-[12px] text-primary font-medium hover:underline">{{ $concept->domain->name }}</a>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[12px] text-on-surface-variant/60">Concepts in domain</span>
                        <span class="text-[12px] font-medium text-on-surface">{{ $concept->domain->concepts_count }} concept{{ $concept->domain->concepts_count !== 1 ? 's' : '' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[12px] text-on-surface-variant/60">Difficulty</span>
                        <span class="text-[12px] font-medium text-on-surface capitalize">{{ $concept->difficulty->value }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[12px] text-on-surface-variant/60">Updated</span>
                        <span class="text-[12px] text-on-surface-variant/60">{{ $concept->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
