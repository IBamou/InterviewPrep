<x-app-layout activeNav="quizzes" title="Quiz Mode">
    <x-slot:topbar-actions>
        <a href="{{ route('quizzes.history') }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container transition-all">
            <span class="material-symbols-outlined text-[16px] align-middle mr-1">history</span>
            Quiz History
        </a>
    </x-slot:topbar-actions>

    <div class="mb-6">
        <h2 class="font-display-lg text-display-lg text-on-surface">Quiz Mode</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Select a domain to start a timed mock interview quiz.</p>
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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($domains as $domain)
        @php
            $readyBarPct = $domain->totalConcepts > 0 ? round(($domain->quizReadyCount / max(config('quiz.domain.min_ready_concepts'), 1)) * 100) : 0;
            $quotaUsed = $quotaLimit - $domain->quotaRemaining;
            $quotaExhausted = $domain->quotaRemaining === 0;
        @endphp
        <div class="group bg-white border border-outline-variant/50 rounded-xl p-5 transition-all block {{ $quotaExhausted ? 'opacity-60' : 'hover:border-primary/40 hover:shadow-sm' }}">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-primary text-[20px]">quiz</span>
                </div>
                <div class="min-w-0">
                    <h3 class="text-[14px] font-semibold"><a href="{{ route('quizzes.byDomain', $domain) }}" class="text-on-surface hover:text-primary transition-colors">{{ $domain->name }}</a></h3>
                    <p class="text-[11px] text-on-surface-variant/50">{{ $domain->totalConcepts }} concept{{ $domain->totalConcepts !== 1 ? 's' : '' }}</p>
                </div>
            </div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] text-on-surface-variant/60">Quiz readiness</span>
                <span class="text-[11px] font-semibold {{ $domain->canQuiz ? 'text-secondary' : 'text-amber-600' }}">
                    {{ $domain->quizReadyCount }}/{{ max(config('quiz.domain.min_ready_concepts'), 1) }} ready
                </span>
            </div>
            <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden mb-3">
                <div class="h-full rounded-full transition-all {{ $domain->canQuiz ? 'bg-secondary' : 'bg-amber-400' }}" style="width: {{ min(100, $readyBarPct) }}%"></div>
            </div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] {{ $domain->canQuiz ? 'text-secondary' : 'text-on-surface-variant/50' }}">
                    @if ($domain->canQuiz)
                    Ready to quiz
                    @else
                    {{ max(config('quiz.domain.min_ready_concepts'), 1) - $domain->quizReadyCount }} more needed
                    @endif
                </span>
                <span class="text-[11px] {{ $quotaExhausted ? 'text-error' : 'text-on-surface-variant/50' }}">
                    {{ $quotaUsed }}/{{ $quotaLimit }} used today
                </span>
            </div>
            @if ($quotaExhausted)
            <div class="flex items-center justify-center gap-1 text-[12px] font-medium text-error">
                <span class="material-symbols-outlined text-[14px]">block</span>
                Limit reached
            </div>
            @else
            <a href="{{ route('quizzes.byDomain', $domain) }}"
               class="mt-2 w-full flex items-center justify-center gap-1 text-[12px] font-medium text-primary py-2 rounded-lg hover:bg-primary/5 transition-all">
                Start Quiz
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            </a>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</x-app-layout>