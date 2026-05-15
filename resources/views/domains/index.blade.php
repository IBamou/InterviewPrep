<x-app-layout activeNav="domains" title="Domains">
    <x-slot:topbar-actions>
        <a href="{{ route('domains.create') }}" class="px-md py-sm bg-primary-container text-on-primary-container rounded-full font-body-sm font-semibold hover:opacity-90 transition-all">Add New</a>
        @php $firstDomain = $domains->first(); @endphp
        @if ($firstDomain)
        <a href="{{ route('concepts.create', $firstDomain) }}" class="px-md py-sm border border-outline-variant text-on-surface rounded-full font-body-sm font-semibold hover:bg-surface-container transition-all">Create Concept</a>
        @endif
    </x-slot:topbar-actions>

    <div class="mb-xl flex flex-col md:flex-row justify-between items-start md:items-end gap-lg">
        <div>
            <h2 class="font-display-lg text-display-lg text-on-surface">Domains</h2>
            <p class="font-body-md text-body-md text-on-surface-variant">Your specialized knowledge areas and technical mastery paths.</p>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg shadow-sm flex flex-col gap-sm min-w-[240px]">
            <div class="flex justify-between items-center">
                <span class="font-label-caps text-label-caps text-on-surface-variant uppercase">Total Progress</span>
                <span class="font-title-lg text-title-lg text-primary">{{ $domains->sum('concepts_count') > 0 ? round(($domains->sum('mastered_count') / $domains->sum('concepts_count')) * 100) : 0 }}%</span>
            </div>
            <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                <div class="bg-primary h-full rounded-full" style="width: {{ $domains->sum('concepts_count') > 0 ? round(($domains->sum('mastered_count') / $domains->sum('concepts_count')) * 100) : 0 }}%;"></div>
            </div>
            <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $domains->sum('concepts_count') }} interview modules</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg">
        @forelse ($domains as $domain)
        @php $pct = $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0; @endphp
        <article class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg shadow-sm hover:shadow-md hover:border-primary-fixed transition-all flex flex-col gap-md group">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 rounded-lg bg-secondary-container flex items-center justify-center text-on-secondary-container">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">layers</span>
                </div>
                <span class="px-sm py-xs bg-secondary/10 text-secondary border border-secondary/20 rounded font-label-caps text-label-caps">L{{ $pct >= 70 ? '3' : ($pct >= 40 ? '2' : '1') }} Mastery</span>
            </div>
            <div>
                <h3 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">{{ $domain->name }}</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-xs">{{ Str::limit($domain->description, 80) ?: 'No description provided.' }}</p>
            </div>
            <div class="mt-auto pt-md flex flex-col gap-sm">
                <div class="flex justify-between items-center font-label-caps text-label-caps text-on-surface-variant">
                    <span>Progress</span>
                    <span>{{ $pct }}%</span>
                </div>
                <div class="w-full bg-surface-container-high h-1.5 rounded-full">
                    <div class="bg-secondary h-full rounded-full" style="width: {{ $pct }}%;"></div>
                </div>
                <a class="flex items-center gap-xs font-title-lg text-title-lg text-primary mt-sm group-hover:translate-x-1 transition-transform" href="{{ route('domains.show', $domain) }}">
                    Continue <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </article>
        @empty
        <div class="lg:col-span-3 relative overflow-hidden rounded-xl border border-dashed border-primary/40 p-8 flex flex-col items-center justify-center text-center bg-primary/5 min-h-[400px]">
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg mb-6 mx-auto">
                    <span class="material-symbols-outlined text-primary text-3xl">library_add</span>
                </div>
                <h3 class="font-headline-md text-headline-md text-primary mb-2">No domains created yet</h3>
                <p class="text-on-surface-variant max-w-md mx-auto mb-8 font-body-md">Start organizing your interview prep by creating your first knowledge domain.</p>
                <a href="{{ route('domains.create') }}" class="bg-primary-container text-on-primary-container px-xl py-md rounded-xl font-title-lg text-title-lg shadow-lg hover:shadow-xl transition-all inline-flex items-center gap-md">
                    <span class="material-symbols-outlined">add_circle</span>
                    Create Your First Domain
                </a>
            </div>
        </div>
        @endforelse
    </div>
</x-app-layout>