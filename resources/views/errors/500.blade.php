<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>500 Server Error | InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>tailwind.config={darkMode:"class",theme:{extend:{colors:{"background":"#F8FBFF","surface":"#FFFFFF","surface-container-lowest":"#FFFFFF","surface-container-low":"#F8FAFC","surface-container":"#F0F4F8","surface-container-high":"#E8EDF2","surface-container-highest":"#E0E5EB","surface-dim":"#D6DBE1","surface-bright":"#FFFFFF","surface-variant":"#E8EDF2","on-surface":"#1A1A2E","on-surface-variant":"#546E7A","on-background":"#1A1A2E","inverse-surface":"#1A1A2E","inverse-on-surface":"#F8FBFF","primary":"#0077B6","on-primary":"#FFFFFF","primary-container":"#00B4D8","on-primary-container":"#004E7A","primary-fixed":"#E0F7FA","on-primary-fixed":"#004E7A","primary-fixed-dim":"#B2EBF2","inverse-primary":"#00B4D8","on-primary-fixed-variant":"#0077B6","surface-tint":"#0077B6","secondary":"#00A896","on-secondary":"#FFFFFF","secondary-container":"#B2DFDB","on-secondary-container":"#004D40","secondary-fixed":"#B2DFDB","on-secondary-fixed":"#004D40","secondary-fixed-dim":"#80CBC4","on-secondary-fixed-variant":"#00695C","tertiary":"#FF6B6B","on-tertiary":"#FFFFFF","tertiary-container":"#FF8A8A","on-tertiary-container":"#C62828","tertiary-fixed":"#FFCDD2","on-tertiary-fixed":"#B71C1C","tertiary-fixed-dim":"#EF9A9A","on-tertiary-fixed-variant":"#D32F2F","error":"#E63946","on-error":"#FFFFFF","error-container":"#FFEBEE","on-error-container":"#C62828","outline":"#90A4AE","outline-variant":"#CFD8DC"},borderRadius:{DEFAULT:"0.5rem",lg:"0.625rem",xl:"0.875rem","2xl":"1rem",full:"9999px"},fontFamily:{sans:["Inter","system-ui","sans-serif"],mono:["JetBrains Mono","monospace"]}}}}</script>
<style>body{background-color:#F8FBFF;font-family:'Inter',sans-serif</style>
</head>
<body class="bg-background text-on-surface min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md text-center">
        <div class="flex items-center justify-center gap-2.5 mb-8">
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-primary to-primary-container flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-[20px]" style="font-variation-settings: 'FILL' 1;">school</span>
            </div>
            <span class="text-[18px] font-bold text-on-surface tracking-tight">InterviewPrep</span>
        </div>

        <div class="bg-white border border-outline-variant/50 rounded-2xl p-10 shadow-sm">
            <div class="w-16 h-16 rounded-full bg-error/10 flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-error text-[32px]">bug_report</span>
            </div>

            <h1 class="text-[64px] font-bold text-error leading-none mb-2">500</h1>
            <h2 class="text-[18px] font-semibold text-on-surface mb-2">Something went wrong</h2>
            <p class="text-[13px] text-on-surface-variant/70 leading-relaxed mb-6">
                An unexpected error occurred. Please try again later.
            </p>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">
                <span class="material-symbols-outlined text-[16px]">refresh</span>
                Try Again
            </a>
        </div>
    </div>
</body>
</html>
