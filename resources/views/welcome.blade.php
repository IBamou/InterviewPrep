<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>InterviewPrep - Master the Technical Interview</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
<body class="bg-background font-sans text-on-surface">
<header class="fixed top-0 w-full z-50 flex items-center justify-between px-6 md:px-12 h-14 bg-white/80 backdrop-blur-md border-b border-outline-variant/50">
<div class="flex items-center gap-2.5">
<div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings: 'FILL' 1;">school</span>
</div>
<span class="text-[16px] font-bold text-on-surface">InterviewPrep</span>
</div>
<nav class="hidden md:flex items-center gap-6">
<a class="text-[13px] text-on-surface-variant hover:text-primary transition-colors" href="#features">Features</a>
<a class="text-[13px] text-on-surface-variant hover:text-primary transition-colors" href="#how-it-works">How it works</a>
</nav>
<div class="flex items-center gap-3">
@guest
<a href="{{ route('login') }}" class="text-[13px] text-on-surface-variant hover:text-primary transition-colors">Log In</a>
<a href="{{ route('register') }}" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">Get Started</a>
@else
<a href="{{ url('/dashboard') }}" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">Dashboard</a>
@endguest
</div>
</header>
<main class="pt-14">
<section class="relative overflow-hidden py-20 md:py-28 bg-white">
<div class="max-w-5xl mx-auto px-6 md:px-12 grid md:grid-cols-2 gap-12 items-center">
<div class="relative z-10">
<span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[12px] font-medium mb-4">STRUCTURED INTERVIEW PREP</span>
<h1 class="text-[36px] md:text-[44px] font-bold text-on-surface mb-4 leading-tight">Master the <span class="text-primary">Technical Interview.</span></h1>
<p class="text-[14px] text-on-surface-variant mb-8 max-w-md leading-relaxed">Structure your knowledge, track progress, and generate AI-powered interview questions to ace your next role.</p>
<div class="flex gap-3">
<a href="{{ route('register') }}" class="px-5 py-2.5 bg-primary text-white rounded-lg text-[14px] font-medium hover:bg-primary/90 transition-all shadow-lg shadow-primary/10">Get Started</a>
<a href="#features" class="px-5 py-2.5 border border-outline-variant text-on-surface-variant rounded-lg text-[14px] font-medium hover:bg-surface-container transition-all">Learn More</a>
</div>
</div>
<div class="relative">
<div class="absolute -top-16 -right-16 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
<div class="relative bg-[#1A1A2E] rounded-xl p-4 shadow-xl overflow-hidden">
<div class="flex items-center gap-2 mb-3 border-b border-white/10 pb-2">
<div class="w-2.5 h-2.5 rounded-full bg-error/60"></div>
<div class="w-2.5 h-2.5 rounded-full bg-amber-500/60"></div>
<div class="w-2.5 h-2.5 rounded-full bg-secondary/60"></div>
<div class="ml-auto text-[11px] text-white/30">engine.php</div>
</div>
<pre class="text-[12px] leading-relaxed text-white/80"><code><span class="text-secondary">class</span> <span class="text-primary-light">InterviewEngine</span> {
    <span class="text-secondary">public function</span> <span class="text-primary-light">generateMastery</span>($topic) {
        <span class="text-secondary">return</span> <span class="text-primary-light">AI</span>::<span class="text-primary-light">structure</span>($topic)
            -><span class="text-primary-light">withConcepts</span>()
            -><span class="text-primary-light">withChallenges</span>();
    }
}</code></pre>
</div>
<div class="absolute -bottom-4 -left-4 bg-white p-3 rounded-lg shadow-lg border border-outline-variant/50">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary text-[16px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span class="text-[12px] font-medium text-on-surface">Mastery: 84%</span>
</div>
<div class="w-24 bg-surface-container h-1 rounded-full mt-1.5">
<div class="bg-secondary h-full w-[84%] rounded-full"></div>
</div>
</div>
</div>
</div>
</section>
<section id="features" class="py-16 bg-surface-container/30">
<div class="max-w-5xl mx-auto px-6 md:px-12">
<div class="text-center mb-12">
<h2 class="text-[24px] font-bold text-on-surface mb-2">Precision-Engineered Preparation</h2>
<p class="text-[14px] text-on-surface-variant">Tools designed for the modern backend professional.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
<div class="md:col-span-2 bg-white p-6 rounded-xl border border-outline-variant/50">
<div class="flex flex-col md:flex-row gap-6 items-center">
<div class="flex-1">
<div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
<span class="material-symbols-outlined text-primary text-[20px]">neurology</span>
</div>
<h3 class="text-[16px] font-semibold text-on-surface mb-2">Manual Concept Tracking</h3>
<p class="text-[13px] text-on-surface-variant leading-relaxed">Define your own technical concepts with personal explanations. Build a custom knowledge base.</p>
</div>
<div class="flex-1 w-full bg-surface-container/50 h-32 rounded-lg overflow-hidden p-4 border border-outline-variant/30">
<div class="space-y-2">
<div class="h-2.5 bg-primary/10 rounded w-3/4"></div>
<div class="h-2.5 bg-primary/10 rounded w-full"></div>
<div class="h-2.5 bg-primary/10 rounded w-5/6"></div>
</div>
</div>
</div>
</div>
<div class="bg-white p-6 rounded-xl border border-outline-variant/50">
<div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center mb-3">
<span class="material-symbols-outlined text-primary text-[20px]">account_tree</span>
</div>
<h3 class="text-[16px] font-semibold text-on-surface mb-2">Domain Mastery</h3>
<p class="text-[13px] text-on-surface-variant mb-4 leading-relaxed">Organize preparation by Laravel, PHP, Architecture, and more.</p>
<div class="flex flex-wrap gap-1.5">
<span class="px-2 py-0.5 rounded bg-primary/5 text-primary text-[11px] font-medium">Laravel</span>
<span class="px-2 py-0.5 rounded bg-secondary/5 text-secondary text-[11px] font-medium">Redis</span>
<span class="px-2 py-0.5 rounded bg-surface-container text-on-surface-variant text-[11px] font-medium">Docker</span>
</div>
</div>
<div class="md:col-span-3 bg-gradient-to-r from-primary to-primary-light text-white p-6 rounded-xl flex flex-col md:flex-row items-center gap-6">
<div class="flex-1">
<h3 class="text-[18px] font-semibold mb-2">Progress Intelligence</h3>
<p class="text-[13px] text-white/70 leading-relaxed">Visualize your growth with dynamic mastery scores. Know exactly where you stand.</p>
</div>
<div class="flex gap-3">
<div class="bg-white/10 p-3 rounded-lg flex-1">
<div class="text-[20px] font-bold text-white">--</div>
<div class="text-[11px] text-white/60">Concepts Mastered</div>
</div>
<div class="bg-white/10 p-3 rounded-lg flex-1">
<div class="text-[20px] font-bold text-white">--</div>
<div class="text-[11px] text-white/60">AI Questions</div>
</div>
</div>
</div>
</div>
</div>
</section>
<section id="how-it-works" class="py-16 bg-white">
<div class="max-w-5xl mx-auto px-6 md:px-12">
<div class="text-center mb-12">
<h2 class="text-[24px] font-bold text-on-surface mb-2">Your Path to Mastery</h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-4 gap-8">
<div class="text-center">
<div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-3">
<span class="material-symbols-outlined text-primary text-[20px]">map</span>
</div>
<h4 class="text-[14px] font-semibold text-on-surface mb-1">1. Define Domains</h4>
<p class="text-[12px] text-on-surface-variant">Select the tech stacks you need to master.</p>
</div>
<div class="text-center">
<div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-3">
<span class="material-symbols-outlined text-primary text-[20px]">edit_note</span>
</div>
<h4 class="text-[14px] font-semibold text-on-surface mb-1">2. Create Concepts</h4>
<p class="text-[12px] text-on-surface-variant">Write explanations for each topic.</p>
</div>
<div class="text-center">
<div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-3">
<span class="material-symbols-outlined text-primary text-[20px]">auto_awesome</span>
</div>
<h4 class="text-[14px] font-semibold text-on-surface mb-1">3. Generate AI Questions</h4>
<p class="text-[12px] text-on-surface-variant">Practice with tailored interview questions.</p>
</div>
<div class="text-center">
<div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center mx-auto mb-3">
<span class="material-symbols-outlined text-white text-[20px]">celebration</span>
</div>
<h4 class="text-[14px] font-semibold text-on-surface mb-1">4. Land the Job</h4>
<p class="text-[12px] text-on-surface-variant">Approach interviews with confidence.</p>
</div>
</div>
</div>
</section>
<section class="py-16 bg-gradient-to-br from-primary to-primary-light text-white relative overflow-hidden">
<div class="absolute inset-0 opacity-10">
<svg class="w-full h-full" viewBox="0 0 800 400" fill="none"><circle cx="400" cy="200" r="150" stroke="white" stroke-width="0.5"/><circle cx="400" cy="200" r="100" stroke="white" stroke-width="0.5"/></svg>
</div>
<div class="max-w-2xl mx-auto px-6 md:px-12 text-center relative z-10">
<h2 class="text-[28px] font-bold mb-3">Ready to ace your next round?</h2>
<p class="text-[14px] text-white/70 mb-6">Start building your structured interview preparation today.</p>
<a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 bg-white text-primary px-5 py-2.5 rounded-lg text-[14px] font-medium hover:bg-white/90 transition-all">
Start Free
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</a>
</div>
</section>
</main>
<footer class="py-6 px-6 md:px-12 flex flex-col md:flex-row justify-between items-center gap-4 bg-white border-t border-outline-variant/30">
<div class="flex items-center gap-2">
<div class="w-6 h-6 rounded bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[14px]" style="font-variation-settings: 'FILL' 1;">school</span>
</div>
<span class="text-[13px] font-medium text-on-surface-variant">© 2026 InterviewPrep</span>
</div>
<div class="flex gap-4">
<a class="text-[12px] text-on-surface-variant/60 hover:text-primary transition-colors" href="#">Privacy</a>
<a class="text-[12px] text-on-surface-variant/60 hover:text-primary transition-colors" href="#">Terms</a>
</div>
</footer>
</body>
</html>
