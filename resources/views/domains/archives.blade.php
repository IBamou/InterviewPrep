<x-app-layout activeNav="archives" title="Archived Domains">
    <x-slot:topbar-actions>
        <a href="{{ route('domains.create') }}" class="px-md py-sm bg-primary-container text-on-primary-container rounded-full font-body-sm font-semibold hover:opacity-90 transition-all">Add New</a>
    </x-slot:topbar-actions>

    @if (session('success'))
    <div class="mb-6 p-4 bg-secondary-container/30 border border-secondary/20 text-on-secondary-container rounded-xl text-sm">{{ session('success') }}</div>
    @endif

    <div class="flex items-center justify-between mb-xl">
        <div class="flex items-center gap-md">
            <h2 class="font-headline-md text-headline-md text-on-surface">Archived Domains</h2>
            @if ($domains->isNotEmpty())
            <span class="px-sm py-xs bg-surface-container-high text-on-surface-variant font-label-caps text-label-caps rounded-full">{{ $domains->count() }}</span>
            @endif
        </div>
    </div>

    @if ($domains->isEmpty())
    <div class="flex flex-col items-center justify-center py-xxl text-center">
        <div class="w-64 h-64 bg-surface-container rounded-full flex items-center justify-center mb-xl">
            <span class="material-symbols-outlined text-[120px] text-primary/20" style="font-variation-settings: 'wght' 200;">inventory_2</span>
        </div>
        <h3 class="font-headline-md text-headline-md text-on-surface mb-sm">Your archive is empty</h3>
        <p class="max-w-md font-body-md text-body-md text-on-surface-variant mb-xl">When you delete domains, they'll appear here for 30 days before being permanently removed.</p>
        <a href="{{ route('domains.index') }}" class="px-xl py-md bg-primary-container text-on-primary-container rounded-xl font-title-lg text-title-lg shadow-lg hover:shadow-xl transition-all inline-flex items-center gap-md">
            <span class="material-symbols-outlined">arrow_back</span>
            Return to Domains
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg">
        @foreach ($domains as $domain)
        <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl shadow-sm hover:shadow-md transition-all group flex flex-col h-full">
            <div class="flex items-start justify-between mb-md">
                <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center text-outline">
                    <span class="material-symbols-outlined text-[32px]">folder</span>
                </div>
                <span class="font-label-caps text-label-caps text-outline px-sm py-xs border border-outline-variant rounded">ARCHIVED</span>
            </div>
            <div class="mb-xl flex-grow">
                <h3 class="font-title-lg text-title-lg text-on-surface mb-xs">{{ $domain->name }}</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">{{ Str::limit($domain->description, 80) ?: 'No description provided.' }}</p>
            </div>
            <div class="pt-md border-t border-outline-variant flex flex-col gap-md">
                <div class="flex items-center gap-xs text-outline font-body-sm text-body-sm">
                    <span class="material-symbols-outlined text-[16px]">delete</span>
                    Deleted {{ $domain->deleted_at->diffForHumans() }}
                </div>
                <div class="flex items-center justify-between gap-md">
                    <form method="POST" action="{{ route('domains.restore', $domain) }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-sm px-md border border-outline-variant text-on-surface font-body-sm font-semibold rounded-lg hover:bg-surface-container-low transition-colors">Restore</button>
                    </form>
                    <form method="POST" action="{{ route('domains.forceDelete', $domain) }}" onsubmit="return confirm('Permanently delete this domain? All associated concepts will also be lost.')">
                        @csrf @method('delete')
                        <button type="submit" class="py-sm px-md text-error font-body-sm font-semibold rounded-lg hover:bg-error-container/20 transition-colors">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-xxl bg-surface-container-low rounded-xl p-xl flex flex-col items-center text-center">
        <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center mb-md">
            <span class="material-symbols-outlined text-outline text-[32px]">info</span>
        </div>
        <h4 class="font-title-lg text-title-lg text-on-surface mb-sm">Archiving Policy</h4>
        <p class="font-body-sm text-body-sm text-on-surface-variant max-w-lg">Items in the archive will be permanently deleted automatically after 30 days. You can restore them at any time before then.</p>
    </div>
    @endif
</x-app-layout>