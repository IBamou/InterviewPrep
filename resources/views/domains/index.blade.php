<x-app-layout activeNav="domains" title="Domains">
    <x-slot:topbar-actions>
        <a href="{{ route('domains.create') }}" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">+ New Domain</a>
        @php $firstDomain = $domains->first(); @endphp
        @if ($firstDomain)
        <a href="{{ route('concepts.create', $firstDomain) }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container transition-all">Create Concept</a>
        @endif
    </x-slot:topbar-actions>

    <div class="mb-6">
        <div>
            <h2 class="font-display-lg text-display-lg text-on-surface">Domains</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Your knowledge areas and mastery paths</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($domains as $domain)
        @php $pct = $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0; @endphp
        <div class="bg-white border border-outline-variant/50 rounded-xl p-4 hover:shadow-md hover:border-primary/30 transition-all group relative">
            <div class="absolute top-3 right-3 z-30">
                <button type="button" onclick="event.stopPropagation(); this.nextElementSibling.classList.toggle('hidden')" class="w-7 h-7 flex items-center justify-center rounded-lg hover:bg-surface-container transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-[18px] text-on-surface-variant/60">more_vert</span>
                </button>
                <div class="hidden absolute right-0 top-8 w-40 bg-white border border-outline-variant/50 rounded-lg shadow-lg overflow-hidden z-50">
                    <a href="{{ route('domains.show', $domain) }}" class="flex items-center gap-2 px-3 py-2 text-[13px] text-on-surface hover:bg-surface-container transition-all">
                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                        View
                    </a>
                    <a href="{{ route('domains.edit', $domain) }}" class="flex items-center gap-2 px-3 py-2 text-[13px] text-on-surface hover:bg-surface-container transition-all">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('domains.destroy', $domain) }}">
                        @csrf @method('DELETE')
                        <button type="button" onclick="event.stopPropagation(); showConfirmModal('Archive Domain', 'Are you sure you want to archive this domain?', () => { this.closest('form').submit(); })" class="w-full flex items-center gap-2 px-3 py-2 text-[13px] text-error hover:bg-error/5 transition-all">
                            <span class="material-symbols-outlined text-[16px]">archive</span>
                            Archive
                        </button>
                    </form>
                </div>
            </div>
            <a href="{{ route('domains.show', $domain) }}" class="block">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-primary/10 to-primary-container/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">layers</span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold mr-9 {{ $pct >= 70 ? 'bg-secondary/10 text-secondary' : ($pct >= 40 ? 'bg-amber-50 text-amber-600' : 'bg-surface-container text-on-surface-variant') }}">
                        {{ $pct >= 70 ? 'Advanced' : ($pct >= 40 ? 'Intermediate' : 'Beginner') }}
                    </span>
                </div>
                <h3 class="text-[15px] font-semibold text-on-surface group-hover:text-primary transition-colors mb-1">{{ $domain->name }}</h3>
                <p class="text-[13px] text-on-surface-variant/70 leading-relaxed mb-3">{{ Str::limit($domain->description, 70) ?: 'No description.' }}</p>
                <div class="flex items-center justify-between pt-3 border-t border-outline-variant/30">
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] text-on-surface-variant/60">{{ $domain->concepts_count }} concept{{ $domain->concepts_count !== 1 ? 's' : '' }}</span>
                    </div>
                    <span class="text-[12px] font-medium text-primary group-hover:translate-x-0.5 transition-transform flex items-center gap-0.5">
                        Open
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </span>
                </div>
            </a>
        </div>
        @empty
        <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
            <div class="w-14 h-14 rounded-2xl bg-primary/5 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-primary text-[28px]">library_add</span>
            </div>
            <h3 class="text-[16px] font-semibold text-on-surface mb-1">No domains yet</h3>
            <p class="text-[13px] text-on-surface-variant/60 max-w-xs mb-4">Create your first knowledge domain to start organizing your interview prep.</p>
            <a href="{{ route('domains.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all inline-flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">add</span>
                Create Domain
            </a>
        </div>
        @endforelse
    </div>

    <script>
    document.addEventListener('click', function(e) {
        document.querySelectorAll('.absolute.top-3 > div:not(.hidden)').forEach(function(dropdown) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
    </script>
</x-app-layout>
