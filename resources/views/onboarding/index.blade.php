<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Setup Your Profile | InterviewPrep</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <script>tailwind.config = { darkMode: "class", theme: { extend: { colors: { "background": "#F8FBFF", "surface": "#FFFFFF", "surface-container": "#F0F4F8", "surface-container-high": "#E8EDF2", "on-surface": "#1A1A2E", "on-surface-variant": "#546E7A", "primary": "#0077B6", "on-primary": "#FFFFFF", "primary-container": "#00B4D8", "primary-fixed": "#E0F7FA", "secondary": "#00A896", "error": "#E63946", "outline-variant": "#CFD8DC" }, borderRadius: { DEFAULT: "0.5rem", lg: "0.625rem", xl: "0.875rem", "2xl": "1rem", full: "9999px" }, fontFamily: { sans: ["Inter", "sans-serif"] }, fontSize: { sm: ["14px", { lineHeight: "20px" }], base: ["16px", { lineHeight: "24px" }], lg: ["18px", { lineHeight: "28px" }], xl: ["24px", { lineHeight: "32px" }], "2xl": ["32px", { lineHeight: "40px" }] } } } }</script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle
        }

        .step-enter {
            animation: stepEnter 0.3s ease-out
        }

        @keyframes stepEnter {
            from {
                opacity: 0;
                transform: translateX(20px)
            }

            to {
                opacity: 1;
                transform: translateX(0)
            }
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-background text-on-surface font-sans min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg" x-data="onboarding()" x-on:keydown.right.prevent="nextStep()"
        x-on:keydown.left.prevent="prevStep()">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-primary-container mb-4 shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-white text-[28px]"
                    style="font-variation-settings: 'FILL' 1;">school</span>
            </div>
            <h1 class="text-xl font-bold text-on-surface">InterviewPrep</h1>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-on-surface-variant" x-text="`Step ${step} of 5`"></span>
                <span class="text-sm font-medium text-primary" x-text="`${Math.round((step / 5) * 100)}%`"></span>
            </div>
            <div class="h-2 bg-surface-container rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full transition-all duration-500 ease-out"
                    :style="`width: ${(step / 5) * 100}%`"></div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('onboarding.store') }}" id="onboarding-form" class="hidden">
            @csrf
            <input type="hidden" name="status" :value="formData.status" />
            <input type="hidden" name="specialization" :value="formData.specialization" />
            <input type="hidden" name="experience_years" :value="formData.experienceYears" />
            <template x-for="tech in formData.techStack" :key="tech">
                <input type="hidden" name="tech_stack[]" :value="tech" />
            </template>
            <input type="hidden" name="interview_goal" :value="formData.interviewGoal" />
        </form>

        <!-- Steps Container -->
        <div class="bg-white border border-outline-variant/50 rounded-2xl p-6 shadow-sm">
            <x-onboarding.step-container :step="1">
                <x-onboarding.step-status />
            </x-onboarding.step-container>

            <x-onboarding.step-container :step="2">
                <x-onboarding.step-specialization />
            </x-onboarding.step-container>

            <x-onboarding.step-container :step="3">
                <x-onboarding.step-experience />
            </x-onboarding.step-container>

            <x-onboarding.step-container :step="4">
                <x-onboarding.step-techstack />
            </x-onboarding.step-container>

            <x-onboarding.step-container :step="5">
                <x-onboarding.step-goal />
            </x-onboarding.step-container>
        </div>

        <!-- Navigation -->
        <div class="flex items-center justify-between mt-6">
            <button type="button" x-show="step > 1" @click="prevStep()"
                class="flex items-center gap-1.5 text-sm font-medium text-on-surface-variant hover:text-on-surface transition-colors px-3 py-2 rounded-lg hover:bg-surface-container">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back
            </button>
            <div x-show="step === 1" class="flex-1"></div>

            <a href="{{ route('onboarding.skip') }}"
                class="text-sm text-on-surface-variant/60 hover:text-on-surface-variant transition-colors px-3 py-2">Skip
                for now</a>

            <button type="button" x-show="step < 5" @click="nextStep()" :disabled="!canProceed"
                :class="canProceed ? 'bg-primary text-white hover:bg-primary/90 shadow-lg shadow-primary/20' : 'bg-surface-container text-on-surface-variant/40 cursor-not-allowed'"
                class="flex items-center gap-1.5 text-sm font-semibold px-5 py-2.5 rounded-xl transition-all">
                Next
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </button>
            <button type="button" x-show="step === 5" @click="submitForm()" :disabled="!canProceed"
                :class="canProceed ? 'bg-primary text-white hover:bg-primary/90 shadow-lg shadow-primary/20' : 'bg-surface-container text-on-surface-variant/40 cursor-not-allowed'"
                class="flex items-center gap-1.5 text-sm font-semibold px-5 py-2.5 rounded-xl transition-all">
                <span class="material-symbols-outlined text-[18px]"
                    style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
                Get Started
            </button>
        </div>
    </div>

    <script>
        function onboarding() {
            return {
                step: 1,
                formData: {
                    status: '',
                    specialization: '',
                    experienceYears: '',
                    techStack: [],
                    interviewGoal: '',
                },
                statusOptions: {{ Js::from($statusOptions) }},
                specializationOptions: {{ Js::from($specializationOptions) }},
                experienceOptions: {{ Js::from($experienceOptions) }},
                goalOptions: {{ Js::from($goalOptions) }},
                techOptions: {{ Js::from($techOptions) }},
                get canProceed() {
                    switch (this.step) {
                        case 1: return this.formData.status !== '';
                        case 2: return this.formData.specialization !== '';
                        case 3: return this.formData.experienceYears !== '';
                        case 4: return this.formData.techStack.length > 0;
                        case 5: return this.formData.interviewGoal !== '';
                        default: return false;
                    }
                },
                selectStatus(value) {
                    this.formData.status = value;
                    setTimeout(() => this.nextStep(), 300);
                },
                toggleTech(tech) {
                    const idx = this.formData.techStack.indexOf(tech);
                    if (idx > -1) {
                        this.formData.techStack.splice(idx, 1);
                    } else {
                        this.formData.techStack.push(tech);
                    }
                },
                nextStep() {
                    if (!this.canProceed || this.step >= 5) return;
                    this.step++;
                },
                prevStep() {
                    if (this.step <= 1) return;
                    this.step--;
                },
                submitForm() {
                    if (!this.canProceed) return;
                    document.getElementById('onboarding-form').submit();
                },
            };
        }
    </script>
</body>

</html>
