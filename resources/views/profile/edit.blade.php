<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>User Profile &amp; Settings | InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Geist:wght@400;500;600&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "outline": "#777587",
                        "primary-container": "#4f46e5",
                        "on-primary-fixed-variant": "#3323cc",
                        "outline-variant": "#c7c4d8",
                        "surface-container": "#e7eefe",
                        "on-surface": "#151c27",
                        "on-background": "#151c27",
                        "error-container": "#ffdad6",
                        "on-tertiary-fixed-variant": "#653e00",
                        "primary-fixed-dim": "#c3c0ff",
                        "inverse-primary": "#c3c0ff",
                        "error": "#ba1a1a",
                        "on-surface-variant": "#464555",
                        "inverse-on-surface": "#ebf1ff",
                        "on-primary": "#ffffff",
                        "surface-tint": "#4d44e3",
                        "on-secondary-fixed": "#002113",
                        "on-secondary-container": "#00714d",
                        "surface-dim": "#d3daea",
                        "tertiary-fixed": "#ffddb8",
                        "surface-variant": "#dce2f3",
                        "tertiary-fixed-dim": "#ffb95f",
                        "surface-container-highest": "#dce2f3",
                        "background": "#f9f9ff",
                        "on-primary-fixed": "#0f0069",
                        "primary": "#3525cd",
                        "surface-container-low": "#f0f3ff",
                        "secondary-fixed": "#6ffbbe",
                        "secondary": "#006c49",
                        "primary-fixed": "#e2dfff",
                        "on-primary-container": "#dad7ff",
                        "tertiary": "#684000",
                        "secondary-fixed-dim": "#4edea3",
                        "on-secondary-fixed-variant": "#005236",
                        "secondary-container": "#6cf8bb",
                        "on-tertiary-container": "#ffd4a4",
                        "on-error": "#ffffff",
                        "surface-bright": "#f9f9ff",
                        "surface": "#f9f9ff",
                        "tertiary-container": "#885500",
                        "on-secondary": "#ffffff",
                        "inverse-surface": "#2a313d",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-high": "#e2e8f8",
                        "on-tertiary-fixed": "#2a1700",
                        "on-error-container": "#93000a",
                        "on-tertiary": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gutter": "1.5rem",
                        "container-max": "1280px",
                        "stack-lg": "2rem",
                        "margin-x": "2rem",
                        "stack-md": "1rem",
                        "stack-sm": "0.5rem"
                    },
                    "fontFamily": {
                        "headline-lg": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-md": ["Geist"],
                        "display": ["Inter"],
                        "code": ["JetBrains Mono"],
                        "headline-md": ["Inter"],
                        "body-md": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],
                        "display": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "code": ["14px", {"lineHeight": "22px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #f9f9ff;
            color: #151c27;
        }
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
        }
    </style>
</head>
<body class="font-body-md text-body-md">
<!-- SideNavBar -->
<aside class="flex flex-col h-full py-6 px-4 h-screen w-64 fixed left-0 top-0 bg-surface dark:bg-inverse-surface border-r border-outline-variant dark:border-outline shadow-sm z-[60]">
<div class="mb-8 px-2">
<h1 class="text-headline-md font-display font-bold text-primary dark:text-inverse-primary">InterviewPrep</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Laravel Mastery</p>
</div>
<nav class="flex-1 space-y-2">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant scale-95 active:scale-90" href="{{ route('dashboard') }}">
<span class="material-symbols-outlined">dashboard</span>
<span>Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant scale-95 active:scale-90" href="{{ route('domains.index') }}">
<span class="material-symbols-outlined">category</span>
<span>Domains</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant scale-95 active:scale-90" href="{{ route('domains.archives') }}">
    <span class="material-symbols-outlined">archive</span>
    <span>Archives</span>
</a>
</nav>
<div class="mt-auto space-y-4">
<button class="w-full py-3 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg transition-transform active:scale-95">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">bolt</span>
                AI Generator
            </button>
