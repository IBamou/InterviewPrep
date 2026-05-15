<x-app-layout activeNav="archives" title="Archived Domains">
    <x-slot:topbar-actions>
        <a href="{{ route('domains.create') }}" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">+ New Domain</a>
    </x-slot:topbar-actions>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-display-lg text-display-lg text-on-surface">Archived Domains</h2>
            <p class="text-[13px] text-on-surface-variant/60 mt-0.5">Domains that can be restored or permanently deleted</p>
        </div>
    </div>

    @if ($domains->isEmpty())
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="w-14 h-14 rounded-2xl bg-surface-container flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-on-surface-variant/30 text-[28px]">inventory_2</span>
        </div>
        <h3 class="text-[16px] font-semibold text-on-surface mb-1">No archived domains</h3>
        <p class="text-[13px] text-on-surface-variant/60 max-w-xs mb-4">Deleted domains will appear here for 30 days.</p>
        <a href="{{ route('domains.index') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all inline-flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Back to Domains
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($domains as $domain)
        <div class="bg-white border border-outline-variant/50 rounded-xl p-4 flex flex-col">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-surface-variant/50 text-[20px]">folder</span>
                </div>
                <span class="px-2 py-0.5 bg-surface-container text-on-surface-variant/60 rounded text-[10px] font-medium uppercase">Archived</span>
            </div>
            <h3 class="text-[14px] font-semibold text-on-surface mb-1">{{ $domain->name }}</h3>
            <p class="text-[12px] text-on-surface-variant/60 mb-3 flex-grow">{{ Str::limit($domain->description, 60) ?: 'No description.' }}</p>
            <div class="pt-3 border-t border-outline-variant/30">
                <div class="text-[11px] text-on-surface-variant/40 mb-2">Deleted {{ $domain->deleted_at->diffForHumans() }}</div>
                <div class="flex gap-2">
                    <form method="POST" action="{{ route('domains.restore', $domain) }}" class="flex-1">
                        @csrf
                        <button type="button" onclick="showConfirmModal('Restore Domain', 'Restore this domain?', () => { this.closest('form').submit(); }, 'success')" class="w-full px-3 py-1.5 border border-outline-variant text-on-surface rounded-lg text-[12px] font-medium hover:bg-surface-container transition-all">Restore</button>
                    </form>
                    <form method="POST" action="{{ route('domains.forceDelete', $domain) }}" class="flex-1">
                        @csrf @method('delete')
                        <button type="button" onclick="showConfirmModal('Delete Domain', 'Permanently delete this domain? This action cannot be undone.', () => { this.closest('form').submit(); })" class="w-full px-3 py-1.5 text-error rounded-lg text-[12px] font-medium hover:bg-error/5 transition-all">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</x-app-layout>
