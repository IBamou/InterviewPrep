<x-app-layout activeNav="domains" title="{{ $concept->title }}">
    <x-slot:topbar-actions>
        <a href="{{ route('concepts.edit', $concept) }}" class="px-md py-sm bg-primary-container text-on-primary-container rounded-full font-body-sm font-semibold hover:opacity-90 transition-all">Edit Concept</a>
        <form method="POST" action="{{ route('concepts.archive', $concept) }}" onsubmit="return confirm('Archive this concept?')">
            @csrf @method('DELETE')
            <button type="submit" class="px-md py-sm border border-outline-variant text-on-surface rounded-full font-body-sm font-semibold hover:bg-surface-container transition-all">Archive</button>
        </form>
    </x-slot:topbar-actions>

    @if (session('success'))
    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <nav class="flex items-center gap-sm mb-lg text-on-surface-variant font-body-sm text-body-sm">
        <a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">Domains</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('domains.show', $concept->domain) }}">{{ $concept->domain->name }}</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-primary font-semibold">{{ $concept->title }}</span>
    </nav>

    <div class="mb-xl flex flex-col gap-md">
        <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight">{{ $concept->title }}</h1>
        <div class="flex gap-sm">
            <span class="px-sm py-[2px] border border-on-tertiary-fixed-variant text-on-tertiary-fixed-variant font-label-caps text-label-caps rounded-sm uppercase">{{ $concept->difficulty->value }}</span>
            <span class="px-md py-[2px] bg-secondary/10 text-secondary font-label-caps text-label-caps rounded-full">{{ $concept->status->label() }}</span>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-gutter">
        <div class="col-span-8 flex flex-col gap-lg">
            <section class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl shadow-sm">
                <div class="border-b border-outline-variant pb-md mb-md">
                    <h2 class="font-headline-md text-headline-md text-on-surface">Detailed Explanation</h2>
                </div>
                <div class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                    <div class="text-body-lg">{!! nl2br(e($concept->explanation)) !!}</div>
                </div>
            </section>
        </div>
        <aside class="col-span-4 flex flex-col gap-lg">
            <div class="bg-primary-container text-on-primary p-lg rounded-xl shadow-md flex flex-col gap-md relative overflow-hidden">
                <div class="absolute top-0 right-0 p-md opacity-20">
                    <span class="material-symbols-outlined text-[64px]" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                </div>
                <h3 class="font-headline-md text-headline-md leading-tight">Generate practice questions for this concept</h3>
                <p class="font-body-sm font-body-sm opacity-90">Leverage our LLM-tuned engine to create customized mock interview scenarios.</p>
                <button class="mt-sm bg-white text-primary font-title-lg text-title-lg py-sm rounded-lg hover:bg-opacity-90 transition-all flex items-center justify-center gap-sm">
                    <span class="material-symbols-outlined">bolt</span>
                    Start AI Prep
                </button>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl shadow-sm">
                <div class="flex items-center justify-between mb-md">
                    <h3 class="font-label-caps text-label-caps text-outline">DOMAIN STATS</h3>
                    <span class="material-symbols-outlined text-primary">analytics</span>
                </div>
                <div class="flex flex-col gap-md">
                    <div class="flex items-center justify-between">
                        <span class="font-body-sm text-body-sm">Domain Coverage</span>
                        <span class="font-title-lg text-title-lg">{{ $concept->domain->concepts_count > 0 ? round(($concept->domain->mastered_count / $concept->domain->concepts_count) * 100) : 0 }}%</span>
                    </div>
                    <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
                        <div class="bg-primary h-full w-[{{ $concept->domain->concepts_count > 0 ? round(($concept->domain->mastered_count / $concept->domain->concepts_count) * 100) : 0 }}%]"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-md mt-sm">
                        <div class="flex flex-col">
                            <span class="font-label-caps text-label-caps text-outline">CONCEPTS</span>
                            <span class="font-headline-md text-headline-md">{{ $concept->domain->concepts_count }} concepts</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-caps text-label-caps text-outline">LAST REVIEW</span>
                            <span class="font-headline-md text-headline-md text-on-surface">{{ $concept->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-sm">
                <form method="POST" action="{{ route('concepts.updateStatus', $concept) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="w-full bg-primary-container text-on-primary font-title-lg text-title-lg py-md rounded-lg shadow-sm hover:opacity-95 active:scale-[0.98] transition-all flex items-center justify-center gap-md">
                        <span class="material-symbols-outlined">trending_up</span>
                        Advance Status
                    </button>
                </form>
                <a href="{{ route('concepts.edit', $concept) }}" class="w-full border border-outline-variant text-on-surface font-title-lg text-title-lg py-md rounded-lg hover:bg-surface-container-low transition-all flex items-center justify-center gap-md">
                    <span class="material-symbols-outlined">edit</span>
                    Edit Concept
                </a>
            </div>
            <div class="p-md border border-outline-variant rounded-xl bg-surface-container-lowest/50">
                <h4 class="font-label-caps text-label-caps text-outline mb-sm">QUICK LINKS</h4>
                <div class="flex flex-col gap-xs">
                    <a class="font-body-sm text-body-sm text-primary hover:underline flex items-center justify-between" href="{{ route('domains.show', $concept->domain) }}">
                        View Domain <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                    </a>
                </div>
            </div>
        </aside>
    </div>
</x-app-layout>