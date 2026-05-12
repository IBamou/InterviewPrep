<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=0.8" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Geist:wght@400;500;600&amp;family=JetBrains+Mono:wght@400&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-tertiary-fixed": "#2a1700",
                    "surface-bright": "#f9f9ff",
                    "outline": "#777587",
                    "secondary-fixed-dim": "#4edea3",
                    "tertiary-fixed-dim": "#ffb95f",
                    "surface": "#f9f9ff",
                    "on-error": "#ffffff",
                    "on-secondary-fixed-variant": "#005236",
                    "outline-variant": "#c7c4d8",
                    "error-container": "#ffdad6",
                    "on-background": "#151c27",
                    "on-primary": "#ffffff",
                    "on-error-container": "#93000a",
                    "on-surface": "#151c27",
                    "tertiary": "#684000",
                    "primary-fixed": "#e2dfff",
                    "on-primary-fixed-variant": "#3323cc",
                    "surface-container": "#e7eefe",
                    "primary-container": "#4f46e5",
                    "primary": "#3525cd",
                    "surface-container-high": "#e2e8f8",
                    "secondary-fixed": "#6ffbbe",
                    "primary-fixed-dim": "#c3c0ff",
                    "on-secondary": "#ffffff",
                    "secondary-container": "#6cf8bb",
                    "inverse-on-surface": "#ebf1ff",
                    "secondary": "#006c49",
                    "inverse-surface": "#2a313d",
                    "on-primary-container": "#dad7ff",
                    "inverse-primary": "#c3c0ff",
                    "tertiary-fixed": "#ffddb8",
                    "tertiary-container": "#885500",
                    "on-secondary-fixed": "#002113",
                    "on-primary-fixed": "#0f0069",
                    "on-tertiary-container": "#ffd4a4",
                    "on-tertiary": "#ffffff",
                    "background": "#f9f9ff",
                    "surface-variant": "#dce2f3",
                    "surface-container-highest": "#dce2f3",
                    "error": "#ba1a1a",
                    "surface-dim": "#d3daea",
                    "surface-container-low": "#f0f3ff",
                    "surface-container-lowest": "#ffffff",
                    "on-tertiary-fixed-variant": "#653e00",
                    "on-surface-variant": "#464555",
                    "surface-tint": "#4d44e3",
                    "on-secondary-container": "#00714d"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.4rem",
                    "xl": "0.6rem",
                    "full": "9999px"
            },
            "spacing": {
                    "stack-lg": "1.6rem",
                    "stack-sm": "0.4rem",
                    "gutter": "1.2rem",
                    "container-max": "1024px",
                    "stack-md": "0.8rem",
                    "margin-x": "1.6rem"
            },
            "fontFamily": {
                    "label-md": ["Geist"],
                    "display": ["Inter"],
                    "headline-md": ["Inter"],
                    "body-md": ["Inter"],
                    "body-lg": ["Inter"],
                    "code": ["JetBrains Mono"],
                    "headline-lg": ["Inter"]
            },
            "fontSize": {
                    "label-md": ["12px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],
                    "display": ["36px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "headline-md": ["20px", {"lineHeight": "32px", "fontWeight": "600"}],
                    "body-md": ["14px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "body-lg": ["15px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "code": ["12px", {"lineHeight": "22px", "fontWeight": "400"}],
                    "headline-lg": ["26px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .code-container {
            background-color: #1e1e2e;
            color: #cdd6f4;
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen">
<!-- SideNavBar Component -->
<aside class="h-screen w-64 fixed left-0 top-0 border-r border-outline-variant dark:border-outline bg-surface dark:bg-inverse-surface shadow-sm flex flex-col py-6 px-4 z-50">
<div class="mb-10 px-2">
<h1 class="text-headline-md font-display font-bold text-primary dark:text-inverse-primary">InterviewPrep</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Laravel Mastery</p>
</div>
<nav class="flex-1 space-y-2">
<a class="flex items-center gap-3 px-3 py-2 transition-colors rounded-lg text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant group" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="font-body-md text-body-md">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-3 py-2 transition-colors rounded-lg text-primary dark:text-inverse-primary font-bold bg-primary-container/10 dark:bg-primary-fixed-dim/10 group" href="#">
<span class="material-symbols-outlined" data-icon="category" style="font-variation-settings: 'FILL' 1;">category</span>
<span class="font-body-md text-body-md">Domains</span>
</a>
<a class="flex items-center gap-3 px-3 py-2 transition-colors rounded-lg text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-high dark:hover:bg-surface-variant group" href="#">
<span class="material-symbols-outlined" data-icon="archive">archive</span>
<span class="font-body-md text-body-md">Archives</span>
</a>
</nav>
<div class="mt-auto">
<button class="w-full py-3 px-4 bg-primary text-on-primary rounded-xl font-bold flex items-center justify-center gap-2 active:scale-95 transition-transform">
<span class="material-symbols-outlined" data-icon="bolt">bolt</span>
                AI Generator
            </button>
<div class="mt-6 flex items-center gap-3 px-2">
<div class="w-10 h-10 rounded-full overflow-hidden bg-surface-container-highest">
<img alt="User profile avatar" data-alt="A professional headshot avatar of a software engineer in a minimalist digital art style. The character has a calm, focused expression with modern glasses, set against a clean, light blue background that matches the high-end technical SaaS aesthetic." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAIcf9QGXGpCD8D7DMdtH_-SyQJ8sr11nnvWogzZuxIzluNrAijXbIbp0RfJIWUmvGDmi89Zfm31QmW6vF-mgBVHXcbZMTSryadn06KiWqBQLg-4Ybp1yXv4vKJjBJPgJgUOiq32H-HA3XE9IgqtKezZPHmmEdJFdOmCAFBOPMh0gFbs9qIDnsPK2P1-05RK4j6WfRooCn5mbnc7I_EiPTGqLPO1uPlVKrTt8vO2gXD9MWwR5kngXgtTHyfasUYHEiWwIk4hT95cus"/>
</div>
<div class="overflow-hidden">
<p class="font-label-md text-label-md font-bold truncate">Alex Dev</p>
<p class="font-label-md text-label-md text-on-surface-variant truncate">Premium Member</p>
</div>
</div>
</div>
</aside>
<!-- TopAppBar Component -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-surface/80 dark:bg-surface-dim/80 backdrop-blur-md border-b border-outline-variant dark:border-outline flex justify-between items-center h-16 px-8">
<div class="flex items-center gap-4 flex-1 max-w-xl">
<div class="relative w-full">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant" data-icon="search">search</span>
<input class="w-full bg-surface-container-low border-none rounded-full pl-10 pr-4 py-2 text-label-md font-label-md focus:ring-2 focus:ring-primary/20" placeholder="Search concepts..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<div class="flex items-center gap-2">
<button class="flex items-center gap-2 text-primary font-bold px-4 py-2 hover:bg-primary/5 rounded-lg transition-colors">
<span class="material-symbols-outlined" data-icon="add">add</span>
<span class="font-label-md text-label-md">Add Domain</span>
</button>
<button class="bg-primary text-on-primary px-4 py-2 rounded-lg font-bold shadow-sm hover:shadow-md active:opacity-80 transition-all">
<span class="font-label-md text-label-md">Create Concept</span>
</button>
</div>
<div class="flex items-center gap-3 border-l border-outline-variant pl-6">
<button class="text-on-surface-variant hover:text-primary transition-all">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="text-on-surface-variant hover:text-primary transition-all">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
</button>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="ml-64 pt-24 pb-12 px-margin-x max-w-container-max mx-auto">
<div class="grid grid-cols-12 gap-gutter items-start">
<!-- Question Column -->
<div class="col-span-8 flex flex-col gap-stack-lg">
<!-- Question Card -->
<section class="bg-surface-container-lowest border border-outline-variant rounded-xl p-8 shadow-sm">
<div class="flex justify-between items-start mb-6">
<div class="flex gap-2">
<span class="px-3 py-1 rounded-full border border-slate-700 text-slate-700 font-bold text-xs bg-slate-50 uppercase tracking-wider">Mid</span>
<span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 font-bold text-xs uppercase tracking-wider">En cours</span>
</div>
<div class="flex items-center gap-3 text-on-surface-variant">
<span class="material-symbols-outlined text-xl" data-icon="timer">timer</span>
<span class="font-code text-code font-bold">12:00</span>
<button class="bg-primary-container text-on-primary-container px-4 py-1.5 rounded-lg font-bold text-sm hover:opacity-90 transition-opacity">
                                Start Timer
                            </button>
</div>
</div>
<h2 class="font-headline-lg text-headline-lg text-on-surface leading-snug mb-4">
                        Explain the difference between Lazy Loading and Eager Loading in Eloquent, and when would you use each?
                    </h2>
<p class="text-on-surface-variant mb-8">
                        Consider the N+1 problem and performance implications for large datasets.
                    </p>
<!-- Text Area Answer -->
<div class="relative">
<label class="block text-label-md font-label-md mb-2 text-on-surface-variant">Your Technical Response</label>
<textarea class="w-full bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-4 focus:ring-primary/10 rounded-xl p-4 font-body-md text-body-md placeholder:text-outline" placeholder="Type your detailed architectural and code-level explanation here... Use markdown if needed." rows="12"></textarea>
</div>
<!-- Actions -->
<div class="mt-6 flex justify-between items-center">
<button class="text-primary font-bold flex items-center gap-2 hover:underline transition-all">
<span class="material-symbols-outlined" data-icon="visibility">visibility</span>
                            Reveal AI Answer
                        </button>
<div class="flex gap-3">
<button class="bg-surface-container border border-outline-variant text-on-surface px-6 py-2.5 rounded-xl font-bold flex items-center gap-2 hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined" data-icon="skip_next">skip_next</span>
                                Next Question
                            </button>
</div>
</div>
</section>
<!-- Hidden AI Feedback Section (Simulated State) -->
<section class="bg-surface-container-low border border-outline-variant rounded-xl p-8 opacity-50 select-none grayscale cursor-not-allowed">
<div class="flex items-center gap-4 mb-6 border-b border-outline-variant pb-4">
<span class="material-symbols-outlined text-primary" data-icon="auto_awesome">auto_awesome</span>
<h3 class="font-headline-md text-headline-md">AI Ideal Response</h3>
</div>
<div class="space-y-4">
<p class="font-bold text-primary">Key Architectural Concepts:</p>
<ul class="list-disc ml-5 space-y-2 text-on-surface-variant">
<li><strong>Lazy Loading:</strong> Relationships are loaded "on-demand" only when accessed. Default behavior. Leads to N+1 query problem in loops.</li>
<li><strong>Eager Loading:</strong> Uses <code class="bg-surface-container-high px-1 rounded">with()</code> to load relationships in a single subsequent query. Prevents N+1.</li>
</ul>
<div class="code-container p-6 rounded-xl overflow-x-auto mt-6 border border-white/10">
<pre class="text-sm"><code>// Lazy Loading (Causes N+1)
$books = Book::all();
foreach ($books as $book) {
    echo $book-&gt;author-&gt;name; // Query on each iteration
}

// Eager Loading (Optimized)
$books = Book::with('author')-&gt;get();
foreach ($books as $book) {
    echo $book-&gt;author-&gt;name; // No additional queries
}</code></pre>
</div>
</div>
<!-- Grading Section -->
<div class="mt-10 pt-8 border-t border-outline-variant">
<p class="text-label-md font-label-md text-on-surface-variant mb-4 uppercase tracking-widest">Self-Assessment</p>
<div class="grid grid-cols-3 gap-4">
<button class="flex flex-col items-center justify-center py-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100 transition-colors">
<span class="material-symbols-outlined mb-1" data-icon="close">close</span>
<span class="font-bold">Incorrect</span>
</button>
<button class="flex flex-col items-center justify-center py-4 rounded-xl border border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 transition-colors">
<span class="material-symbols-outlined mb-1" data-icon="adjust">adjust</span>
<span class="font-bold">Partial</span>
</button>
<button class="flex flex-col items-center justify-center py-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors">
<span class="material-symbols-outlined mb-1" data-icon="check_circle">check_circle</span>
<span class="font-bold">Correct</span>
</button>
</div>
</div>
</section>
</div>
<!-- Context Column -->
<div class="col-span-4 flex flex-col gap-stack-md sticky top-24">
<!-- Session Context Card -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
<h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest mb-4">Current Session</h3>
<div class="space-y-6">
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
<span class="material-symbols-outlined text-3xl" data-icon="laravel">database</span>
</div>
<div>
<p class="text-on-surface-variant text-sm">Domain</p>
<p class="font-bold text-lg">Laravel Framework</p>
</div>
</div>
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-xl bg-secondary-container/20 flex items-center justify-center text-secondary">
<span class="material-symbols-outlined text-3xl" data-icon="account_tree">account_tree</span>
</div>
<div>
<p class="text-on-surface-variant text-sm">Concept</p>
<p class="font-bold text-lg">Eloquent ORM</p>
</div>
</div>
</div>
</div>
<!-- Stats Card -->
<div class="bg-primary text-on-primary rounded-xl p-6 shadow-md relative overflow-hidden">
<div class="relative z-10">
<h3 class="font-label-md text-label-md text-on-primary-container uppercase tracking-widest mb-4">Performance</h3>
<div class="flex justify-between items-end">
<div>
<p class="text-3xl font-display font-bold">1,240</p>
<p class="text-primary-fixed-dim text-sm">Experience Points</p>
</div>
<div class="text-right">
<p class="text-3xl font-display font-bold">12</p>
<p class="text-primary-fixed-dim text-sm">Daily Streak</p>
</div>
</div>
<div class="mt-6 bg-white/10 h-2 rounded-full overflow-hidden">
<div class="bg-secondary-fixed h-full w-[75%]"></div>
</div>
<p class="text-xs mt-2 text-on-primary-container">Next Level: 260 XP Remaining</p>
</div>
<!-- Abstract Background Pattern -->
<div class="absolute -bottom-4 -right-4 opacity-20">
<span class="material-symbols-outlined text-[120px]" data-icon="show_chart">show_chart</span>
</div>
</div>
<!-- Guidance/Tips -->
<div class="bg-tertiary-fixed text-on-tertiary-fixed rounded-xl p-6">
<div class="flex items-center gap-2 mb-3">
<span class="material-symbols-outlined text-tertiary" data-icon="lightbulb">lightbulb</span>
<h4 class="font-bold">Interview Tip</h4>
</div>
<p class="text-sm leading-relaxed opacity-90">
                        When answering this, mention the <code class="bg-white/30 px-1 rounded">Lazy Loading Violation</code> prevention tools in Laravel 8.43+ as a "bonus" senior-level insight.
                    </p>
</div>
<!-- Visual Element -->
<div class="rounded-xl overflow-hidden h-40 border border-outline-variant grayscale hover:grayscale-0 transition-all">
<img class="w-full h-full object-cover" data-alt="A macro close-up of clean code on a monitor in a dark room. The lighting is sophisticated, with subtle glows of neon blue and violet from the syntax highlighting, reflecting a high-performance deep-tech workspace. The aesthetic is professional, minimalist, and engineering-focused." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBtcJrZmC8SWyT1tMNnOiRCAOiVLgZ8BzLBrhkUsANHP5HZWrO4GFOd-8QWXSttB1yIOZWimxCgkzbmrTRlLe8Gi7iYafMx84sFmcGuHKZozgDII-Cl60Gd0Wlej8-JBRwNHEX6Laku5pHdnazpH-L5AolEl-MFXXu2_w40X6PUUWpHKePFBSH1l6psahLl66OmuaLaXA7nYAjNiIorHlLwO-bPG_lLtbTNHbFlRZH0iN8qvG5HmZXvn1ljWQ7uZ577y1NmVo-Hz30"/>
</div>
</div>
</div>
</main>
</body></html>
