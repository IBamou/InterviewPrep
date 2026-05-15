<x-app-layout activeNav="domains" title="Edit Concept">
    <nav class="flex items-center gap-sm text-body-sm text-on-surface-variant mb-lg">
        <a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">Domains</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('domains.show', $concept->domain) }}">{{ $concept->domain->name }}</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('concepts.show', $concept) }}">{{ $concept->title }}</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-on-surface font-semibold">Edit</span>
    </nav>

    <div class="mb-xl">
        <h2 class="font-display-lg text-display-lg text-on-surface mb-xs">Edit Concept</h2>
        <p class="text-on-surface-variant font-body-md">Refine the details of your technical knowledge node.</p>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-xl text-sm"><ul class="list-disc pl-4 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-xl">
        <div class="lg:col-span-8">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-xl shadow-sm">
                <form method="POST" action="{{ route('concepts.update', $concept) }}" class="space-y-xl">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                        <div class="space-y-sm">
                            <label class="font-body-sm font-semibold text-on-surface">Concept Title</label>
                            <input class="w-full h-12 rounded-lg border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md px-md @error('title') border-error @enderror" type="text" name="title" value="{{ old('title', $concept->title) }}" required/>
                            @error('title')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-sm">
                            <label class="font-body-sm font-semibold text-on-surface">Domain (Read-only)</label>
                            <div class="w-full h-12 bg-surface-container-low rounded-lg border border-outline-variant flex items-center px-md text-on-surface-variant font-body-md">
                                {{ $concept->domain->name }}
                            </div>
                        </div>
                    </div>
                    <div class="space-y-sm">
                        <label class="font-body-sm font-semibold text-on-surface">Difficulty Level</label>
                        <div class="grid grid-cols-3 gap-md">
                            @foreach (['junior' => 'EASY', 'mid' => 'MEDIUM', 'senior' => 'HARD'] as $val => $lbl)
                            <label class="cursor-pointer">
                                <input type="radio" name="difficulty" value="{{ $val }}" class="hidden peer" {{ old('difficulty', $concept->difficulty->value) === $val ? 'checked' : '' }}/>
                                <div class="flex flex-col items-center justify-center p-md border border-outline-variant rounded-lg hover:bg-surface-container-low peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                    <span class="font-label-caps border border-outline-variant bg-surface-container px-sm py-xs rounded mb-sm text-[10px]">{{ $lbl }}</span>
                                    <span class="font-body-sm text-on-surface-variant capitalize">{{ $val === 'mid' ? 'Mid' : ucfirst($val) }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="space-y-sm">
                        <label class="font-body-sm font-semibold text-on-surface">Proficiency Status</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                            @foreach (['to_review' => 'To Review', 'in_progress' => 'In Progress', 'mastered' => 'Mastered'] as $val => $lbl)
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="{{ $val }}" class="hidden peer" {{ old('status', $concept->status->value) === $val ? 'checked' : '' }}/>
                                <div class="flex items-center gap-md p-md border border-outline-variant rounded-lg hover:bg-surface-container-low peer-checked:border-primary peer-checked:bg-primary/5 transition-all">
                                    <div class="w-3 h-3 rounded-full {{ $val === 'to_review' ? 'bg-error' : ($val === 'mastered' ? 'bg-secondary' : 'bg-primary') }}"></div>
                                    <div class="flex flex-col">
                                        <span class="font-body-sm font-semibold">{{ $lbl }}</span>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="space-y-sm">
                        <label class="font-body-sm font-semibold text-on-surface">Technical Explanation</label>
                        <textarea class="w-full rounded-lg border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all font-body-md p-md @error('explanation') border-error @enderror" name="explanation" rows="8" placeholder="Describe the concept, key algorithms, and trade-offs..." required>{{ old('explanation', $concept->explanation) }}</textarea>
                        @error('explanation')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex items-center justify-end gap-md pt-lg border-t border-outline-variant">
                        <a href="{{ route('concepts.show', $concept) }}" class="px-xl h-12 rounded-lg text-on-surface font-semibold hover:bg-surface-container transition-all flex items-center">Cancel</a>
                        <button class="px-xl h-12 rounded-lg bg-primary text-white font-semibold shadow-md hover:opacity-90 active:scale-95 transition-all" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="lg:col-span-4 space-y-lg">
            <div class="bg-surface-container border border-outline-variant rounded-xl overflow-hidden shadow-sm">
                <div class="aspect-video w-full bg-surface-variant flex items-center justify-center">
                    <span class="material-symbols-outlined text-[64px] text-on-surface-variant" style="font-variation-settings: 'wght' 200;">data_object</span>
                </div>
                <div class="p-lg space-y-md">
                    <h3 class="font-title-lg text-title-lg">Content Guidelines</h3>
                    <ul class="space-y-sm text-body-sm text-on-surface-variant">
                        <li class="flex gap-sm">
                            <span class="material-symbols-outlined text-[18px] text-primary">check_circle</span>
                            Keep explanations concise and technical.
                        </li>
                        <li class="flex gap-sm">
                            <span class="material-symbols-outlined text-[18px] text-primary">check_circle</span>
                            Highlight trade-offs between different strategies.
                        </li>
                        <li class="flex gap-sm">
                            <span class="material-symbols-outlined text-[18px] text-primary">check_circle</span>
                            Link to relevant code examples in the domain.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-lg shadow-sm">
                <h3 class="font-title-lg text-title-lg mb-md">Analytics</h3>
                <div class="space-y-md">
                    <div class="flex justify-between items-center">
                        <span class="text-body-sm text-on-surface-variant">Last Revision</span>
                        <span class="text-body-sm font-semibold">{{ $concept->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="pt-sm">
                        <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
                            <div class="bg-primary w-3/4 h-full"></div>
                        </div>
                        <p class="text-[11px] text-on-surface-variant mt-xs">Mastery progress based on status</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>