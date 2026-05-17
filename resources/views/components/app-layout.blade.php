@props(['activeNav' => 'dashboard', 'title' => 'InterviewPrep'])
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>{{ $title }} | InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>tailwind.config={darkMode:"class",theme:{extend:{colors:{"background":"#F8FBFF","surface":"#FFFFFF","surface-container-lowest":"#FFFFFF","surface-container-low":"#F8FAFC","surface-container":"#F0F4F8","surface-container-high":"#E8EDF2","surface-container-highest":"#E0E5EB","surface-dim":"#D6DBE1","surface-bright":"#FFFFFF","surface-variant":"#E8EDF2","on-surface":"#1A1A2E","on-surface-variant":"#546E7A","on-background":"#1A1A2E","inverse-surface":"#1A1A2E","inverse-on-surface":"#F8FBFF","primary":"#0077B6","on-primary":"#FFFFFF","primary-container":"#00B4D8","on-primary-container":"#004E7A","primary-fixed":"#E0F7FA","on-primary-fixed":"#004E7A","primary-fixed-dim":"#B2EBF2","inverse-primary":"#00B4D8","on-primary-fixed-variant":"#0077B6","surface-tint":"#0077B6","secondary":"#00A896","on-secondary":"#FFFFFF","secondary-container":"#B2DFDB","on-secondary-container":"#004D40","secondary-fixed":"#B2DFDB","on-secondary-fixed":"#004D40","secondary-fixed-dim":"#80CBC4","on-secondary-fixed-variant":"#00695C","tertiary":"#FF6B6B","on-tertiary":"#FFFFFF","tertiary-container":"#FF8A8A","on-tertiary-container":"#C62828","tertiary-fixed":"#FFCDD2","on-tertiary-fixed":"#B71C1C","tertiary-fixed-dim":"#EF9A9A","on-tertiary-fixed-variant":"#D32F2F","error":"#E63946","on-error":"#FFFFFF","error-container":"#FFEBEE","on-error-container":"#C62828","outline":"#90A4AE","outline-variant":"#CFD8DC"},borderRadius:{DEFAULT:"0.5rem",lg:"0.625rem",xl:"0.875rem","2xl":"1rem",full:"9999px"},spacing:{lg:"20px","container-max":"1200px",md:"16px",xs:"4px",xl:"24px",gutter:"20px",sm:"8px",unit:"8px",xxl:"32px"},fontFamily:{"headline-md":["Inter"],"code-block":["JetBrains Mono"],"body-md":["Inter"],"title-lg":["Inter"],"display-lg-mobile":["Inter"],"body-sm":["Inter"],"display-lg":["Inter"],"label-caps":["Inter"]},fontSize:{"headline-md":["18px",{"lineHeight":"26px","letterSpacing":"-0.01em","fontWeight":"600"}],"code-block":["13px",{"lineHeight":"20px","fontWeight":"400"}],"body-md":["14px",{"lineHeight":"21px","fontWeight":"400"}],"title-lg":["15px",{"lineHeight":"22px","fontWeight":"600"}],"display-lg-mobile":["24px",{"lineHeight":"32px","letterSpacing":"-0.02em","fontWeight":"700"}],"body-sm":["13px",{"lineHeight":"18px","fontWeight":"400"}],"display-lg":["28px",{"lineHeight":"36px","letterSpacing":"-0.02em","fontWeight":"700"}],"label-caps":["11px",{"lineHeight":"16px","letterSpacing":"0.05em","fontWeight":"600"}]}}}}</script>
<style>[x-cloak]{display:none!important}.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;vertical-align:middle;display:inline-block;line-height:1}body{background-color:#F8FBFF;font-family:'Inter',sans-serif}*{scrollbar-width:thin;scrollbar-color:#CFD8DC transparent}::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:#CFD8DC;border-radius:3px}</style>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-background text-on-surface">
<x-sidebar :active-nav="$activeNav"/>
<x-topbar :topbar-actions="$topbarActions ?? ''"/>
<main class="ml-56 pt-16 min-h-screen">
<div class="max-w-container-max mx-auto px-lg py-lg">
@if (session('success'))
<div class="mb-4 p-3 bg-secondary/5 border border-secondary/20 text-secondary rounded-lg text-sm flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">check_circle</span>{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="mb-4 p-3 bg-error/5 border border-error/20 text-error rounded-lg text-sm flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">error</span>{{ session('error') }}</div>
@endif
{{ $slot }}
</div>
</main>
<x-confirm-modal/>
</body>
</html>