<div class="flex items-center gap-3 p-2 rounded-xl bg-surface-container-low border border-outline-variant">
<img alt="User profile avatar" class="w-10 h-10 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB0viPcs19AoDiCrwoXV3QfXpBKCEKRO736XlhT7zTjUqNqvkC3dJnMifpGL5DbiC6ldN9vUPDoFV-8kofnIY9AvLBWTSWdFHJrWS0wmSxrJvRyD0ouC01wfqK4d31nHSySxG2HVqdeiOsdV6PKYPLatz847ibx-_ikrhUqpbCjp5axTBizS5bxIF28y_0gLDKS7LKE2WF71gH4Nyy51yDS0VkwQPrb47rmNGOMn8Y-AQyo40PSqvSOVqueL-dvztJG3316_gZhNTs"/>
<div class="overflow-hidden">
<p class="text-xs font-bold truncate">{{ Auth::user()->name }}</p>
<p class="text-[10px] text-on-surface-variant truncate">Premium Member</p>
</div>
</div>
</div>
</aside>
<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 px-8 flex justify-between items-center bg-surface/80 dark:bg-surface-dim/80 backdrop-blur-md border-b border-outline-variant dark:border-outline z-50">
<div class="flex items-center flex-1">
<div class="relative w-full max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
<input class="w-full pl-10 pr-4 py-2 bg-surface-container-low border-none rounded-lg text-label-md focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Search resources..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex gap-4">
<a href="{{ route('domains.create') }}" class="font-label-md text-label-md px-4 py-2 rounded-lg border border-outline-variant text-label-md font-medium text-on-surface-variant hover:bg-surface-container transition-all">Add Domain</a>
<a href="{{ route('concepts.create', Auth::user()->domains()->first()?->id ?: '__placeholder__') }}" class="font-label-md text-label-md px-4 py-2 rounded-lg bg-primary text-on-primary text-label-md font-medium hover:opacity-90 active:scale-95 transition-all">Create Concept</a>
</div>
<div class="flex items-center gap-4 text-outline border-l border-outline-variant pl-4">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="material-symbols-outlined hover:text-primary transition-colors" title="Logout">logout</button>
</form>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="ml-64 pt-24 pb-12 px-8">
<div class="max-w-container-max mx-auto">

@if (session('status') === 'profile-updated')
<div class="mb-6 p-4 bg-secondary-container/30 border border-secondary/20 text-on-secondary-container rounded-lg text-sm">
Profile updated successfully.
</div>
@endif

@if (session('status') === 'password-updated')
<div class="mb-6 p-4 bg-secondary-container/30 border border-secondary/20 text-on-secondary-container rounded-lg text-sm">
Password updated successfully.
</div>
@endif

<!-- Profile Overview -->
<section class="mb-8">
<div class="relative bg-white rounded-xl border border-outline-variant p-8 flex flex-col md:flex-row items-center md:items-end gap-6 overflow-hidden">
<div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-primary/10 via-primary/5 to-transparent"></div>
<div class="relative z-10 w-32 h-32 rounded-2xl border-4 border-white shadow-lg overflow-hidden shrink-0">
<img alt="{{ $user->name }}" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAVyGJKdRN-GC9gyVDNpKnfRDnqdaElVHUH7_h4LVPEHGBejGnCE3baXYvWQjeZNZdh4TT9elBWFg1IVE7fe7f3OPBgePmkDv-0sxOFDHnU2Nps-4QTyV1KDkDh56HPejat2-vvpGjvT80NMR8FGiEID-Ey05_fpTotAOZHI_ac3Gu3KY_rP0R3hlkx5Orx4e5ePNEPAITe7eBDfJssWhN74sSEjXoZQKAeg10axxO0gTlLa75tTTAYAnH8AV73zYh3aRnknr1HObs"/>
</div>
<div class="relative z-10 flex-1 text-center md:text-left">
<div class="flex flex-col md:flex-row md:items-center gap-3 mb-2">
<h1 class="font-headline-lg text-headline-lg text-on-surface">{{ $user->name }}</h1>
<span class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary font-label-md text-xs border border-primary/20">
<span class="material-symbols-outlined text-[14px] mr-1" style="font-variation-settings: 'FILL' 1;">verified</span>
                                Senior Backend Engineer
                            </span>
