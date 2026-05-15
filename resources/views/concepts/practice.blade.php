<x-app-layout activeNav="domains" title="Practice: {{ $concept->title }}">
    <x-slot:topbar-actions>
        <a href="{{ route('concepts.show', $concept) }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container transition-all">View Evaluations</a>
        <a href="{{ route('concepts.edit', $concept) }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container transition-all">Edit</a>
    </x-slot:topbar-actions>

    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">Domains</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('domains.show', $concept->domain) }}">{{ $concept->domain->name }}</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('concepts.show', $concept) }}">{{ $concept->title }}</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface font-medium">Practice</span>
    </nav>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-display-lg text-display-lg text-on-surface">Practice: {{ $concept->title }}</h2>
            <div class="flex items-center gap-2 mt-2">
                <span class="px-2 py-0.5 rounded text-[11px] font-medium {{ $concept->difficulty->value === 'junior' ? 'bg-secondary/10 text-secondary' : ($concept->difficulty->value === 'mid' ? 'bg-amber-50 text-amber-600' : 'bg-error/5 text-error') }}">
                    {{ ucfirst($concept->difficulty->value) }}
                </span>
            </div>
        </div>
        <form method="POST" action="{{ route('concepts.generateQuestions', $concept) }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-[12px] font-medium hover:bg-primary/90 transition-all flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[14px]">add</span>
                Generate New Set
            </button>
        </form>
    </div>

    @if ($currentSet && $currentSet->isNotEmpty())
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-[16px] font-semibold text-on-surface">
                Practice Set {{ $currentSetNumber }}
                <span class="text-[12px] text-on-surface-variant/50 font-normal ml-2">
                    {{ $currentSet->whereNotNull('rating')->count() }}/{{ $currentSet->count() }} evaluated
                </span>
            </h3>
        </div>

        <form method="POST" action="{{ route('concepts.submitAnswers', $concept) }}">
            @csrf
            <div class="space-y-5">
                @foreach ($currentSet as $index => $q)
                <section class="bg-white border border-outline-variant/50 rounded-xl overflow-hidden">
                    <div class="px-5 py-3 border-b border-outline-variant/30 bg-surface-container/30">
                        <div class="flex gap-3">
                            <span class="w-6 h-6 rounded-full bg-primary/10 text-primary text-[11px] font-semibold flex items-center justify-center shrink-0 mt-0.5">{{ $loop->iteration }}</span>
                            <p class="text-[13px] font-medium text-on-surface">{{ $q->question }}</p>
                        </div>
                    </div>
                    <div class="p-5">
                        @if ($q->rating !== null)
                            <div class="space-y-3">
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
                            <div>
                                <textarea name="answers[{{ $index }}][answer]" rows="4" class="w-full rounded-lg border border-outline-variant/60 text-[12px] p-3 focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all resize-none placeholder:text-on-surface-variant/30" placeholder="Type your answer...">{{ $q->answer }}</textarea>
                                <input type="hidden" name="answers[{{ $index }}][question_id]" value="{{ $q->id }}"/>
                            </div>
                        @endif
                    </div>
                </section>
                @endforeach

                @if ($currentSet->contains(fn($q) => $q->rating === null))
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-[12px] font-medium hover:bg-primary/90 transition-all flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">rate_review</span>
                        Submit All for AI Review
                    </button>
                    <p class="text-[11px] text-on-surface-variant/40">All answers will be evaluated in one request</p>
                </div>
                @endif
            </div>
        </form>
    @else
        <div class="bg-white border border-outline-variant/50 rounded-xl p-8 text-center">
            <span class="material-symbols-outlined text-[48px] text-on-surface-variant/30 mb-3">quiz</span>
            <h3 class="text-[16px] font-semibold text-on-surface mb-1">No Practice Questions Yet</h3>
            <p class="text-[13px] text-on-surface-variant/60 mb-4">Generate your first set of questions to start practicing.</p>
            <form method="POST" action="{{ route('concepts.generateQuestions', $concept) }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-[12px] font-medium hover:bg-primary/90 transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">bolt</span>
                    Generate Questions
                </button>
            </form>
        </div>
    @endif

    @if (count($setNumbers) > 1)
    <div class="mt-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1.5 border border-outline-variant/30 text-on-surface-variant/30 rounded-lg text-[12px] cursor-not-allowed">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[12px] font-medium hover:bg-surface-container transition-all">Previous</a>
            @endif
        </div>

        <div class="flex items-center gap-1">
            @foreach ($setNumbers as $num)
                @php
                    $page = array_search($num, $setNumbers) + 1;
                    $isActive = $page == $paginator->currentPage();
                @endphp
                <a href="{{ $paginator->url($page) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-[12px] font-medium {{ $isActive ? 'bg-primary text-white' : 'text-on-surface-variant hover:bg-surface-container' }}">
                    {{ $num }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center gap-2">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[12px] font-medium hover:bg-surface-container transition-all">Next</a>
            @else
                <span class="px-3 py-1.5 border border-outline-variant/30 text-on-surface-variant/30 rounded-lg text-[12px] cursor-not-allowed">Next</span>
            @endif
        </div>
    </div>
    @endif
</x-app-layout>
