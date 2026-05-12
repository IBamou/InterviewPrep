<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Reset Password | InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono&amp;family=Geist:wght@500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface": "#f9f9ff",
                    "on-error-container": "#93000a",
                    "on-primary-fixed": "#0f0069",
                    "inverse-on-surface": "#ebf1ff",
                    "outline": "#777587",
                    "on-secondary-fixed-variant": "#005236",
                    "tertiary-container": "#885500",
                    "tertiary-fixed": "#ffddb8",
                    "tertiary-fixed-dim": "#ffb95f",
                    "on-secondary-container": "#00714d",
                    "surface-variant": "#dce2f3",
                    "on-surface-variant": "#464555",
                    "primary-fixed-dim": "#c3c0ff",
                    "inverse-primary": "#c3c0ff",
                    "on-secondary": "#ffffff",
                    "surface-bright": "#f9f9ff",
                    "on-primary": "#ffffff",
                    "surface-container-lowest": "#ffffff",
                    "surface-container-low": "#f0f3ff",
                    "on-error": "#ffffff",
                    "surface-dim": "#d3daea",
                    "on-tertiary": "#ffffff",
                    "on-secondary-fixed": "#002113",
                    "on-tertiary-container": "#ffd4a4",
                    "primary": "#3525cd",
                    "secondary-container": "#6cf8bb",
                    "outline-variant": "#c7c4d8",
                    "on-primary-fixed-variant": "#3323cc",
                    "error": "#ba1a1a",
                    "primary-fixed": "#e2dfff",
                    "on-surface": "#151c27",
                    "surface-container-highest": "#dce2f3",
                    "surface-container-high": "#e2e8f8",
                    "on-tertiary-fixed-variant": "#653e00",
                    "background": "#f9f9ff",
                    "secondary": "#006c49",
                    "on-background": "#151c27",
                    "inverse-surface": "#2a313d",
                    "on-tertiary-fixed": "#2a1700",
                    "secondary-fixed-dim": "#4edea3",
                    "secondary-fixed": "#6ffbbe",
                    "tertiary": "#684000",
                    "error-container": "#ffdad6",
                    "surface-container": "#e7eefe",
                    "primary-container": "#4f46e5",
                    "on-primary-container": "#dad7ff",
                    "surface-tint": "#4d44e3"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "stack-sm": "0.5rem",
                    "container-max": "1280px",
                    "margin-x": "2rem",
                    "gutter": "1.5rem",
                    "stack-md": "1rem",
                    "stack-lg": "2rem"
            },
            "fontFamily": {
                    "headline-md": ["Inter"],
                    "display": ["Inter"],
                    "headline-lg": ["Inter"],
                    "body-lg": ["Inter"],
                    "code": ["JetBrains Mono"],
                    "body-md": ["Inter"],
                    "label-md": ["Geist"]
            },
            "fontSize": {
                    "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                    "display": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "code": ["14px", {"lineHeight": "22px", "fontWeight": "400"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
            line-height: 1;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md min-h-screen flex items-center justify-center p-margin-x">
<main class="w-full max-w-[440px] flex flex-col items-center">
<!-- Logo/Identity Anchor -->
<div class="mb-stack-lg flex flex-col items-center">
<div class="w-12 h-12 bg-primary flex items-center justify-center rounded-xl mb-4 shadow-sm">
<span class="material-symbols-outlined text-on-primary text-2xl">lock_reset</span>
</div>
<h1 class="font-display text-headline-md text-primary">InterviewPrep</h1>
</div>
<!-- Recovery Card -->
<div class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl p-8 shadow-sm">
<div class="text-center mb-stack-lg">
<h2 class="font-headline-md text-on-surface mb-2">Reset your password</h2>
<p class="font-body-md text-on-surface-variant">
                    Enter your email address and we'll send you a link to reset your password.
                </p>
</div>

@if (session('status'))
<div class="mb-6 p-4 bg-secondary-container/30 border border-secondary/20 text-on-secondary-container rounded-lg text-sm text-center">
{{ session('status') }}
</div>
@endif

@if ($errors->any())
<div class="mb-6 p-4 bg-error-container/20 border border-error/20 text-on-error-container rounded-lg text-sm">
<ul class="list-disc pl-4 space-y-1">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="space-y-6">
@csrf
<div class="flex flex-col gap-2">
<label class="font-label-md text-label-md text-on-surface-variant px-1" for="email">Email Address</label>
<div class="relative">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">mail</span>
<input class="w-full pl-10 pr-4 py-3 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all font-body-md placeholder:text-outline/50 @error('email') border-error @enderror" id="email" name="email" placeholder="name@company.com" required type="email" value="{{ old('email') }}" autofocus/>
</div>
@error('email')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<button class="w-full bg-primary text-on-primary font-label-md text-label-md py-3 rounded-lg hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2 shadow-sm" type="submit">
                    Send Reset Link
                    <span class="material-symbols-outlined text-[20px]" data-icon="arrow_forward">arrow_forward</span>
</button>
</form>
<div class="mt-stack-lg flex justify-center">
<a class="group flex items-center gap-1 font-label-md text-label-md text-primary hover:underline transition-all" href="{{ route('login') }}">
<span class="material-symbols-outlined text-[18px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    Back to Login
                </a>
</div>
</div>
<!-- Trust Footer -->
<div class="mt-stack-lg w-full">
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter opacity-60">
<div class="flex items-start gap-3 p-4 bg-surface-container-low rounded-lg border border-outline-variant/30">
<span class="material-symbols-outlined text-primary text-xl">security</span>
<div>
<p class="font-label-md text-label-md text-on-surface font-bold">Secure Recovery</p>
<p class="text-[12px] text-on-surface-variant">Encrypted reset tokens expire after 1 hour.</p>
</div>
</div>
<div class="flex items-start gap-3 p-4 bg-surface-container-low rounded-lg border border-outline-variant/30">
<span class="material-symbols-outlined text-primary text-xl">support_agent</span>
<div>
<p class="font-label-md text-label-md text-on-surface font-bold">Need Help?</p>
<p class="text-[12px] text-on-surface-variant">Contact our support team for manual verification.</p>
</div>
</div>
</div>
</div>
</main>
<!-- Background Decorative -->
<div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
<div class="absolute -top-[10%] -right-[10%] w-[40%] h-[40%] bg-primary/5 rounded-full blur-[120px]"></div>
<div class="absolute -bottom-[10%] -left-[10%] w-[40%] h-[40%] bg-secondary/5 rounded-full blur-[120px]"></div>
</div>
</body></html>