</div>
<p class="text-on-surface-variant font-body-md flex items-center justify-center md:justify-start gap-2">
<span class="material-symbols-outlined text-[18px]">calendar_today</span>
                            Member Since {{ $user->created_at->format('F Y') }}
                        </p>
</div>
<div class="relative z-10 flex gap-3">
<button class="px-5 py-2.5 rounded-xl bg-white border border-outline-variant text-label-md font-medium hover:bg-surface-container transition-all flex items-center gap-2">
<span class="material-symbols-outlined text-[20px]">share</span>
                            Share Profile
                        </button>
<a href="#account-settings" class="px-5 py-2.5 rounded-xl bg-primary text-on-primary text-label-md font-medium hover:opacity-90 active:scale-95 transition-all flex items-center gap-2">
<span class="material-symbols-outlined text-[20px]">edit</span>
                            Edit Profile
                        </a>
</div>
</div>
</section>
<div class="bento-grid">
<!-- Account Settings & Preferences (Left Column) -->
<div class="col-span-12 lg:col-span-8 space-y-6">
<!-- Account Settings -->
<div id="account-settings" class="bg-white rounded-xl border border-outline-variant p-6 shadow-sm">
<div class="flex items-center gap-3 mb-6">
<span class="material-symbols-outlined text-primary">person_outline</span>
<h2 class="font-headline-md text-headline-md">Account Settings</h2>
</div>

@if ($errors->any())
<div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-lg text-sm">
<ul class="list-disc pl-4 space-y-1">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('profile.update') }}">
@csrf
@method('patch')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
<div class="space-y-2">
<label class="font-label-md text-on-surface-variant" for="name">Full Name</label>
<input class="w-full px-4 py-2.5 rounded-lg border border-outline-variant bg-surface-container-low text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none @error('name') border-error @enderror" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required/>
@error('name')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<div class="space-y-2">
<label class="font-label-md text-on-surface-variant" for="email">Email Address</label>
<input class="w-full px-4 py-2.5 rounded-lg border border-outline-variant bg-surface-container-low text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none @error('email') border-error @enderror" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required/>
@error('email')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
</div>

@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
<div class="mb-4 p-4 bg-surface-container-high rounded-lg border border-outline-variant/50">
<p class="text-sm text-on-surface-variant">
Your email address is unverified.
<form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="inline">
@csrf
<button type="submit" class="text-primary font-bold hover:underline ml-1">Click here to re-send the verification email.</button>
</form>
</p>
@if (session('status') === 'verification-link-sent')
<p class="mt-2 font-medium text-sm text-secondary">
A new verification link has been sent to your email address.
</p>
@endif
</div>
@endif

<div class="flex items-center gap-4 pt-4 border-t border-outline-variant/30">
<button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-on-primary font-label-md hover:opacity-90 active:scale-95 transition-all">Save Changes</button>
@if (session('status') === 'profile-updated')
<span class="text-sm text-secondary font-medium">Saved.</span>
@endif
</div>
</form>

