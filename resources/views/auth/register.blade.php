<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Sign Up - InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Geist:wght@400;500;600&amp;family=JetBrains+Mono:wght@400&amp;display=swap" rel="stylesheet"/>
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
        }
        body {
            background-color: #f9f9ff;
        }
    </style>
</head>
<body class="font-body-md text-on-surface">
<main class="min-h-screen flex flex-col md:flex-row">
<!-- Left Side: Branding & Benefits -->
<section class="hidden md:flex md:w-1/2 bg-primary relative overflow-hidden p-12 flex-col justify-between">
<!-- Decorative Background Element -->
<div class="absolute top-0 right-0 w-full h-full opacity-10 pointer-events-none">
<img alt="Cybersecurity grid" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBPo1_OT4r6zmr0dS9qjqUQ2a6x8aZ2Rti3VDNqJiblHK7fdcd92tV67hhXDD2D5cfbiaUZPlQTy8ELmZIjLjtPgXDuE5nCJ-iTMbD0rqykhtV6bdCuzzGIaobsnM1HqBI-VW4RRvkKqQUCk9fR0lZYe0gx49zF-ibDfbw5_kgbBscHKJB_HL9tsQKDCF5AYMTJvFTdeQErq3nsiKyONEkGbF4lNp6vHg-qbhv6WediR74ng5_646rqia6w3W9UOLLC5Te9JxtwRSI"/>
</div>
<div class="relative z-10">
<div class="flex items-center gap-2 mb-12">
<span class="material-symbols-outlined text-on-primary-container text-4xl" data-icon="terminal">terminal</span>
<h1 class="font-display text-headline-md text-white tracking-tight">InterviewPrep</h1>
</div>
<div class="space-y-12 max-w-lg">
<h2 class="font-display text-display text-white leading-tight">Master the technical interview with precision.</h2>
<ul class="space-y-8">
<li class="flex items-start gap-4">
<div class="mt-1 w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-primary-fixed-dim" data-icon="account_tree">account_tree</span>
</div>
<div>
<h3 class="font-headline-md text-white text-body-lg mb-1">Organize Domains</h3>
<p class="text-on-primary-container/80 text-body-md">Structure your knowledge into logical domains. Keep track of Laravel, System Design, and more in a unified dashboard.</p>
</div>
</li>
<li class="flex items-start gap-4">
<div class="mt-1 w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-primary-fixed-dim" data-icon="monitoring">monitoring</span>
</div>
<div>
<h3 class="font-headline-md text-white text-body-lg mb-1">Track Mastery</h3>
<p class="text-on-primary-container/80 text-body-md">Visual progress indicators for every concept. Move from 'À revoir' to 'Maîtrisé' with data-driven confidence.</p>
</div>
</li>
<li class="flex items-start gap-4">
<div class="mt-1 w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
<span class="material-symbols-outlined text-primary-fixed-dim" data-icon="psychology">psychology</span>
</div>
<div>
<h3 class="font-headline-md text-white text-body-lg mb-1">Generate AI Questions</h3>
<p class="text-on-primary-container/80 text-body-md">Leverage advanced LLMs to generate tailored interview questions based on your specific curriculum and seniority level.</p>
</div>
</li>
</ul>
</div>
</div>
<div class="relative z-10 p-6 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10">
<p class="text-on-primary-container italic font-body-md mb-4">"I structure my knowledge manually with concepts, track my progress, and generate AI interview questions to prepare with confidence."</p>
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
<span class="material-symbols-outlined text-primary-fixed-dim">person</span>
</div>
<div>
<p class="text-white font-label-md">You</p>
<p class="text-on-primary-container/60 text-xs">Start your journey</p>
</div>
</div>
</div>
</section>
<!-- Right Side: Registration Form -->
<section class="flex-1 flex flex-col items-center justify-center p-6 md:p-12 lg:p-24 bg-surface">
<div class="w-full max-w-md">
<div class="mb-10">
<h2 class="font-headline-lg text-on-surface mb-2">Create your account</h2>
<p class="text-on-surface-variant text-body-md">Start mastering your technical interview preparation.</p>
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

