<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Verify Email | InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        primary: '#0077B6', 'primary-dark': '#005F8F', 'primary-light': '#00B4D8',
        secondary: '#00A896', error: '#E63946', surface: '#FFFFFF', background: '#F8FBFF',
        'on-surface': '#1A1A2E', 'on-surface-variant': '#546E7A', outline: '#CFD8DC', 'outline-variant': '#E8EDF2',
      },
      fontFamily: { sans: ['Inter', 'sans-serif'] }
    }
  }
}
</script>
<style>.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }</style>
</head>
<body class="bg-background font-sans text-on-surface min-h-screen flex items-center justify-center p-6">
<main class="w-full max-w-sm">
<div class="flex flex-col items-center mb-6">
<div class="w-12 h-12 bg-primary/10 flex items-center justify-center rounded-xl mb-3">
<span class="material-symbols-outlined text-primary text-[24px]">mail</span>
</div>
<h1 class="text-[18px] font-bold text-on-surface">InterviewPrep</h1>
</div>
<div class="bg-white border border-outline-variant/50 rounded-xl p-5">
<div class="text-center mb-4">
<h2 class="text-[16px] font-semibold text-on-surface mb-1">Verify your email</h2>
<p class="text-[13px] text-on-surface-variant/60">Click the link we sent to your email to verify your account.</p>
</div>
@if (session('status') == 'verification-link-sent')
<div class="mb-3 p-2 bg-secondary/5 border border-secondary/20 text-secondary rounded-lg text-[12px] text-center">
Verification link sent! Check your inbox.
</div>
@endif
<div class="space-y-2">
<form method="POST" action="{{ route('verification.send') }}">
@csrf
<button class="w-full h-9 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all" type="submit">Resend Email</button>
</form>
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="w-full h-9 border border-outline-variant text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container transition-all">Log Out</button>
</form>
</div>
</div>
</main>
</body>
</html>