<div class="flex items-center justify-between pt-4 mt-4 border-t border-outline-variant/30">
<div class="flex items-center gap-3 text-on-surface-variant">
<span class="material-symbols-outlined text-[20px]">lock_reset</span>
<span class="text-label-md">Security was last updated recently</span>
</div>
<a href="#update-password" class="text-primary font-label-md hover:underline flex items-center gap-1">
                                Change Password
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
</a>
</div>
</div>
<!-- Update Password -->
<div id="update-password" class="bg-white rounded-xl border border-outline-variant p-6 shadow-sm">
<div class="flex items-center justify-between mb-6">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary">lock</span>
<h2 class="font-headline-md text-headline-md">Update Password</h2>
</div>
</div>
<form method="POST" action="{{ route('password.update') }}">
@csrf
@method('put')
<div class="space-y-4">
<div class="space-y-2">
<label class="font-label-md text-on-surface-variant" for="update_password_current_password">Current Password</label>
<input class="w-full px-4 py-2.5 rounded-lg border border-outline-variant bg-surface-container-low text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none @error('current_password', 'updatePassword') border-error @enderror" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" placeholder="••••••••"/>
@error('current_password', 'updatePassword')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div class="space-y-2">
<label class="font-label-md text-on-surface-variant" for="update_password_password">New Password</label>
<input class="w-full px-4 py-2.5 rounded-lg border border-outline-variant bg-surface-container-low text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none @error('password', 'updatePassword') border-error @enderror" id="update_password_password" name="password" type="password" autocomplete="new-password" placeholder="••••••••"/>
@error('password', 'updatePassword')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<div class="space-y-2">
<label class="font-label-md text-on-surface-variant" for="update_password_password_confirmation">Confirm Password</label>
<input class="w-full px-4 py-2.5 rounded-lg border border-outline-variant bg-surface-container-low text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" placeholder="••••••••"/>
</div>
</div>
</div>
<div class="flex items-center gap-4 pt-4 mt-4 border-t border-outline-variant/30">
<button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-on-primary font-label-md hover:opacity-90 active:scale-95 transition-all">Update Password</button>
@if (session('status') === 'password-updated')
<span class="text-sm text-secondary font-medium">Saved.</span>
@endif
</div>
</form>
</div>
</div>
<!-- Preferences & Subscription (Right Column) -->
<div class="col-span-12 lg:col-span-4 space-y-6">
<!-- Preferences -->
<div class="bg-white rounded-xl border border-outline-variant p-6 shadow-sm">
<h3 class="font-headline-md text-[20px] mb-6">Preferences</h3>
<div class="space-y-5">
<div class="flex items-center justify-between">
<div>
<p class="font-label-md text-on-surface">Dark Mode</p>
<p class="text-[12px] text-on-surface-variant">Adjust interface appearance</p>
</div>
<button class="w-12 h-6 rounded-full bg-outline-variant relative transition-colors">
<span class="absolute left-1 top-1 w-4 h-4 rounded-full bg-white transition-all"></span>
</button>
</div>
<div class="flex items-center justify-between">
<div>
<p class="font-label-md text-on-surface">Email Notifications</p>
<p class="text-[12px] text-on-surface-variant">Weekly study reminders</p>
</div>
<button class="w-12 h-6 rounded-full bg-primary relative transition-colors">
<span class="absolute right-1 top-1 w-4 h-4 rounded-full bg-white transition-all"></span>
</button>
</div>
<div class="flex items-center justify-between">
<div>
<p class="font-label-md text-on-surface">Public Profile</p>
<p class="text-[12px] text-on-surface-variant">Visible in community rankings</p>
</div>
<button class="w-12 h-6 rounded-full bg-primary relative transition-colors">
<span class="absolute right-1 top-1 w-4 h-4 rounded-full bg-white transition-all"></span>
</button>
</div>
</div>
</div>
<!-- Subscription & Usage -->
<div class="bg-primary text-on-primary rounded-xl p-6 shadow-lg relative overflow-hidden">
<div class="absolute -right-10 -bottom-10 w-40 h-40 bg-on-primary/10 rounded-full blur-3xl"></div>
<div class="relative z-10">
<div class="flex items-center justify-between mb-4">
<span class="px-3 py-1 bg-on-primary/20 rounded-full text-[12px] font-bold uppercase tracking-widest">Pro Member</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
<h3 class="text-headline-md mb-1">$29.00 <span class="text-sm font-normal">/ month</span></h3>
<p class="text-on-primary-container text-sm mb-6">Next billing: {{ now()->addMonth()->format('M d, Y') }}</p>
<div class="space-y-2 mb-6">
<div class="flex justify-between text-xs font-medium">
<span>AI Generations Usage</span>
<span>742 / 1000</span>
</div>
<div class="w-full h-2 bg-on-primary/20 rounded-full overflow-hidden">
<div class="h-full bg-secondary-fixed w-[74.2%] rounded-full"></div>
</div>
</div>
<button class="w-full py-2.5 bg-white text-primary font-bold rounded-lg text-sm hover:bg-surface-container transition-all active:scale-95">
                                Manage Subscription
                            </button>
