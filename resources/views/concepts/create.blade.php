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

        <form method="POST" action="{{ route('concepts.store', $domain) }}" class="space-y-5" x-data="explanationGenerator()">
            @csrf
            <div class="bg-white border border-outline-variant/50 rounded-xl p-5 space-y-5">
                <div>
                    <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="title">Title</label>
                    <div class="flex items-center gap-2">
                        <input x-model="title" @keydown.enter.prevent="verifyTitle('{{ route('concepts.verifyTitle', $domain) }}')" class="flex-1 h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all placeholder:text-on-surface-variant/30 @error('title') border-error @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Consistent Hashing, CAP Theorem..." type="text" required/>
                        <button type="button" @click="verifyTitle('{{ route('concepts.verifyTitle', $domain) }}')" :disabled="verifying || !canVerify" class="shrink-0 px-3 py-2 text-[11px] font-semibold rounded-xl transition-all flex items-center gap-1.5 disabled:opacity-50 disabled:cursor-not-allowed" :class="titleValid === null ? 'bg-secondary/10 text-secondary hover:bg-secondary/20' : (titleValid ? 'bg-secondary/10 text-secondary' : 'bg-error/10 text-error')">
                            <span class="material-symbols-outlined text-[14px]" x-show="!verifying && titleValid === null">check_circle</span>
                            <span class="material-symbols-outlined text-[14px]" x-show="!verifying && titleValid === true" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="material-symbols-outlined text-[14px]" x-show="!verifying && titleValid === false" style="font-variation-settings: 'FILL' 1;">error_outline</span>
                            <span class="material-symbols-outlined text-[14px] animate-spin" x-show="verifying">progress_activity</span>
                            <span x-text="verifying ? 'Checking...' : 'Verify'"></span>
                        </button>
                    </div>
                    <div x-show="titleSuggestion" x-transition class="mt-2 p-2 bg-amber-50 border border-amber-200 rounded-lg text-[12px] text-amber-700 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">edit</span>
                        <span x-text="titleMessage"></span>
                        <button type="button" @click="applySuggestion()" class="underline font-medium hover:no-underline ml-1">Apply</button>
                    </div>
                    <div x-show="titleValid === true" x-transition class="mt-2 p-2 bg-secondary/5 border border-secondary/20 rounded-lg text-[12px] text-secondary flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <span>Looks good! Ready to generate.</span>
                    </div>
                    <div x-show="titleInvalid" x-transition class="mt-2 p-2 bg-error/5 border border-error/20 rounded-lg text-[12px] text-error flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">error_outline</span>
                        <span x-text="titleMessage"></span>
                    </div>
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
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-[13px] font-medium text-on-surface" for="explanation">Explanation</label>
                        <button type="button" @click="generate('{{ route('concepts.generateExplanation', $domain) }}')" :disabled="loading || !canGenerate" class="inline-flex items-center gap-1 text-[11px] text-secondary font-medium hover:opacity-80 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="material-symbols-outlined text-[14px]" x-show="!loading">auto_awesome</span>
                            <span class="material-symbols-outlined text-[14px] animate-spin" x-show="loading">progress_activity</span>
                            <span x-text="loading ? 'Generating...' : 'Generate with AI'"></span>
                        </button>
                    </div>
                    <textarea x-model="explanation" class="w-full p-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all resize-none @error('explanation') border-error @enderror" id="explanation" name="explanation" rows="8" placeholder="Describe the concept, how it works, and why it matters..."></textarea>
                    <div x-show="error" x-transition class="mt-2 p-2 bg-error/5 border border-error/20 rounded-lg text-[12px] text-error flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">error_outline</span>
                        <span x-text="error"></span>
                    </div>
                    <p x-show="!canGenerate && !error" class="text-[11px] text-on-surface-variant/40 mt-1">Enter a concept title first.</p>
                    @error('explanation')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all" type="submit">Add Concept</button>
                <a class="text-[13px] text-on-surface-variant hover:text-on-surface transition-colors" href="{{ route('domains.show', $domain) }}">Cancel</a>
            </div>
        </form>
    </div>

    <script>
    function explanationGenerator() {
        return {
            title: '{{ old('title', '') }}',
            explanation: '{{ old('explanation', '') }}',
            loading: false,
            error: '',
            verifying: false,
            titleValid: null,
            titleSuggestion: '',
            titleInvalid: false,
            titleMessage: '',
            get canVerify() {
                return this.title.trim().length >= 3;
            },
            get canGenerate() {
                return this.title.trim().length >= 3;
            },
            verifyTitle(url) {
                this.titleValid = null;
                this.titleSuggestion = '';
                this.titleInvalid = false;
                this.titleMessage = '';
                this.verifying = true;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ title: this.title.trim() }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        this.titleInvalid = true;
                        this.titleMessage = data.error;
                        return;
                    }
                    if (data.valid === true) {
                        this.titleValid = true;
                        this.titleMessage = '';
                    } else {
                        this.titleValid = false;
                        this.titleMessage = data.message || '';
                        if (data.suggestion) {
                            this.titleSuggestion = data.suggestion;
                        } else {
                            this.titleInvalid = true;
                        }
                    }
                })
                .catch(() => {
                    this.titleInvalid = true;
                    this.titleMessage = 'Failed to verify title. Please try again.';
                })
                .finally(() => {
                    this.verifying = false;
                });
            },
            applySuggestion() {
                if (this.titleSuggestion) {
                    this.title = this.titleSuggestion;
                    this.titleSuggestion = '';
                    this.titleValid = true;
                    this.titleMessage = '';
                }
            },
            generate(url) {
                this.error = '';

                const difficulty = document.querySelector('input[name="difficulty"]:checked')?.value || 'junior';

                this.loading = true;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ title: this.title.trim(), difficulty }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        this.error = data.error;
                        return;
                    }
                    this.explanation = data.explanation;
                })
                .catch(() => {
                    this.error = 'Failed to generate explanation. Please try again.';
                })
                .finally(() => {
                    this.loading = false;
                });
            },
        };
    }
    </script>
</x-app-layout>
