<div class="text-center mb-6">
    <span class="material-symbols-outlined text-primary text-[32px] mb-2" style="font-variation-settings: 'FILL' 1;">widgets</span>
    <h2 class="text-lg font-semibold text-on-surface mb-1">What technologies do you use?</h2>
    <p class="text-sm text-on-surface-variant/70">Select all that apply (at least 1)</p>
</div>

<!-- Selected techs -->
<div x-show="formData.techStack.length > 0" class="mb-4 p-3 bg-primary/5 border border-primary/20 rounded-xl">
    <div class="flex items-center gap-1.5 mb-2">
        <span class="material-symbols-outlined text-primary text-[14px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        <span class="text-[11px] font-semibold text-primary uppercase tracking-wider">Selected</span>
    </div>
    <div class="flex flex-wrap gap-1.5">
        <template x-for="tech in formData.techStack" :key="tech">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary text-white rounded-lg text-[12px] font-medium transition-all">
                <span x-text="tech"></span>
                <button type="button" @click="toggleTech(tech)" class="hover:text-primary/70 transition-colors">
                    <span class="material-symbols-outlined text-[14px]">close</span>
                </button>
            </span>
        </template>
    </div>
</div>

<!-- Tech options -->
<div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
    <template x-for="tech in techOptions" :key="tech">
        <button type="button" @click="toggleTech(tech)"
            :class="formData.techStack.includes(tech)
                ? 'bg-primary text-white border-primary shadow-md shadow-primary/20 scale-[1.02]'
                : 'bg-white text-on-surface-variant border-outline-variant/40 hover:border-primary/50 hover:text-primary hover:bg-primary/5'"
            class="px-3 py-2.5 rounded-xl border-2 text-[12px] font-medium transition-all duration-200 flex items-center justify-center gap-1.5"
            x-text="tech">
        </button>
    </template>
</div>
