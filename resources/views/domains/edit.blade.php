<x-app-layout activeNav="domains" title="Edit Domain: {{ $domain->name }}">
    <x-slot:topbar-actions>
        <a href="{{ route('concepts.create', $domain) }}" class="px-md py-sm bg-primary-container text-on-primary-container rounded-full font-body-sm font-semibold hover:opacity-90 transition-all">Create Concept</a>
    </x-slot:topbar-actions>

    <nav class="mb-lg">
        <ol class="flex items-center gap-xs text-on-surface-variant font-body-sm">
            <li><a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">Domains</a></li>
            <li><span class="material-symbols-outlined text-[16px]">chevron_right</span></li>
            <li><a class="hover:text-primary transition-colors" href="{{ route('domains.show', $domain) }}">{{ $domain->name }}</a></li>
            <li><span class="material-symbols-outlined text-[16px]">chevron_right</span></li>
            <li class="text-on-surface font-semibold">Edit</li>
        </ol>
    </nav>

    <div class="mb-xl">
        <h1 class="font-display-lg text-display-lg text-on-surface">Edit Domain: {{ $domain->name }}</h1>
        <p class="text-on-surface-variant font-body-md mt-xs">Update your knowledge domain structure and appearance.</p>
    </div>

    @if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-xl text-sm">
        <ul class="list-disc pl-4 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="grid grid-cols-12 gap-gutter">
        <div class="col-span-12 lg:col-span-8">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg card-shadow">
                <form method="POST" action="{{ route('domains.update', $domain) }}" class="space-y-lg">
                    @csrf @method('PUT')
                    <div class="space-y-sm">
                        <label class="font-body-sm text-body-sm font-semibold text-on-surface" for="name">Domain Name</label>
                        <input class="w-full h-12 px-md bg-background border border-outline-variant rounded-lg focus:border-primary-container focus:ring-2 focus:ring-primary-container focus:ring-opacity-20 transition-all @error('name') border-error @enderror" id="name" name="name" type="text" value="{{ old('name', $domain->name) }}" required/>
                        @error('name')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-sm">
                        <label class="font-body-sm text-body-sm font-semibold text-on-surface" for="color">Accent Color</label>
                        <div class="flex items-center gap-md">
                            <input class="w-12 h-12 rounded-lg border border-outline-variant cursor-pointer" type="color" name="color_preview" id="color_preview" value="#{{ ltrim(old('color', $domain->color), '#') }}" onchange="document.getElementById('color').value = this.value.replace('#',''); document.getElementById('color_preview_hex').textContent = this.value"/>
                            <input class="flex-grow h-12 px-md bg-background border border-outline-variant rounded-lg font-code-block text-code-block @error('color') border-error @enderror" id="color" name="color" type="text" value="{{ old('color', $domain->color) }}"/>
                        </div>
                        @error('color')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-sm">
                        <label class="font-body-sm text-body-sm font-semibold text-on-surface" for="description">Description</label>
                        <textarea class="w-full px-md py-md bg-background border border-outline-variant rounded-lg focus:border-primary-container focus:ring-2 focus:ring-primary-container focus:ring-opacity-20 transition-all resize-none @error('description') border-error @enderror" id="description" name="description" rows="6">{{ old('description', $domain->description) }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="pt-md border-t border-outline-variant flex items-center gap-lg">
                        <button class="h-12 px-xl bg-primary-container text-on-primary font-semibold rounded-lg hover:bg-primary transition-all shadow-sm" type="submit">Update Domain</button>
                        <a class="font-body-md text-primary hover:underline transition-all" href="{{ route('domains.show', $domain) }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-4 space-y-gutter">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden card-shadow">
                <div class="h-32 relative" style="background-color: #{{ ltrim(old('color', $domain->color), '#') }}">
                    <div class="absolute inset-0 bg-gradient-to-tr from-black/40 to-transparent"></div>
                    <span class="absolute top-4 right-4 bg-white/20 backdrop-blur-md px-sm py-xs rounded-full font-label-caps text-label-caps text-white">PREVIEW</span>
                </div>
                <div class="p-lg">
                    <h3 class="font-headline-md text-headline-md text-on-surface mb-sm">{{ old('name', $domain->name) }}</h3>
                    <div class="flex gap-xs mb-md">
                        <span class="px-sm py-xs bg-secondary-container text-on-secondary-container rounded font-label-caps text-label-caps">{{ $domain->concepts_count }} QUESTIONS</span>
                        <span class="px-sm py-xs bg-tertiary-fixed text-on-tertiary-fixed-variant rounded font-label-caps text-label-caps">ACTIVE</span>
                    </div>
                    <p class="text-on-surface-variant font-body-sm line-clamp-3">{{ old('description', $domain->description) ?: 'High-level architectural patterns and distributed systems fundamentals for modern engineering roles.' }}</p>
                </div>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg card-shadow">
                <div class="flex items-center justify-between mb-lg">
                    <h3 class="font-title-lg text-title-lg text-on-surface">Domain Insights</h3>
                    <span class="material-symbols-outlined text-on-surface-variant">monitoring</span>
                </div>
                <div class="space-y-md">
                    @php $pct = $domain->concepts_count > 0 ? round(($domain->mastered_count / $domain->concepts_count) * 100) : 0; @endphp
                    <div class="flex items-center justify-between">
                        <span class="text-on-surface-variant font-body-sm">Completion Rate</span>
                        <span class="font-semibold text-primary">{{ $pct }}%</span>
                    </div>
                    <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                        <div class="bg-primary-container h-full w-[{{ $pct }}%]"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-sm pt-md">
                        <div class="p-sm bg-surface-container-low rounded-lg border border-outline-variant/30">
                            <div class="font-label-caps text-label-caps text-on-surface-variant mb-xs">CONCEPTS</div>
                            <div class="font-headline-md text-headline-md text-on-surface">{{ $domain->concepts_count }}</div>
                        </div>
                        <div class="p-sm bg-surface-container-low rounded-lg border border-outline-variant/30">
                            <div class="font-label-caps text-label-caps text-on-surface-variant mb-xs">MASTERED</div>
                            <div class="font-headline-md text-headline-md text-secondary">{{ $domain->mastered_count }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>