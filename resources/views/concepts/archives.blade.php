<x-app-layout activeNav="archives" title="Archived Concepts">
    <nav class="flex items-center gap-sm mb-lg text-on-surface-variant">
        <a class="font-body-sm hover:text-primary transition-colors" href="{{ route('domains.show', $domain) }}">{{ $domain->name }}</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="font-body-sm font-semibold text-on-surface">Archived Concepts</span>
    </nav>

    <div class="flex items-center justify-between mb-xl">
        <div class="flex items-center gap-md">
            <h2 class="font-headline-md text-headline-md text-on-surface">Archived Concepts</h2>
            @if ($concepts->isNotEmpty())
            <span class="bg-primary-fixed text-on-primary-fixed px-sm py-xs rounded-lg font-label-caps text-label-caps">{{ $concepts->count() }} ITEMS</span>
            @endif
        </div>
    </div>

    @if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
    @endif

    @if ($concepts->isEmpty())
    <div class="flex flex-col items-center justify-center py-xxl text-center">
        <div class="w-48 h-48 mb-xl relative">
            <div class="absolute inset-0 bg-primary/5 rounded-full blur-3xl"></div>
            <span class="material-symbols-outlined text-[96px] text-primary/30" style="font-variation-settings: 'wght' 200;">inventory_2</span>
        </div>
        <h3 class="font-headline-md text-headline-md text-on-surface mb-sm">Nothing else in the vault</h3>
        <p class="max-w-md font-body-md text-body-md text-on-surface-variant mb-xl">Your archive helps keep your active workspace clutter-free. Concepts here are preserved indefinitely and can be restored at any time.</p>
        <a href="{{ route('domains.show', $domain) }}" class="px-xl py-md bg-white border border-outline-variant text-primary rounded-xl font-body-md font-semibold hover:bg-primary-container hover:text-white transition-all shadow-sm active:scale-95">View All Active Concepts</a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg mb-xxl">
        @foreach ($concepts as $concept)
        @php
        $dc = ['junior' => 'bg-secondary-container text-on-secondary-container', 'mid' => 'bg-tertiary-fixed text-on-tertiary-fixed-variant', 'senior' => 'border border-error text-error'];
        @endphp
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg card-shadow flex flex-col gap-md hover:translate-y-[-4px] transition-transform duration-300 group">
            <div class="flex justify-between items-start">
                <span class="px-sm py-xs {{ $dc[$concept->difficulty->value] ?? '' }} rounded-lg font-label-caps text-label-caps">{{ $domain->name }}</span>
                <span class="px-sm py-xs border border-outline-variant rounded-lg font-body-sm text-on-tertiary-fixed-variant text-[12px] font-semibold capitalize">{{ $concept->difficulty->value }}</span>
            </div>
            <div>
                <h3 class="font-title-lg text-title-lg text-on-surface mb-xs">{{ $concept->title }}</h3>
                <p class="font-body-sm text-on-surface-variant">Archived {{ $concept->deleted_at->diffForHumans() }}</p>
            </div>
            <div class="mt-auto pt-md border-t border-outline-variant flex gap-sm">
                <form method="POST" action="{{ route('concepts.restore', $concept) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-sm border border-outline-variant rounded-lg font-body-sm font-semibold text-on-surface hover:bg-surface-container-high transition-colors flex items-center justify-center gap-sm">
                        <span class="material-symbols-outlined text-[18px]">restore</span>
                        Restore
                    </button>
                </form>
                <form method="POST" action="{{ route('concepts.forceDelete', $concept) }}" onsubmit="return confirm('Permanently delete this concept?')" class="w-12">
                    @csrf @method('delete')
                    <button type="submit" class="w-full py-sm text-error hover:bg-error-container rounded-lg transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined">delete_forever</span>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</x-app-layout>