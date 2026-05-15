<x-app-layout activeNav="dashboard" title="Dashboard">
    <x-slot:topbar-actions>
        <a href="{{ route('domains.create') }}" class="px-md py-sm bg-primary-container text-on-primary-container rounded-full font-body-sm font-semibold hover:opacity-90 transition-all">Add New</a>
    </x-slot:topbar-actions>

    <div class="mb-xl flex justify-between items-end">
        <div>
            <h2 class="font-display-lg text-display-lg text-on-surface tracking-tight">Welcome back, {{ Auth::user()->name }}!</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Ready for your next technical deep-dive?</p>
        </div>
        <div class="flex items-center gap-sm bg-secondary-container text-on-secondary-container px-lg py-sm rounded-xl border border-outline-variant">
            <span class="material-symbols-outlined">bolt</span>
            <span class="font-label-caps text-label-caps">STREAK: {{ max(1, $domains->max('concepts_count') ?? 1) }} DAYS</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-gutter mb-xl">
        <div class="custom-card p-lg rounded-xl flex flex-col justify-between h-40">
            <div class="flex justify-between items-start">
                <span class="font-label-caps text-label-caps text-on-surface-variant">TOTAL CONCEPTS</span>
                <span class="material-symbols-outlined text-primary">menu_book</span>
            </div>
            <div class="font-headline-md text-headline-md text-on-surface">{{ $totalConcepts }}</div>
        </div>
        <div class="custom-card p-lg rounded-xl flex flex-col justify-between h-40">
            <div class="flex justify-between items-start">
                <span class="font-label-caps text-label-caps text-on-surface-variant">MASTERY RATE</span>
                <span class="material-symbols-outlined text-secondary">verified</span>
            </div>
            <div>
                <div class="font-headline-md text-headline-md text-on-surface mb-xs">{{ $masteryRate }}%</div>
                <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                    <div class="bg-primary h-full rounded-full" style="width: {{ $masteryRate }}%"></div>
                </div>
            </div>
        </div>
        <div class="custom-card p-lg rounded-xl flex flex-col justify-between h-40">
            <div class="flex justify-between items-start">
                <span class="font-label-caps text-label-caps text-on-surface-variant">TOP DOMAIN</span>
                <span class="material-symbols-outlined text-tertiary-container">star</span>
            </div>
            <div class="font-title-lg text-title-lg text-on-surface">{{ $topDomain?->name ?? 'N/A' }}</div>
        </div>
        <div class="custom-card p-lg rounded-xl flex flex-col justify-between h-40">
            <div class="flex justify-between items-start">
                <span class="font-label-caps text-label-caps text-on-surface-variant">REVIEW NEEDED</span>
                <span class="material-symbols-outlined text-error">notification_important</span>
            </div>
            <div>
                <div class="font-headline-md text-headline-md text-error">{{ $reviewConcepts->count() }}</div>
                <div class="font-body-sm text-body-sm text-on-surface-variant">{{ $reviewConcepts->first()?->domain?->name ?? 'All caught up' }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        <div class="lg:col-span-2 space-y-gutter">
            <section class="custom-card rounded-xl overflow-hidden">
                <div class="p-lg border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
                    <h3 class="font-title-lg text-title-lg text-on-surface">Next in Queue</h3>
                    <a href="{{ route('domains.index') }}" class="text-primary font-label-caps text-label-caps hover:underline">VIEW ALL</a>
                </div>
                <div class="divide-y divide-outline-variant">
                    @forelse ($reviewConcepts->take(3) as $concept)
                    <div class="p-lg flex items-center justify-between hover:bg-background transition-colors group">
                        <div class="flex items-center gap-lg">
                            <div class="w-10 h-10 rounded-lg bg-primary-fixed flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">key</span>
                            </div>
                            <div>
                                <div class="font-body-md text-body-md font-semibold text-on-surface">{{ $concept->title }}</div>
                                <div class="flex items-center gap-sm mt-xs">
                                    <span class="px-2 py-0.5 border border-outline-variant rounded font-label-caps text-[10px] text-on-surface-variant uppercase">{{ $concept->difficulty->value }}</span>
                                    <span class="flex items-center gap-1 text-[10px] font-semibold text-error uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error"></span>To Review
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('concepts.show', $concept) }}" class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">chevron_right</a>
                    </div>
                    @empty
                    <div class="p-lg text-center text-on-surface-variant">No concepts need review. Great job!</div>
                    @endforelse
                </div>
            </section>

            <section class="custom-card rounded-xl p-lg">
                <h3 class="font-title-lg text-title-lg text-on-surface mb-lg">Performance by Domain</h3>
                <div class="space-y-lg">
                    @forelse ($domains->take(5) as $domain)
                    @php $pct = $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0; @endphp
                    <div>
                        <div class="flex justify-between font-body-sm text-body-sm mb-sm">
                            <span>{{ $domain->name }}</span>
                            <span class="font-semibold">{{ $pct }}%</span>
                        </div>
                        <div class="w-full bg-surface-container h-3 rounded-full">
                            <div class="bg-primary-container h-full rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-on-surface-variant">No domains yet.</div>
                    @endforelse
                </div>
            </section>
        </div>

        <div class="space-y-gutter">
            <section class="custom-card rounded-xl p-lg">
                <h3 class="font-title-lg text-title-lg text-on-surface mb-lg">Recent Activity</h3>
                <div class="space-y-xl relative before:content-[''] before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-[2px] before:bg-outline-variant">
                    @forelse ($domains->take(3) as $domain)
                    <div class="relative pl-xl">
                        <div class="absolute left-0 top-1 w-6 h-6 rounded-full bg-white border-2 border-primary flex items-center justify-center z-10">
                            <div class="w-2 h-2 rounded-full bg-primary"></div>
                        </div>
                        <div class="font-body-sm text-body-sm">
                            <span class="font-bold">{{ $domain->name }}</span> domain active
                            <p class="text-on-surface-variant text-[12px] mt-1">{{ $domain->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-on-surface-variant text-sm">No activity yet.</div>
                    @endforelse
                </div>
            </section>

            <section class="rounded-xl overflow-hidden relative h-64 flex flex-col justify-end p-lg group cursor-pointer shadow-lg">
                <div class="absolute inset-0 bg-primary-container"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-sm mb-2">
                        <span class="material-symbols-outlined text-primary-fixed">psychology</span>
                        <span class="text-white font-label-caps text-label-caps">NEW FEATURE</span>
                    </div>
                    <h4 class="text-white font-headline-md text-headline-md mb-2">Try AI Mock Interview</h4>
                    <p class="text-on-primary-container font-body-sm font-body-sm mb-lg">Practice real-time technical questions with our new AI coach.</p>
                    <button class="w-full bg-white text-primary font-bold py-3 rounded-lg hover:bg-primary-fixed transition-colors">Start Session</button>
                </div>
            </section>
        </div>
    </div>

    <button class="fixed bottom-xl right-xl w-14 h-14 bg-primary-container text-on-primary rounded-full shadow-xl flex items-center justify-center hover:scale-110 active:scale-95 transition-transform z-50">
        <span class="material-symbols-outlined text-3xl">add</span>
    </button>
</x-app-layout>