<x-app-layout activeNav="archives" title="Archived Concepts">
    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <a class="hover:text-primary transition-colors" href="{{ route('domains.show', $domain) }}">{{ $domain->name }}</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface font-medium">Archived</span>
    </nav>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-display-lg text-display-lg text-on-surface">Archived Concepts</h2>
            <p class="text-[13px] text-on-surface-variant/60 mt-0.5">Concepts that can be restored or permanently deleted</p>
        </div>
    </div>

    @if ($concepts->isEmpty())
    <div class="flex flex-col items-center justify-center py-16 text-center">
        <div class="w-14 h-14 rounded-2xl bg-surface-container flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-on-surface-variant/30 text-[28px]">inventory_2</span>
        </div>
        <h3 class="text-[16px] font-semibold text-on-surface mb-1">No archived concepts</h3>
        <p class="text-[13px] text-on-surface-variant/60 max-w-xs mb-4">Deleted concepts will appear here and can be restored anytime.</p>
        <a href="{{ route('domains.show', $domain) }}" class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all inline-flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Back to Domain
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($concepts as $concept)
        <div class="bg-white border border-outline-variant/50 rounded-xl p-4 flex flex-col">
            <div class="flex items-start justify-between mb-3">
                <span class="px-2 py-0.5 bg-primary/5 text-primary rounded text-[10px] font-medium">{{ $domain->name }}</span>
            </div>
            <h3 class="text-[14px] font-semibold text-on-surface mb-1">{{ $concept->title }}</h3>
            <p class="text-[12px] text-on-surface-variant/40 mb-3">Archived {{ $concept->deleted_at->diffForHumans() }}</p>
            <div class="pt-3 border-t border-outline-variant/30 flex gap-2 mt-auto">
                <form method="POST" action="{{ route('concepts.restore', $concept) }}" class="flex-1">
                    @csrf
                    <button type="button" onclick="showConfirmModal('Restore Concept', 'Restore this concept?', () => { this.closest('form').submit(); }, 'success')" class="w-full px-3 py-1.5 border border-outline-variant text-on-surface rounded-lg text-[12px] font-medium hover:bg-surface-container transition-all inline-flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">restore</span>
                        Restore
                    </button>
                </form>
                <form method="POST" action="{{ route('concepts.forceDelete', $concept) }}" class="flex-1">
                    @csrf @method('delete')
                    <button type="button" onclick="showConfirmModal('Delete Concept', 'Permanently delete this concept? This action cannot be undone.', () => { this.closest('form').submit(); })" class="w-full px-3 py-1.5 text-error rounded-lg text-[12px] font-medium hover:bg-error/5 transition-all inline-flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">delete_forever</span>
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</x-app-layout>
