<x-app-layout activeNav="domains" title="Add New Concept">
    <div class="max-w-4xl mx-auto">
        <nav class="flex items-center gap-xs mb-lg text-label-caps text-outline uppercase tracking-wider">
            <a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">Domains</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ route('domains.show', $domain) }}">{{ $domain->name }}</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface-variant font-bold">New Concept</span>
        </nav>

        <div class="mb-xxl">
            <h1 class="font-headline-md text-headline-md text-on-surface mb-xs">Add New Concept</h1>
            <p class="font-body-sm text-body-sm text-outline">Document a new architectural pattern or fundamental principle for your interview preparation.</p>
        </div>

        @if ($errors->any())
        <div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-xl text-sm">
            <ul class="list-disc pl-4 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
            <div class="md:col-span-8">
                <div class="bg-surface-container-lowest border border-outline-variant p-lg rounded-xl shadow-sm space-y-xl">
                    <form method="POST" action="{{ route('concepts.store', $domain) }}" class="space-y-xl">
                        @csrf
                        <div class="flex flex-col gap-sm">
                            <label class="font-body-sm text-body-sm font-semibold text-on-surface" for="title">Concept Title</label>
                            <input class="h-12 w-full px-md rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-outline/50 @error('title') border-error @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Consistent Hashing, CAP Theorem..." type="text" required/>
                            @error('title')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex flex-col gap-sm">
                            <label class="font-body-sm text-body-sm font-semibold text-on-surface">Domain</label>
                            <div class="w-full h-12 px-md rounded-lg border border-outline-variant bg-surface-container text-on-surface-variant flex items-center">
                                <span class="material-symbols-outlined text-outline mr-md">lock</span>
                                {{ $domain->name }}
                            </div>
                        </div>
                        <div class="flex flex-col gap-sm">
                            <label class="font-body-sm text-body-sm font-semibold text-on-surface">Target Complexity Level</label>
                            <div class="grid grid-cols-3 gap-md">
                                @foreach (['junior' => 'Junior', 'mid' => 'Mid-Level', 'senior' => 'Senior+'] as $val => $label)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="difficulty" value="{{ $val }}" class="sr-only peer" {{ old('difficulty', 'junior') === $val ? 'checked' : '' }}/>
                                    <div class="flex flex-col items-center justify-center p-md border border-outline-variant rounded-lg bg-surface hover:border-primary peer-checked:border-primary peer-checked:bg-primary-fixed transition-all h-24">
                                        <span class="font-body-sm text-body-sm font-bold {{ $val === 'junior' ? 'text-secondary' : ($val === 'mid' ? 'text-primary' : 'text-tertiary') }}">{{ $label }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('difficulty')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex flex-col gap-sm">
                            <div class="flex justify-between items-center">
                                <label class="font-body-sm text-body-sm font-semibold text-on-surface" for="explanation">Detailed Explanation</label>
                                <span class="text-label-caps text-outline">Markdown Supported</span>
                            </div>
                            <textarea class="w-full p-md rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none @error('explanation') border-error @enderror" id="explanation" name="explanation" rows="8" placeholder="Break down the concept, use cases, and performance considerations..." required>{{ old('explanation') }}</textarea>
                            @error('explanation')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex items-center gap-lg pt-md">
                            <button class="h-12 px-xl bg-primary-container text-on-primary-container rounded-lg font-body-md font-bold shadow-sm hover:translate-y-[-1px] active:translate-y-0 active:scale-95 transition-all" type="submit">Add Concept</button>
                            <a class="font-body-sm text-body-sm font-semibold text-primary hover:underline decoration-2 underline-offset-4" href="{{ route('domains.show', $domain) }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="md:col-span-4 flex flex-col gap-gutter">
                <div class="bg-surface-container-low p-lg rounded-xl border border-outline-variant/50">
                    <div class="flex items-center gap-sm mb-md text-primary">
                        <span class="material-symbols-outlined">lightbulb</span>
                        <span class="font-title-lg text-title-lg">Writing Tips</span>
                    </div>
                    <ul class="space-y-md text-body-sm text-on-surface-variant">
                        <li class="flex gap-sm">
                            <span class="material-symbols-outlined text-secondary text-[18px]">check_circle</span>
                            Use clear headings to separate "Pros" and "Cons".
                        </li>
                        <li class="flex gap-sm">
                            <span class="material-symbols-outlined text-secondary text-[18px]">check_circle</span>
                            Link to real-world examples (e.g. Redis for caching).
                        </li>
                        <li class="flex gap-sm">
                            <span class="material-symbols-outlined text-secondary text-[18px]">check_circle</span>
                            Mention the "Trade-offs" for Senior levels.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>