<x-app-layout activeNav="quizzes" title="Quiz: {{ $domainName }}">
    <x-slot:topbar-actions></x-slot:topbar-actions>

    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <a class="hover:text-primary transition-colors" href="{{ route('quizzes.index') }}">Quizzes</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('quizzes.byDomain', $quiz->domain_id) }}">{{ $domainName }}</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface font-medium">Active Quiz</span>
    </nav>

    @if (session('warning'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
         class="mb-4 px-4 py-3 rounded-lg bg-amber-50 border border-amber-200 text-[13px] text-amber-800 flex items-center gap-2.5">
        <span class="material-symbols-outlined text-[18px] text-amber-600">warning</span>
        <span>{{ session('warning') }}</span>
        <button type="button" @click="show = false" class="ml-auto text-amber-400 hover:text-amber-600">
            <span class="material-symbols-outlined text-[16px]">close</span>
        </button>
    </div>
    @endif

    <div x-data="quizTimer({{ $quiz->time_limit_minutes }}, {{ $quiz->started_at?->timestamp ?? now()->timestamp }}, {{ Js::from($timeExpired) }})" x-init="initTimer()">

        @if ($timeExpired)
        <div class="mb-4 px-4 py-2.5 rounded-lg bg-amber-50 border border-amber-200 text-[13px] text-amber-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] text-amber-600">timer_off</span>
            <span>Time has expired. Review your answers and click <strong>End Quiz</strong> to submit.</span>
        </div>
        @endif

        <div x-show="timesUp" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 p-6 text-center">
                <div class="w-14 h-14 rounded-full bg-error/10 flex items-center justify-center mx-auto mb-3">
                    <span class="material-symbols-outlined text-error text-[28px]">timer_off</span>
                </div>
                <h3 class="text-[16px] font-semibold text-on-surface mb-1">Time's Up!</h3>
                <p class="text-[13px] text-on-surface-variant/70 mb-5">Your quiz time has expired. Redirecting to results...</p>
                <div class="flex justify-center">
                    <span class="material-symbols-outlined text-primary animate-spin text-[24px]">progress_activity</span>
                    </div>
                </div>
            </div>

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="font-display-lg text-display-lg text-on-surface">{{ $domainName }} Quiz</h2>
                <p class="text-[13px] text-on-surface-variant/60 mt-0.5">{{ $quiz->questions->count() }} questions &middot; {{ $quiz->time_limit_minutes }} minutes</p>
            </div>
            <div class="flex items-center gap-3">
            <div class="text-right">
                <div class="px-4 py-2 rounded-lg text-[13px] font-semibold inline-block"
                     :class="timeExpired ? 'bg-error/10 text-error' : (timeLeft > 600 ? 'bg-secondary/10 text-secondary' : (timeLeft > 300 ? 'bg-amber-50 text-amber-600' : (timeLeft <= 60 ? 'bg-error/10 text-error animate-pulse' : 'bg-error/10 text-error')))">
                    <span x-text="formattedTime"></span>
                </div>
            </div>
            </div>
        </div>

        <form id="quiz-form" method="POST" action="{{ route('quizzes.update', $quiz) }}"
              x-data="{
                current: 0,
                answers: {},
                ratings: {},
                draftRestored: false,
                showConfirm: false,
                confirmTitle: '',
                confirmMessage: '',
                confirmVariant: 'danger',
                confirmAction: null,
                submitting: false,
                get total() { return {{ $quiz->questions->count() }}; },
                get isLast() { return this.current === this.total - 1; },
                get isFirst() { return this.current === 0; },
                get progress() { return this.current + 1 + ' / ' + this.total; },
                prev() { if (this.current > 0) this.current--; },
                next() { if (this.current < this.total - 1) this.current++; },
                //
                init() {
                    const saved = localStorage.getItem('quiz_draft_{{ $quiz->id }}');
                    if (saved) {
                        try {
                            const data = JSON.parse(saved);
                            if (data.answers && Object.keys(data.answers).length > 0) {
                                this.answers = data.answers;
                                this.current = data.current || 0;
                                this.draftRestored = true;
                                setTimeout(() => this.draftRestored = false, 4000);
                            }
                        } catch (e) {}
                    }
                    this.$watch('answers', val => this.saveDraft());
                },
                saveDraft() {
                    localStorage.setItem('quiz_draft_{{ $quiz->id }}', JSON.stringify({
                        answers: this.answers,
                        current: this.current
                    }));
                },
                clearDraft() {
                    localStorage.removeItem('quiz_draft_{{ $quiz->id }}');
                },
                submitQuiz() {
                    if (this.submitting) return;
                    const filled = Object.values(this.answers).filter(a => a?.trim()).length;
                    const minRequired = Math.max(Math.ceil(this.total / 3), 1);
                    if (filled < minRequired) {
                        this.confirmTitle = 'Not Enough Answers';
                        this.confirmMessage = 'You must answer at least ' + minRequired + ' of ' + this.total + ' questions before submitting.';
                        this.confirmVariant = 'danger';
                        this.confirmAction = null;
                        this.showConfirm = true;
                        return;
                    }
                    this.clearDraft();
                    this.confirmTitle = 'Submit Quiz';
                    this.confirmMessage = 'Submit your quiz for AI evaluation? Unanswered questions will be scored 0.';
                    this.confirmVariant = 'success';
                    this.confirmAction = () => {
                        this.submitting = true;
                        document.getElementById('mode-input').value = 'submit';
                        document.getElementById('quiz-form').submit();
                    };
                    this.showConfirm = true;
                },
                endQuiz() {
                    if (this.submitting) return;
                    this.clearDraft();
                    this.confirmTitle = 'End Quiz';
                    this.confirmMessage = 'End the quiz now? Your progress will be saved but answers will NOT be evaluated by AI.';
                    this.confirmVariant = 'danger';
                    this.confirmAction = () => {
                        this.submitting = true;
                        document.getElementById('mode-input').value = 'end';
                        document.getElementById('quiz-form').submit();
                    };
                    this.showConfirm = true;
                },
                closeConfirm() {
                    this.showConfirm = false;
                    this.confirmAction = null;
                },
                doConfirm() {
                    const action = this.confirmAction;
                    this.showConfirm = false;
                    this.confirmAction = null;
                    if (typeof action === 'function') action();
                }
              }"
              @keydown.left.prevent="if ($event.target.tagName !== 'TEXTAREA' && !isFirst) prev()"
              @keydown.right.prevent="if ($event.target.tagName !== 'TEXTAREA' && !isLast) next()">

            @csrf
            @method('PATCH')
            <input type="hidden" name="mode" id="mode-input" value="">
            <div x-show="draftRestored" x-cloak x-transition
                 class="mb-4 px-4 py-2.5 rounded-lg bg-amber-50 border border-amber-200 text-[12px] text-amber-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">restore</span>
                Draft restored — your previous answers have been loaded
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
                <div class="lg:col-span-1">
                    <div class="bg-white border border-outline-variant/50 rounded-xl p-4 sticky top-20">
                        <h4 class="text-[13px] font-semibold text-on-surface mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-primary">format_list_bulleted</span>
                            Questions
                        </h4>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($quiz->questions as $index => $q)
                            <button type="button" @click="current = {{ $index }}"
                                    class="w-8 h-8 rounded-lg text-[11px] font-medium transition-all"
                                    :class="current === {{ $index }} ? 'bg-primary text-white' : (answers[{{ $index }}]?.trim() ? 'bg-primary/10 text-primary' : 'bg-surface-container text-on-surface-variant/60 hover:bg-surface-container-high')">
                                {{ $index + 1 }}
                            </button>
                            @endforeach
                        </div>
                        <div class="mt-3 flex items-center gap-2 text-[11px] text-on-surface-variant/50">
                            <span class="w-3 h-3 rounded bg-primary/10"></span> Answered
                            <span class="w-3 h-3 rounded bg-surface-container"></span> Unanswered
                        </div>
                        <button type="button" @click="endQuiz"
                                class="mt-4 w-full px-3 py-2 border border-error/30 text-error rounded-lg text-[11px] font-medium hover:bg-error/5 transition-all flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px]">logout</span>
                            End Quiz
                        </button>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    @foreach ($quiz->questions as $index => $q)
                    <section x-show="current === {{ $index }}" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-x-6"
                             x-transition:enter-end="opacity-100 translate-x-0"
                             class="bg-white border border-outline-variant/50 rounded-xl overflow-hidden">
                        <div class="px-5 py-3 border-b border-outline-variant/30 bg-surface-container/30">
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-full bg-primary/10 text-primary text-[12px] font-semibold flex items-center justify-center shrink-0">{{ $loop->iteration }}</span>
                                <div>
                                    <p class="text-[11px] text-on-surface-variant/50 font-medium">{{ $q->concept?->title ?? 'Concept' }}</p>
                                    <p class="text-[14px] font-medium text-on-surface mt-0.5">{{ $q->question }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            <textarea :name="'answers[' + {{ $index }} + ']'"
                                      x-model="answers[{{ $index }}]"
                                      x-ref="textarea_{{ $index }}"
                                      rows="6"
                                      class="w-full rounded-xl border border-outline-variant/60 text-[12px] p-3 focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all resize-y placeholder:text-on-surface-variant/30 font-mono"
                                       placeholder="Write your answer..."></textarea>
                            <input type="hidden" :name="'ratings[' + {{ $index }} + ']'" value="3">
                            <p class="text-[11px] mt-2 text-center font-semibold flex items-center justify-center gap-1 {{ $timeExpired ? 'text-error' : 'text-secondary' }}"><span class="material-symbols-outlined text-[14px]">info</span> Answers are auto-submitted when time expires.</p>
                        </div>
                    </section>
                    @endforeach

                    <div class="grid grid-cols-3 items-center pt-4 border-t border-outline-variant/30">
                        <div class="flex justify-start">
                            <button type="button" @click="prev()" x-show="!isFirst"
                                    class="px-3 py-2 border border-outline-variant text-on-surface-variant rounded-lg text-[12px] font-medium hover:bg-surface-container transition-all flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">chevron_left</span>
                                Previous
                            </button>
                        </div>
                        <div class="flex justify-center">
                            <span class="text-[13px] text-on-surface-variant/50 font-semibold" x-text="progress"></span>
                        </div>
                        <div class="flex items-center justify-end gap-2">
                            <button type="button" @click="next()" x-show="!isLast"
                                    class="px-4 py-2 border border-outline-variant text-on-surface-variant rounded-lg text-[12px] font-medium hover:bg-surface-container transition-all flex items-center gap-1">
                                Next
                                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                            </button>
                            <button type="button" x-show="isLast"
                                    @click="submitQuiz"
                                    class="px-4 py-2 bg-primary text-white rounded-lg text-[12px] font-medium hover:bg-primary/90 transition-all flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[14px]">rate_review</span>
                                Submit Quiz
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="showConfirm" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" @click.self="closeConfirm">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0"
                             :class="confirmVariant === 'success' ? 'bg-primary/10' : 'bg-error/10'">
                            <span class="material-symbols-outlined text-[20px]"
                                  :class="confirmVariant === 'success' ? 'text-primary' : 'text-error'"
                                  x-text="confirmVariant === 'success' ? 'check_circle' : 'warning'"></span>
                        </div>
                        <h3 class="text-[15px] font-semibold text-on-surface" x-text="confirmTitle"></h3>
                    </div>
                    <p class="text-[13px] text-on-surface-variant/70 mb-5" x-text="confirmMessage"></p>
                    <div class="flex gap-2 justify-end">
                        <button type="button" @click="closeConfirm()" class="px-4 py-2 border border-outline-variant text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container transition-all">Cancel</button>
                        <button type="button" @click="doConfirm()"
                                class="px-4 py-2 text-white rounded-lg text-[13px] font-medium transition-all"
                                :class="confirmVariant === 'success' ? 'bg-primary hover:bg-primary/90' : 'bg-error hover:bg-error/90'"
                                x-text="confirmVariant === 'success' ? 'Submit' : 'OK'"></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
    function quizTimer(minutes, startedAt, expired) {
        return {
            timeLeft: expired ? 0 : minutes * 60,
            interval: null,
            keepAliveInterval: null,
            timesUp: false,
            submitting: false,
            timeExpired: expired,
            initTimer() {
                if (this.timeExpired) {
                    this.timeLeft = 0;
                    return;
                }
                const elapsed = Math.floor((Date.now() / 1000) - startedAt);
                this.timeLeft = Math.max(0, (minutes * 60) - elapsed);
                if (this.timeLeft <= 0) {
                    this.expire();
                    return;
                }
                this.interval = setInterval(() => {
                    this.timeLeft--;
                    if (this.timeLeft <= 0) {
                        clearInterval(this.interval);
                        this.expire();
                    }
                }, 1000);
                this.keepAliveInterval = setInterval(() => {
                    fetch('{{ route('keep-alive') }}').catch(() => {});
                }, 300000);
            },
            expire() {
                if (this.submitting) return;
                this.submitting = true;
                clearInterval(this.keepAliveInterval);
                localStorage.removeItem('quiz_draft_{{ $quiz->id }}');
                this.timesUp = true;
                setTimeout(() => {
                    const modeInput = document.getElementById('mode-input');
                    if (modeInput) modeInput.value = 'timeup';
                    const form = document.getElementById('quiz-form');
                    if (form) form.submit();
                }, 2500);
            },
            get formattedTime() {
                const m = Math.floor(this.timeLeft / 60);
                const s = this.timeLeft % 60;
                return String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
            }
        };
    }
    </script>
</x-app-layout>
