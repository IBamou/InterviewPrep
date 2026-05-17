@props(['domain'])
@php
    $colors = $domain->canQuiz ? 'border-primary/40 bg-primary-fixed/20' : 'border-outline-variant/30';
    $disabled = !$domain->canQuiz ? 'opacity-60' : '';
    $minConcepts = max(config('quiz.domain.min_ready_concepts') ?? 3, 1);
    $barPct = $domain->totalConcepts > 0 ? round(($domain->quizReadyCount / $minConcepts) * 100) : 0;
@endphp
<div class="bg-white border {{ $colors }} rounded-xl overflow-hidden {{ $disabled }}">
    <div class="px-5 py-4 border-b border-outline-variant/20 flex items-center justify-between">
        <div class="flex items-center gap-3">
            @if ($domain->canQuiz)
            <input type="radio" name="domain_id" value="{{ $domain->id }}"
                   @click="selectDomain({{ $domain->id }})"
                   class="w-4 h-4 text-primary border-outline-variant focus:ring-primary/30">
            @else
            <span class="material-symbols-outlined text-[18px] text-on-surface-variant/30">lock</span>
            @endif
            <div>
                <span class="text-[14px] font-semibold text-on-surface">{{ $domain->name }}</span>
                <span class="text-[11px] text-on-surface-variant/50 ml-2">{{ $domain->totalConcepts }} concept{{ $domain->totalConcepts !== 1 ? 's' : '' }}</span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if ($domain->canQuiz)
            <span class="px-2 py-0.5 bg-secondary/10 text-secondary rounded text-[11px] font-semibold">Quiz ready</span>
            @else
            <span class="text-[11px] text-on-surface-variant/50">{{ $domain->quizReadyCount }}/{{ $minConcepts }} concepts ready</span>
            @endif
        </div>
    </div>

    <div class="px-5 py-3 bg-surface-container-low/50">
        <div class="flex items-center gap-2 mb-2">
            <span class="text-[11px] font-medium text-on-surface-variant/60">Quiz readiness</span>
            <span class="text-[11px] font-semibold {{ $domain->canQuiz ? 'text-secondary' : 'text-amber-600' }}">
                {{ $domain->quizReadyCount }}/{{ $minConcepts }} ready
            </span>
        </div>
        <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
            <div class="h-full rounded-full transition-all {{ $domain->canQuiz ? 'bg-secondary' : 'bg-amber-400' }}" style="width: {{ min(100, $barPct) }}%"></div>
        </div>
        @if (!$domain->canQuiz)
        <p class="text-[11px] text-on-surface-variant/50 mt-1.5">Need {{ $minConcepts - $domain->quizReadyCount }} more ready {{ Str::plural('concept', $minConcepts - $domain->quizReadyCount) }} to unlock quiz</p>
        @endif
    </div>

    @if ($domain->canQuiz)
    <div x-show="selectedDomain === {{ $domain->id }}" x-cloak class="px-5 py-3 border-t border-outline-variant/20">
        <div class="flex items-center justify-between mb-2">
            <span class="text-[12px] font-medium text-on-surface-variant/70">Select concepts (minimum {{ $minConcepts }})</span>
            <span class="text-[11px] text-on-surface-variant/50" x-text="selectedCount + ' selected'"></span>
        </div>
        <div class="space-y-1">
            @foreach ($domain->allConcepts as $concept)
            @php $isReady = $concept->quizStatus === 'ready'; @endphp
            <label class="flex items-center gap-3 p-2.5 rounded-lg border transition-all cursor-pointer"
                   :class="selectedConcepts.includes({{ $concept->id }}) ? 'border-primary bg-primary-fixed/30' : 'border-outline-variant/20 hover:bg-surface-container/50'">
                @if ($isReady)
                <input type="checkbox" name="concept_ids[]" value="{{ $concept->id }}"
                       @click="toggleConcept({{ $concept->id }})"
                       class="w-4 h-4 text-primary border-outline-variant rounded focus:ring-primary/30">
                @else
                <span class="material-symbols-outlined text-[16px] text-on-surface-variant/30">block</span>
                @endif
                <div class="flex-1 min-w-0">
                    <span class="text-[13px] font-medium {{ $isReady ? 'text-on-surface' : 'text-on-surface-variant/50' }}">{{ $concept->title }}</span>
                    @if ($isReady)
                    <span class="text-[10px] px-1.5 py-0.5 rounded ml-1.5 bg-secondary/10 text-secondary font-medium">Ready</span>
                    <span class="text-[10px] text-on-surface-variant/50 ml-1">{{ $concept->getGlobalAvgRating() }}/5 avg</span>
                    @endif
                </div>
                @if (!$isReady)
                <span class="text-[10px] text-on-surface-variant/40 text-right max-w-[160px] leading-tight">{{ $concept->quizMessage }}</span>
                @endif
            </label>
            @endforeach
        </div>
    </div>
    @else
    <details class="group px-5 py-2 border-t border-outline-variant/10">
        <summary class="text-[11px] text-on-surface-variant/50 font-medium cursor-pointer hover:text-on-surface-variant transition-colors list-none flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px] group-open:rotate-180 transition-transform">expand_more</span>
            Show concept readiness
        </summary>
        <div class="pt-2 pb-1 space-y-1">
            @foreach ($domain->allConcepts as $concept)
            <div class="flex items-center gap-2 px-2 py-1.5 rounded text-[12px]">
                @if ($concept->quizStatus === 'ready')
                <span class="material-symbols-outlined text-[14px] text-secondary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                @else
                <span class="material-symbols-outlined text-[14px] text-on-surface-variant/30">radio_button_unchecked</span>
                @endif
                <span class="flex-1 {{ $concept->quizStatus === 'ready' ? 'text-on-surface font-medium' : 'text-on-surface-variant/60' }}">{{ $concept->title }}</span>
                <span class="text-[10px] {{ $concept->quizStatus === 'ready' ? 'text-secondary' : 'text-on-surface-variant/40' }}">{{ $concept->quizMessage }}</span>
            </div>
            @endforeach
        </div>
    </details>
    @endif
</div>
