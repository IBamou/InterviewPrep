<x-app-layout activeNav="domains" title="Create Domain">
    <div class="max-w-2xl">
        <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
            <a class="hover:text-primary transition-colors" href="{{ route('domains.index') }}">Domains</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-on-surface font-medium">New Domain</span>
        </nav>

        <h2 class="font-display-lg text-display-lg text-on-surface mb-1">Create Domain</h2>
        <p class="text-[13px] text-on-surface-variant/60 mb-6">Define a new knowledge area for your interview prep.</p>

        @if ($errors->any())
        <div class="mb-4 p-3 bg-error/5 border border-error/20 text-error rounded-lg text-[13px]">
            <ul class="list-disc pl-4 space-y-0.5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('domains.store') }}" class="space-y-5">
            @csrf
            <div class="bg-white border border-outline-variant/50 rounded-xl p-5 space-y-5">
                <div>
                    <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="name">Name</label>
                    <input class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all placeholder:text-on-surface-variant/30 @error('name') border-error @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. System Design, React, Algorithms" type="text" required/>
                    @error('name')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="description">Description</label>
                    <textarea class="w-full p-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all resize-none @error('description') border-error @enderror" id="description" name="description" rows="4" placeholder="What does this domain cover?">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all" type="submit">Create Domain</button>
                <a class="text-[13px] text-on-surface-variant hover:text-on-surface transition-colors" href="{{ route('domains.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
