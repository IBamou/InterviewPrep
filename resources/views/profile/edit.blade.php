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
