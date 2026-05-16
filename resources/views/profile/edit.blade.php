<x-app-layout activeNav="profile" title="Profile">
    @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
    <div class="mb-4 p-3 bg-secondary/5 border border-secondary/20 text-secondary rounded-lg text-[13px] flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">check_circle</span>Profile updated successfully.</div>
    @endif

    <div class="max-w-2xl">
        <h2 class="font-display-lg text-display-lg text-on-surface mb-6">Profile Settings</h2>

        <div class="bg-white border border-outline-variant/50 rounded-xl p-5 mb-5">
            <h3 class="text-[14px] font-semibold text-on-surface mb-4">Account</h3>
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf @method('patch')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="name">Name</label>
                        <input class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all @error('name') border-error @enderror" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required/>
                        @error('name')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="email">Email</label>
                        <input class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all @error('email') border-error @enderror" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required/>
                        @error('email')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex justify-end">
                    <button class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all" type="submit">Save</button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-outline-variant/50 rounded-xl p-5 mb-5">
            <h3 class="text-[14px] font-semibold text-on-surface mb-1">Interview Profile</h3>
            <p class="text-[13px] text-on-surface-variant/60 mb-4">Customize your interview prep experience. AI will tailor questions to your background.</p>
            <form method="POST" action="{{ route('profile.update') }}" x-data="{
                techStack: {{ json_encode(old('tech_stack', $user->tech_stack ?? [])) }},
                newTech: '',
                addTech() {
                    const t = this.newTech.trim();
                    if (t && !this.techStack.includes(t)) { this.techStack.push(t); }
                    this.newTech = '';
                },
                removeTech(i) { this.techStack.splice(i, 1); }
            }" class="space-y-4">
                @csrf @method('patch')
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="status">Status</label>
                        <select class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all @error('status') border-error @enderror" id="status" name="status">
                            <option value="">Select...</option>
                            @foreach(\App\Enums\UserStatus::cases() as $s)
                                <option value="{{ $s->value }}" @selected(old('status', $user->status?->value ?? $user->status) === $s->value)>{{ $s->label() }}</option>
                            @endforeach
                        </select>
                        @error('status')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="specialization">Specialization</label>
                        <select class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all @error('specialization') border-error @enderror" id="specialization" name="specialization">
                            <option value="">Select...</option>
                            @foreach(\App\Enums\Specialization::cases() as $spec)
                                <option value="{{ $spec->value }}" @selected(old('specialization', $user->specialization?->value ?? $user->specialization) === $spec->value)>{{ $spec->label() }}</option>
                            @endforeach
                        </select>
                        @error('specialization')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="experience_years">Years of Experience</label>
                        <select class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all @error('experience_years') border-error @enderror" id="experience_years" name="experience_years">
                            <option value="">Select...</option>
                            @foreach(\App\Enums\ExperienceLevel::cases() as $exp)
                                <option value="{{ $exp->value }}" @selected(old('experience_years', $user->experience_years?->value ?? $user->experience_years) === $exp->value)>{{ $exp->label() }}</option>
                            @endforeach
                        </select>
                        @error('experience_years')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="interview_goal">Interview Goal</label>
                        <select class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all @error('interview_goal') border-error @enderror" id="interview_goal" name="interview_goal">
                            <option value="">Select...</option>
                            @foreach(\App\Enums\InterviewGoal::cases() as $goal)
                                <option value="{{ $goal->value }}" @selected(old('interview_goal', $user->interview_goal?->value ?? $user->interview_goal) === $goal->value)>{{ $goal->label() }}</option>
                            @endforeach
                        </select>
                        @error('interview_goal')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="text-[13px] font-medium text-on-surface mb-1.5 block">Tech Stack</label>
                    <div class="flex gap-2 mb-2">
                        <input class="flex-1 h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all" x-model="newTech" @keydown.enter.prevent="addTech()" placeholder="Add technology (e.g., Laravel, React)"/>
                        <button type="button" @click="addTech()" class="px-3 py-2 bg-secondary/10 text-secondary rounded-lg text-[13px] font-medium hover:bg-secondary/20 transition-all">Add</button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="(tech, i) in techStack" :key="i">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-primary/10 text-primary rounded-full text-[12px]">
                                <span x-text="tech"></span>
                                <button type="button" @click="removeTech(i)" class="hover:text-primary-dark">&times;</button>
                            </span>
                        </template>
                    </div>
                    <template x-for="(tech, i) in techStack" :key="'hidden-' + i">
                        <input type="hidden" name="tech_stack[]" :value="tech"/>
                    </template>
                    @error('tech_stack')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                </div>
                <div class="flex justify-end">
                    <button class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all" type="submit">Save Profile</button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-outline-variant/50 rounded-xl p-5 mb-5">
            <h3 class="text-[14px] font-semibold text-on-surface mb-4">Update Password</h3>
            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf @method('put')
                <div>
                    <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="current_password">Current Password</label>
                    <input class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all @error('current_password', 'updatePassword') border-error @enderror" id="current_password" name="current_password" type="password" autocomplete="current-password"/>
                    @error('current_password', 'updatePassword')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="password">New Password</label>
                        <input class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all @error('password', 'updatePassword') border-error @enderror" id="password" name="password" type="password" autocomplete="new-password"/>
                        @error('password', 'updatePassword')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="password_confirmation">Confirm</label>
                        <input class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"/>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all" type="submit">Update Password</button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-error/30 rounded-xl p-5">
            <h3 class="text-[14px] font-semibold text-error mb-1">Delete Account</h3>
            <p class="text-[13px] text-on-surface-variant/60 mb-4">Once your account is deleted, all data will be permanently removed. Enter your password to confirm.</p>
            @if ($errors->userDeletion->isNotEmpty())
            <div class="mb-3 p-2 bg-error/5 border border-error/20 text-error rounded-lg text-[12px]">
                @foreach ($errors->userDeletion->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf @method('delete')
                <div class="flex items-center gap-3">
                    <input id="delete-password" class="flex-1 h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-error focus:ring-2 focus:ring-error/15 outline-none transition-all" name="password" type="password" placeholder="Enter your password" oninput="document.getElementById('delete-btn').disabled = this.value.length === 0"/>
                    <button id="delete-btn" type="submit" disabled class="px-4 py-2 bg-error text-white rounded-lg text-[13px] font-medium hover:bg-error/90 transition-all disabled:opacity-40 disabled:cursor-not-allowed">Delete Account</button>
                </div>
            </form>
        </div>
</x-app-layout>
