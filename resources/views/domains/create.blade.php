<x-app-layout activeNav="domains" title="Create Domain">
    <div class="flex flex-col gap-sm mb-xl">
        <a class="flex items-center text-primary font-body-sm hover:underline gap-xs w-fit" href="{{ route('domains.index') }}">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Back to Domains
        </a>
        <h1 class="font-headline-md text-headline-md text-on-surface">Create New Domain</h1>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-xl text-sm">
        <ul class="list-disc pl-4 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="grid grid-cols-12 gap-gutter">
        <div class="col-span-12 lg:col-span-8 space-y-lg">
            <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm">
                <form method="POST" action="{{ route('domains.store') }}" class="space-y-lg">
                    @csrf
                    <div class="space-y-sm">
                        <label class="font-body-sm text-body-sm font-semibold text-on-surface" for="name">Domain Name</label>
                        <input class="w-full h-[48px] px-md rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none bg-white @error('name') border-error @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Frontend" type="text" required/>
                        @error('name')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-sm">
                        <label class="font-body-sm text-body-sm font-semibold text-on-surface" for="color">Accent Color</label>
                        <div class="flex gap-md items-center">
                            <input class="w-12 h-12 rounded-lg border-none cursor-pointer bg-transparent" type="color" name="color_preview" id="color_preview" value="{{ old('color', '#3525cd') }}" onchange="document.getElementById('color').value = this.value.replace('#',''); document.getElementById('color_preview_hex').textContent = this.value"/>
                            <div class="relative flex-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant font-code-block">#</span>
                                <input class="w-full h-[48px] pl-8 pr-md rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 font-code-block transition-all outline-none bg-white @error('color') border-error @enderror" id="color" name="color" type="text" value="{{ old('color', '3525cd') }}" placeholder="3525cd"/>
                            </div>
                        </div>
                        @error('color')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-sm">
                        <label class="font-body-sm text-body-sm font-semibold text-on-surface" for="description">Description</label>
                        <textarea class="w-full p-md rounded-lg border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none bg-white resize-none @error('description') border-error @enderror" id="description" name="description" placeholder="Describe the focus of this domain (e.g., React, System Design, Algorithms)..." rows="6">{{ old('description') }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="pt-md flex items-center gap-xl">
                        <button class="bg-primary text-white h-[48px] px-xxl rounded-lg font-bold text-body-md hover:bg-primary-container transition-all active:scale-95 shadow-sm" type="submit">Create Domain</button>
                        <a class="text-on-surface-variant hover:text-on-surface font-body-sm" href="{{ route('domains.index') }}">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-4 space-y-lg">
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant shadow-sm overflow-hidden">
                <div class="p-md border-b border-outline-variant bg-surface-container-low">
                    <p class="font-label-caps text-label-caps text-on-surface-variant uppercase tracking-wider">Live Preview</p>
                </div>
                <div class="p-lg">
                    <div class="group relative bg-white border border-outline-variant rounded-xl overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="h-32 relative overflow-hidden" style="background-color: #{{ old('color', '3525cd') }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-4">
                                <div class="text-white font-headline-md text-headline-md" id="preview-name">{{ old('name') ?: 'Frontend' }}</div>
                                <div class="text-white/80 font-body-sm text-body-sm">0 Concepts</div>
                            </div>
                        </div>
                        <div class="p-md space-y-sm">
                            <p class="text-on-surface-variant font-body-sm line-clamp-2">{{ old('description') ?: 'Your domain description will appear here...' }}</p>
                            <div class="flex items-center justify-between pt-sm">
                                <span class="bg-secondary-container text-on-secondary-container px-sm py-xs rounded-full font-label-caps text-[10px] uppercase">Active</span>
                                <span class="material-symbols-outlined text-primary">arrow_forward</span>
                            </div>
                        </div>
                    </div>
                    <p class="mt-md text-on-surface-variant text-center font-body-sm italic">This is how your domain card will appear in the main index.</p>
                </div>
            </div>
            <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm space-y-md">
                <h3 class="font-title-lg text-title-lg text-on-surface flex items-center gap-sm">
                    <span class="material-symbols-outlined text-secondary">lightbulb</span>
                    Creation Tips
                </h3>
                <ul class="space-y-md">
                    <li class="flex gap-md">
                        <span class="material-symbols-outlined text-on-surface-variant shrink-0 mt-0.5">check_circle</span>
                        <p class="font-body-sm text-body-sm text-on-surface-variant"><span class="font-semibold text-on-surface">Specific Naming:</span> Use clear, concise names like "Behavioral" or "Machine Learning" to keep your dashboard organized.</p>
                    </li>
                    <li class="flex gap-md">
                        <span class="material-symbols-outlined text-on-surface-variant shrink-0 mt-0.5">palette</span>
                        <p class="font-body-sm text-body-sm text-on-surface-variant"><span class="font-semibold text-on-surface">Color Coding:</span> Assign distinct colors to domains to quickly differentiate them during quick-fire practice sessions.</p>
                    </li>
                    <li class="flex gap-md">
                        <span class="material-symbols-outlined text-on-surface-variant shrink-0 mt-0.5">description</span>
                        <p class="font-body-sm text-body-sm text-on-surface-variant"><span class="font-semibold text-on-surface">Rich Descriptions:</span> Define the scope of each domain to help the AI Generator suggest relevant technical questions.</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>