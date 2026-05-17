<x-app-layout activeNav="domains" title="{{ $concept->title }}">
    <x-slot:topbar-actions>
        <a href="{{ route('concepts.practice', $concept) }}?tier=junior" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">Practice</a>
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
                <span class="px-2 py-0.5 rounded text-[11px] font-medium {{ $concept->status->value === 'to_review' ? 'bg-error/5 text-error' : ($concept->status->value === 'mastered' ? 'bg-secondary/10 text-secondary' : 'bg-amber-50 text-amber-600') }}">
                    {{ $concept->status->label() }}
                </span>
                <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-primary/10 text-primary">
                    {{ $concept->xp }} XP
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-5">
            <section class="bg-white border border-outline-variant/50 rounded-xl p-5" x-data="explanationImprover()">
                <div class="flex items-center justify-between mb-3 pb-3 border-b border-outline-variant/30">
                    <h3 class="text-[14px] font-semibold text-on-surface">Explanation</h3>
                    <button @click="improveExplanation('{{ route('concepts.improveExplanation', $concept) }}')" :disabled="loading" class="inline-flex items-center gap-1 text-[11px] {{ $concept->explanation ? 'text-primary' : 'text-secondary' }} font-medium hover:opacity-80 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="material-symbols-outlined text-[14px]" x-show="!loading">{{ $concept->explanation ? 'auto_fix_high' : 'auto_awesome' }}</span>
                        <span class="material-symbols-outlined text-[14px] animate-spin" x-show="loading">progress_activity</span>
                        <span x-text="loading ? 'Generating...' : '{{ $concept->explanation ? 'Improve with AI' : 'Generate with AI' }}'"></span>
                    </button>
                </div>
                <div x-show="!showSuggestion" x-cloak>
                    @if($concept->explanation)
                        <div class="text-[14px] text-on-surface-variant/80 leading-relaxed">{!! nl2br(e($concept->explanation)) !!}</div>
                    @else
                        <div class="flex flex-col items-center justify-center py-6 text-center">
                            <span class="material-symbols-outlined text-on-surface-variant/30 text-[40px] mb-2">edit_note</span>
                            <p class="text-[13px] text-on-surface-variant/50 mb-1">No explanation written yet.</p>
                            <p class="text-[12px] text-on-surface-variant/40">Write your own or click "Generate with AI" to create one.</p>
                        </div>
                    @endif
                </div>
                <div x-show="showSuggestion" x-cloak class="mt-3 bg-primary-fixed/30 border border-primary/20 rounded-lg p-3">
                    <p class="text-[12px] font-medium text-on-surface-variant/50 mb-1">AI Suggestion:</p>
                    <div class="text-[14px] text-on-surface-variant/80 leading-relaxed mb-3" x-html="suggestion"></div>
                    <div class="flex items-center gap-2">
                        <form :action="acceptUrl" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="explanation" :value="suggestion"/>
                            <button type="submit" class="px-3 py-1 bg-primary text-white rounded-lg text-[11px] font-medium hover:bg-primary/90 transition-all flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">check</span>
                                Accept
                            </button>
                        </form>
                        <button @click="showSuggestion = false" class="px-3 py-1 border border-outline-variant text-on-surface-variant rounded-lg text-[11px] font-medium hover:bg-surface-container transition-all flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">close</span>
                            Reject
                        </button>
                    </div>
                </div>
            </section>

            @foreach ($tiers as $tier)
            @php
                $isUnlocked = $concept->hasTierUnlocked($tier);
                $tierSets = $tierData[$tier] ?? collect();
                $tierColors = [
                    'junior' => ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'border' => 'border-primary/20'],
                    'mid' => ['bg' => 'bg-secondary/10', 'text' => 'text-secondary', 'border' => 'border-secondary/20'],
                    'senior' => ['bg' => 'bg-tertiary/10', 'text' => 'text-tertiary', 'border' => 'border-tertiary/20'],
                ];
                $colors = $tierColors[$tier];
            @endphp
            <section class="bg-white border {{ $isUnlocked ? $colors['border'] : 'border-outline-variant/30' }} rounded-xl overflow-hidden">
                <details class="group" @if ($isUnlocked) open @endif>
                    <summary class="px-5 py-4 border-b {{ $isUnlocked ? 'border-outline-variant/30' : 'border-transparent' }} flex items-center justify-between {{ $isUnlocked ? 'bg-surface-container/30 hover:bg-surface-container/50' : 'bg-surface-container-low/50' }} cursor-pointer transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined {{ $isUnlocked ? $colors['text'] : 'text-on-surface-variant/30' }} text-[20px]" style="font-variation-settings: 'FILL' 1;">{{ $isUnlocked ? 'shield' : 'lock' }}</span>
                            <div>
                                <h3 class="text-[14px] font-semibold text-on-surface">{{ ucfirst($tier) }} Level</h3>
                                @if ($isUnlocked)
                                <p class="text-[11px] text-on-surface-variant/50">{{ $tierSets->count() }} practice set{{ $tierSets->count() !== 1 ? 's' : '' }}</p>
                                @else
                                <p class="text-[11px] text-on-surface-variant/40">Complete requirements to unlock</p>
                                @endif
                            </div>
                        </div>
                        @if ($isUnlocked)
                        <span class="material-symbols-outlined text-on-surface-variant/50 group-open:rotate-180 transition-transform">expand_more</span>
                        @endif
                    </summary>
                    @if ($isUnlocked)
                    <div class="p-5">
                        @if ($tierSets->isNotEmpty())
                        <div class="space-y-3">
                            @foreach ($tierSets as $setNumber => $questions)
                            @php $evaluatedCount = $questions->whereNotNull('rating')->count(); @endphp
                            <details class="group/set bg-surface-container/30 rounded-lg border border-outline-variant/20">
                                <summary class="px-4 py-3 flex items-center justify-between cursor-pointer hover:bg-surface-container/50 transition-colors rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary text-[16px]">auto_awesome</span>
                                        <h4 class="text-[13px] font-medium text-on-surface">Set {{ $setNumber }}</h4>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[11px] text-on-surface-variant/50">{{ $evaluatedCount }}/{{ $questions->count() }} evaluated</span>
                                        @if ($evaluatedCount > 0)
                                        <a href="{{ route('concepts.practice', $concept) }}?tier={{ $tier }}&page={{ array_search($setNumber, $tierSets->keys()->toArray()) + 1 }}" class="min-w-[82px] justify-center px-2.5 py-1 bg-secondary text-white rounded-lg text-[11px] font-medium hover:bg-secondary/90 transition-all flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">visibility</span>
                                            Review
                                        </a>
                                        @else
                                        <a href="{{ route('concepts.practice', $concept) }}?tier={{ $tier }}&page={{ array_search($setNumber, $tierSets->keys()->toArray()) + 1 }}" class="min-w-[82px] justify-center px-2.5 py-1 bg-primary text-white rounded-lg text-[11px] font-medium hover:bg-primary/90 transition-all flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
                                            Practice
                                        </a>
                                        @endif
                                        <span class="material-symbols-outlined text-on-surface-variant/50 group-open/set:rotate-180 transition-transform">expand_more</span>
                                    </div>
                                </summary>
                                <div class="px-4 pb-4 space-y-4">
                                    @foreach ($questions as $q)
                                    <div class="pb-4 {{ !$loop->last ? 'border-b border-outline-variant/20' : '' }}">
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
                                                    @php
                                                        $xpMap = [0 => 0, 1 => -10, 2 => -5, 3 => 5, 4 => 10, 5 => 20];
                                                        $qXp = $xpMap[$q->rating] ?? 0;
                                                    @endphp
                                                    <span class="text-[11px] font-semibold {{ $qXp < 0 ? 'text-error' : 'text-primary' }}">{{ $qXp >= 0 ? '+' : '' }}{{ $qXp }} XP</span>
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
                                                <p class="text-[12px] text-on-surface-variant/40 italic">Not yet answered — <a href="{{ route('concepts.practice', $concept) }}?tier={{ $tier }}&page={{ array_search($setNumber, $tierSets->keys()->toArray()) + 1 }}" class="text-primary hover:underline">go to practice</a></p>
                                            </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </details>
                            @endforeach
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <span class="material-symbols-outlined text-on-surface-variant/30 text-[32px] mb-2">quiz</span>
                            <p class="text-[13px] text-on-surface-variant/50 mb-1">No practice sets yet</p>
                            <form method="POST" action="{{ route('concepts.generateQuestions', $concept) }}" class="mt-2">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[12px] font-medium hover:bg-primary/90 transition-all flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[14px]">add</span>
                                    Generate Set
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                    @endif
                </details>
            </section>
            @endforeach
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
                    <a href="{{ route('concepts.practice', $concept) }}?tier=junior" class="block w-full bg-white text-primary px-3 py-1.5 rounded-lg text-[12px] font-medium hover:bg-white/90 transition-all text-center">
                        Go to Practice
                    </a>
                </div>
            </div>

            @php $progression = app(\App\Services\ProgressionService::class); @endphp
            <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h4 class="text-[13px] font-semibold text-on-surface mb-3">Progress</h4>
                <div class="space-y-3">
                    @php
                        $tierXp = $concept->tier_xp ?? ['junior' => 0, 'mid' => 0, 'senior' => 0];
                        $tierColors = [
                            'junior' => ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'bar' => 'bg-primary'],
                            'mid' => ['bg' => 'bg-secondary/10', 'text' => 'text-secondary', 'bar' => 'bg-secondary'],
                            'senior' => ['bg' => 'bg-tertiary/10', 'text' => 'text-tertiary', 'bar' => 'bg-tertiary'],
                        ];
                    @endphp
                    @foreach (['junior', 'mid', 'senior'] as $t)
                    @php $colors = $tierColors[$t]; @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[11px] font-medium {{ $colors['text'] }}">{{ ucfirst($t) }}</span>
                            <span class="text-[11px] text-on-surface-variant/60">{{ $tierXp[$t] ?? 0 }} XP</span>
                        </div>
                        <div class="w-full bg-surface-container h-1.5 rounded-full">
                            <div class="{{ $colors['bar'] }} h-full rounded-full transition-all" style="width: {{ min(100, round((($tierXp[$t] ?? 0) / 200) * 100)) }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            @php $nextUnlock = $progression->getNextUnlockThreshold($concept); @endphp
            @if ($nextUnlock)
            <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h4 class="text-[13px] font-semibold text-on-surface mb-3">Next Unlock</h4>
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[12px] font-medium text-secondary">{{ ucfirst($nextUnlock['tier']) }}</span>
                    </div>
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-[11px] text-on-surface-variant/50">
                            <span>XP</span>
                            <span>{{ $nextUnlock['current_xp'] }}/{{ $nextUnlock['xp_needed'] }}</span>
                        </div>
                        <div class="w-full bg-surface-container h-1.5 rounded-full">
                            <div class="bg-secondary h-full rounded-full transition-all" style="width: {{ min(100, round(($nextUnlock['current_xp'] / $nextUnlock['xp_needed']) * 100)) }}%"></div>
                        </div>
                        <div class="flex justify-between text-[11px] text-on-surface-variant/50">
                            <span>Practice Sets</span>
                            <span>{{ $nextUnlock['sets_completed'] }}/{{ $nextUnlock['sets_needed'] }}</span>
                        </div>
                        <div class="w-full bg-surface-container h-1.5 rounded-full">
                            <div class="bg-secondary h-full rounded-full transition-all" style="width: {{ min(100, round(($nextUnlock['sets_completed'] / $nextUnlock['sets_needed']) * 100)) }}%"></div>
                        </div>
                        <div class="flex justify-between text-[11px] text-on-surface-variant/50">
                            <span>Global Avg Rating</span>
                            <span class="{{ $nextUnlock['current_avg_rating'] >= $nextUnlock['avg_rating_needed'] ? 'text-primary' : 'text-on-surface-variant/50' }}">{{ $nextUnlock['current_avg_rating'] }}/{{ $nextUnlock['avg_rating_needed'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @php $masteryProgress = $progression->getMasteryProgress($concept); @endphp
            <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h4 class="text-[13px] font-semibold text-on-surface mb-3">Mastery Requirements</h4>
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] {{ $masteryProgress['avg_rating_met'] ? 'text-primary' : 'text-on-surface-variant/30' }}" style="font-variation-settings: 'FILL' 1;">{{ $masteryProgress['avg_rating_met'] ? 'check_circle' : 'radio_button_unchecked' }}</span>
                        <span class="text-[12px] {{ $masteryProgress['avg_rating_met'] ? 'text-on-surface' : 'text-on-surface-variant/50' }}">Global avg ≥ 3.5 for mastery ({{ $masteryProgress['global_avg_rating'] }})</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant/30" style="font-variation-settings: 'FILL' 1;">info</span>
                        <span class="text-[12px] text-on-surface-variant/50">Global avg ≥ 3.0 needed to unlock tiers</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] {{ $masteryProgress['all_tiers_unlocked'] ? 'text-primary' : 'text-on-surface-variant/30' }}" style="font-variation-settings: 'FILL' 1;">{{ $masteryProgress['all_tiers_unlocked'] ? 'check_circle' : 'radio_button_unchecked' }}</span>
                        <span class="text-[12px] {{ $masteryProgress['all_tiers_unlocked'] ? 'text-on-surface' : 'text-on-surface-variant/50' }}">All tiers unlocked</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] {{ $masteryProgress['senior_xp_met'] ? 'text-primary' : 'text-on-surface-variant/30' }}" style="font-variation-settings: 'FILL' 1;">{{ $masteryProgress['senior_xp_met'] ? 'check_circle' : 'radio_button_unchecked' }}</span>
                        <span class="text-[12px] {{ $masteryProgress['senior_xp_met'] ? 'text-on-surface' : 'text-on-surface-variant/50' }}">200 XP in Senior ({{ $masteryProgress['senior_xp'] }})</span>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h4 class="text-[13px] font-semibold text-on-surface mb-3">Ratings by Tier</h4>
                <div class="space-y-3">
                    @php
                        $tierColors = [
                            'junior' => ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'bar' => 'bg-primary'],
                            'mid' => ['bg' => 'bg-secondary/10', 'text' => 'text-secondary', 'bar' => 'bg-secondary'],
                            'senior' => ['bg' => 'bg-tertiary/10', 'text' => 'text-tertiary', 'bar' => 'bg-tertiary'],
                        ];
                    @endphp
                    @foreach (['junior', 'mid', 'senior'] as $t)
                    @php $colors = $tierColors[$t]; @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[11px] font-medium {{ $colors['text'] }}">{{ ucfirst($t) }}</span>
                            <span class="text-[11px] text-on-surface-variant/60">{{ $masteryProgress['tier_averages'][$t] }}/5</span>
                        </div>
                        <div class="w-full bg-surface-container h-1.5 rounded-full">
                            <div class="{{ $colors['bar'] }} h-full rounded-full transition-all" style="width: {{ $masteryProgress['tier_averages'][$t] * 20 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                    <div class="pt-2 border-t border-outline-variant/20">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-semibold text-on-surface">Global</span>
                            <span class="text-[11px] font-semibold text-on-surface">{{ $masteryProgress['global_avg_rating'] }}/5</span>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            @php $totalQuestions = $concept->generatedQuestions->count(); @endphp
            @if ($totalQuestions > 0)
            <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h4 class="text-[13px] font-semibold text-on-surface mb-3">Practice Stats</h4>
                @php
                    $evaluated = $concept->generatedQuestions->whereNotNull('rating')->count();
                    $avgRating = $concept->generatedQuestions->whereNotNull('rating')->avg('rating');
                @endphp
                <div class="space-y-3">
                    <div class="flex justify-between text-[12px]">
                        <span class="text-on-surface-variant/60">Questions answered</span>
                        <span class="font-medium">{{ $evaluated }}/{{ $totalQuestions }}</span>
                    </div>
                    @if ($evaluated > 0)
                    <div class="w-full bg-surface-container h-1.5 rounded-full">
                        <div class="bg-primary h-full rounded-full" style="width: {{ ($evaluated / $totalQuestions) * 100 }}%"></div>
                    </div>
                    <div class="flex justify-between text-[12px]">
                        <span class="text-on-surface-variant/60">Average rating</span>
                        <span class="font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-amber-500 text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            {{ number_format($avgRating, 1) }}/5
                        </span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h4 class="text-[13px] font-semibold text-on-surface mb-3">Details</h4>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center">
                        <span class="text-[12px] text-on-surface-variant/60">Domain</span>
                        <a href="{{ route('domains.show', $concept->domain) }}" class="text-[12px] text-primary font-medium hover:underline">{{ $concept->domain->name }} ({{ $concept->domain->concepts->count() }} concepts)</a>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[12px] text-on-surface-variant/60">Updated</span>
                        <span class="text-[12px] text-on-surface-variant/60">{{ $concept->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function explanationImprover() {
        return {
            showSuggestion: false,
            suggestion: '',
            loading: false,
            acceptUrl: '{{ route('concepts.acceptExplanation', $concept) }}',
            improveExplanation(url) {
                this.loading = true;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    this.suggestion = data.suggestion.replace(/\n/g, '<br>');
                    this.showSuggestion = true;
                })
                .catch(() => {
                    alert('Failed to generate suggestion. Please try again.');
                })
                .finally(() => {
                    this.loading = false;
                });
            },
        };
    }
    </script>
</x-app-layout>
