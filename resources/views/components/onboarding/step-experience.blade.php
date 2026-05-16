<div class="text-center mb-6">
    <span class="material-symbols-outlined text-primary text-[32px] mb-2" style="font-variation-settings: 'FILL' 1;">timeline</span>
    <h2 class="text-lg font-semibold text-on-surface mb-1">Years of experience?</h2>
    <p class="text-sm text-on-surface-variant/70">In tech or your current field</p>
</div>
<div class="space-y-2">
    <template x-for="exp in experienceOptions" :key="exp.value">
        <button type="button" @click="formData.experienceYears = exp.value"
            :class="formData.experienceYears === exp.value ? 'border-primary bg-primary-fixed ring-2 ring-primary/20' : 'border-outline-variant/50 hover:border-primary/50'"
            class="w-full flex items-center justify-between p-4 rounded-xl border-2 transition-all">
            <span class="text-base font-medium text-on-surface" x-text="exp.label"></span>
            <span class="material-symbols-outlined text-[20px]"
                :class="formData.experienceYears === exp.value ? 'text-primary' : 'text-transparent'"
                style="font-variation-settings: 'FILL' 1;">check_circle</span>
        </button>
    </template>
</div>
