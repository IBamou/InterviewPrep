<x-app-layout activeNav="quizzes" title="{{ $domain->name }} Quizzes">
    <x-slot:topbar-actions>
        <a href="{{ route('quizzes.domain-history', $domain) }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container transition-all">
            <span class="material-symbols-outlined text-[16px] align-middle mr-1">history</span>
            Quiz History
        </a>
    </x-slot:topbar-actions>

    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <a class="hover:text-primary transition-colors" href="{{ route('quizzes.index') }}">Quizzes</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface font-medium">{{ $domain->name }}</span>
    </nav>

    <div class="mb-6">
        <h2 class="font-display-lg text-display-lg text-on-surface">{{ $domain->name }}</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">{{ $domain->description ?? 'Start a new quiz or review past attempts.' }}</p>
    </div>

    @if ($domain->totalConcepts === 0)
    <div class="bg-white border border-outline-variant/50 rounded-xl p-8 text-center">
        <span class="material-symbols-outlined text-on-surface-variant/30 text-[48px] mb-3">quiz</span>
        <h3 class="text-[16px] font-semibold text-on-surface mb-1">No concepts yet</h3>
        <p class="text-[13px] text-on-surface-variant/60 mb-4">Add concepts to this domain before creating a quiz.</p>
        <a href="{{ route('domains.show', $domain) }}" class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all inline-flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">add</span>
            Add Concepts
        </a>
    </div>
    @elseif (!$domain->canQuiz)
    <div class="bg-white border border-outline-variant/50 rounded-xl p-8 text-center">
        <span class="material-symbols-outlined text-on-surface-variant/30 text-[48px] mb-3">lock</span>
        <h3 class="text-[16px] font-semibold text-on-surface mb-1">Not enough ready concepts</h3>
        <p class="text-[13px] text-on-surface-variant/60 max-w-md mx-auto mb-2">
            This domain has {{ $domain->quizReadyCount }} of {{ max(config('quiz.domain.min_ready_concepts'), 1) }} required quiz-ready concepts.
        </p>
        <p class="text-[12px] text-on-surface-variant/50 mb-4">Each concept needs: an explanation, {{ config('quiz.requirements.min_evaluated_sets') }}+ evaluated practice set{{ config('quiz.requirements.min_evaluated_sets') > 1 ? 's' : '' }}, and avg rating &ge; {{ config('quiz.requirements.min_avg_rating') }}.</p>
        <a href="{{ route('domains.show', $domain) }}" class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all inline-flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Go to Domain
        </a>
    </div>
    @elseif ($quotaRemaining === 0)
    <div class="bg-white border border-outline-variant/50 rounded-xl p-8 text-center">
        <span class="material-symbols-outlined text-on-surface-variant/30 text-[48px] mb-3">block</span>
        <h3 class="text-[16px] font-semibold text-on-surface mb-1">Daily Limit Reached</h3>
        <p class="text-[13px] text-on-surface-variant/60 max-w-md mx-auto mb-2">
            You've used all {{ $quotaLimit }} quiz attempts for this domain in the last 24 hours.
        </p>
        <p class="text-[12px] text-on-surface-variant/50 mb-4">Come back later or review your past results.</p>
        <a href="{{ route('quizzes.domain-history', $domain) }}" class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all inline-flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">history</span>
            View Past Results
        </a>
    </div>
    @else
    <form method="POST" action="{{ route('quizzes.store') }}"
          x-data="quizForm({{ Js::from($domain->quizReadyConcepts->values()) }}, {{ config('quiz.questions.per_concept') }}, {{ config('quiz.questions.min_per_quiz') }}, {{ config('quiz.questions.max_per_quiz') }}, {{ config('quiz.timer.minutes_per_question') }}, {{ config('quiz.timer.min_minutes') }}, {{ $domain->id }})"
          @submit.prevent="submitForm">
        @csrf
        <input type="hidden" name="domain_id" value="{{ $domain->id }}">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
            <div class="lg:col-span-2">
                <div class="bg-white border border-outline-variant/50 rounded-xl p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-[14px] font-semibold text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-primary">checklist</span>
                            Select Concepts
                        </h3>
                        <span class="text-[12px] text-on-surface-variant/60" x-text="selectedCount + ' selected'"></span>
                    </div>
                    <div class="space-y-1.5">
                        <template x-for="(concept, index) in concepts" :key="concept.id">
                            <label class="flex items-center gap-3 p-3 rounded-lg border transition-all cursor-pointer"
                                   :class="selectedIds.includes(concept.id) ? 'border-primary bg-primary-fixed/30' : 'border-outline-variant/20 hover:bg-surface-container/50'">
                                <input type="checkbox" name="concept_ids[]"
                                       :value="concept.id"
                                       @click="toggleConcept(concept.id)"
                                       class="w-4 h-4 text-primary border-outline-variant rounded focus:ring-primary/30">
                                <div class="flex-1 min-w-0">
                                    <span class="text-[13px] font-medium text-on-surface" x-text="concept.title"></span>
                                    <span class="text-[10px] px-1.5 py-0.5 rounded ml-1.5 bg-secondary/10 text-secondary font-medium">Ready</span>
                                    <span class="text-[10px] text-on-surface-variant/50 ml-1" x-text="concept.avgRating + '/5 avg'"></span>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>
                @error('concept_ids') <p class="text-[12px] text-error mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-4">
                <div class="bg-gradient-to-br from-primary to-primary-container rounded-xl p-4 text-white relative overflow-hidden sticky top-20">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-bl-full -mr-3 -mt-3"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-1.5 mb-2">
                            <span class="material-symbols-outlined text-white/70 text-[16px]">schedule</span>
                            <span class="text-[10px] font-semibold text-white/60 uppercase">Quiz</span>
                        </div>
                        <h4 class="text-[13px] font-semibold mb-1">Summary</h4>
                        <div class="space-y-1.5 text-[12px] text-white/80">
                            <p>Concepts: <span class="font-medium text-white" x-text="selectedCount"></span></p>
                            <p>Questions: <span class="font-medium text-white" x-text="estimatedQuestions"></span></p>
                            <p>Time limit: <span class="font-medium text-white" x-text="timeLimit + ' min'"></span></p>
                            <p class="pt-1.5 border-t border-white/20">Remaining today: <span class="font-medium text-white">{{ $quotaRemaining }}/{{ $quotaLimit }}</span></p>
                        </div>
                        <button type="submit" :disabled="selectedCount < minConcepts || submitting"
                                :class="selectedCount < minConcepts ? 'opacity-50 cursor-not-allowed' : ''"
                                class="w-full mt-4 bg-white text-primary px-3 py-1.5 rounded-lg text-[12px] font-medium hover:bg-white/90 transition-all flex items-center justify-center gap-1.5">
                            <span x-show="!submitting">Start Quiz</span>
                            <span x-show="submitting" class="material-symbols-outlined text-[14px] animate-spin">sync</span>
                            <span x-show="submitting">Generating...</span>
                        </button>
                    </div>
                </div>

                <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
                    <h4 class="text-[12px] font-semibold text-on-surface mb-2">Requirements per concept</h4>
                    <ul class="space-y-1.5 text-[11px] text-on-surface-variant/60">
                        <li class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px]">edit_note</span>
                            Write an explanation
                        </li>
                        <li class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px]">rate_review</span>
                            Complete {{ config('quiz.requirements.min_evaluated_sets') }}+ practice set{{ config('quiz.requirements.min_evaluated_sets') > 1 ? 's' : '' }}
                        </li>
                        <li class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px]">star</span>
                            Average rating &ge; {{ config('quiz.requirements.min_avg_rating') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
    @endif

    @if ($domain->canQuiz)
    <script>
    function quizForm(concepts, perConcept, minQuestions, maxQuestions, minutesPerQuestion, minMinutes, domainId) {
        return {
            concepts: concepts,
            selectedIds: [],
            submitting: false,
            minConcepts: {{ max(config('quiz.domain.min_ready_concepts'), 1) }},
            get selectedCount() { return this.selectedIds.length; },
            get estimatedQuestions() {
                const count = this.selectedIds.length;
                if (count === 0) return 0;
                return Math.min(Math.max(count * perConcept, minQuestions), maxQuestions);
            },
            get timeLimit() {
                return Math.max(Math.round(this.estimatedQuestions * minutesPerQuestion), minMinutes);
            },
            toggleConcept(id) {
                const idx = this.selectedIds.indexOf(id);
                if (idx === -1) {
                    this.selectedIds.push(id);
                } else {
                    this.selectedIds.splice(idx, 1);
                }
            },
            submitForm() {
                if (this.selectedIds.length < this.minConcepts) return;
                this.submitting = true;
                this.$el.submit();
            }
        };
    }
    </script>
    @endif
</x-app-layout>