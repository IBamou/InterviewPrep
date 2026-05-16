<div class="text-center mb-6">
    <span class="material-symbols-outlined text-primary text-[32px] mb-2" style="font-variation-settings: 'FILL' 1;">flag</span>
    <h2 class="text-lg font-semibold text-on-surface mb-1">What's your interview goal?</h2>
    <p class="text-sm text-on-surface-variant/70">This helps us generate relevant questions</p>
</div>
<div class="space-y-2">
    <template x-for="goal in goalOptions" :key="goal.value">
        <button type="button" @click="formData.interviewGoal = goal.value"
            :class="formData.interviewGoal === goal.value ? 'border-primary bg-primary-fixed ring-2 ring-primary/20' : 'border-outline-variant/50 hover:border-primary/50'"
            class="w-full flex items-center gap-3 p-4 rounded-xl border-2 transition-all text-left">
            <span class="material-symbols-outlined text-[20px]"
                :class="formData.interviewGoal === goal.value ? 'text-primary' : 'text-on-surface-variant/60'"
                style="font-variation-settings: 'FILL' 1;" x-text="goal.icon"></span>
            <div class="flex-1">
                <div class="text-base font-medium text-on-surface" x-text="goal.label"></div>
                <div class="text-sm text-on-surface-variant/70" x-text="goal.desc"></div>
            </div>
            <span class="material-symbols-outlined text-[20px]"
                :class="formData.interviewGoal === goal.value ? 'text-primary' : 'text-outline-variant'"
                style="font-variation-settings: 'FILL' 1;"
                x-show="formData.interviewGoal === goal.value">check_circle</span>
        </button>
    </template>
</div>
