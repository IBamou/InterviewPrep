<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>InterviewPrep - Master the Technical Interview</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;family=JetBrains+Mono&amp;family=Geist:wght@400;500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9f9ff;
        }
    </style>
<script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "surface-tint": "#4d44e3",
                      "surface-container-high": "#e2e8f8",
                      "tertiary-fixed": "#ffddb8",
                      "on-tertiary-fixed-variant": "#653e00",
                      "tertiary": "#684000",
                      "on-primary-container": "#dad7ff",
                      "on-secondary-fixed": "#002113",
                      "secondary-fixed": "#6ffbbe",
                      "outline": "#777587",
                      "inverse-surface": "#2a313d",
                      "on-tertiary-fixed": "#2a1700",
                      "primary-container": "#4f46e5",
                      "on-tertiary-container": "#ffd4a4",
                      "on-surface-variant": "#464555",
                      "on-primary-fixed": "#0f0069",
                      "surface-dim": "#d3daea",
                      "primary-fixed-dim": "#c3c0ff",
                      "surface-container-low": "#f0f3ff",
                      "surface-variant": "#dce2f3",
                      "on-secondary-fixed-variant": "#005236",
                      "on-secondary-container": "#00714d",
                      "on-secondary": "#ffffff",
                      "secondary-fixed-dim": "#4edea3",
                      "primary": "#3525cd",
                      "on-error": "#ffffff",
                      "on-background": "#151c27",
                      "error-container": "#ffdad6",
                      "surface-container": "#e7eefe",
                      "surface-container-highest": "#dce2f3",
                      "on-primary-fixed-variant": "#3323cc",
                      "surface-container-lowest": "#ffffff",
                      "secondary": "#006c49",
                      "inverse-primary": "#c3c0ff",
                      "surface": "#f9f9ff",
                      "inverse-on-surface": "#ebf1ff",
                      "on-primary": "#ffffff",
                      "on-error-container": "#93000a",
                      "background": "#f9f9ff",
                      "outline-variant": "#c7c4d8",
                      "primary-fixed": "#e2dfff",
                      "on-surface": "#151c27",
                      "surface-bright": "#f9f9ff",
                      "on-tertiary": "#ffffff",
                      "secondary-container": "#6cf8bb",
                      "tertiary-fixed-dim": "#ffb95f",
                      "tertiary-container": "#885500",
                      "error": "#ba1a1a"
              },
              "borderRadius": {
                      "DEFAULT": "0.25rem",
                      "lg": "0.5rem",
                      "xl": "0.75rem",
                      "full": "9999px"
              },
              "spacing": {
                      "stack-md": "1rem",
                      "margin-x": "2rem",
                      "gutter": "1.5rem",
                      "stack-sm": "0.5rem",
                      "stack-lg": "2rem",
                      "container-max": "1280px"
              },
              "fontFamily": {
                      "display": ["Inter"],
                      "code": ["JetBrains Mono"],
                      "label-md": ["Geist"],
                      "headline-md": ["Inter"],
                      "headline-lg": ["Inter"],
                      "body-lg": ["Inter"],
                      "body-md": ["Inter"]
              },
              "fontSize": {
                      "display": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                      "code": ["14px", {"lineHeight": "22px", "fontWeight": "400"}],
                      "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],
                      "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                      "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                      "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                      "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
              }
            },
          },
        }
    </script>
