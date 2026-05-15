<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Sign In - InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary: '#0077B6',
        'primary-dark': '#005F8F',
        'primary-light': '#00B4D8',
        secondary: '#00A896',
        error: '#E63946',
        surface: '#FFFFFF',
        background: '#F8FBFF',
        'on-surface': '#1A1A2E',
        'on-surface-variant': '#546E7A',
        outline: '#CFD8DC',
        'outline-variant': '#E8EDF2',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      }
    }
  }
}
</script>
<style>
.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>
</head>
<body class="bg-background font-sans text-on-surface">
<main class="min-h-screen flex">
<section class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary to-primary-light items-center justify-center p-16 relative overflow-hidden">
<div class="absolute inset-0 opacity-10">
<svg class="w-full h-full" viewBox="0 0 800 600" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="400" cy="300" r="200" stroke="white" stroke-width="0.5"/>
<circle cx="400" cy="300" r="150" stroke="white" stroke-width="0.5"/>
<circle cx="400" cy="300" r="100" stroke="white" stroke-width="0.5"/>
<circle cx="400" cy="300" r="50" stroke="white" stroke-width="0.5"/>
</svg>
</div>
<div class="relative z-10 text-white max-w-md">
<div class="flex items-center gap-2.5 mb-8">
<div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[20px]" style="font-variation-settings: 'FILL' 1;">school</span>
</div>
<span class="text-[18px] font-bold">InterviewPrep</span>
</div>
<h1 class="text-[32px] font-bold leading-tight mb-4">Master your technical interviews</h1>
<p class="text-white/70 text-[14px] leading-relaxed">Organize your knowledge, track your progress, and generate AI-powered practice questions.</p>
</div>
</section>
<section class="w-full lg:w-1/2 flex items-center justify-center p-6 md:p-12 bg-surface">
<div class="w-full max-w-sm">
<div class="lg:hidden flex items-center gap-2.5 mb-8">
<div class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings: 'FILL' 1;">school</span>
</div>
<span class="text-[16px] font-bold text-primary">InterviewPrep</span>
</div>
<h2 class="text-[24px] font-bold text-on-surface mb-1">Welcome back</h2>
<p class="text-[13px] text-on-surface-variant mb-6">Sign in to continue your preparation</p>

@if (session('status'))
<div class="mb-4 p-3 bg-secondary/5 border border-secondary/20 text-secondary rounded-lg text-[13px] flex items-center gap-2">
<span class="material-symbols-outlined text-[16px]">check_circle</span>{{ session('status') }}
</div>
@endif
@if ($errors->any())
<div class="mb-4 p-3 bg-error/5 border border-error/20 text-error rounded-lg text-[13px]">
<ul class="list-disc pl-4 space-y-0.5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-4">
@csrf
<div>
<label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="email">Email</label>
<input class="w-full h-10 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all placeholder:text-on-surface-variant/30 @error('email') border-error @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@company.com"/>
@error('email')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
</div>
<div>
<div class="flex justify-between mb-1.5">
<label class="text-[13px] font-medium text-on-surface" for="password">Password</label>
<a class="text-[12px] text-primary hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
</div>
<input class="w-full h-10 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all placeholder:text-on-surface-variant/30 @error('password') border-error @enderror" id="password" name="password" placeholder="••••••••" required type="password" autocomplete="current-password"/>
@error('password')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
</div>
<div class="flex items-center gap-2">
<input class="h-4 w-4 rounded border-outline-variant/60 text-primary focus:ring-primary/20" id="remember" name="remember" type="checkbox"/>
<label class="text-[12px] text-on-surface-variant" for="remember">Keep me signed in</label>
</div>
<button class="w-full h-10 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all" type="submit">Sign In</button>
</form>
<p class="mt-6 text-center text-[13px] text-on-surface-variant">
Don't have an account? <a class="text-primary font-medium hover:underline" href="{{ route('register') }}">Sign up</a>
</p>
</div>
</section>
</main>
</body>
</html>
