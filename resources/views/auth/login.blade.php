<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Sign In - InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=JetBrains+Mono:wght@400&amp;family=Geist:wght@500&amp;display=swap" rel="stylesheet"/>
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
        .auth-card {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface">
<main class="min-h-screen flex">
<!-- Left Section: Visual Narrative -->
<section class="hidden lg:flex lg:w-1/2 relative bg-primary-container overflow-hidden items-center justify-center p-16">
<div class="absolute inset-0 z-0">
<img alt="Abstract technical background" class="w-full h-full object-cover mix-blend-overlay opacity-30" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDyT_ReNZKVQpkrUcdfa3G0PK54Tpy6wZb-gXPtevJp3OCJgYeN_-c4pn1s8ZUDa2at7yn_7QCYzoBRZUBzml9vNqSQoqwzg_X1N974-3uKtKU86G48o4Udm1C-H6Z1K-suEEqf_uEeFg5OdnNF4okl6GqlRRoNglt5GjofATKbBSYJPQYxwAUM25kSjocpy_AXxjJ7XOZCDY2aENT3Y7B_8KuWipt_8qHkfvBwmqfYfBbKmle7lw4nKZTW2-xIdBs3Fbi4-Bh3qOk"/>
</div>
<div class="relative z-10 max-w-lg">
<div class="mb-12">
<span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary-container/20 text-secondary-fixed font-label-md text-label-md mb-6">
<span class="material-symbols-outlined text-sm">terminal</span>
                        Engineered Mastery
                    </span>
<h1 class="font-display text-display text-white mb-6">Master your technical narrative.</h1>
<p class="font-body-lg text-body-lg text-on-primary-container">
                        The systematic approach to acing top-tier engineering interviews. Join the community of Laravel experts and software architects.
                    </p>
</div>
<div class="grid grid-cols-2 gap-gutter">
<div class="p-6 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
<p class="font-headline-md text-headline-md text-secondary-fixed mb-1">2.4k+</p>
<p class="font-label-md text-label-md text-on-primary-container">Curated Challenges</p>
</div>
<div class="p-6 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
<p class="font-headline-md text-headline-md text-secondary-fixed mb-1">98%</p>
<p class="font-label-md text-label-md text-on-primary-container">Placement Rate</p>
</div>
</div>
</div>
<!-- Bottom Left Logo Branding -->
<div class="absolute bottom-8 left-8 flex items-center gap-2">
<div class="w-8 h-8 bg-secondary rounded flex items-center justify-center">
<span class="material-symbols-outlined text-white text-lg">code</span>
</div>
<span class="font-display font-bold text-headline-sm text-white">InterviewPrep</span>
</div>
</section>
<!-- Right Section: Login Form -->
<section class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 bg-surface">
<div class="w-full max-w-md">
<div class="mb-10 text-center lg:text-left">
<div class="lg:hidden flex justify-center mb-8">
<div class="flex items-center gap-2">
<div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
<span class="material-symbols-outlined text-white">code</span>
</div>
<span class="font-display font-bold text-headline-md text-primary">InterviewPrep</span>
</div>
</div>
<h2 class="font-headline-lg text-headline-lg text-on-surface mb-2">Welcome back</h2>
<p class="font-body-md text-body-md text-on-surface-variant">Please enter your details to sign in.</p>
</div>

@if (session('status'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
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

<!-- Social Logins -->
<div class="grid grid-cols-2 gap-4 mb-8">
<button class="flex items-center justify-center gap-3 px-4 py-3 rounded-lg border border-outline-variant bg-white font-label-md text-label-md text-on-surface hover:bg-surface-container-low transition-colors">
<img alt="Google" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDF-dVNJ5g1VjgrbLfLyoW3ioREMB5qDQAY2wTG3CmUVoKk0ABR_G2rXBjJuRS7A8EHWrIU76IdczjCjDBMHBM-wA0IXKcGJ62wPyp2FD-au6iMKYEd3rwQRErOX3tnt5Sm4v1R_WkZVVSHSjycuxwRQ1Cxq02LiVNGZEH5uqLn-AiXY3Vmp8w_OiIcLqmB1QWJTs9Hwydgji3ZNm6-A3YxanhGeOoOrOtEdA0e7lSfBOx59cxUhW1EiDG8JFlMv9zTE-lM68Gqpjk"/>
                        Google
                    </button>
<button class="flex items-center justify-center gap-3 px-4 py-3 rounded-lg border border-outline-variant bg-white font-label-md text-label-md text-on-surface hover:bg-surface-container-low transition-colors">
<img alt="GitHub" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBCtGqOFXQXrSUsxHTfSYYRf_Y4n_MHaOviCH0S1-LPTNuPp-vM8k31nnbzDDN1GVeHvXMjjDOUQjgg_1OZvP-EOkYfxp2jHU46dmg1IjfhiHwueGN6sfoPZJgvFJLEB3p3xQyfzFb6NDaDd1PWZeHSgV5udBz_YUKzvfx2ME9zIuR-eR1F2MJJAD9nqp5CNySwta8tQRSPdAwLoNefwx_hRvYSmlEwGpp2yJGCpZdgcUJTqloqA5xybJL0aOea_3kHXPHOmK2J2ME"/>
                        GitHub
                    </button>
</div>
<div class="relative mb-8">
<div class="absolute inset-0 flex items-center">
<div class="w-full border-t border-outline-variant"></div>
</div>
<div class="relative flex justify-center text-label-md">
<span class="bg-surface px-4 text-on-surface-variant">Or continue with email</span>
</div>
</div>
<form method="POST" action="{{ route('login') }}" class="space-y-6">
@csrf
<div>
<label class="block font-label-md text-label-md text-on-surface mb-2" for="email">Email address</label>
<input class="w-full px-4 py-3 rounded-lg border border-outline-variant bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-body-md text-body-md @error('email') border-error @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@company.com"/>
@error('email')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<div>
<div class="flex justify-between mb-2">
<label class="block font-label-md text-label-md text-on-surface" for="password">Password</label>
<a class="font-label-md text-label-md text-primary hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
</div>
<div class="relative">
<input class="w-full px-4 py-3 rounded-lg border border-outline-variant bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-body-md text-body-md @error('password') border-error @enderror" id="password" name="password" placeholder="••••••••" required="" type="password" autocomplete="current-password"/>
                              <button onclick="var p=document.getElementById('password');p.type=p.type==='password'?'text':'password';this.querySelector('span').textContent=p.type==='password'?'visibility':'visibility_off'" class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors" type="button">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </button>
</div>
@error('password')
<p class="mt-1 text-sm text-error">{{ $message }}</p>
@enderror
</div>
<div class="flex items-center">
<input class="h-4 w-4 rounded border-outline-variant text-primary focus:ring-primary" id="remember" name="remember" type="checkbox"/>
<label class="ml-3 block font-body-md text-label-md text-on-surface-variant" for="remember">
                            Keep me signed in for 30 days
                        </label>
</div>
<button class="w-full bg-primary text-white font-label-md text-label-md py-4 rounded-lg hover:bg-primary-container hover:shadow-lg active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                        Sign In
                        <span class="material-symbols-outlined">arrow_forward</span>
</button>
</form>
<p class="mt-8 text-center font-body-md text-body-md text-on-surface-variant">
                    Don't have an account? 
                    <a class="text-secondary font-bold hover:underline" href="{{ route('register') }}">Sign up for free</a>
</p>
<!-- Footer Links -->
<div class="mt-16 flex justify-center gap-6 font-label-md text-label-md text-on-surface-variant">
<a class="hover:text-primary" href="#">Privacy Policy</a>
<a class="hover:text-primary" href="#">Terms of Service</a>
<a class="hover:text-primary" href="#">Help Center</a>
</div>
</div>
</section>
</main>
</body></html>