</head>
<body class="bg-surface text-on-surface">
<!-- TopNavBar -->
<header class="fixed top-0 w-full z-50 flex items-center justify-between px-margin-x h-16 max-w-container-max mx-auto bg-surface dark:bg-background border-b border-outline-variant dark:border-outline shadow-sm">
<div class="flex items-center gap-8">
<span class="font-display text-headline-md font-bold text-primary dark:text-primary-fixed-dim">InterviewPrep</span>
<nav class="hidden md:flex items-center gap-6">
<a class="font-body-md text-body-md text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim transition-colors duration-200" href="#">Features</a>
<a class="font-body-md text-body-md text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim transition-colors duration-200" href="#">Curriculum</a>
<a class="font-body-md text-body-md text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim transition-colors duration-200" href="#">Pricing</a>
<a class="font-body-md text-body-md text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim transition-colors duration-200" href="#">Documentation</a>
</nav>
</div>
<div class="flex items-center gap-4">
@guest
<a href="{{ route('login') }}" class="font-label-md text-label-md text-primary dark:text-primary-fixed-dim active:scale-95 transition-transform duration-150">Log In</a>
<a href="{{ route('register') }}" class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-md text-label-md active:scale-95 transition-transform duration-150">Get Started</a>
@else
<a href="{{ url('/dashboard') }}" class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-md text-label-md active:scale-95 transition-transform duration-150">Dashboard</a>
@endguest
</div>
</header>
<main class="pt-16">
<!-- Hero Section -->
<section class="relative overflow-hidden py-24 md:py-32 bg-surface">
<div class="max-w-container-max mx-auto px-margin-x grid md:grid-cols-2 gap-12 items-center">
<div class="relative z-10">
<span class="inline-block px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed-variant font-label-md text-[12px] mb-6">NEW: AI MOCK INTERVIEWS</span>
<h1 class="font-display text-display text-on-surface mb-6 leading-tight">Master the <span class="text-primary">Technical Interview.</span></h1>
<p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-lg">The AI-powered workspace to structure your knowledge, track progress, and ace your next Laravel or backend role.</p>
<div class="flex flex-wrap gap-4">
<a href="{{ route('register') }}" class="bg-primary text-on-primary px-8 py-4 rounded-xl font-headline-md active:scale-95 transition-transform duration-150 shadow-lg shadow-primary/20">Get Started for Free</a>
<a href="#" class="border border-outline-variant text-on-surface px-8 py-4 rounded-xl font-headline-md active:scale-95 transition-transform duration-150 hover:bg-surface-container-low">Watch Demo</a>
</div>
</div>
<div class="relative">
<div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
<div class="relative bg-inverse-surface rounded-2xl p-4 shadow-2xl overflow-hidden border border-outline/20">
<div class="flex items-center gap-2 mb-4 border-b border-outline/10 pb-2">
<div class="w-3 h-3 rounded-full bg-error/50"></div>
<div class="w-3 h-3 rounded-full bg-tertiary/50"></div>
<div class="w-3 h-3 rounded-full bg-secondary/50"></div>
<div class="ml-auto font-code text-[12px] text-surface-variant/50">auth_service.php</div>
</div>
<pre class="font-code text-primary-fixed-dim text-sm leading-relaxed"><code><span class="text-secondary-fixed">class</span> <span class="text-tertiary-fixed">InterviewEngine</span> {
    <span class="text-outline">/**
     * @param string $topic
     * @return Guide
     */</span>
    <span class="text-secondary-fixed">public function</span> <span class="text-primary-fixed">generateMastery</span>($topic) {
        <span class="text-secondary-fixed">return</span> <span class="text-primary-fixed">AI</span>::<span class="text-primary-fixed">structure</span>($topic)
            -&gt;<span class="text-primary-fixed">withConcepts</span>()
            -&gt;<span class="text-primary-fixed">withChallenges</span>();
    }
}</code></pre>
</div>
<!-- Stats Floating Card -->
<div class="absolute -bottom-8 -left-8 bg-surface-container-lowest p-6 rounded-xl shadow-xl border border-outline-variant max-w-[200px]">
<div class="flex items-center gap-3 mb-2">
<span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span class="font-label-md text-on-surface">Mastery: 84%</span>
</div>
<div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
<div class="bg-secondary h-full w-[84%]"></div>
</div>
</div>
</div>
</div>
</section>
<!-- Features Bento Grid -->
<section class="py-24 bg-surface-container-low">
<div class="max-w-container-max mx-auto px-margin-x">
<div class="text-center mb-16">
<h2 class="font-display text-headline-lg text-on-surface mb-4">Precision-Engineered Preparation</h2>
<p class="font-body-md text-on-surface-variant">Tools designed for the modern backend professional.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
<!-- Feature 1 -->
<div class="md:col-span-2 bg-surface-container-lowest p-10 rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow group">
<div class="flex flex-col md:flex-row gap-10 items-center">
<div class="flex-1">
<span class="material-symbols-outlined text-primary text-4xl mb-6">neurology</span>
<h3 class="font-display text-headline-md text-on-surface mb-4">AI Concept Generator</h3>
<p class="font-body-md text-on-surface-variant">Turn abstract topics into structured study guides. Our AI parses complex documentation to create digestible, interview-ready modules for any framework.</p>
</div>
<div class="flex-1 w-full bg-surface-container h-48 rounded-lg overflow-hidden flex items-center justify-center p-6 border border-outline-variant/30">
<div class="w-full space-y-3">
<div class="h-4 bg-primary/10 rounded w-3/4"></div>
<div class="h-4 bg-primary/10 rounded w-full"></div>
<div class="h-4 bg-primary/10 rounded w-5/6"></div>
</div>
</div>
</div>
</div>
<!-- Feature 2 -->
<div class="bg-surface-container-lowest p-10 rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
<span class="material-symbols-outlined text-primary text-4xl mb-6">account_tree</span>
<h3 class="font-display text-headline-md text-on-surface mb-4">Domain Mastery</h3>
<p class="font-body-md text-on-surface-variant mb-6">Organize preparation by Laravel, PHP, Architecture, and more. Deep dive into specific technical stacks.</p>
<div class="flex flex-wrap gap-2">
<span class="px-3 py-1 rounded bg-secondary-container text-on-secondary-container font-label-md text-[12px]">Laravel</span>
<span class="px-3 py-1 rounded bg-surface-container-high text-on-surface-variant font-label-md text-[12px]">Redis</span>
<span class="px-3 py-1 rounded bg-surface-container-high text-on-surface-variant font-label-md text-[12px]">Docker</span>
</div>
</div>
<!-- Feature 3 -->
<div class="md:col-span-3 bg-inverse-surface text-inverse-on-surface p-10 rounded-xl shadow-xl flex flex-col md:flex-row items-center gap-10 overflow-hidden">
<div class="flex-1 relative">
</div>
<div class="flex-1">
<h3 class="font-display text-headline-lg mb-4">Progress Intelligence</h3>
<p class="font-body-md text-surface-variant mb-8">Visualize your growth with dynamic heatmaps and automated mastery scores. Know exactly where you stand before the recruiter calls.</p>
<div class="flex gap-4">
<div class="bg-surface/10 p-4 rounded-lg flex-1">
<div class="text-headline-md font-bold text-secondary-fixed">244</div>
<div class="text-label-md text-surface-variant/70">Concepts Mastered</div>
</div>
<div class="bg-surface/10 p-4 rounded-lg flex-1">
<div class="text-headline-md font-bold text-tertiary-fixed">12</div>
<div class="text-label-md text-surface-variant/70">Mock Interviews</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- How It Works -->
<section class="py-24 bg-surface overflow-hidden">
<div class="max-w-container-max mx-auto px-margin-x">
<div class="text-center mb-20">
<h2 class="font-display text-headline-lg text-on-surface">Your Path to Mastery</h2>
</div>
<div class="relative flex flex-col md:flex-row justify-between gap-12">
<!-- Progress Line (Desktop) -->
<div class="hidden md:block absolute top-12 left-0 w-full h-[2px] bg-outline-variant z-0"></div>
<!-- Step 1 -->
<div class="relative z-10 flex-1 text-center">
<div class="w-24 h-24 bg-surface-container-highest border-4 border-surface rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
<span class="material-symbols-outlined text-primary text-3xl">map</span>
</div>
<h4 class="font-display text-headline-md mb-2">1. Define Domains</h4>
<p class="font-body-md text-on-surface-variant px-4">Select the tech stacks and architectural patterns you need to master.</p>
</div>
<!-- Step 2 -->
<div class="relative z-10 flex-1 text-center">
<div class="w-24 h-24 bg-surface-container-highest border-4 border-surface rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
<span class="material-symbols-outlined text-primary text-3xl">auto_awesome</span>
</div>
<h4 class="font-display text-headline-md mb-2">2. Generate Concepts</h4>
<p class="font-body-md text-on-surface-variant px-4">Our AI builds a custom curriculum tailored to current industry standards.</p>
</div>
<!-- Step 3 -->
<div class="relative z-10 flex-1 text-center">
<div class="w-24 h-24 bg-surface-container-highest border-4 border-surface rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
<span class="material-symbols-outlined text-primary text-3xl">terminal</span>
</div>
<h4 class="font-display text-headline-md mb-2">3. Practice with AI</h4>
<p class="font-body-md text-on-surface-variant px-4">Interactive coding challenges and mock behavioral rounds with real-time feedback.</p>
</div>
<!-- Step 4 -->
<div class="relative z-10 flex-1 text-center">
<div class="w-24 h-24 bg-primary border-4 border-surface rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
<span class="material-symbols-outlined text-on-primary text-3xl">celebration</span>
</div>
<h4 class="font-display text-headline-md mb-2">4. Land the Job</h4>
<p class="font-body-md text-on-surface-variant px-4">Approach your interview with the confidence of a domain expert.</p>
</div>
</div>
</div>
</section>
<!-- Testimonial Section -->
<section class="py-24 bg-surface-container">
<div class="max-w-container-max mx-auto px-margin-x">
<div class="bg-surface-container-lowest p-12 md:p-20 rounded-3xl border border-outline-variant shadow-sm relative overflow-hidden text-center">
<div class="absolute -top-10 -left-10 w-40 h-40 bg-primary/5 rounded-full"></div>
<div class="max-w-3xl mx-auto">
<div class="flex justify-center mb-8">
<div class="flex text-secondary">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
</div>
<blockquote class="font-display text-headline-lg text-on-surface mb-10 leading-snug">
                            "The most organized way to prepare for senior roles. I stopped guessing what to study and followed the AI's mastery path."
                        </blockquote>
