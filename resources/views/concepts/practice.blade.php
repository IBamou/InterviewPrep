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

    @if (session()->has('xp_earned'))
    @php
        $xpEarned = session('xp_earned');
        $xpColor = $xpEarned > 0 ? 'text-primary' : ($xpEarned < 0 ? 'text-error' : 'text-amber-600');
        $xpBg = $xpEarned > 0 ? 'bg-primary/5 border-primary/20' : ($xpEarned < 0 ? 'bg-error/5 border-error/20' : 'bg-amber-50 border-amber-200');
        $xpIcon = $xpEarned > 0 ? 'trending_up' : ($xpEarned < 0 ? 'trending_down' : 'warning');
    @endphp
    <div class="mb-4 p-3 {{ $xpBg }} border rounded-xl">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined {{ $xpColor }} text-[20px]" style="font-variation-settings: 'FILL' 1;">{{ $xpIcon }}</span>
            <div>
                <p class="text-[13px] font-semibold {{ $xpColor }}">{{ $xpEarned >= 0 ? '+' : '' }}{{ $xpEarned }} XP</p>
                @if ($xpEarned === 0)
                <p class="text-[11px] text-error/70 mt-0.5">Blank answers count as 0/5 and lower your average rating</p>
                @endif
                <p class="text-[11px] text-on-surface-variant/60">Global avg: {{ $concept->getGlobalAvgRating() }}/5 · {{ ucfirst($tier) }} avg: {{ $concept->getTierAvgRating($tier) }}/5</p>
                @if (session('next_unlock'))
                @php $next = session('next_unlock'); @endphp
                <p class="text-[10px] text-primary/70 mt-0.5">
                    {{ ucfirst($next['tier']) }}: {{ $next['sets_completed'] }}/{{ $next['sets_needed'] }} sets · Global avg {{ $next['current_avg_rating'] }}/{{ $next['avg_rating_needed'] }} · {{ $next['current_xp'] }}/{{ $next['xp_needed'] }} XP
                </p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-display-lg text-display-lg text-on-surface">Practice: {{ $concept->title }}</h2>
        </div>
        <form method="POST" action="{{ route('concepts.generateQuestions', $concept) }}">
            @csrf
            <input type="hidden" name="tier" value="{{ $tier }}"/>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-[12px] font-medium hover:bg-primary/90 transition-all flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[14px]">add</span>
                Generate New Set
            </button>
        </form>
    </div>

    @php
        $tierColors = [
            'junior' => ['bg' => 'bg-primary/10', 'text' => 'text-primary', 'border' => 'border-primary', 'activeBg' => 'bg-primary', 'activeText' => 'text-white'],
            'mid' => ['bg' => 'bg-secondary/10', 'text' => 'text-secondary', 'border' => 'border-secondary', 'activeBg' => 'bg-secondary', 'activeText' => 'text-white'],
            'senior' => ['bg' => 'bg-tertiary/10', 'text' => 'text-tertiary', 'border' => 'border-tertiary', 'activeBg' => 'bg-tertiary', 'activeText' => 'text-white'],
        ];
    @endphp

    <div class="flex items-center gap-2 mb-4">
        @foreach ($allTiers as $t)
        @php $meta = $tierMetadata[$t]; @endphp
        @if ($meta['unlocked'])
        <a href="{{ route('concepts.practice', $concept) }}?tier={{ $t }}" class="px-4 py-2 rounded-lg text-[13px] font-medium transition-all {{ $t === $tier ? $tierColors[$t]['activeBg'] . ' ' . $tierColors[$t]['activeText'] : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-high' }}">
            {{ ucfirst($t) }}
            <span class="ml-1 text-[11px] {{ $t === $tier ? 'opacity-80' : 'opacity-60' }}">{{ $meta['setCount'] }} · {{ $concept->getTierXp($t) }} XP</span>
        </a>
        @else
        <span class="px-4 py-2 rounded-lg text-[13px] font-medium bg-surface-container-low text-on-surface-variant/40 cursor-not-allowed flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px]">lock</span>
            {{ ucfirst($t) }}
        </span>
        @endif
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5">
        <div class="lg:col-span-1">
            <div class="bg-white border border-outline-variant/50 rounded-xl p-4 sticky top-20">
                <h4 class="text-[13px] font-semibold text-on-surface mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined {{ $tierColors[$tier]['text'] }} text-[16px]">layers</span>
                    Practice Sets
                </h4>
                @if ($tierMetadata[$tier]['setCount'] > 0)
                <div class="space-y-1.5">
                    @foreach ($tierMetadata[$tier]['sets'] as $set)
                    @php
                        $isActive = $set['number'] === $currentSetNumber;
                        $statusIcons = [
                            'completed' => ['icon' => 'check_circle', 'color' => 'text-primary'],
                            'in_progress' => ['icon' => 'pending', 'color' => 'text-amber-600'],
                            'not_started' => ['icon' => 'circle', 'color' => 'text-on-surface-variant/30'],
                        ];
                        $status = $statusIcons[$set['status']];
                    @endphp
                    <a href="{{ route('concepts.practice', $concept) }}?tier={{ $tier }}&page={{ array_search($set['number'], array_column($tierMetadata[$tier]['sets'], 'number')) + 1 }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-lg transition-all {{ $isActive ? 'bg-surface-container-high border border-outline-variant/30' : 'hover:bg-surface-container/50' }}">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined {{ $status['color'] }} text-[16px]" style="font-variation-settings: 'FILL' 1;">{{ $status['icon'] }}</span>
                            <span class="text-[12px] font-medium {{ $isActive ? 'text-on-surface' : 'text-on-surface-variant/70' }}">Set {{ $set['number'] }}</span>
                        </div>
                        <span class="text-[11px] text-on-surface-variant/50">{{ $set['evaluated'] }}/{{ $set['total'] }}</span>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-6">
                    <span class="material-symbols-outlined text-on-surface-variant/30 text-[32px] mb-2">quiz</span>
                    <p class="text-[12px] text-on-surface-variant/50">No sets yet</p>
                </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-3">
            @if ($currentSet && $currentSet->isNotEmpty())
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-[16px] font-semibold text-on-surface">
                            Set {{ $currentSetNumber }}
                            <span class="text-[12px] text-on-surface-variant/50 font-normal ml-2">
                                {{ $currentSet->whereNotNull('rating')->count() }}/{{ $currentSet->count() }} evaluated
                            </span>
                        </h3>
                    </div>
                </div>

                <form method="POST" action="{{ route('concepts.submitAnswers', $concept) }}">
                    @csrf
                    <div class="space-y-5">
                        @foreach ($currentSet as $index => $q)
                        <section class="bg-white border border-outline-variant/50 rounded-xl overflow-hidden">
                            <div class="px-5 py-3 border-b border-outline-variant/30 bg-surface-container/30">
                                <div class="flex gap-3">
                                    <span class="w-6 h-6 rounded-full {{ $tierColors[$tier]['bg'] }} {{ $tierColors[$tier]['text'] }} text-[11px] font-semibold flex items-center justify-center shrink-0 mt-0.5">{{ $loop->iteration }}</span>
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
                            <p class="text-[11px] text-on-surface-variant/40">Leave blank if you don't know — you'll get the answer to learn (0/5, +0 XP)</p>
                        </div>
                        @endif
                    </div>
                </form>
            @else
                <div class="bg-white border border-outline-variant/50 rounded-xl p-8 text-center">
                    <span class="material-symbols-outlined text-on-surface-variant/30 text-[48px] mb-3">quiz</span>
                    <h3 class="text-[16px] font-semibold text-on-surface mb-1">No Practice Questions Yet</h3>
                    <p class="text-[13px] text-on-surface-variant/60 mb-4">Generate your first set of questions to start practicing.</p>
                    <form method="POST" action="{{ route('concepts.generateQuestions', $concept) }}" class="inline">
                        @csrf
                        <input type="hidden" name="tier" value="{{ $tier }}"/>
                        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-[12px] font-medium hover:bg-primary/90 transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px]">bolt</span>
                            Generate Questions
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