<form method="POST" action="{{ route('register') }}" class="space-y-6">
@csrf
<!-- Full Name -->
<div class="space-y-2">
<label class="block font-label-md text-on-surface-variant" for="name">Full Name</label>
<div class="relative">
<input class="w-full px-4 py-3 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-body-md placeholder:text-outline @error('name') border-error @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" type="text" required autofocus autocomplete="name"/>
</div>
@error('name')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<!-- Email -->
<div class="space-y-2">
<label class="block font-label-md text-on-surface-variant" for="email">Work Email</label>
<div class="relative">
<input class="w-full px-4 py-3 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-body-md placeholder:text-outline @error('email') border-error @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="john@company.com" type="email" required autocomplete="username"/>
</div>
@error('email')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<!-- Password -->
<div class="space-y-2">
<label class="block font-label-md text-on-surface-variant" for="password">Password</label>
<div class="relative">
<input class="w-full px-4 py-3 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-body-md placeholder:text-outline @error('password') border-error @enderror" id="password" name="password" placeholder="••••••••" type="password" required autocomplete="new-password"/>
                              <button onclick="var p=document.getElementById('password');p.type=p.type==='password'?'text':'password';this.querySelector('span').textContent=p.type==='password'?'visibility':'visibility_off'" class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface" type="button">
                                        <span class="material-symbols-outlined" data-icon="visibility">visibility</span>
                                    </button>
</div>
@error('password')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<!-- Password Confirmation -->
<div class="space-y-2">
<label class="block font-label-md text-on-surface-variant" for="password_confirmation">Confirm Password</label>
<div class="relative">
<input class="w-full px-4 py-3 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-body-md placeholder:text-outline @error('password_confirmation') border-error @enderror" id="password_confirmation" name="password_confirmation" placeholder="••••••••" type="password" required autocomplete="new-password"/>
</div>
</div>
<!-- Submit Button -->
<button class="w-full py-4 bg-primary text-white font-label-md rounded-lg shadow-sm hover:bg-primary/90 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                        Create Account
                        <span class="material-symbols-outlined text-lg" data-icon="arrow_forward">arrow_forward</span>
</button>
</form>
<!-- Alternative Sign Up -->
<div class="mt-8 space-y-6">
<div class="relative">
<div class="absolute inset-0 flex items-center">
<div class="w-full border-t border-outline-variant"></div>
</div>
<div class="relative flex justify-center text-sm">
<span class="px-2 bg-surface text-on-surface-variant font-label-md">Or continue with</span>
</div>
</div>
<div class="grid grid-cols-2 gap-4">
<button class="flex items-center justify-center gap-2 py-3 px-4 border border-outline-variant rounded-lg hover:bg-surface-container-low transition-colors font-label-md">
<img alt="Google" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCC8O33megz2OAJm-dE3JcNg6pCCPqaF5SEF9T0Z10N6FrHmgu9pdFwiAADPRBLB-_4tx1Ffqfb0_Y-a31VlFq0yy5eBpIC_IWCyxT19yOepc3TSwZAvohOZQxO7s7s8ijKSTuLe6VFckXhQouhGEYvjmVYq15teuWZke5lxuTq5DA2Vs3P2mfNW1kj8hshQtaYSQN-W7A6BznMlvkcE-ZZ-IbG3erdI_V0l7_VWzGFySbFuJSrPw_cmfgzKQlPkiHvp5qSx-qEtVw"/>
                            Google
                        </button>
<button class="flex items-center justify-center gap-2 py-3 px-4 border border-outline-variant rounded-lg hover:bg-surface-container-low transition-colors font-label-md">
<svg class="w-5 h-5" fill="currentColor" viewbox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"></path></svg>
                            GitHub
                        </button>
</div>
</div>
<p class="mt-10 text-center text-body-md text-on-surface-variant">
                    Already have an account? 
                    <a class="text-primary font-bold hover:underline" href="{{ route('login') }}">Sign In</a>
</p>
</div>
</section>
</main>
</body></html>
