<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Verify Email | InterviewPrep</title>
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
                    "surface-container-high": "#e2e8f8",
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
<div class="mb-stack-lg flex flex-col items-center">
<div class="w-12 h-12 bg-primary flex items-center justify-center rounded-xl mb-4 shadow-sm">
<span class="material-symbols-outlined text-on-primary text-2xl">mail</span>
</div>
<h1 class="font-display text-headline-md text-primary">InterviewPrep</h1>
</div>
<div class="w-full bg-surface-container-lowest border border-outline-variant rounded-xl p-8 shadow-sm">
<div class="text-center mb-stack-lg">
<h2 class="font-headline-md text-on-surface mb-2">Verify your email</h2>
<p class="font-body-md text-on-surface-variant">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
            </p>
</div>

@if (session('status') == 'verification-link-sent')
<div class="mb-6 p-4 bg-secondary-container/30 border border-secondary/20 text-on-secondary-container rounded-lg text-sm text-center">
                A new verification link has been sent to the email address you provided during registration.
            </div>
@endif

<div class="flex items-center justify-between gap-4">
<form method="POST" action="{{ route('verification.send') }}" class="flex-1">
@csrf
<button class="w-full bg-primary text-on-primary font-label-md text-label-md py-3 rounded-lg hover:opacity-90 active:scale-[0.98] transition-all shadow-sm" type="submit">
                    Resend Verification Email
                </button>
</form>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="w-full font-label-md text-label-md text-on-surface-variant py-3 hover:text-primary transition-colors">
                    Log Out
                </button>
</form>
</div>
</div>
</main>
<div class="fixed top-0 left-0 w-full h-full -z-10 overflow-hidden pointer-events-none">
<div class="absolute -top-[10%] -right-[10%] w-[40%] h-[40%] bg-primary/5 rounded-full blur-[120px]"></div>
<div class="absolute -bottom-[10%] -left-[10%] w-[40%] h-[40%] bg-secondary/5 rounded-full blur-[120px]"></div>
</div>
</body></html>