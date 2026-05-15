<x-app-layout activeNav="profile" title="Profile & Settings">
    <x-slot:topbar-actions>
        <a href="{{ route('domains.create') }}" class="px-md py-xs rounded-full border border-outline-variant text-on-surface-variant hover:bg-surface-container transition-all text-body-sm font-semibold">Save</a>
        <a href="{{ route('domains.create') }}" class="px-md py-xs bg-primary-container text-on-primary-container rounded-full text-body-sm font-semibold hover:opacity-90 transition-all">Add New</a>
    </x-slot:topbar-actions>

    @if (session('status') === 'profile-updated')
    <div class="mb-6 p-4 bg-secondary-container/30 border border-secondary/20 text-on-secondary-container rounded-xl text-sm">Profile updated successfully.</div>
    @endif
    @if (session('status') === 'password-updated')
    <div class="mb-6 p-4 bg-secondary-container/30 border border-secondary/20 text-on-secondary-container rounded-xl text-sm">Password updated successfully.</div>
    @endif

    <section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-xl flex flex-col md:flex-row items-center md:items-end justify-between gap-xl">
        <div class="flex flex-col md:flex-row items-center gap-xl">
            <div class="relative">
                <img alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-primary-fixed" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAVyGJKdRN-GC9gyVDNpKnfRDnqdaElVHUH7_h4LVPEHGBejGnCE3baXYvWQjeZNZdh4TT9elBWFg1IVE7fe7f3OPBgePmkDv-0sxOFDHnU2Nps-4QTyV1KDkDh56HPejat2-vvpGjvT80NMR8FGiEID-Ey05_fpTotAOZHI_ac3Gu3KY_rP0R3hlkx5Orx4e5ePNEPAITe7eBDfJssWhN74sSEjXoZQKAeg10axxO0gTlLa75tTTAYAnH8AV73zYh3aRnknr1HObs"/>
                <div class="absolute bottom-1 right-1 w-6 h-6 bg-secondary border-4 border-surface rounded-full"></div>
            </div>
            <div class="text-center md:text-left space-y-xs">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-sm">
                    <h2 class="font-headline-md text-headline-md text-on-surface">{{ $user->name }}</h2>
                    <span class="px-sm py-xs bg-secondary-container text-on-secondary-container rounded-lg font-label-caps text-label-caps uppercase">Developer</span>
                </div>
                <p class="font-body-md text-on-surface-variant flex items-center justify-center md:justify-start gap-xs">
                    <span class="material-symbols-outlined text-body-sm">calendar_today</span>
                    Member Since {{ $user->created_at->format('F Y') }}
                </p>
            </div>
        </div>
        <div class="flex gap-md">
            <button class="px-lg h-12 rounded-lg border border-outline-variant font-semibold text-on-surface hover:bg-surface-container transition-all flex items-center gap-sm">
                <span class="material-symbols-outlined">share</span>
                Share
            </button>
            <a href="#account-settings" class="px-lg h-12 rounded-lg bg-primary-container text-on-primary font-semibold hover:opacity-90 transition-all flex items-center gap-sm">
                <span class="material-symbols-outlined">edit</span>
                Edit Profile
            </a>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg mt-xl">
        <div class="lg:col-span-7 space-y-lg">
            <div id="account-settings" class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
                <div class="px-lg py-md border-b border-outline-variant bg-surface-container-low">
                    <h3 class="font-title-lg text-title-lg text-on-surface">Account Settings</h3>
                </div>
                <div class="p-lg space-y-lg">
                    @if ($errors->any())
                    <div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-xl text-sm">
                        <ul class="list-disc pl-4 space-y-1">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf @method('patch')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                            <div class="space-y-xs">
                                <label class="font-body-sm text-body-sm font-semibold text-on-surface-variant">Full Name</label>
                                <input class="w-full h-12 px-md border border-outline-variant rounded-lg focus:border-primary-container focus:ring-4 focus:ring-primary-fixed transition-all @error('name') border-error @enderror" name="name" type="text" value="{{ old('name', $user->name) }}" required/>
                                @error('name')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-xs">
                                <label class="font-body-sm text-body-sm font-semibold text-on-surface-variant">Email Address</label>
                                <input class="w-full h-12 px-md border border-outline-variant rounded-lg focus:border-primary-container focus:ring-4 focus:ring-primary-fixed transition-all @error('email') border-error @enderror" name="email" type="email" value="{{ old('email', $user->email) }}" required/>
                                @error('email')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="flex justify-end pt-md">
                            <button type="submit" class="px-lg h-10 bg-primary-container text-on-primary rounded-lg font-semibold hover:opacity-90 transition-all">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
                <div class="px-lg py-md border-b border-outline-variant bg-surface-container-low">
                    <h3 class="font-title-lg text-title-lg text-on-surface">Security</h3>
                </div>
                <div class="p-lg space-y-lg">
                    <div class="flex items-center gap-lg">
                        <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">lock</span>
                        </div>
                        <div>
                            <p class="font-body-md font-semibold text-on-surface">Change Password</p>
                            <p class="font-body-sm text-on-surface-variant">Update your account password to stay secure.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf @method('put')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div class="space-y-xs">
                                <input class="w-full h-10 px-md border border-outline-variant rounded-lg focus:border-primary-container focus:ring-4 focus:ring-primary-fixed transition-all @error('current_password', 'updatePassword') border-error @enderror" name="current_password" type="password" autocomplete="current-password" placeholder="Current Password"/>
                                @error('current_password', 'updatePassword')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-xs">
                                <input class="w-full h-10 px-md border border-outline-variant rounded-lg focus:border-primary-container focus:ring-4 focus:ring-primary-fixed transition-all @error('password', 'updatePassword') border-error @enderror" name="password" type="password" autocomplete="new-password" placeholder="New Password"/>
                                @error('password', 'updatePassword')<p class="mt-1 text-sm text-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="flex justify-end mt-md">
                            <button type="submit" class="px-lg h-10 border border-primary text-primary rounded-lg font-semibold hover:bg-primary-fixed transition-all">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="lg:col-span-5 space-y-lg">
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
                <div class="px-lg py-md border-b border-outline-variant bg-surface-container-low">
                    <h3 class="font-title-lg text-title-lg text-on-surface">Preferences</h3>
                </div>
                <div class="p-lg space-y-md">
                    <div class="flex items-center justify-between">
                        <div class="space-y-xs">
                            <p class="font-body-sm font-semibold text-on-surface">Dark Mode</p>
                            <p class="text-[12px] text-on-surface-variant">Sync with system theme</p>
                        </div>
                        <div class="w-10 h-5 bg-outline-variant rounded-full relative cursor-pointer">
                            <div class="absolute left-1 top-1 w-3 h-3 bg-white rounded-full transition-all"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-xs">
                            <p class="font-body-sm font-semibold text-on-surface">Email Notifications</p>
                            <p class="text-[12px] text-on-surface-variant">Daily summary of progress</p>
                        </div>
                        <div class="w-10 h-5 bg-secondary-container rounded-full relative cursor-pointer">
                            <div class="absolute right-1 top-1 w-3 h-3 bg-white rounded-full transition-all"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="space-y-xs">
                            <p class="font-body-sm font-semibold text-on-surface">Public Profile</p>
                            <p class="text-[12px] text-on-surface-variant">Show stats to others</p>
                        </div>
                        <div class="w-10 h-5 bg-secondary-container rounded-full relative cursor-pointer">
                            <div class="absolute right-1 top-1 w-3 h-3 bg-white rounded-full transition-all"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
                <div class="p-lg flex flex-col gap-md">
                    <div class="flex justify-between items-start">
                        <div class="space-y-xs">
                            <span class="font-label-caps text-label-caps text-on-surface-variant">CURRENT PLAN</span>
                            <h4 class="font-headline-md text-headline-md text-on-surface">Free Tier</h4>
                        </div>
                        <span class="material-symbols-outlined text-primary text-xxl">verified_user</span>
                    </div>
                    <p class="font-body-sm text-on-surface-variant">Unlock personalized AI-generated roadmaps and mock interview sessions.</p>
                    <button class="w-full py-sm bg-inverse-surface text-inverse-on-surface rounded-lg font-semibold hover:opacity-90 transition-all">Upgrade to Pro</button>
                </div>
            </div>
            <div class="bg-surface-container-lowest border border-error rounded-xl overflow-hidden">
                <div class="px-lg py-sm bg-error-container">
                    <h3 class="font-label-caps text-label-caps text-on-error-container">DANGER ZONE</h3>
                </div>
                <div class="p-lg">
                    <p class="font-body-sm text-on-surface-variant mb-md">Once you deactivate your account, there is no going back. Please be certain.</p>
                    <button onclick="document.getElementById('delete-account-modal').classList.remove('hidden')" class="w-full py-sm border border-error text-error rounded-lg font-semibold hover:bg-error-container transition-all">Deactivate Account</button>
                </div>
            </div>
        </div>
    </div>

    <div id="delete-account-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm hidden">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-8 shadow-2xl max-w-md w-full mx-4">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-full bg-error/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-error text-2xl" style="font-variation-settings: 'FILL' 1;">warning</span>
                </div>
                <h3 class="font-headline-md text-headline-md text-on-surface">Delete Account</h3>
            </div>
            <p class="text-on-surface-variant text-sm mb-6">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.</p>
            @if ($errors->userDeletion->isNotEmpty())
            <div class="mb-4 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-xl text-sm">
                <ul class="list-disc pl-4 space-y-1">@foreach ($errors->userDeletion->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
            @endif
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf @method('delete')
                <div class="space-y-2 mb-6">
                    <label class="font-body-sm text-body-sm font-semibold text-on-surface-variant" for="delete-password">Password</label>
                    <input class="w-full h-12 px-md border border-outline-variant rounded-lg focus:border-primary-container focus:ring-4 focus:ring-primary-fixed transition-all" id="delete-password" name="password" type="password" placeholder="Enter your password to confirm"/>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="document.getElementById('delete-account-modal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl border border-outline-variant text-on-surface font-semibold hover:bg-surface-container transition-all">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-error text-on-error font-semibold hover:opacity-90 active:scale-95 transition-all">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>