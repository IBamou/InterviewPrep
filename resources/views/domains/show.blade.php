<x-app-layout activeNav="domains" title="{{ $domain->name }} Mastery">
    <x-slot:topbar-actions>
        <a href="{{ route('concepts.create', $domain) }}" class="bg-primary-container text-on-primary-container px-lg py-sm rounded-full font-body-sm font-semibold hover:opacity-90 transition-all">Add New</a>
    </x-slot:topbar-actions>

    <div class="mb-xl">
        <nav class="flex items-center gap-xs font-label-caps text-label-caps text-on-surface-variant mb-md">
            <a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">DOMAINS</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">{{ strtoupper($domain->name) }}</span>
        </nav>
        <div class="flex flex-col md:flex-row justify-between items-end gap-lg">
            <div class="space-y-xs">
                <h2 class="font-display-lg text-display-lg text-on-surface">{{ $domain->name }}</h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-lg">{{ $domain->description ?? 'No description provided.' }}</p>
            </div>
            <div class="w-full md:w-64 space-y-sm">
                <div class="flex justify-between items-center font-label-caps text-label-caps">
                    <span class="text-on-surface-variant">DOMAIN PROGRESS</span>
                    <span class="text-primary font-bold">{{ $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0 }}%</span>
                </div>
                <div class="h-2 w-full bg-outline-variant rounded-full overflow-hidden">
                    <div class="h-full bg-primary-container w-[{{ $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0 }}%] rounded-full"></div>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm">
        <div class="px-lg py-md border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
            <h3 class="font-title-lg text-title-lg text-on-surface">Core Concepts</h3>
            <div class="flex items-center gap-sm">
                <span class="material-symbols-outlined text-on-surface-variant">filter_list</span>
                <span class="font-label-caps text-label-caps text-on-surface-variant">FILTER BY STATUS</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-lg py-md font-label-caps text-label-caps text-on-surface-variant border-b border-outline-variant">TITLE & PREVIEW</th>
                        <th class="px-lg py-md font-label-caps text-label-caps text-on-surface-variant border-b border-outline-variant">DIFFICULTY</th>
                        <th class="px-lg py-md font-label-caps text-label-caps text-on-surface-variant border-b border-outline-variant">STATUS</th>
                        <th class="px-lg py-md font-label-caps text-label-caps text-on-surface-variant border-b border-outline-variant">LAST ACTIVITY</th>
                        <th class="px-lg py-md font-label-caps text-label-caps text-on-surface-variant border-b border-outline-variant text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    @forelse ($domain->concepts as $concept)
                    @php
                    $dc = ['junior' => 'border-secondary text-secondary bg-secondary/10', 'mid' => 'border-on-tertiary-fixed-variant text-on-tertiary-fixed-variant', 'senior' => 'border-error text-error'];
                    $sc = ['to_review' => 'bg-error-container/20 text-secondary font-bold', 'in_progress' => 'bg-primary-fixed text-on-primary-fixed-variant', 'mastered' => 'bg-secondary-container/20 text-secondary font-bold'];
                    $sl = ['to_review' => 'To Review', 'in_progress' => 'In Progress', 'mastered' => 'Mastered'];
                    @endphp
                    <tr class="hover:bg-background transition-colors group">
                        <td class="px-lg py-lg">
                            <div class="flex flex-col gap-1">
                                <a href="{{ route('concepts.show', $concept) }}" class="font-body-md font-bold text-on-surface hover:text-primary transition-colors">{{ $concept->title }}</a>
                                <span class="font-body-sm text-on-surface-variant line-clamp-1 italic">{{ Str::limit($concept->explanation, 50) }}</span>
                            </div>
                        </td>
                        <td class="px-lg py-lg">
                            <span class="inline-block px-sm py-1 border border-outline-variant rounded font-label-caps text-[10px] uppercase {{ $dc[$concept->difficulty->value] ?? '' }}">{{ ucfirst($concept->difficulty->value) }}</span>
                        </td>
                        <td class="px-lg py-lg">
                            <span class="inline-flex items-center px-sm py-1 rounded-full font-label-caps text-[11px] font-bold {{ $sc[$concept->status->value] ?? '' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $concept->status->value === 'to_review' ? 'bg-error' : ($concept->status->value === 'mastered' ? 'bg-secondary' : 'bg-primary-container') }}"></span>
                                {{ $sl[$concept->status->value] ?? $concept->status->label() }}
                            </span>
                        </td>
                        <td class="px-lg py-lg font-body-sm text-on-surface-variant">{{ $concept->updated_at->diffForHumans() }}</td>
                        <td class="px-lg py-lg text-right">
                            <a href="{{ route('concepts.show', $concept) }}" class="text-primary font-bold font-label-caps hover:underline">VIEW DETAILS</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-lg py-12 text-center text-on-surface-variant">
                            No concepts in this domain yet. <a href="{{ route('concepts.create', $domain) }}" class="text-primary font-bold hover:underline">Create one</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-3 gap-lg mt-xl">
        <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl shadow-sm space-y-md">
            <div class="flex items-center justify-between">
                <h4 class="font-title-lg text-title-lg">Focus Area</h4>
                <span class="material-symbols-outlined text-primary">analytics</span>
            </div>
            <div class="space-y-md">
                <div class="space-y-xs">
                    <div class="flex justify-between text-label-caps font-label-caps">
                        <span class="text-on-surface-variant">Consistency Models</span>
                        <span>{{ $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0 }}%</span>
                    </div>
                    <div class="h-1.5 bg-outline-variant rounded-full overflow-hidden">
                        <div class="h-full bg-primary-container w-[{{ $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0 }}%]"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative overflow-hidden bg-primary-container text-on-primary p-lg rounded-xl shadow-sm flex flex-col justify-between min-h-[200px]">
            <div class="z-10 space-y-xs">
                <h4 class="font-title-lg text-title-lg text-white">Daily Mock Exam</h4>
                <p class="font-body-sm text-on-primary-container/80">Simulate a real-world architect interview session.</p>
            </div>
            <div class="z-10">
                <a href="{{ route('concepts.create', $domain) }}" class="bg-white text-primary-container font-bold px-lg py-sm rounded-lg hover:bg-primary-fixed transition-colors inline-block">Add Concept</a>
            </div>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl shadow-sm space-y-md">
            <h4 class="font-title-lg text-title-lg">Study Overview</h4>
            <div class="grid grid-cols-2 gap-md">
                <div class="p-md bg-background rounded-lg border border-outline-variant">
                    <div class="font-display-lg text-primary text-[28px] leading-tight">{{ $domain->concepts_count }}</div>
                    <div class="font-label-caps text-label-caps text-on-surface-variant">CONCEPTS</div>
                </div>
                <div class="p-md bg-background rounded-lg border border-outline-variant">
                    <div class="font-display-lg text-secondary text-[28px] leading-tight">{{ $domain->mastered_count }}</div>
                    <div class="font-label-caps text-label-caps text-on-surface-variant">MASTERED</div>
                </div>
            </div>
        </div>
    </section>

    <a href="{{ route('concepts.create', $domain) }}" class="fixed bottom-xl right-xl w-14 h-14 bg-primary-container text-on-primary rounded-full shadow-lg flex items-center justify-center hover:scale-105 active:scale-95 transition-all z-50">
        <span class="material-symbols-outlined text-[32px]">add</span>
    </a>
</x-app-layout>