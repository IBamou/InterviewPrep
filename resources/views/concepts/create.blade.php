<x-app-layout activeNav="domains" title="Add Concept">
    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">Domains</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('domains.show', $domain) }}">{{ $domain->name }}</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface font-medium">New Concept</span>
    </nav>

    <div class="max-w-2xl">
        <h2 class="font-display-lg text-display-lg text-on-surface mb-1">Add Concept</h2>
        <p class="text-[13px] text-on-surface-variant/60 mb-6">Document a technical topic for your interview preparation.</p>

        @if ($errors->any())
        <div class="mb-4 p-3 bg-error/5 border border-error/20 text-error rounded-lg text-[13px]">
            <ul class="list-disc pl-4 space-y-0.5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('concepts.store', $domain) }}" class="space-y-5">
            @csrf
            <div class="bg-white border border-outline-variant/50 rounded-xl p-5 space-y-5">
                <div>
                    <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="title">Title</label>
                    <input class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all placeholder:text-on-surface-variant/30 @error('title') border-error @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Consistent Hashing, CAP Theorem..." type="text" required/>
                    @error('title')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-[13px] font-medium text-on-surface mb-1.5 block">Domain</label>
                    <div class="w-full h-9 px-3 rounded-lg border border-outline-variant/30 bg-surface-container/50 text-[13px] text-on-surface-variant/60 flex items-center">
                        {{ $domain->name }}
                    </div>
                </div>

                <div>
                    <label class="text-[13px] font-medium text-on-surface mb-2 block">Difficulty</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach (['junior' => ['Junior', 'text-secondary border-secondary/30 bg-secondary/5'], 'mid' => ['Mid', 'text-amber-600 border-amber-300/50 bg-amber-50'], 'senior' => ['Senior', 'text-error border-error/30 bg-error/5']] as $val => [$label, $colors])
                        <label class="cursor-pointer">
                            <input type="radio" name="difficulty" value="{{ $val }}" class="sr-only peer" {{ old('difficulty', 'junior') === $val ? 'checked' : '' }}/>
                            <div class="flex items-center justify-center py-2.5 border rounded-lg peer-checked:border-primary peer-checked:bg-primary/5 transition-all text-[13px] font-medium {{ $colors }}">
                                {{ $label }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('difficulty')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="explanation">Explanation</label>
                    <textarea class="w-full p-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all resize-none @error('explanation') border-error @enderror" id="explanation" name="explanation" rows="8" placeholder="Describe the concept, how it works, and why it matters..." required>{{ old('explanation') }}</textarea>
                    @error('explanation')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all" type="submit">Add Concept</button>
                <a class="text-[13px] text-on-surface-variant hover:text-on-surface transition-colors" href="{{ route('domains.show', $domain) }}">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
