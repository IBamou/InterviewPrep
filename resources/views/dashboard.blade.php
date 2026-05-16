<x-app-layout activeNav="dashboard" title="Dashboard" :show-search="false">
    <x-slot:topbar-actions>
        <a href="{{ route('domains.create') }}" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">+ New Domain</a>
    </x-slot:topbar-actions>

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="font-display-lg text-display-lg text-on-surface">Welcome back, {{ Auth::user()->name }}</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Track your technical interview preparation</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-outline-variant/50 rounded-xl p-4 hover:shadow-md hover:border-primary/30 transition-all">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-[18px]">menu_book</span>
                </div>
                <span class="text-[11px] font-semibold text-on-surface-variant/70 uppercase tracking-wide">Concepts</span>
            </div>
            <div class="text-2xl font-bold text-on-surface">{{ $totalConcepts }}</div>
        </div>
        <div class="bg-white border border-outline-variant/50 rounded-xl p-4 hover:shadow-md hover:border-primary/30 transition-all">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-secondary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-secondary text-[18px]">verified</span>
                </div>
                <span class="text-[11px] font-semibold text-on-surface-variant/70 uppercase tracking-wide">Mastered</span>
            </div>
            <div class="text-2xl font-bold text-on-surface mb-1">{{ $totalMastered }}/{{ $totalConcepts }}</div>
            <div class="w-full bg-surface-container h-1.5 rounded-full">
                <div class="bg-secondary h-full rounded-full transition-all" style="width: {{ $masteryRate }}%"></div>
            </div>
        </div>
        <div class="bg-white border border-outline-variant/50 rounded-xl p-4 hover:shadow-md hover:border-primary/30 transition-all">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-primary-container/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary-container text-[18px]">layers</span>
                </div>
                <span class="text-[11px] font-semibold text-on-surface-variant/70 uppercase tracking-wide">Top Domain</span>
            </div>
            <div class="text-[15px] font-semibold text-on-surface truncate">{{ $topDomain?->name ?? '—' }}</div>
        </div>
        <div class="bg-white border border-outline-variant/50 rounded-xl p-4 hover:shadow-md hover:border-primary/30 transition-all">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-lg bg-error/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-error text-[18px]">notification_important</span>
                </div>
                <span class="text-[11px] font-semibold text-on-surface-variant/70 uppercase tracking-wide">To Review</span>
            </div>
            <div class="text-2xl font-bold text-error">{{ $reviewConcepts->count() }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-5">
            <section class="bg-white border border-outline-variant/50 rounded-xl overflow-hidden">
                <div class="px-4 py-3 border-b border-outline-variant/50 flex justify-between items-center">
                    <h3 class="text-[14px] font-semibold text-on-surface">Next in Queue</h3>
                    <a href="{{ route('domains.index') }}" class="text-[12px] text-primary font-medium hover:underline">View all</a>
                </div>
                <div class="divide-y divide-outline-variant/30">
                    @forelse ($reviewConcepts->take(5) as $concept)
                    <a href="{{ route('concepts.show', $concept) }}" class="px-4 py-3 flex items-center justify-between hover:bg-surface-container/50 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-primary/60 group-hover:text-primary text-[16px]">description</span>
                            </div>
                            <div>
                                <div class="text-[13px] font-medium text-on-surface">{{ $concept->title }}</div>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[10px] text-on-surface-variant/60">{{ $concept->domain->name }}</span>
                                    <span class="w-1 h-1 rounded-full bg-outline-variant"></span>
                                    <span class="text-[10px] text-error font-medium">To Review</span>
                                </div>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors text-[16px]">chevron_right</span>
                    </a>
                    @empty
                    <div class="px-4 py-8 text-center text-on-surface-variant/60 text-[13px]">All caught up! Great job.</div>
                    @endforelse
                </div>
            </section>

            @if ($staleConcepts->isNotEmpty())
            <section class="bg-white border border-amber-200 rounded-xl overflow-hidden">
                <div class="px-4 py-3 border-b border-amber-200 flex justify-between items-center bg-amber-50/50">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-600 text-[18px]">history_edu</span>
                        <h3 class="text-[14px] font-semibold text-amber-800">Needs Refresh</h3>
                    </div>
                    <span class="text-[11px] text-amber-700/60">Not practiced in 30+ days</span>
                </div>
                <div class="divide-y divide-amber-100/50">
                    @foreach ($staleConcepts as $concept)
                    <a href="{{ route('concepts.practice', $concept) }}" class="px-4 py-3 flex items-center justify-between hover:bg-amber-50/50 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                                <span class="material-symbols-outlined text-amber-700 text-[16px]">refresh</span>
                            </div>
                            <div>
                                <div class="text-[13px] font-medium text-on-surface">{{ $concept->title }}</div>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[10px] text-on-surface-variant/60">{{ $concept->domain->name }}</span>
                                </div>
                            </div>
                        </div>
                        <span class="text-[11px] text-amber-600 font-medium group-hover:text-amber-700">Practice →</span>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            <section class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h3 class="text-[14px] font-semibold text-on-surface mb-4">Domains Overview</h3>
                <div class="space-y-3">
                    @forelse ($domains->take(5) as $domain)
                    <div class="flex items-center gap-3">
                        <span class="text-[13px] text-on-surface w-32 truncate">{{ $domain->name }}</span>
                        <div class="flex-1 flex items-center gap-2">
                            <div class="flex-1 bg-surface-container h-2 rounded-full overflow-hidden">
                                <div class="bg-secondary h-full rounded-full transition-all" style="width: {{ $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0 }}%"></div>
                            </div>
                            <span class="text-[11px] text-on-surface-variant/60 w-20 text-right">{{ $domain->mastered_count }}/{{ $domain->concepts_count }} mastered</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-on-surface-variant/60 text-[13px]">No domains yet.</div>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="space-y-5">
            <section class="bg-white border border-outline-variant/50 rounded-xl p-4">
                <h3 class="text-[14px] font-semibold text-on-surface mb-3">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('domains.create') }}" class="flex items-center gap-3 p-3 rounded-lg bg-primary/5 hover:bg-primary/10 transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center">
                            <span class="material-symbols-outlined text-[16px]">add</span>
                        </div>
                        <div>
                            <div class="text-[13px] font-medium text-on-surface">New Domain</div>
                            <div class="text-[11px] text-on-surface-variant/60">Create a study area</div>
                        </div>
                    </a>
                    <a href="{{ route('domains.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-secondary/5 hover:bg-secondary/10 transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-secondary text-white flex items-center justify-center">
                            <span class="material-symbols-outlined text-[16px]">account_tree</span>
                        </div>
                        <div>
                            <div class="text-[13px] font-medium text-on-surface">Browse Domains</div>
                            <div class="text-[11px] text-on-surface-variant/60">Review your concepts</div>
                        </div>
                    </a>
                </div>
            </section>

            <section class="bg-gradient-to-br from-primary to-primary-container rounded-xl p-4 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-bl-full -mr-6 -mt-6"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-white/70 text-[16px]">auto_awesome</span>
                        <span class="text-[10px] font-semibold text-white/60 uppercase tracking-wide">AI Powered</span>
                    </div>
                    <h4 class="text-[15px] font-semibold mb-1">Generate Questions</h4>
                    <p class="text-[12px] text-white/70 mb-3">Create practice questions from your concepts using AI.</p>
                    <a href="{{ route('domains.index') }}" class="inline-flex items-center gap-1.5 bg-white text-primary px-3 py-1.5 rounded-lg text-[12px] font-medium hover:bg-white/90 transition-all">
                        Get Started
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
