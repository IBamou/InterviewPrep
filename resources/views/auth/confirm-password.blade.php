<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Confirm Password | InterviewPrep</title>
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
<span class="material-symbols-outlined text-primary text-[24px]">lock</span>
</div>
<h1 class="text-[18px] font-bold text-on-surface">InterviewPrep</h1>
</div>
<div class="bg-white border border-outline-variant/50 rounded-xl p-5">
<div class="text-center mb-4">
<h2 class="text-[16px] font-semibold text-on-surface mb-1">Confirm your password</h2>
<p class="text-[13px] text-on-surface-variant/60">Please confirm your password before continuing.</p>
</div>
@if ($errors->any())
<div class="mb-3 p-2 bg-error/5 border border-error/20 text-error rounded-lg text-[12px]">
<ul class="list-disc pl-4 space-y-0.5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif
<form method="POST" action="{{ route('password.confirm') }}" class="space-y-3">
@csrf
<div>
<label class="text-[13px] font-medium text-on-surface mb-1.5 block" for="password">Password</label>
<input class="w-full h-9 px-3 rounded-lg border border-outline-variant/60 text-[13px] focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none transition-all @error('password') border-error @enderror" id="password" name="password" type="password" required autocomplete="current-password"/>
@error('password')<p class="mt-1 text-[12px] text-error">{{ $message }}</p>@enderror
</div>
<button class="w-full h-9 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all" type="submit">Confirm</button>
</form>
</div>
</main>
</body>
</html>
