<div class="text-center mb-6">
    <span class="material-symbols-outlined text-primary text-[32px] mb-2" style="font-variation-settings: 'FILL' 1;">code</span>
    <h2 class="text-lg font-semibold text-on-surface mb-1">What's your specialization?</h2>
    <p class="text-sm text-on-surface-variant/70">Select the one that best fits your focus</p>
</div>
<div class="grid grid-cols-2 gap-3">
    <template x-for="spec in specializationOptions" :key="spec.value">
        <button type="button" @click="formData.specialization = spec.value"
            :class="formData.specialization === spec.value ? 'border-primary bg-primary-fixed ring-2 ring-primary/20' : 'border-outline-variant/50 hover:border-primary/50'"
            class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 transition-all">
            <span class="material-symbols-outlined text-[24px]"
                :class="formData.specialization === spec.value ? 'text-primary' : 'text-on-surface-variant/60'"
                style="font-variation-settings: 'FILL' 1;" x-text="spec.icon"></span>
            <span class="text-sm font-medium text-on-surface" x-text="spec.label"></span>
        </button>
    </template>
</div>
