<x-app-layout activeNav="quizzes" title="Quiz Results: {{ $domainName }}">
    <x-slot:topbar-actions>
        <a href="{{ route('quizzes.index') }}" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">New Quiz</a>
    </x-slot:topbar-actions>

    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <a class="hover:text-primary transition-colors" href="{{ route('quizzes.index') }}">Quizzes</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('quizzes.byDomain', $quiz->domain_id) }}">{{ $domainName }}</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface font-medium">Results</span>
    </nav>

    <div class="mb-6">
        <div class="bg-white border border-outline-variant/50 rounded-xl p-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-full mx-auto mb-3 flex items-center justify-center
                     {{ $percentage >= 70 ? 'bg-secondary/10' : ($percentage >= 40 ? 'bg-amber-50' : 'bg-error/10') }}">
                    <span class="material-symbols-outlined text-[32px]
                          {{ $percentage >= 70 ? 'text-secondary' : ($percentage >= 40 ? 'text-amber-600' : 'text-error') }}"
                          style="font-variation-settings: 'FILL' 1;">
                        {{ $percentage >= 70 ? 'check_circle' : ($percentage >= 40 ? 'trending_up' : 'refresh') }}
                    </span>
                </div>
                <h2 class="font-display-lg text-display-lg text-on-surface">{{ $domainName }} Quiz</h2>
                <div class="mt-2">
                    <span class="text-[32px] font-bold text-on-surface">{{ number_format($percentage, 0) }}%</span>
                    <span class="text-[14px] text-on-surface-variant/60 ml-2">({{ $quiz->total_score }}/{{ $quiz->max_score }} pts)</span>
                </div>
                <p class="text-[13px] text-on-surface-variant/60 mt-1">{{ $quiz->questions->count() }} questions</p>
                @if ($durationMinutes !== null)
                <p class="text-[12px] text-on-surface-variant/50 mt-0.5">Completed in {{ $durationMinutes > 0 ? $durationMinutes . ' min' : 'less than 1 min' }}</p>
                @endif
            </div>

            @php
                $questionResults = $quiz->questions->map(function ($q) {
                    $xp = config('gamification.xp_per_rating')[$q->rating] ?? 0;
                    return ['question' => $q, 'xp' => $xp];
                });
            @endphp

            <div class="space-y-3">
                @foreach ($questionResults as $qr)
                @php $q = $qr['question']; @endphp
                <details class="group bg-surface-container/30 rounded-lg border border-outline-variant/20">
                    <summary class="px-4 py-3 flex items-center justify-between cursor-pointer hover:bg-surface-container/50 transition-colors rounded-lg">
                        <div class="flex items-center gap-2 flex-1 min-w-0">
                            <span class="w-6 h-6 rounded-full bg-primary/10 text-primary text-[11px] font-semibold flex items-center justify-center shrink-0">{{ $loop->iteration }}</span>
                            <p class="text-[13px] font-medium text-on-surface truncate">{{ $q->question }}</p>
                        </div>
                        <div class="flex items-center gap-2 ml-2 shrink-0">
                            <span class="text-[11px] text-on-surface-variant/50">{{ $q->concept?->title ?? 'Concept' }}</span>
                            @if ($q->rating)
                            <div class="flex gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                <span class="material-symbols-outlined text-[14px] {{ $i <= $q->rating ? 'text-amber-500' : 'text-outline-variant/40' }}" style="font-variation-settings: 'FILL' 1;">star</span>
                                @endfor
                            </div>
                            <span class="text-[11px] font-medium text-primary">+{{ $qr['xp'] }} XP</span>
                            @endif
                            <span class="material-symbols-outlined text-on-surface-variant/50 group-open:rotate-180 transition-transform text-[16px]">expand_more</span>
                        </div>
                    </summary>
                    <div class="px-4 pb-4 space-y-3">
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
                        @if (!$q->answer && !$q->feedback && !$q->model_answer)
                        <p class="text-[12px] text-on-surface-variant/40 italic">Not answered</p>
                        @endif
                    </div>
                </details>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
