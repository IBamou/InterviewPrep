<x-app-layout activeNav="domains" title="Edit Concept">
    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">Domains</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('domains.show', $concept->domain) }}">{{ $concept->domain?->name ?? 'Unknown' }}</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('concepts.show', $concept) }}">{{ $concept->title }}</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface font-medium">Edit</span>
    </nav>

    <div class="max-w-2xl">
        <h2 class="font-display-lg text-display-lg text-on-surface mb-1">Edit Concept</h2>
        <p class="text-[13px] text-on-surface-variant/60 mb-6">Update the details of this concept.</p>

        @if ($errors->any())
        <div class="mb-4 p-3 bg-error/5 border border-error/20 text-error rounded-lg text-[13px]">
            <ul class="list-disc pl-4 space-y-0.5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('concepts.update', $concept) }}" class="space-y-5">
            @csrf @method('PUT')
            <div class="bg-white border border-outline-variant/50 rounded-xl p-5 space-y-5">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="title">Title</label>
                        <input class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all @error('title') border-error @enderror" type="text" name="title" id="title" value="{{ old('title', $concept->title) }}" required/>
                        @error('title')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[13px] font-medium text-on-surface mb-1.5 block">Domain</label>
                        <div class="w-full h-9 px-3 rounded-lg border border-outline-variant/30 bg-surface-container/50 text-[13px] text-on-surface-variant/60 flex items-center">
{{ $concept->domain?->name ?? 'Unknown' }}
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="explanation">Explanation</label>
                    <textarea class="w-full p-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all resize-none @error('explanation') border-error @enderror" name="explanation" id="explanation" rows="8" required>{{ old('explanation', $concept->explanation) }}</textarea>
                    @error('explanation')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('concepts.show', $concept) }}" class="text-[13px] text-on-surface-variant hover:text-on-surface transition-colors">Cancel</a>
                <button class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all" type="submit">Save Changes</button>
            </div>
        </form>
    </div>
</x-app-layout>
