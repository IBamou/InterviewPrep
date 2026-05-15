@props(['activeNav' => 'dashboard', 'title' => 'InterviewPrep'])
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>{{ $title }} | InterviewPrep</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>tailwind.config={darkMode:"class",theme:{extend:{colors:{"background":"#f9f9ff","surface":"#f9f9ff","surface-container-lowest":"#ffffff","surface-container-low":"#f0f3ff","surface-container":"#e7eefe","surface-container-high":"#e2e8f8","surface-container-highest":"#dce3f2","surface-dim":"#d3daea","surface-bright":"#f9f9ff","surface-variant":"#dce3f2","on-surface":"#151c27","on-surface-variant":"#464555","on-background":"#151c27","inverse-surface":"#2a313c","inverse-on-surface":"#ebf1ff","primary":"#1e00a9","on-primary":"#ffffff","primary-container":"#3525cd","on-primary-container":"#b1afff","primary-fixed":"#e2dfff","on-primary-fixed":"#0f0069","primary-fixed-dim":"#c3c0ff","inverse-primary":"#c3c0ff","on-primary-fixed-variant":"#3323cc","surface-tint":"#4d44e3","secondary":"#006c49","on-secondary":"#ffffff","secondary-container":"#9af2c5","on-secondary-container":"#0c714d","secondary-fixed":"#9df4c8","on-secondary-fixed":"#002113","secondary-fixed-dim":"#81d8ad","on-secondary-fixed-variant":"#005236","tertiary":"#621500","on-tertiary":"#ffffff","tertiary-container":"#892200","on-tertiary-container":"#ff9e82","tertiary-fixed":"#ffdbd1","on-tertiary-fixed":"#3b0900","tertiary-fixed-dim":"#ffb5a0","on-tertiary-fixed-variant":"#872100","error":"#ba1a1a","on-error":"#ffffff","error-container":"#ffdad6","on-error-container":"#93000a","outline":"#777587","outline-variant":"#c7c4d8"},borderRadius:{DEFAULT:"0.25rem",lg:"0.5rem",xl:"0.75rem",full:"9999px"},spacing:{lg:"24px","container-max":"1280px",md:"16px",xs:"4px",xl:"32px",gutter:"24px",sm:"8px",unit:"8px",xxl:"48px"},fontFamily:{"headline-md":["Inter"],"code-block":["JetBrains Mono"],"body-md":["Inter"],"title-lg":["Inter"],"display-lg-mobile":["Inter"],"body-sm":["Inter"],"display-lg":["Inter"],"label-caps":["Inter"]},fontSize:{"headline-md":["24px",{"lineHeight":"32px","letterSpacing":"-0.01em","fontWeight":"600"}],"code-block":["14px",{"lineHeight":"22px","fontWeight":"400"}],"body-md":["16px",{"lineHeight":"24px","fontWeight":"400"}],"title-lg":["18px",{"lineHeight":"28px","fontWeight":"600"}],"display-lg-mobile":["32px",{"lineHeight":"40px","letterSpacing":"-0.02em","fontWeight":"700"}],"body-sm":["14px",{"lineHeight":"20px","fontWeight":"400"}],"display-lg":["48px",{"lineHeight":"56px","letterSpacing":"-0.02em","fontWeight":"700"}],"label-caps":["12px",{"lineHeight":"16px","letterSpacing":"0.05em","fontWeight":"600"}]}}}}</script>
<style>.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;vertical-align:middle;display:inline-block;line-height:1}body{background-color:#f9f9ff;font-family:'Inter',sans-serif}.custom-card{background-color:#ffffff;border:1px solid #c7c4d8;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05)}</style>
</head>
<body class="bg-background text-on-surface">
<x-sidebar :active-nav="$activeNav"/>
<x-topbar :topbar-actions="$topbarActions ?? ''"/>
<main class="ml-48 pt-16 min-h-screen">
<div class="max-w-container-max mx-auto p-lg">
@if (session('success'))
<div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
@endif
{{ $slot }}
</div>
</main>
</body>
</html>