</div>
</div>
<!-- Quick Stats -->
<div class="bg-surface-container-low rounded-xl border border-outline-variant border-dashed p-6">
<p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider mb-4">Quick Stats</p>
<div class="grid grid-cols-2 gap-4">
<div>
<p class="text-headline-md text-on-surface">124</p>
<p class="text-[12px] text-on-surface-variant">Concepts Mastered</p>
</div>
<div>
<p class="text-headline-md text-on-surface">89%</p>
<p class="text-[12px] text-on-surface-variant">Success Rate</p>
</div>
</div>
</div>
</div>
<!-- Danger Zone (Full Width Bottom) -->
<div class="col-span-12">
<div class="bg-error-container/20 border border-error/20 rounded-xl p-6">
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
<div class="flex items-start gap-4">
<div class="w-12 h-12 rounded-full bg-error/10 flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-error">warning</span>
</div>
<div>
<h3 class="font-bold text-on-surface">Danger Zone</h3>
<p class="text-on-surface-variant text-sm">Deleting your account is permanent. All your interview prep history, custom concepts, and AI settings will be wiped instantly.</p>
</div>
</div>
<button onclick="document.getElementById('delete-account-modal').classList.remove('hidden')" class="px-6 py-2.5 bg-error text-on-error rounded-xl font-medium text-sm hover:opacity-90 active:scale-95 transition-all">
                                Delete Account
                            </button>
</div>
</div>
</div>
</div>
</div>
</main>
<!-- Delete Account Modal -->
<div id="delete-account-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm">
<div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-8 shadow-2xl max-w-md w-full mx-4">
<div class="flex items-center gap-3 mb-6">
<div class="w-12 h-12 rounded-full bg-error/10 flex items-center justify-center">
<span class="material-symbols-outlined text-error text-2xl" style="font-variation-settings: 'FILL' 1;">warning</span>
</div>
<h3 class="font-headline-md text-on-surface">Delete Account</h3>
</div>
<p class="text-on-surface-variant text-sm mb-6">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.</p>

@if ($errors->userDeletion->isNotEmpty())
<div class="mb-4 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-lg text-sm">
<ul class="list-disc pl-4 space-y-1">
@foreach ($errors->userDeletion->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('profile.destroy') }}">
@csrf
@method('delete')
<div class="space-y-2 mb-6">
<label class="font-label-md text-on-surface-variant" for="delete-password">Password</label>
<input class="w-full px-4 py-2.5 rounded-lg border border-outline-variant bg-surface-container-low text-body-md focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" id="delete-password" name="password" type="password" placeholder="Enter your password to confirm"/>
</div>
<div class="flex gap-3 justify-end">
<button type="button" onclick="document.getElementById('delete-account-modal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl border border-outline-variant text-on-surface font-label-md hover:bg-surface-container transition-all">Cancel</button>
<button type="submit" class="px-5 py-2.5 rounded-xl bg-error text-on-error font-label-md hover:opacity-90 active:scale-95 transition-all">Delete Account</button>
</div>
</form>
</div>
</div>
<!-- Footer -->
<footer class="ml-64 px-8 pb-8">
<div class="max-w-container-max mx-auto border-t border-outline-variant/30 pt-8 flex justify-between items-center text-on-surface-variant text-[12px]">
<p>© 2024 InterviewPrep Laravel mastery Engine.</p>
<div class="flex gap-6">
<a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
<a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
<a class="hover:text-primary transition-colors" href="#">API Docs</a>
</div>
</div>
</footer>
</body></html>
