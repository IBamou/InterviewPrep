<div class="text-center mb-6">
    <span class="material-symbols-outlined text-primary text-[32px] mb-2" style="font-variation-settings: 'FILL' 1;">person</span>
    <h2 class="text-lg font-semibold text-on-surface mb-1">What best describes you?</h2>
    <p class="text-sm text-on-surface-variant/70">This helps us tailor your experience</p>
</div>
<div class="space-y-3">
    <template x-for="opt in statusOptions" :key="opt.value">
        <button type="button" @click="selectStatus(opt.value)"
            :class="formData.status === opt.value ? 'border-primary bg-primary-fixed ring-2 ring-primary/20' : 'border-outline-variant/50 hover:border-primary/50 hover:bg-primary/5'"
            class="w-full flex items-center gap-4 p-4 rounded-xl border-2 transition-all text-left">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0"
                :class="opt.value === 'student' ? 'bg-primary/10' : 'bg-secondary/10'">
                <span class="material-symbols-outlined text-[20px]"
                    :class="opt.value === 'student' ? 'text-primary' : 'text-secondary'"
                    x-text="opt.icon"></span>
            </div>
            <div class="flex-1">
                <div class="text-base font-medium text-on-surface" x-text="opt.label"></div>
                <div class="text-sm text-on-surface-variant/70" x-text="opt.desc"></div>
            </div>
            <span class="material-symbols-outlined text-[20px]"
                :class="formData.status === opt.value ? 'text-primary' : 'text-outline-variant'"
                style="font-variation-settings: 'FILL' 1;"
                x-show="formData.status === opt.value">check_circle</span>
        </button>
    </template>
</div>
