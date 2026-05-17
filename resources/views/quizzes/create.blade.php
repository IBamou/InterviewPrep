<x-app-layout activeNav="quizzes" title="New Quiz">
    <x-slot:topbar-actions>
        <a href="{{ route('quizzes.history') }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container transition-all">History</a>
    </x-slot:topbar-actions>

    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <span class="text-on-surface font-medium">New Quiz</span>
    </nav>

    <div class="mb-6">
        <h2 class="font-display-lg text-display-lg text-on-surface">Create a Quiz</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Select a domain and at least {{ config('quiz.domain.min_ready_concepts') }} ready concepts to generate a timed mock interview.</p>
    </div>

    <div class="mb-4 p-3 bg-primary-fixed/30 border border-primary/20 rounded-xl">
        <div class="flex items-center gap-2 text-[12px] text-primary">
            <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">info</span>
            <span>Each concept needs: an explanation <span class="text-on-surface-variant/60">&middot;</span> {{ config('quiz.requirements.min_evaluated_sets') }}+ evaluated practice set{{ config('quiz.requirements.min_evaluated_sets') > 1 ? 's' : '' }} <span class="text-on-surface-variant/60">&middot;</span> avg rating &ge; {{ config('quiz.requirements.min_avg_rating') }}</span>
        </div>
    </div>

    @if ($domains->isEmpty())
    <div class="bg-white border border-outline-variant/50 rounded-xl p-8 text-center">
        <span class="material-symbols-outlined text-on-surface-variant/30 text-[48px] mb-3">quiz</span>
        <h3 class="text-[16px] font-semibold text-on-surface mb-1">No Domains Yet</h3>
        <p class="text-[13px] text-on-surface-variant/60 max-w-md mx-auto mb-4">Create a domain and add concepts first.</p>
        <a href="{{ route('domains.index') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all inline-flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Go to Domains
        </a>
    </div>
    @else
    <form method="POST" action="{{ route('quizzes.store') }}"               x-data="quizForm({{ config('quiz.domain.min_ready_concepts') }}, {{ config('quiz.questions.per_concept') }}, {{ config('quiz.questions.min_per_quiz') }}, {{ config('quiz.questions.max_per_quiz') }})" @submit.prevent="submitForm">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-2 space-y-4">
                @foreach ($domains as $domain)
                <x-quiz-domain-card :domain="$domain"/>
                @endforeach

                @error('domain_id') <p class="text-[12px] text-error mt-2">{{ $message }}</p> @enderror
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

    <script>
    function quizForm(minConcepts, perConcept, minQuestions, maxQuestions) {
        return {
            selectedDomain: null,
            selectedConcepts: [],
            submitting: false,
            minConcepts: minConcepts,
            get selectedCount() { return this.selectedConcepts.length; },
            get estimatedQuestions() {
                const count = this.selectedConcepts.length;
                if (count === 0) return 0;
                return Math.min(Math.max(count * perConcept, minQuestions), maxQuestions);
            },
            get timeLimit() {
                return Math.max(Math.round(this.estimatedQuestions * 1.5), 10);
            },
            selectDomain(id) {
                this.selectedDomain = id;
                this.selectedConcepts = [];
            },
            toggleConcept(id) {
                const idx = this.selectedConcepts.indexOf(id);
                if (idx === -1) {
                    this.selectedConcepts.push(id);
                } else {
                    this.selectedConcepts.splice(idx, 1);
                }
            },
            submitForm() {
                if (this.selectedConcepts.length < this.minConcepts) return;
                this.submitting = true;
                this.$el.submit();
            }
        }
    }
    </script>
    @endif
</x-app-layout>