<div class="flex flex-col items-center">
<img alt="Software Engineer" class="w-16 h-16 rounded-full mb-4 border-2 border-primary" data-alt="A professional headshot of a software engineer in his late 20s, wearing a clean dark navy sweater." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRdWtxgvZznM6wTxwKkhKNwLy4NfwjUEmEaDKmutdgAfpyf3C9z4iEN0RTweiOC34PJQLersErILMdMU3BmqqOpsN1Ca-MCV-AT3iwP1irfhWjAWizZcNrtyXT9qN2ISxC-FBcWkheo8Y4e_SiJHEt3E_Q3kJcWFNg5MZnEhTlV358CEwMJ3nRZWWauqc0WmQt_PjeOZ1vJTZgE7pVpIBq9VHfYJCIvIAAv_oemjmI5y48qUCWqiU-RfkGIF6oiBWAZ80_Od8OYHE"/>
<cite class="not-italic">
<span class="block font-headline-md text-on-surface">Marcus Thorne</span>
<span class="block font-label-md text-on-surface-variant">Senior Backend Developer @ CloudScale</span>
</cite>
</div>
</div>
</div>
</div>
</section>
<!-- CTA Section -->
<section class="py-24">
<div class="max-w-container-max mx-auto px-margin-x">
<div class="bg-primary rounded-3xl p-12 md:p-20 text-center relative overflow-hidden">
<div class="absolute top-0 right-0 w-full h-full opacity-10 pointer-events-none">
<svg height="100%" preserveaspectratio="none" viewbox="0 0 100 100" width="100%">
<defs>
<pattern height="10" id="grid" patternunits="userSpaceOnUse" width="10">
<path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"></path>
</pattern>
</defs>
<rect fill="url(#grid)" height="100" width="100"></rect>
</svg>
</div>
<h2 class="font-display text-display text-on-primary mb-6">Ready to ace your next round?</h2>
<p class="font-body-lg text-on-primary-container mb-12 max-w-xl mx-auto opacity-90">Join 10,000+ engineers building their future in tech with InterviewPrep.</p>
<div class="flex flex-col sm:flex-row gap-4 justify-center">
<a href="{{ route('register') }}" class="bg-on-primary text-primary px-10 py-5 rounded-xl font-headline-md shadow-xl hover:bg-primary-fixed transition-colors">Start Free Trial</a>
<a href="{{ route('register') }}" class="bg-primary-container text-on-primary-container px-10 py-5 rounded-xl font-headline-md border border-on-primary-container/30 hover:bg-primary/80 transition-colors">Compare Plans</a>
</div>
</div>
</div>
</section>
</main>
<!-- Footer -->
<footer class="w-full py-stack-lg px-margin-x flex flex-col md:flex-row justify-between items-center gap-stack-md max-w-container-max mx-auto bg-surface-container-lowest dark:bg-inverse-surface border-t border-outline-variant dark:border-outline">
<div class="flex flex-col items-center md:items-start gap-4">
<span class="font-display text-headline-md font-bold text-primary dark:text-primary-fixed-dim">InterviewPrep</span>
<p class="font-label-md text-label-md text-on-surface-variant dark:text-surface-variant">© 2024 InterviewPrep. Engineered for mastery.</p>
</div>
<div class="flex gap-8">
<a class="font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim underline transition-all opacity-80 hover:opacity-100" href="#">Privacy Policy</a>
<a class="font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim underline transition-all opacity-80 hover:opacity-100" href="#">Terms of Service</a>
<a class="font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim underline transition-all opacity-80 hover:opacity-100" href="#">Github</a>
<a class="font-label-md text-label-md text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim underline transition-all opacity-80 hover:opacity-100" href="#">Status</a>
</div>
</footer>
</body></html>
