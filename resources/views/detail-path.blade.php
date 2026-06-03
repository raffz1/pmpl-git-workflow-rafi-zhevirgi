<?php
    $theme = $path->theme ?? 'cyan';
    $gradient = 'from-blue-600 via-blue-700 to-indigo-900';
    $primaryColor = 'blue-600';
    $accentColor = '#2563eb';
    $themeLightBg = 'bg-blue-50/50';
    $themeBorder = 'border-blue-100';
    
    if ($theme === 'green') {
        $gradient = 'from-emerald-600 via-teal-700 to-slate-900';
        $primaryColor = 'emerald-600';
        $accentColor = '#10b981';
        $themeLightBg = 'bg-emerald-50/50';
        $themeBorder = 'border-emerald-100';
    } elseif ($theme === 'pink') {
        $gradient = 'from-pink-600 via-rose-700 to-slate-900';
        $primaryColor = 'pink-600';
        $accentColor = '#ec4899';
        $themeLightBg = 'bg-pink-50/50';
        $themeBorder = 'border-pink-100';
    } elseif ($theme === 'orange') {
        $gradient = 'from-orange-600 via-amber-700 to-slate-900';
        $primaryColor = 'orange-600';
        $accentColor = '#f97316';
        $themeLightBg = 'bg-orange-50/50';
        $themeBorder = 'border-orange-100';
    } elseif ($theme === 'yellow') {
        $gradient = 'from-yellow-500 via-amber-600 to-slate-900';
        $primaryColor = 'amber-500';
        $accentColor = '#eab308';
        $themeLightBg = 'bg-yellow-50/50';
        $themeBorder = 'border-yellow-100';
    }
    
    $slugPrefix = $path->slug === 'project-manager' ? 'pm' : $path->slug;
    $totalModules = count($modules) ?: 7;
    $completeRoute = Route::has('path.' . $slugPrefix . '.complete') 
        ? route('path.' . $slugPrefix . '.complete') 
        : route('path.detail.complete.dynamic', $path->slug);
    $resetRoute = Route::has('path.' . $slugPrefix . '.reset') 
        ? route('path.' . $slugPrefix . '.reset') 
        : route('path.detail.reset.dynamic', $path->slug);
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $path->title }} - Path Deck</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Quill Rich Text Editor CDN -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        /* Mobile Sidebar Drawer transition classes */
        @media (max-width: 767px) {
            #learning-sidebar {
                transform: translateX(100%) !important;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            #learning-sidebar.translate-x-0 {
                transform: translateX(0) !important;
            }
            #learning-sidebar.translate-x-full {
                transform: translateX(100%) !important;
            }
        }

        /* Quill output overrides to fit nicely inside the workspace content body */
        #workspace-content-body.ql-editor {
            padding: 0 !important;
            overflow-y: visible !important;
            height: auto !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            color: #475569 !important; /* slate-600 */
        }
        #workspace-content-body.ql-editor p {
            margin-bottom: 1.5rem !important;
            line-height: 1.75 !important;
            color: #475569 !important;
        }
        #workspace-content-body.ql-editor h1,
        #workspace-content-body.ql-editor h2,
        #workspace-content-body.ql-editor h3 {
            font-family: 'Space Grotesk', sans-serif !important;
            font-weight: 800 !important;
            color: #0f172a !important; /* slate-900 */
            margin-top: 2rem !important;
            margin-bottom: 1rem !important;
        }
        #workspace-content-body.ql-editor h1 { font-size: 2.25rem !important; }
        #workspace-content-body.ql-editor h2 { font-size: 1.875rem !important; }
        #workspace-content-body.ql-editor h3 { font-size: 1.5rem !important; }
        
        #workspace-content-body.ql-editor div,
        #workspace-content-body.ql-editor iframe {
            margin-top: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }
        
        /* Premium design for Quill Toolbar inside the admin modal */
        .ql-toolbar.ql-snow {
            border: 1px solid #e2e8f0 !important;
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
            background-color: #f8fafc !important;
            padding: 0.75rem !important;
        }
        .ql-container.ql-snow {
            border: 1px solid #e2e8f0 !important;
            border-bottom-left-radius: 1rem !important;
            border-bottom-right-radius: 1rem !important;
            border-top: none !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        .title-font {
            font-family: 'Space Grotesk', sans-serif;
        }

        /* 3D Tilt/Wobble Effect for Unlocked/Active Curriculum Cards */
        .wobble-card {
            transform-style: preserve-3d;
            perspective: 1000px;
            transition: transform 0.15s ease-out, box-shadow 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
        }
        .wobble-card * {
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }
        .inner-lift {
            transition: transform 0.25s cubic-bezier(0.25, 1, 0.5, 1);
            transform: translateZ(0px);
        }
        .wobble-card:hover .inner-lift {
            transform: translateZ(30px);
        }

        /* Subtle pulsing border for active step */
        .card-active-glow {
            animation: pulse-border 2s infinite alternate;
        }
        @keyframes pulse-border {
            0% { border-color: rgba(59, 130, 246, 0.4); box-shadow: 0 4px 20px -4px rgba(59, 130, 246, 0.1); }
            100% { border-color: rgba(59, 130, 246, 0.8); box-shadow: 0 4px 24px -2px rgba(59, 130, 246, 0.3); }
        }

        /* Ambient Background Blobs Animation */
        @keyframes float-blob {
            0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
            33% { transform: translateY(-25px) scale(1.08) rotate(3deg); }
            66% { transform: translateY(20px) scale(0.92) rotate(-3deg); }
        }
        .animate-float-blob {
            animation: float-blob 12s ease-in-out infinite;
        }

        /* Fade In Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        /* Responsive timeline line adjustments */
        @media (max-width: 767px) {
            .timeline-line {
                left: 2rem !important;
            }
            .timeline-node {
                left: 2rem !important;
                transform: translateX(-50%) !important;
            }
        }

        /* Scroll Down Reveal Animation */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(35px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-on-scroll.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Modal Transition Animations */
        #info-modal {
            transition: opacity 0.35s ease-out;
        }
        #info-modal.show {
            opacity: 1;
        }
        #info-modal.show #modal-container {
            transform: scale(1) translateY(0);
        }

        /* Sub-page overlay for Quiz */
        #quiz-modal {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 99999 !important;
            background-color: #F3F7FF !important;
            overflow-y: auto !important;
            display: none;
            flex-direction: column;
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1), transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #quiz-modal.show {
            display: flex !important;
            opacity: 1 !important;
            transform: scale(1) !important;
        }
        #quiz-exit-confirm-modal {
            z-index: 100050 !important;
        }
        #quiz-card-stack {
            height: 460px !important;
        }

        /* Deck Card Stack Classes with 3D tilts and smooth transitions */
        .quiz-card-stack-item {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            perspective: 1500px;
            will-change: transform, opacity;
            transform: translate3d(0, 0, 0);
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.6s ease;
        }

        .quiz-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            will-change: transform;
            transform: translate3d(0, 0, 0);
            transition: transform 0.75s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .quiz-card-stack-item.flipped .quiz-card-inner {
            transform: translate3d(0, 0, 0) rotateY(180deg);
        }

        .quiz-card-front, .quiz-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            border-radius: 28px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            flex-direction: column;
            padding: 32px;
            justify-content: space-between;
            will-change: transform;
            transform: translate3d(0, 0, 0);
        }

        .quiz-card-back {
            transform: translate3d(0, 0, 0) rotateY(180deg);
        }

        /* 3D card swap animation to-back */
        @keyframes moveToBack {
            0% {
                transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
                z-index: 50;
                opacity: 1;
            }
            45% {
                transform: translate3d(-120%, -30px, 100px) rotate(-12deg) scale(0.95);
                z-index: 50;
                opacity: 0.9;
            }
            50% {
                z-index: 10;
            }
            100% {
                transform: translate3d(0, 48px, -80px) scale(0.8) rotate(0deg);
                z-index: 10;
                opacity: 0.4;
            }
        }
        .quiz-card-stack-item.move-to-back {
            animation: moveToBack 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        /* Confetti particle style */
        .confetti-particle {
            position: absolute;
            width: 8px;
            height: 8px;
            z-index: 9999;
            opacity: 0.85;
            animation: confetti-fall linear forwards;
        }
        @keyframes confetti-fall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(105vh) rotate(720deg);
                opacity: 0;
            }
        }

        /* Fade effects for dynamic content */
        .content-fade-enter {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.25s ease-out, transform 0.25s ease-out;
        }

        /* Custom scrollbar styling for workspaces */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Workspace Header Transitions */
        header.shrink {
            height: 3.5rem !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Custom Quiz Card styling */
        .quiz-option-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            border-radius: 20px;
            border: 1.5px solid #e2e8f0;
            background: white;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .quiz-option-card:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }
        .quiz-option-card.selected {
            border-color: {{ $accentColor }};
            background: {{ $themeLightBg }};
        }
        .quiz-option-card.correct {
            border-color: #10b981;
            background: #ecfdf5;
        }
        .quiz-option-card.incorrect {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .quiz-opt-indicator {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            flex-shrink: 0;
        }
        .quiz-option-card.selected .quiz-opt-indicator {
            border-color: {{ $accentColor }};
        }
        .quiz-option-card.correct .quiz-opt-indicator {
            border-color: #10b981;
            background: #10b981;
        }
        .quiz-option-card.incorrect .quiz-opt-indicator {
            border-color: #ef4444;
            background: #ef4444;
        }
        .quiz-opt-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: transparent;
            transition: all 0.2s ease;
        }
        .quiz-option-card.selected .quiz-opt-dot {
            background: {{ $accentColor }};
        }
        .quiz-option-card.correct .quiz-opt-dot, .quiz-option-card.incorrect .quiz-opt-dot {
            background: white;
        }
        .quiz-opt-text {
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            line-height: 1.4;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col overflow-x-hidden relative">

    <!-- CSRF Token Input -->
    @csrf

    <!-- Top Navigation Bar -->
    @include('layouts.navbar')

    <!-- Main Outer Wrapper containing layout details -->
    <div class="relative flex-grow min-h-screen bg-gradient-to-b from-white via-blue-50/15 to-white py-16 px-4 overflow-hidden">
        
        <!-- Faded tech grid background -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f605_1px,transparent_1px),linear-gradient(to_bottom,#3b82f605_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_80%,transparent_100%)] pointer-events-none z-0"></div>

        <!-- Ambient Light Floating Blobs -->
        <div class="absolute top-[8%] left-[-8%] w-[450px] h-[450px] rounded-full bg-blue-300/10 blur-3xl pointer-events-none animate-float-blob" style="animation-duration: 11s;"></div>
        <div class="absolute bottom-[8%] right-[-10%] w-[480px] h-[480px] rounded-full bg-indigo-300/10 blur-3xl pointer-events-none animate-float-blob" style="animation-delay: -3s; animation-duration: 13s;"></div>

        <!-- Particle Floating Items Container -->
        <div id="particle-container" class="absolute inset-0 overflow-hidden pointer-events-none z-0"></div>

        <main class="max-w-7xl mx-auto w-full relative z-10">
            
            <!-- Back link -->
            <div class="mb-6 animate-fade-in-up">
                <a href="{{ route('explore.path') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-blue-600 transition-colors gap-1.5">
                    &larr; Kembali ke Explore
                </a>
            </div>

            <!-- Success Alert Notification -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-sm font-semibold flex items-center gap-3 animate-fade-in-up">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Roadmap View (Timeline Outline) -->
            <div id="roadmap-view" class="transition-all duration-350">
                <!-- Career Path Header Card -->
                <section class="mb-14 animate-fade-in-up" style="animation-delay: 50ms;">
                    <div class="bg-gradient-to-br {{ $gradient }} rounded-3xl p-8 sm:p-10 shadow-[0_12px_40px_-6px_rgba(37,99,235,0.25)] flex flex-col lg:flex-row items-center gap-10 text-white relative overflow-hidden border-none">
                        <!-- Grid overlay pattern -->
                        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:3rem_3rem] pointer-events-none"></div>
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-blue-400/20 via-transparent to-transparent opacity-70 pointer-events-none"></div>

                        <!-- Left: Text Information -->
                        <div class="flex-grow max-w-2xl order-2 lg:order-1 relative z-10">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/15 border border-white/20 text-white mb-4 tracking-wide uppercase">
                                <svg class="w-3.5 h-3.5 text-blue-200 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Career Path
                            </div>
                            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight title-font mb-4 drop-shadow-sm uppercase">
                                {{ $path->title }}
                            </h1>
                            <p class="text-sm sm:text-base text-blue-50/90 leading-relaxed mb-6 font-medium">
                                {{ $path->description }}
                            </p>
                            
                            <!-- Information Trigger Button -->
                            <button id="open-info-btn" class="inline-flex items-center gap-2 px-4 py-2 border border-white/20 hover:border-white/40 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 transition-all duration-300 shadow-sm cursor-pointer hover:scale-[1.03]">
                                Informasi Umum
                                <svg class="w-4 h-4 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Right: Mockup Image -->
                        <div class="w-full lg:w-[380px] h-60 sm:h-72 rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 group relative cursor-pointer order-1 lg:order-2 flex-shrink-0 z-10">
                            <img src="{{ $path->image }}" alt="{{ $path->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/40 to-transparent"></div>
                        </div>
                    </div>
                </section>

                <!-- Curriculum Section Header & Progress Bar -->
                <section class="mb-14 animate-fade-in-up" style="animation-delay: 100ms;">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200/60 pb-6 mb-10">
                        <div class="flex items-center gap-4">
                            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight title-font flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                                Learning Curriculum
                            </h2>
                            
                            @if(!$isAdmin)
                            <!-- Reset Progress Form -->
                            <form action="{{ $resetRoute }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 border border-red-200 hover:border-red-400 rounded-xl text-xs font-bold text-red-600 bg-red-50/50 hover:bg-red-50 transition-all duration-300 shadow-sm cursor-pointer hover:scale-[1.03]" title="Reset Detail Progress">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89H18.21" />
                                    </svg>
                                    Mulai dari Awal
                                </button>
                            </form>
                            @endif
                        </div>
                        
                        @php
                            $totalModules = count($modules) ?: 7;
                            $percentVal = min(100, round(($currentStep / $totalModules) * 100));
                        @endphp
                        <!-- Progress display -->
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <span class="text-xs font-bold text-slate-400 whitespace-nowrap">Your Progress</span>
                            <div class="w-full sm:w-44 bg-slate-200/70 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-blue-600 h-2.5 rounded-full shadow-sm transition-all duration-1000" style="width: {{ $percentVal }}%"></div>
                            </div>
                            <span class="text-xs font-extrabold text-blue-600 whitespace-nowrap bg-blue-50 border border-blue-100/50 px-2 py-0.5 rounded-lg">{{ $percentVal }}%</span>
                        </div>
                    </div>

                    <!-- Vertical Timeline Section -->
                    <div class="relative max-w-5xl mx-auto px-2 py-4">
                        
                        <!-- Central vertical line -->
                        <div class="absolute timeline-line top-0 bottom-0 left-1/2 w-1.5 bg-slate-200 -translate-x-1/2 z-0 rounded-full overflow-hidden">
                            <div class="absolute top-0 w-full bg-gradient-to-b from-blue-400 via-blue-600 to-indigo-600 rounded-full shadow-[0_0_12px_rgba(59,130,246,0.8)]" style="height: {{ $percentVal }}%; transition: height 1.2s cubic-bezier(0.25, 1, 0.5, 1);">
                                <div class="absolute bottom-0 left-0 right-0 h-4 bg-white animate-pulse rounded-full shadow-[0_0_15px_#fff]"></div>
                            </div>
                        </div>

                        <!-- Curriculum Modules Grid Loop -->
                        <div class="space-y-12 relative z-10">
                            @foreach($modules as $index => $module)
                                @php
                                    $status = '';
                                    if ($isAdmin) {
                                        $status = ($index < $currentStep) ? 'Completed' : 'Active';
                                    } else if ($index < $currentStep) {
                                        $status = 'Completed';
                                    } elseif ($index == $currentStep) {
                                        $status = 'Active';
                                    } else {
                                        $status = 'Locked';
                                    }

                                    $nodeIcon = 'circle';
                                    if ($status === 'Completed') {
                                        $nodeIcon = 'check';
                                        $nodeColor = 'bg-emerald-500 border-emerald-500 text-white shadow-md shadow-emerald-500/20';
                                    } elseif ($status === 'Active') {
                                        $nodeIcon = 'active';
                                        $nodeColor = 'bg-white border-blue-500 border-4 text-blue-600 shadow-md shadow-blue-500/10 animate-bounce';
                                    } else {
                                        $nodeIcon = 'locked';
                                        $nodeColor = 'bg-slate-100 border-slate-200 text-slate-300';
                                    }

                                    $badgeClass = '';
                                    switch($status) {
                                        case 'Completed':
                                            $badgeClass = 'bg-emerald-50 border border-emerald-100 text-emerald-600';
                                            break;
                                        case 'Active':
                                            $badgeClass = 'bg-blue-50 border border-blue-100 text-blue-600 animate-pulse';
                                            break;
                                        default:
                                            $badgeClass = 'bg-slate-200/50 border border-slate-200/40 text-slate-400';
                                            break;
                                    }
                                @endphp

                                <div class="flex flex-col md:flex-row items-center justify-between w-full relative reveal-on-scroll">
                                    
                                    <!-- Left Card -->
                                    <div class="w-full md:w-[44%] {{ $module->side === 'left' ? 'order-1' : 'order-3 opacity-0 pointer-events-none md:block hidden' }}">
                                        @if($module->side === 'left')
                                            @if($status !== 'Locked')
                                                <div onclick="openLearningView({{ $index }})" class="group wobble-card bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:bg-blue-600 hover:border-blue-600 hover:shadow-[0_16px_36px_-8px_rgba(37,99,235,0.22)] cursor-pointer transition-all duration-300 {{ $status === 'Active' ? 'card-active-glow' : '' }}">
                                                    <div class="inner-lift flex items-start gap-4">
                                                        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center font-extrabold text-xs text-blue-600 flex-shrink-0 group-hover:bg-white/20 group-hover:border-white/30 group-hover:text-white transition-colors duration-300 font-mono">
                                                            {{ $module->icon }}
                                                        </div>
                                                        <div class="flex-grow">
                                                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-white transition-colors duration-300">
                                                                    {{ $module->title }}
                                                                </h3>
                                                                <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $badgeClass }} group-hover:bg-white/25 group-hover:border-transparent group-hover:text-white transition-colors duration-300 font-mono">
                                                                    {{ $status }}
                                                                </span>
                                                            </div>
                                                            <p class="text-xs sm:text-sm text-slate-500 group-hover:text-blue-50 transition-colors duration-300 mb-5 leading-relaxed">
                                                                {{ $module->desc }}
                                                            </p>
                                                            <div>
                                                                @if($status === 'Active')
                                                                    <button type="button" onclick="event.stopPropagation(); openLearningView({{ $index }})" class="inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold rounded-xl bg-slate-50 text-slate-600 border border-slate-200/60 hover:bg-blue-50 hover:text-blue-600 group-hover:bg-white group-hover:text-blue-600 group-hover:border-white transition-all duration-300 shadow-sm cursor-pointer hover:no-underline">
                                                                        Start Learning
                                                                    </button>
                                                                @else
                                                                    <button type="button" onclick="event.stopPropagation(); openLearningView({{ $index }})" class="inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200 group-hover:bg-white/20 group-hover:text-white group-hover:border-white/30 transition-all duration-300 shadow-sm cursor-pointer">
                                                                        Review
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="bg-slate-100/70 border border-slate-200/60 rounded-2xl p-6 opacity-60 cursor-not-allowed select-none transition-none">
                                                    <div class="flex items-start gap-4">
                                                        <div class="w-12 h-12 rounded-xl bg-slate-200/80 border border-slate-300/40 flex items-center justify-center font-extrabold text-xs text-slate-400 flex-shrink-0 font-mono">
                                                            {{ $module->icon }}
                                                        </div>
                                                        <div class="flex-grow">
                                                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                                <h3 class="text-base sm:text-lg font-extrabold text-slate-400">
                                                                    {{ $module->title }}
                                                                </h3>
                                                                <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $badgeClass }} font-mono">
                                                                    Locked
                                                                </span>
                                                            </div>
                                                            <p class="text-xs sm:text-sm text-slate-400 mb-5 leading-relaxed">
                                                                {{ $module->desc }}
                                                            </p>
                                                            <div>
                                                                <span class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold rounded-xl bg-slate-200/50 text-slate-400 border border-slate-300/30 cursor-not-allowed">
                                                                    Locked 🔒
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Timeline Node Circle -->
                                    <div class="timeline-node absolute left-1/2 -translate-x-1/2 w-10 h-10 rounded-full flex items-center justify-center z-10 {{ $nodeColor }} order-2 my-4 md:my-0">
                                        @if($nodeIcon === 'locked')
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        @else
                                            <div class="w-2.5 h-2.5 rounded-full bg-current"></div>
                                        @endif
                                    </div>

                                    <!-- Right Card -->
                                    <div class="w-full md:w-[44%] {{ $module->side === 'right' ? 'order-3' : 'order-1 opacity-0 pointer-events-none md:block hidden' }}">
                                        @if($module->side === 'right')
                                            @if($status !== 'Locked')
                                                <div onclick="openLearningView({{ $index }})" class="group wobble-card bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:bg-blue-600 hover:border-blue-600 hover:shadow-[0_16px_36px_-8px_rgba(37,99,235,0.22)] cursor-pointer transition-all duration-300 {{ $status === 'Active' ? 'card-active-glow' : '' }}">
                                                    <div class="inner-lift flex items-start gap-4">
                                                        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center font-extrabold text-xs text-blue-600 flex-shrink-0 group-hover:bg-white/20 group-hover:border-white/30 group-hover:text-white transition-colors duration-300 font-mono">
                                                            {{ $module->icon }}
                                                        </div>
                                                        <div class="flex-grow">
                                                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-white transition-colors duration-300">
                                                                    {{ $module->title }}
                                                                </h3>
                                                                <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $badgeClass }} group-hover:bg-white/25 group-hover:border-transparent group-hover:text-white transition-colors duration-300 font-mono">
                                                                    {{ $status }}
                                                                </span>
                                                            </div>
                                                            <p class="text-xs sm:text-sm text-slate-500 group-hover:text-blue-50 transition-colors duration-300 mb-5 leading-relaxed">
                                                                {{ $module->desc }}
                                                            </p>
                                                            <div>
                                                                @if($status === 'Active')
                                                                    <button type="button" onclick="event.stopPropagation(); openLearningView({{ $index }})" class="inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold rounded-xl bg-slate-50 text-slate-600 border border-slate-200/60 hover:bg-blue-50 hover:text-blue-600 group-hover:bg-white group-hover:text-blue-600 group-hover:border-white transition-all duration-300 shadow-sm cursor-pointer hover:no-underline">
                                                                        Start Learning
                                                                    </button>
                                                                @else
                                                                    <button type="button" onclick="event.stopPropagation(); openLearningView({{ $index }})" class="inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200 group-hover:bg-white/20 group-hover:text-white group-hover:border-white/30 transition-all duration-300 shadow-sm cursor-pointer">
                                                                        Review
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="bg-slate-100/70 border border-slate-200/60 rounded-2xl p-6 opacity-60 cursor-not-allowed select-none transition-none">
                                                    <div class="flex items-start gap-4">
                                                        <div class="w-12 h-12 rounded-xl bg-slate-200/80 border border-slate-300/40 flex items-center justify-center font-extrabold text-xs text-slate-400 flex-shrink-0 font-mono">
                                                            {{ $module->icon }}
                                                        </div>
                                                        <div class="flex-grow">
                                                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                                <h3 class="text-base sm:text-lg font-extrabold text-slate-400">
                                                                    {{ $module->title }}
                                                                </h3>
                                                                <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $badgeClass }} font-mono">
                                                                    Locked
                                                                </span>
                                                            </div>
                                                            <p class="text-xs sm:text-sm text-slate-400 mb-5 leading-relaxed">
                                                                {{ $module->desc }}
                                                            </p>
                                                            <div>
                                                                <span class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold rounded-xl bg-slate-200/50 text-slate-400 border border-slate-300/30 cursor-not-allowed">
                                                                    Locked 🔒
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                        </div>

                    </div>
                </section>
            </div>

        </main>
    </div>

    <!-- Learning View Workspace (Redesigned Split Pane Layout) -->
    <div id="learning-view" class="hidden opacity-0 fixed inset-0 bg-white z-[60] flex flex-col overflow-hidden font-sans transition-all duration-350">
        
        <!-- Navbar -->
        <header class="h-14 sm:h-16 border-b border-slate-200 bg-white px-3 sm:px-8 flex justify-between items-center shrink-0">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-1 sm:gap-2 text-[#0050d2]">
                    <svg class="h-4.5 w-4.5 sm:h-6 sm:w-6 text-[#0050d2] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-8-4-8 4v10l8 4 8-4V7z" />
                    </svg>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:gap-1 text-xs sm:text-base md:text-lg font-black tracking-tight leading-none whitespace-nowrap">
                        <span>Path</span>
                        <span>Deck</span>
                    </div>
                </a>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-6 h-full">
                <a href="{{ route('dashboard') }}" class="text-[10px] sm:text-sm font-semibold text-slate-500 hover:text-[#0050d2] transition-colors whitespace-nowrap">Dashboard</a>
                <a href="{{ route('explore.path') }}" class="relative text-[10px] sm:text-sm font-semibold text-[#0050d2] py-4 sm:py-5 whitespace-nowrap">
                    Explore path
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#0050d2]"></span>
                </a>
                <span class="h-4 sm:h-6 w-px bg-slate-200"></span>
                
                <button class="text-[#0050d2] hover:opacity-85 transition-opacity cursor-pointer border-0 bg-transparent shrink-0">
                    <svg class="w-4 h-4 sm:w-5 sm:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
                
                <button class="text-[#0050d2] hover:opacity-85 transition-opacity cursor-pointer border-0 bg-transparent shrink-0">
                    <svg class="w-4.5 h-4.5 sm:w-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
        </header>

        <!-- Sidebar Backdrop for Mobile -->
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-40 md:hidden transition-opacity duration-300 opacity-0"></div>

        <!-- Main split container -->
        <div class="grow flex overflow-hidden">
            
            <!-- Left Pane -->
            <div class="flex-grow min-w-0 flex flex-col overflow-hidden bg-white">
                
                <!-- Sub-header Toolbar -->
                <div class="h-20 border-b border-slate-200 px-4 sm:px-12 flex justify-between items-center bg-white shrink-0">
                    <div>
                        <span class="text-[10px] font-extrabold text-[#0050d2] uppercase tracking-wider block">CURRENT LESSON</span>
                        <h2 id="workspace-lesson-title" class="text-base sm:text-xl font-extrabold text-slate-900 mt-1">Pengenalan</h2>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                        <span id="workspace-progress-fraction" class="text-xs sm:text-sm font-extrabold text-slate-800 font-mono">1/{{ $totalModules }}</span>
                        <span class="h-6 w-px bg-slate-200"></span>
                        
                        @if($isAdmin)
                        <!-- Edit Mode Toggle -->
                        <button id="edit-mode-toggle-btn" onclick="toggleEditMode()" class="flex items-center gap-2 text-xs font-bold text-slate-600 border border-slate-200 rounded-xl px-3 py-2 bg-white transition-all duration-200 cursor-pointer shadow-sm hover:bg-slate-50">
                            <span class="w-2 h-2 rounded-full bg-slate-400 transition-colors duration-300" id="edit-mode-indicator"></span>
                            <span class="hidden sm:inline">Edit Mode: <strong id="edit-mode-text">OFF</strong></span>
                            <strong class="sm:hidden" id="edit-mode-text-mobile">OFF</strong>
                        </button>
                        <span class="h-6 w-px bg-slate-200"></span>

                        <!-- Edit Module Action -->
                        <button id="admin-edit-module-btn" onclick="openEditModuleModal()" class="hidden flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-blue-600 hover:bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-1.5 bg-white transition-all duration-200 cursor-pointer shadow-sm active:scale-95">
                            🔧 <span class="hidden sm:inline">Edit Modul</span>
                        </button>
                        <span id="admin-edit-module-separator" class="hidden h-6 w-px bg-slate-200"></span>

                        <!-- Add Module Action -->
                        <button id="admin-add-module-btn" onclick="openAddModuleModal()" class="hidden flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-600 hover:bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-1.5 bg-white transition-all duration-200 cursor-pointer shadow-sm active:scale-95">
                            ➕ <span class="hidden sm:inline">Tambah Modul</span>
                        </button>
                        <span id="admin-add-module-separator" class="hidden h-6 w-px bg-slate-200"></span>
                        @endif

                        <button id="marks-btn" onclick="toggleCurrentModuleMark()" class="flex items-center gap-1.5 text-sm font-extrabold text-[#0050d2] hover:opacity-80 transition-opacity cursor-pointer border-0 bg-transparent">
                            <svg id="marks-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                            </svg>
                            <span id="marks-text" class="hidden sm:inline">Marks</span>
                        </button>
                        <span class="h-6 w-px bg-slate-200"></span>

                        <!-- Sidebar toggle button for both mobile and desktop -->
                        <button id="sidebar-toggle-btn" onclick="toggleSidebar()" class="flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 bg-slate-50 text-slate-600 hover:text-[#0050d2] transition-all cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <span class="h-6 w-px bg-slate-200"></span>

                        <button onclick="closeLearningView()" class="flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 border border-slate-200 rounded-xl px-3 py-1.5 bg-slate-50 transition-all duration-200 cursor-pointer shadow-sm active:scale-95">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </div>
                </div>

                <!-- Content Area -->
                <div id="workspace-scroll-container" class="grow overflow-y-auto px-12 py-10 bg-white custom-scrollbar">
                    <div class="max-w-4xl mx-auto">
                        
                        <!-- Content Box -->
                        <div id="workspace-content-container" class="mb-10">
                            <h1 id="workspace-content-title" class="text-4xl font-extrabold text-slate-950 leading-tight mb-6">
                                Apa itu {{ $path->title }}?
                            </h1>
                            <div id="workspace-content-body" class="ql-editor text-[15px] leading-relaxed text-slate-600 space-y-6">
                                <!-- Injected dynamically -->
                            </div>
                        </div>

                        <!-- Checkpoint Quiz Card -->
                        <div id="workspace-quiz-card" class="bg-white border border-slate-200 rounded-3xl p-8 shadow-[0_4px_24px_-4px_rgba(0,0,0,0.03)] relative overflow-hidden transition-all duration-350 hover:shadow-md cursor-pointer" onclick="launchInteractiveQuiz()">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#0050d2]"></div>
                            
                            <div class="flex flex-col gap-4">
                                <div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold text-[#0050d2] bg-[#EBF3FF] uppercase tracking-wide">
                                        ★ Checkpoint Pembelajaran
                                    </span>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-slate-900 mb-1.5">Siap Menguji Pemahaman Kamu?</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed">Sebelum melanjutkan ke modul selanjutnya, mari pastikan kamu telah menguasai konsep inti dari bab ini.</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0050d2] hover:bg-[#0040a8] border-0 text-white rounded-xl text-xs font-bold shadow-md shadow-[#0050d2]/10 transition-all duration-300">
                                        Mulai Kuis Sekarang
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </button>
                                    @if($isAdmin)
                                    <button id="admin-edit-quiz-btn" type="button" onclick="event.stopPropagation(); openEditQuizModal()" class="hidden inline-flex items-center gap-1.5 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 border-0 text-slate-700 rounded-xl text-xs font-extrabold transition-all duration-300 cursor-pointer">
                                        🔧 Edit Kuis
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Checkpoint Completed Card -->
                        <div id="workspace-quiz-completed-card" class="hidden bg-white border border-slate-200 rounded-3xl p-8 shadow-sm relative overflow-hidden">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500"></div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-md shrink-0">
                                    ✓
                                </div>
                                <div class="flex-grow">
                                    <span class="inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-[9px] font-bold text-emerald-600 bg-emerald-50 uppercase tracking-wide mb-2">Checkpoint Selesai</span>
                                    <h4 class="text-base font-bold text-slate-900 mb-1">Hebat! Checkpoint Telah Diselesaikan</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed">Semua materi pada modul ini telah dipahami dengan baik dan progres tersimpan secara realtime.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer panel inside Pane -->
                <div class="h-16 border-t border-slate-200 px-12 flex justify-between items-center bg-slate-50 shrink-0">
                    <button onclick="closeLearningView()" class="text-xs font-bold text-slate-500 hover:text-slate-800 flex items-center gap-1 cursor-pointer border-0 bg-transparent">
                        &larr; Back to timeline
                    </button>
                    
                    <button id="workspace-next-btn" onclick="goToNextModule()" class="inline-flex items-center gap-1 px-4 py-2 bg-slate-100 hover:bg-blue-50 text-[#0050d2] hover:text-[#0040a8] font-bold rounded-xl text-xs border border-slate-200 transition-all duration-200 active:scale-95 shadow-sm cursor-pointer">
                        Next &rarr;
                    </button>
                </div>

            </div>
            
            <!-- Right Pane: Sidebar -->
            <aside id="learning-sidebar" class="fixed md:relative inset-y-0 md:inset-y-auto right-0 md:right-auto z-50 md:z-auto w-[280px] md:w-[320px] transition-all duration-300 transform translate-x-full md:translate-x-0 border-l border-slate-200 bg-[#F2F7FF] flex flex-col shrink-0 overflow-y-auto shadow-2xl md:shadow-none">
                <div class="bg-[#0050d2] p-6 text-white shrink-0">
                    <span class="text-[9px] font-extrabold tracking-widest text-blue-200/80 uppercase block mb-1">LEARNING PATH</span>
                    <h3 class="text-lg font-black tracking-tight mb-6">{{ $path->title }}</h3>
                    
                    <span class="text-[10px] font-bold text-blue-100 block mb-1.5">Progres</span>
                    <div class="w-full bg-white/20 rounded-full h-1.5 overflow-hidden mb-2">
                        <div id="sidebar-progress-bar" class="bg-white h-1.5 rounded-full transition-all duration-1000" style="width: 0%"></div>
                    </div>
                    <span id="sidebar-progress-text" class="text-[11px] font-bold text-blue-100/90 block">0 of 7 lessons completed</span>
                </div>
                
                <div class="p-6">
                    <h3 class="text-base font-extrabold text-slate-800 mb-4 tracking-tight">Library</h3>
                    <div id="sidebar-library-list" class="divide-y divide-slate-200/60 border-t border-b border-slate-200/60">
                        <!-- Injected dynamically -->
                    </div>
                </div>
            </aside>

        </div>
    </div>

    <!-- Interactive Quiz Modal -->
    <div id="quiz-modal" class="fixed inset-0 z-[110] hidden flex-col bg-[#F3F7FF] transition-all duration-300 opacity-0 transform scale-95 overflow-y-auto">
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute top-[10%] left-[-10%] w-[350px] h-[350px] rounded-full bg-blue-300/25 blur-3xl animate-float-blob" style="animation-duration: 10s;"></div>
            <div class="absolute bottom-[10%] right-[-10%] w-[350px] h-[350px] rounded-full bg-indigo-300/20 blur-3xl animate-float-blob" style="animation-delay: -4s; animation-duration: 12s;"></div>
        </div>

        <div id="quiz-modal-container" class="w-full max-w-4xl mx-auto px-6 py-8 flex flex-col justify-between grow relative z-10">
            <div class="flex justify-between items-center shrink-0 mb-6">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-blue-600 block">KUIS CHECKPOINT</span>
                    <h3 id="quiz-modal-lesson-title" class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight title-font mt-1">HTML Basics</h3>
                    <p class="text-sm text-slate-500 mt-1 font-medium">Kerjakan kuis berikut!</p>
                </div>
                
                <div class="text-right flex flex-col items-end">
                    <span id="quiz-progress-text-main" class="text-[11px] font-bold text-slate-400 tracking-wider uppercase block font-mono">QUESTION 1 OF 5</span>
                    <button onclick="handleQuizCloseAttempt()" class="mt-2 w-10 h-10 rounded-full bg-white hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-700 transition-all duration-200 shadow-sm cursor-pointer border border-slate-200/30 hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="w-full mb-8 shrink-0">
                <div class="w-full bg-slate-200/60 rounded-full h-2 overflow-hidden">
                    <div id="quiz-progress-bar-main" class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: 20%"></div>
                </div>
            </div>

            <div class="grow flex items-center justify-center p-2 relative min-h-[460px] mb-6">
                <div id="quiz-card-stack" class="relative w-full max-w-[460px] h-[440px] mx-auto select-none" style="perspective: 1200px;">
                    <!-- Loaded dynamically -->
                </div>
            </div>

            <!-- Result Overlay Screen -->
            <div id="quiz-result-screen" class="hidden absolute inset-0 bg-[#F3F7FF] z-50 flex flex-col items-center justify-center text-center p-6 animate-fade-in-up">
                <div class="bg-white rounded-[32px] p-8 sm:p-10 max-w-md w-full shadow-2xl border border-slate-100/50 flex flex-col items-center">
                    <div id="result-badge-container" class="w-20 h-20 rounded-[24px] bg-emerald-50 text-emerald-500 flex items-center justify-center text-4xl shadow-sm mb-6 animate-bounce">
                        🎉
                    </div>
                    <h3 id="result-title" class="text-2xl font-black text-slate-950 mb-2">Kuis Selesai!</h3>
                    <p id="result-desc" class="text-sm text-slate-500 leading-relaxed mb-6 font-medium">Kamu berhasil menyelesaikan kuis ini.</p>
                    
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl py-4 px-6 w-full mb-8 flex justify-around">
                        <div>
                            <span class="text-xs text-slate-400 block mb-0.5 font-bold">Total Soal</span>
                            <span class="text-lg font-extrabold text-slate-800">5</span>
                        </div>
                        <div class="w-px bg-slate-200"></div>
                        <div>
                            <span class="text-xs text-slate-400 block mb-0.5 font-bold font-mono">Benar</span>
                            <span id="result-correct-count" class="text-lg font-extrabold text-emerald-600">5</span>
                        </div>
                        <div class="w-px bg-slate-200"></div>
                        <div>
                            <span class="text-xs text-slate-400 block mb-0.5 font-bold">Status</span>
                            <span id="result-status-badge" class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-lg border border-emerald-200">LULUS</span>
                        </div>
                    </div>
                    
                    <button id="result-continue-btn" onclick="closeQuizModalAndUnlock()" class="w-full inline-flex items-center justify-center px-6 py-4 bg-blue-600 hover:bg-blue-700 border-0 text-white font-extrabold rounded-2xl text-sm shadow-lg shadow-blue-500/25 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] cursor-pointer">
                        Lanjutkan Belajar
                    </button>
                    
                    <button id="result-retry-btn" onclick="restartQuiz()" class="w-full mt-3 inline-flex items-center justify-center px-6 py-4 bg-slate-100 hover:bg-slate-200 border-0 text-slate-700 font-extrabold rounded-2xl text-sm transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] cursor-pointer">
                        Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Exit Confirmation Modal -->
    <div id="quiz-exit-confirm-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-[28px] max-w-md w-full p-8 shadow-[0_24px_60px_-15px_rgba(0,0,0,0.3)] border border-slate-100 flex flex-col items-center text-center transform scale-95 transition-all duration-300">
            <div class="w-16 h-16 rounded-[20px] bg-amber-50 text-amber-500 border border-amber-100 flex items-center justify-center text-3xl mb-5 shadow-sm animate-pulse">
                ⚠️
            </div>
            <h3 class="text-xl font-bold text-slate-950 mb-3 title-font">Konfirmasi Keluar</h3>
            <p class="text-sm text-slate-600 leading-relaxed mb-6 font-medium">Apakah kamu yakin ingin menghentikan kuiz? Progres kamu sebelumnya tidak akan terekam. Apakah kamu yakin untuk melanjutkan?</p>
            <div class="flex flex-col gap-3.5 w-full">
                <button onclick="confirmExitQuiz(true)" class="w-full py-3.5 bg-rose-600 hover:bg-rose-700 border-0 text-white font-extrabold rounded-2xl text-xs sm:text-sm transition-all duration-200 cursor-pointer shadow-md shadow-rose-500/10 active:scale-95">
                    Ya, saya yakin
                </button>
                <button onclick="confirmExitQuiz(false)" class="w-full py-3.5 bg-slate-100 hover:bg-slate-200 border-0 text-slate-700 font-extrabold rounded-2xl text-xs sm:text-sm transition-all duration-200 cursor-pointer active:scale-95">
                    Tidak, kembali mengerjakan
                </button>
            </div>
        </div>
    </div>

    <!-- Mini Card Modal (Informasi Umum) -->
    <div id="info-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-sm opacity-0">
        <div id="modal-container" class="bg-white rounded-[28px] max-w-4xl w-full overflow-hidden flex flex-col md:flex-row shadow-[0_24px_60px_-15px_rgba(0,0,0,0.3)] relative transform scale-90 translate-y-8 transition-all duration-500 max-h-[90vh] md:max-h-none overflow-y-auto md:overflow-y-visible">
            
            <button id="close-modal-btn" class="absolute top-4 right-4 z-50 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-800 transition-colors shadow-sm cursor-pointer border border-slate-200/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Left Section -->
            <div class="w-full md:w-[35%] bg-[#f0f4ff] p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden shrink-0">
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f605_1px,transparent_1px),linear-gradient(to_bottom,#3b82f605_1px,transparent_1px)] bg-[size:1.5rem_1.5rem] opacity-70"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center font-extrabold text-xs text-white shadow-md shadow-blue-500/30 mb-6 uppercase font-mono">
                        {{ substr($path->slug, 0, 4) }}
                    </div>
                    
                    <h2 class="text-2xl font-black text-slate-900 leading-tight mb-4 title-font">
                        {{ $path->title }}
                    </h2>
                    
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-3 py-1 bg-blue-600 text-white rounded-full text-xs font-bold shadow-sm">
                            Profesional
                        </span>
                        <span class="px-3 py-1 bg-blue-500 text-white rounded-full text-xs font-bold shadow-sm">
                            Advanced
                        </span>
                    </div>
                </div>

                <div class="w-full h-48 md:h-64 rounded-2xl overflow-hidden shadow-md mt-6 relative border border-white z-10">
                    <img src="{{ $path->image }}" alt="{{ $path->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950/20 to-transparent"></div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="w-full md:w-[65%] p-6 sm:p-8 flex flex-col justify-between shrink-0 overflow-y-auto max-h-[60vh] md:max-h-none">
                <div>
                    <span class="text-xs font-black tracking-wider text-slate-400 uppercase block mb-3 font-mono">
                        DESKRIPSI KARIR
                    </span>
                    
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium mb-6">
                        {{ $path->career_description }}
                    </p>

                    <!-- Columns -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        
                        <!-- Salary Range -->
                        <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4 flex flex-col justify-between">
                            <span class="text-xs font-bold text-slate-400 block mb-1">
                                Estimasi Gaji
                            </span>
                            <div>
                                <span class="text-sm sm:text-base font-black text-blue-600 block">
                                    {{ $path->salary_range }}
                                </span>
                                <span class="text-xs font-bold text-slate-500">
                                    / bulan
                                </span>
                            </div>
                        </div>

                        <!-- Skill Box -->
                        <div class="border border-slate-200/80 rounded-2xl p-4">
                            <span class="text-xs font-bold text-slate-400 block mb-3">
                                Skill yang harus kamu kuasai
                            </span>
                            <div class="flex flex-wrap gap-2">
                                @foreach($path->skills ?? [] as $skill)
                                <span class="inline-flex items-center gap-1 px-2 py-1 border border-slate-200 rounded-lg text-[9px] font-bold text-slate-700 bg-white uppercase">
                                    <span class="text-blue-500 font-mono text-[9px] font-bold">&lt;&gt;</span> {{ $skill }}
                                </span>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <!-- Checklist -->
                    <div class="bg-blue-50/20 border border-blue-100/30 rounded-2xl p-5">
                        <h4 class="text-xs sm:text-sm font-black text-slate-800 tracking-tight title-font mb-4">
                            Cocok buat kamu yang...
                        </h4>
                        <ul class="space-y-3.5 text-xs text-slate-600 font-medium">
                            @foreach($path->suitability ?? [] as $suit)
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ $suit }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if($isAdmin)
    <!-- Edit Module Modal -->
    <div id="edit-module-modal" class="fixed inset-0 z-[120] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-3xl w-full max-w-3xl overflow-hidden shadow-2xl border border-slate-100 transition-transform duration-300 scale-95 flex flex-col max-h-[90vh]">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-xl font-bold text-slate-900 title-font flex items-center gap-2">
                    <span class="w-2.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                    Edit Konten Modul
                </h3>
                <button type="button" onclick="closeEditModuleModal()" class="w-8 h-8 rounded-full hover:bg-slate-200 text-slate-400 hover:text-slate-600 flex items-center justify-center transition-colors border-0 bg-transparent cursor-pointer text-sm">
                    ✕
                </button>
            </div>

            <form id="edit-module-form" onsubmit="submitEditModule(event)" class="flex-grow overflow-y-auto p-8 space-y-6">
                @csrf
                <input type="hidden" id="edit-module-id">

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Modul (Timeline)</label>
                    <input type="text" id="edit-module-title" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Singkat (Timeline/Sidebar)</label>
                    <input type="text" id="edit-module-desc" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Header Konten Workspace</label>
                    <input type="text" id="edit-module-content-title" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Materi Pembelajaran</label>
                    <div id="editor-container" class="bg-white border border-slate-200 rounded-2xl overflow-hidden font-medium text-slate-800 text-sm min-h-[300px]"></div>
                    <input type="hidden" id="edit-module-content-body">
                </div>

                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                    <button type="button" onclick="deleteCurrentModule()" class="px-6 py-3 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 font-bold rounded-2xl text-sm transition-all cursor-pointer">
                        🗑️ Hapus Modul
                    </button>
                    <div class="flex gap-3">
                        <button type="button" onclick="closeEditModuleModal()" class="px-6 py-3 border border-slate-200 bg-transparent hover:bg-slate-50 text-slate-500 font-bold rounded-2xl text-sm transition-colors cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 border-0 text-white font-bold rounded-2xl text-sm transition-all shadow-md shadow-blue-500/10 cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Module Modal -->
    <div id="add-module-modal" class="fixed inset-0 z-[120] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-3xl w-full max-w-3xl overflow-hidden shadow-2xl border border-slate-100 transition-transform duration-300 scale-95 flex flex-col max-h-[90vh]">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-xl font-bold text-slate-900 title-font flex items-center gap-2">
                    <span class="w-2.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                    Tambah Modul Baru
                </h3>
                <button type="button" onclick="closeAddModuleModal()" class="w-8 h-8 rounded-full hover:bg-slate-200 text-slate-400 hover:text-slate-600 flex items-center justify-center transition-colors border-0 bg-transparent cursor-pointer text-sm">
                    ✕
                </button>
            </div>

            <form id="add-module-form" onsubmit="submitAddModule(event)" class="flex-grow overflow-y-auto p-8 space-y-6">
                @csrf
                <input type="hidden" name="path_id" value="{{ $path->id }}">

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Judul Modul (Timeline)</label>
                    <input type="text" id="add-module-title" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm" placeholder="e.g. Pengenalan HTML">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Singkat (Timeline/Sidebar)</label>
                    <input type="text" id="add-module-desc" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm" placeholder="e.g. Memahami sintaks dasar tag HTML dan pembuatannya...">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Header Konten Workspace</label>
                    <input type="text" id="add-module-content-title" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm" placeholder="e.g. Apa itu HTML?">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Materi Pembelajaran</label>
                    <div id="add-editor-container" class="bg-white border border-slate-200 rounded-2xl overflow-hidden font-medium text-slate-800 text-sm min-h-[300px]"></div>
                    <input type="hidden" id="add-module-content-body">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeAddModuleModal()" class="px-6 py-3 border border-slate-200 bg-transparent hover:bg-slate-50 text-slate-500 font-bold rounded-2xl text-sm transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 border-0 text-white font-bold rounded-2xl text-sm transition-all shadow-md shadow-blue-500/10 cursor-pointer">
                        Tambah Modul
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Quiz Modal -->
    <div id="edit-quiz-modal" class="fixed inset-0 z-[120] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-3xl w-full max-w-3xl overflow-hidden shadow-2xl border border-slate-100 transition-transform duration-300 scale-95 flex flex-col max-h-[90vh]">
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-xl font-bold text-slate-900 title-font flex items-center gap-2">
                    <span class="w-2.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                    Edit Checkpoint Quiz
                </h3>
                <button type="button" onclick="closeEditQuizModal()" class="w-8 h-8 rounded-full hover:bg-slate-200 text-slate-400 hover:text-slate-600 flex items-center justify-center transition-colors border-0 bg-transparent cursor-pointer text-sm">
                    ✕
                </button>
            </div>

            <div class="px-8 py-3 bg-slate-50 border-b border-slate-100 flex gap-2">
                @for($i = 0; $i < 5; $i++)
                <button type="button" id="quiz-tab-{{ $i }}" onclick="selectQuizEditTab({{ $i }})" class="px-4 py-2 text-xs font-bold rounded-xl border border-slate-200 transition-all cursor-pointer bg-white text-slate-600 hover:border-blue-400">
                    Soal {{ $i + 1 }}
                </button>
                @endfor
            </div>

            <form id="edit-quiz-form" onsubmit="submitEditQuiz(event)" class="flex-grow overflow-y-auto p-8 space-y-6">
                @csrf
                <input type="hidden" id="edit-quiz-id">

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pertanyaan</label>
                    <textarea id="edit-quiz-question" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm"></textarea>
                </div>

                <div class="space-y-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Pilihan Jawaban</label>
                    
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-slate-400">A.</span>
                        <input type="text" id="edit-quiz-opt-0" class="flex-grow px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-slate-400">B.</span>
                        <input type="text" id="edit-quiz-opt-1" class="flex-grow px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-slate-400">C.</span>
                        <input type="text" id="edit-quiz-opt-2" class="flex-grow px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jawaban Yang Benar</label>
                    <select id="edit-quiz-correct" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm bg-white">
                        <option value="0">Pilihan A</option>
                        <option value="1">Pilihan B</option>
                        <option value="2">Pilihan C</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeEditQuizModal()" class="px-6 py-3 border border-slate-200 bg-transparent hover:bg-slate-50 text-slate-500 font-bold rounded-2xl text-sm transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 border-0 text-white font-bold rounded-2xl text-sm transition-all shadow-md shadow-blue-500/10 cursor-pointer">
                        Simpan Soal Ini
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Interactive JS Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Quill Editor if container exists
            if (document.getElementById('editor-container')) {
                window.quill = new Quill('#editor-container', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'align': [] }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'indent': '-1' }, { 'indent': '+1' }],
                            ['blockquote', 'code-block'],
                            ['link', 'image'],
                            ['clean']
                        ]
                    }
                });
            }

            if (document.getElementById('add-editor-container')) {
                window.addQuill = new Quill('#add-editor-container', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'align': [] }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'indent': '-1' }, { 'indent': '+1' }],
                            ['blockquote', 'code-block'],
                            ['link', 'image'],
                            ['clean']
                        ]
                    }
                });
            }

            // --- Global Learning Path Variables ---
            let currentStep = {{ $currentStep }};
            let totalLessons = {{ count($modules) }};
            let activeModuleIndex = 0;
            let progressChanged = false;
            let selectedOptions = [null, null, null, null, null];
            let currentQuestionIndex = 0;
            let quizScore = 0;
            const markedModules = @json($markedModules ?? []);

            const pathSlug = @json($path->slug);
            const loadTime = Math.floor(Date.now() / 1000);
            let lastUpdated = loadTime;

            // Poll for updates every 10 seconds
            setInterval(() => {
                fetch(`/api/path/${pathSlug}/check-updates?last_updated=${lastUpdated}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.has_updates) {
                            lastUpdated = data.last_updated;
                            showUpdateNotification();
                        }
                    })
                    .catch(err => console.error("Update checking failed", err));
            }, 10000);

            function showUpdateNotification() {
                let toast = document.getElementById('updates-toast');
                if (!toast) {
                    toast = document.createElement('div');
                    toast.id = 'updates-toast';
                    toast.className = 'fixed bottom-6 right-6 z-[99999] bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl p-5 shadow-2xl border border-blue-400/20 max-w-sm flex flex-col gap-3 animate-bounce transition-all duration-300';
                    toast.innerHTML = `
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">⚡</span>
                            <div class="text-left">
                                <h4 class="font-extrabold text-sm text-white">Materi Diperbarui!</h4>
                                <p class="text-xs text-blue-100 mt-0.5 leading-relaxed">Admin baru saja memperbarui konten pembelajaran ini secara realtime.</p>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button onclick="window.location.reload()" class="px-4 py-2 bg-white text-blue-600 font-extrabold rounded-xl text-xs hover:bg-blue-50 transition-colors shadow-sm cursor-pointer border-0">
                                Segarkan Halaman
                            </button>
                        </div>
                    `;
                    document.body.appendChild(toast);
                }
            }

            // --- Modules Data ---
            const modulesData = @json($modulesData);

            // Check session for auto-open redirect logic
            const autoOpenIndex = sessionStorage.getItem('autoOpenModuleIndex');
            if (autoOpenIndex !== null) {
                sessionStorage.removeItem('autoOpenModuleIndex');
                const idx = parseInt(autoOpenIndex, 10);
                setTimeout(() => {
                    openLearningView(idx);
                }, 400);
            } else {
                // Check URL parameters for auto-open redirect logic
                const urlParams = new URLSearchParams(window.location.search);
                const openModuleId = urlParams.get('open_module_id');
                if (openModuleId) {
                    const modIdx = modulesData.findIndex(m => m.id == openModuleId);
                    if (modIdx !== -1) {
                        setTimeout(() => {
                            openLearningView(modIdx);
                        }, 400);
                    }
                }
            }

            // --- Custom Confetti Generator ---
            function triggerConfetti() {
                const container = document.body;
                const colors = ['#2563eb', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#06b6d4'];
                
                for (let i = 0; i < 90; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'confetti-particle';
                    
                    const color = colors[Math.floor(Math.random() * colors.length)];
                    particle.style.backgroundColor = color;
                    particle.style.left = `${Math.random() * 100}vw`;
                    particle.style.top = `${window.scrollY - 30}px`;
                    particle.style.width = `${Math.random() * 8 + 6}px`;
                    particle.style.height = `${Math.random() * 12 + 6}px`;
                    
                    if (Math.random() > 0.5) {
                        particle.style.borderRadius = '50%';
                    }
                    
                    particle.style.animationDuration = `${Math.random() * 1.5 + 1.5}s`;
                    particle.style.animationDelay = `${Math.random() * 0.4}s`;
                    
                    container.appendChild(particle);
                    
                    setTimeout(() => {
                        particle.remove();
                    }, 3000);
                }
            }

            // --- Workspace View Transitions ---
            window.openLearningView = function(index) {
                const isAdmin = @json($isAdmin);
                if (!isAdmin && index > currentStep) {
                    alert('Modul ini masih terkunci! Selesaikan kuis pada modul aktif terlebih dahulu.');
                    return;
                }
                
                const roadmapView = document.getElementById('roadmap-view');
                roadmapView.classList.add('opacity-0');
                setTimeout(() => {
                    roadmapView.classList.add('hidden');
                    
                    const learningView = document.getElementById('learning-view');
                    learningView.classList.remove('hidden');
                    void learningView.offsetWidth;
                    learningView.classList.remove('opacity-0');
                    document.body.classList.add('overflow-hidden');
                    
                    loadModuleContent(index);
                }, 350);
            };

            window.closeLearningView = function() {
                if (progressChanged) {
                    window.location.reload();
                    return;
                }
                
                const learningView = document.getElementById('learning-view');
                learningView.classList.add('opacity-0');
                setTimeout(() => {
                    learningView.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    
                    const roadmapView = document.getElementById('roadmap-view');
                    roadmapView.classList.remove('hidden');
                    void roadmapView.offsetWidth;
                    roadmapView.classList.remove('opacity-0');
                }, 350);
            };

            // Execute script contents injected via innerHTML
            function executeScriptsInElement(element) {
                const scripts = element.querySelectorAll('script');
                scripts.forEach(oldScript => {
                    const newScript = document.createElement('script');
                    Array.from(oldScript.attributes).forEach(attr => {
                        newScript.setAttribute(attr.name, attr.value);
                    });
                    if (oldScript.src) {
                        newScript.src = oldScript.src;
                    } else {
                        newScript.textContent = oldScript.textContent;
                    }
                    oldScript.parentNode.replaceChild(newScript, oldScript);
                });
            }

            // --- Workspace Module Content Loader ---
            window.loadModuleContent = function(index) {
                activeModuleIndex = index;
                const data = modulesData[index];

                // Auto close sidebar on mobile if it is open
                if (window.innerWidth < 768) {
                    const sidebar = document.getElementById('learning-sidebar');
                    const backdrop = document.getElementById('sidebar-backdrop');
                    if (sidebar && sidebar.classList.contains('translate-x-0')) {
                        sidebar.classList.remove('translate-x-0');
                        sidebar.classList.add('translate-x-full');
                        if (backdrop) {
                            backdrop.classList.remove('opacity-100');
                            backdrop.classList.add('opacity-0');
                            setTimeout(() => {
                                backdrop.classList.add('hidden');
                            }, 300);
                        }
                    }
                }

                document.getElementById('workspace-lesson-title').innerText = data.title;
                document.getElementById('workspace-progress-fraction').innerText = `${index + 1}/${totalLessons}`;

                const scrollContainer = document.getElementById('workspace-scroll-container');
                if (scrollContainer) {
                    scrollContainer.scrollTop = 0;
                }

                const titleEl = document.getElementById('workspace-content-title');
                const bodyEl = document.getElementById('workspace-content-body');
                
                titleEl.classList.add('content-fade-enter');
                bodyEl.classList.add('content-fade-enter');

                setTimeout(() => {
                    titleEl.innerText = data.fullTitle;
                    bodyEl.innerHTML = data.content;
                    
                    // Parse and execute custom widget scripts
                    executeScriptsInElement(bodyEl);

                    titleEl.classList.remove('content-fade-enter');
                    bodyEl.classList.remove('content-fade-enter');
                }, 100);

                const marksIcon = document.getElementById('marks-icon');
                const marksText = document.getElementById('marks-text');
                if (markedModules.includes(data.id)) {
                    marksIcon.setAttribute('fill', '#0050d2');
                    if (marksText) marksText.innerText = 'Marked';
                } else {
                    marksIcon.setAttribute('fill', 'none');
                    if (marksText) marksText.innerText = 'Marks';
                }

                if (index < currentStep) {
                    document.getElementById('workspace-quiz-card').classList.add('hidden');
                    document.getElementById('workspace-quiz-completed-card').classList.remove('hidden');
                } else {
                    document.getElementById('workspace-quiz-card').classList.remove('hidden');
                    document.getElementById('workspace-quiz-completed-card').classList.add('hidden');
                }

                const nextBtn = document.getElementById('workspace-next-btn');
                if (nextBtn) {
                    if (index === totalLessons - 1) {
                        nextBtn.innerHTML = `Selesai <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>`;
                    } else {
                        nextBtn.innerHTML = `Next <svg class="w-4 h-4 text-[{{ $accentColor }}]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>`;
                    }
                }

                renderSidebarProgress();
                renderSidebarLibrary();
            };

            // --- Sidebar Render Handlers ---
            function renderSidebarProgress() {
                const completedCount = currentStep;
                const pct = Math.min(100, Math.round((completedCount / totalLessons) * 100));
                document.getElementById('sidebar-progress-bar').style.width = `${pct}%`;
                document.getElementById('sidebar-progress-text').innerText = `${completedCount} of ${totalLessons} lessons completed`;
            }

            function renderSidebarLibrary() {
                const listEl = document.getElementById('sidebar-library-list');
                listEl.innerHTML = '';

                const isAdmin = @json($isAdmin);

                modulesData.forEach((mod, idx) => {
                    const isCompleted = idx < currentStep;
                    const isActive = idx === activeModuleIndex;
                    const isLocked = !isAdmin && (idx > currentStep);

                    let iconHtml = '';
                    let textClass = 'text-slate-600 font-medium';
                    let itemClass = 'bg-transparent border-b border-slate-200/60';
                    let clickAction = `onclick="loadModuleContent(${idx})"`;

                    if (isActive) {
                        textClass = 'text-slate-900 font-bold';
                        iconHtml = `
                            <span class="w-4.5 h-4.5 rounded-full border-2 border-[{{ $accentColor }}] flex items-center justify-center shrink-0">
                            </span>
                        `;
                    } else if (isCompleted) {
                        textClass = 'text-slate-900 font-bold';
                        iconHtml = `
                            <span class="w-4.5 h-4.5 rounded-full bg-emerald-500 flex items-center justify-center shrink-0 text-white font-black text-[9px]">
                                ✓
                            </span>
                        `;
                    } else if (isLocked) {
                        textClass = 'text-slate-400 font-medium';
                        itemClass = 'opacity-65 cursor-not-allowed border-b border-slate-200/60';
                        clickAction = '';
                        iconHtml = `
                            <span class="text-slate-400 shrink-0">
                                <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        `;
                    }

                    const itemHtml = `
                        <div ${clickAction} class="flex items-center justify-between py-4 px-2 cursor-pointer transition-all duration-200 ${itemClass}">
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-slate-400 font-mono">${idx + 1 < 10 ? '0' : ''}${idx + 1}</span>
                                <span class="text-xs leading-snug ${textClass}">${mod.title}</span>
                            </div>
                            ${iconHtml}
                        </div>
                    `;
                    listEl.insertAdjacentHTML('beforeend', itemHtml);
                });
            }

            // --- Next Module Action ---
            window.goToNextModule = function() {
                const isAdmin = @json($isAdmin);
                if (activeModuleIndex === totalLessons - 1) {
                    closeLearningView();
                    return;
                }

                if (isAdmin || activeModuleIndex < currentStep) {
                    loadModuleContent(activeModuleIndex + 1);
                } else {
                    alert('Selesaikan checkpoint kuis terlebih dahulu untuk membuka modul berikutnya!');
                }
            };

            // --- Toggle Checkpoint Mark ---
            window.toggleCurrentModuleMark = function() {
                const isAdmin = @json($isAdmin);
                if (isAdmin) return; // Admins don't write progress

                const data = modulesData[activeModuleIndex];
                const csrfToken = document.querySelector('input[name="_token"]').value;

                fetch(`/path/module/${data.id}/toggle-mark`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(resData => {
                    if (resData.success) {
                        if (resData.is_marked) {
                            if (!markedModules.includes(data.id)) {
                                markedModules.push(data.id);
                            }
                            document.getElementById('marks-icon').setAttribute('fill', '#0050d2');
                            const marksText = document.getElementById('marks-text');
                            if (marksText) marksText.innerText = 'Marked';
                        } else {
                            const idx = markedModules.indexOf(data.id);
                            if (idx !== -1) {
                                markedModules.splice(idx, 1);
                            }
                            document.getElementById('marks-icon').setAttribute('fill', 'none');
                            const marksText = document.getElementById('marks-text');
                            if (marksText) marksText.innerText = 'Marks';
                        }
                    }
                })
                .catch(err => {
                    console.error("Error toggling bookmark:", err);
                });
            };

            // --- Complete Active Step via AJAX ---
            function completeActiveModuleRealtime() {
                const csrfToken = document.querySelector('input[name="_token"]').value;

                fetch("{{ $completeRoute }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        currentStep = data.currentStep;
                        progressChanged = true;
                        triggerConfetti();
                        loadModuleContent(activeModuleIndex);
                    }
                })
                .catch(err => {
                    console.error("AJAX Error: ", err);
                    currentStep++;
                    progressChanged = true;
                    triggerConfetti();
                    loadModuleContent(activeModuleIndex);
                });
            }

            // --- Quiz System Logic ---
            window.launchInteractiveQuiz = function() {
                const data = modulesData[activeModuleIndex];
                
                document.getElementById('quiz-modal-lesson-title').innerText = data.title;
                
                currentQuestionIndex = 0;
                quizScore = 0;
                selectedOptions = [null, null, null, null, null];

                const resultScreen = document.getElementById('quiz-result-screen');
                resultScreen.classList.remove('flex');
                resultScreen.classList.add('hidden');

                renderQuizStack();

                const quizModal = document.getElementById('quiz-modal');
                quizModal.classList.remove('hidden');
                quizModal.classList.add('flex');
                void quizModal.offsetWidth;
                quizModal.classList.add('show');
                quizModal.classList.remove('opacity-0', 'scale-95');
                quizModal.classList.add('opacity-100', 'scale-100');
                document.body.classList.add('overflow-hidden');
            };

            window.closeQuizModal = function() {
                const quizModal = document.getElementById('quiz-modal');
                quizModal.classList.remove('show');
                quizModal.classList.remove('opacity-100', 'scale-100');
                quizModal.classList.add('opacity-0', 'scale-95');
                document.body.classList.remove('overflow-hidden');
                setTimeout(() => {
                    quizModal.classList.remove('flex');
                    quizModal.classList.add('hidden');
                }, 300);
            };

            window.handleQuizCloseAttempt = function() {
                const resultScreen = document.getElementById('quiz-result-screen');
                const isResultOpen = resultScreen && !resultScreen.classList.contains('hidden');
                
                if (isResultOpen) {
                    closeQuizModal();
                } else {
                    const confirmModal = document.getElementById('quiz-exit-confirm-modal');
                    if (confirmModal) {
                        confirmModal.classList.remove('hidden');
                        confirmModal.classList.add('flex');
                        void confirmModal.offsetWidth;
                        confirmModal.classList.remove('opacity-0');
                        confirmModal.classList.add('opacity-100');
                        confirmModal.querySelector('div').classList.remove('scale-95');
                        confirmModal.querySelector('div').classList.add('scale-100');
                    }
                }
            };

            window.confirmExitQuiz = function(shouldExit) {
                const confirmModal = document.getElementById('quiz-exit-confirm-modal');
                if (confirmModal) {
                    confirmModal.classList.remove('opacity-100');
                    confirmModal.classList.add('opacity-0');
                    confirmModal.querySelector('div').classList.remove('scale-100');
                    confirmModal.querySelector('div').classList.add('scale-95');
                    setTimeout(() => {
                        confirmModal.classList.remove('flex');
                        confirmModal.classList.add('hidden');
                        if (shouldExit) {
                            closeQuizModal();
                        }
                    }, 300);
                }
            };

            function renderQuizStack() {
                const data = modulesData[activeModuleIndex];
                const stackContainer = document.getElementById('quiz-card-stack');
                stackContainer.innerHTML = '';

                data.quiz.forEach((q, qIdx) => {
                    let optionsHtml = '';
                    q.options.forEach((opt, oIdx) => {
                        optionsHtml += `
                            <div id="quiz-opt-card-${qIdx}-${oIdx}" onclick="selectQuizOption(${qIdx}, ${oIdx})" class="quiz-option-card">
                                <span class="quiz-opt-indicator" id="quiz-opt-indicator-${qIdx}-${oIdx}">
                                    <span class="quiz-opt-dot" id="quiz-opt-dot-${qIdx}-${oIdx}"></span>
                                </span>
                                <span class="quiz-opt-text">${opt}</span>
                            </div>
                        `;
                    });

                    const cardHtml = `
                        <div id="quiz-card-item-${qIdx}" class="quiz-card-stack-item">
                            <div class="quiz-card-inner w-full h-full">
                                <!-- FRONT -->
                                <div class="quiz-card-front">
                                    <div class="flex justify-between items-start mb-4 shrink-0">
                                        <span class="text-xs font-black tracking-wider text-slate-400 font-mono">PERTANYAAN ${qIdx + 1} DARI 5</span>
                                        <span class="text-3xl font-extrabold text-slate-300 font-sans">${qIdx + 1}</span>
                                    </div>
                                    
                                    <div class="grow flex flex-col justify-between overflow-y-auto pr-1">
                                        <div>
                                            <h4 class="text-lg sm:text-xl font-bold text-slate-800 leading-snug mb-6">${q.question}</h4>
                                            <div class="space-y-3 mb-6">
                                                ${optionsHtml}
                                            </div>
                                        </div>
                                        
                                        <div class="flex justify-end pt-4 border-t border-slate-100 shrink-0">
                                            <button id="quiz-confirm-btn-${qIdx}" disabled onclick="verifyQuizCardAnswer(${qIdx})" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-slate-100 text-slate-400 font-extrabold rounded-2xl text-xs sm:text-sm transition-all duration-300 cursor-not-allowed border-0">
                                                Verifikasi Jawaban
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- BACK -->
                                <div class="quiz-card-back">
                                    <div class="flex justify-between items-start mb-4 shrink-0">
                                        <span class="text-xs font-black tracking-wider text-slate-400 font-mono">HASIL CHECKPOINT</span>
                                        <span id="result-icon-${qIdx}" class="text-xl">🎉</span>
                                    </div>
                                    
                                    <div class="grow flex flex-col justify-between overflow-y-auto">
                                        <div class="text-center py-6 flex flex-col items-center justify-center grow">
                                            <div id="feedback-badge-${qIdx}" class="w-16 h-16 rounded-[20px] flex items-center justify-center text-3xl mb-4 shadow-sm animate-bounce">
                                                🎉
                                            </div>
                                            <h4 id="feedback-title-${qIdx}" class="text-lg font-black mb-2 text-slate-950">Jawaban Kamu Benar!</h4>
                                            <p id="feedback-desc-${qIdx}" class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-xs font-medium"></p>
                                        </div>
                                        
                                        <div class="flex justify-end pt-4 border-t border-slate-100 shrink-0">
                                            <button onclick="slideOutAndNext(${qIdx})" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl text-xs sm:text-sm transition-all duration-300 shadow-md shadow-blue-500/20 cursor-pointer border-0">
                                                Lanjut
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    stackContainer.insertAdjacentHTML('beforeend', cardHtml);
                });

                updateStackTransforms();
                updateQuizProgressIndicators();
            }

            function updateStackTransforms() {
                const cards = document.querySelectorAll('.quiz-card-stack-item');
                cards.forEach((card, index) => {
                    const relativeIndex = index - currentQuestionIndex;
                    
                    if (card.classList.contains('move-to-back')) {
                        return;
                    }

                    if (relativeIndex < 0) {
                        card.classList.add('move-to-back');
                        card.style.pointerEvents = 'none';
                        return;
                    }
                    
                    if (relativeIndex === 0) {
                        card.classList.remove('slide-out', 'move-to-back');
                        card.style.transform = 'translate3d(0, 0, 0) scale(1) rotate(0deg)';
                        card.style.zIndex = '50';
                        card.style.opacity = '1';
                        card.style.pointerEvents = 'auto';
                    } else {
                        card.classList.remove('slide-out', 'move-to-back');
                        const offsetTranslateY = relativeIndex * 12;
                        const offsetTranslateZ = -relativeIndex * 20;
                        const scale = 1 - (relativeIndex * 0.04);
                        const opacity = 1 - (relativeIndex * 0.15);
                        const rotate = (relativeIndex % 2 === 0 ? 1.5 : -1.5) * relativeIndex;
                        
                        card.style.transform = `translate3d(0, ${offsetTranslateY}px, ${offsetTranslateZ}px) scale(${scale}) rotate(${rotate}deg)`;
                        card.style.zIndex = `${50 - relativeIndex}`;
                        card.style.opacity = opacity > 0 ? opacity.toString() : '0';
                        card.style.pointerEvents = 'none';
                    }
                });
            }

            function updateQuizProgressIndicators() {
                const progressText = document.getElementById('quiz-progress-text-main');
                const progressBar = document.getElementById('quiz-progress-bar-main');
                
                const currentQ = Math.min(5, currentQuestionIndex + 1);
                progressText.innerText = `SOAL ${currentQ} DARI 5`;
                
                const pct = Math.round((currentQ / 5) * 100);
                progressBar.style.width = `${pct}%`;
            }

            window.selectQuizOption = function(qIdx, oIdx) {
                const cardEl = document.getElementById(`quiz-card-item-${qIdx}`);
                if (cardEl && cardEl.classList.contains('flipped')) return;

                selectedOptions[qIdx] = oIdx;

                const q = modulesData[activeModuleIndex].quiz[qIdx];
                for (let i = 0; i < q.options.length; i++) {
                    const optEl = document.getElementById(`quiz-opt-card-${qIdx}-${i}`);
                    if (optEl) {
                        optEl.classList.remove('selected');
                    }
                }

                const selEl = document.getElementById(`quiz-opt-card-${qIdx}-${oIdx}`);
                if (selEl) {
                    selEl.classList.add('selected');
                }

                const verifyBtn = document.getElementById(`quiz-confirm-btn-${qIdx}`);
                if (verifyBtn) {
                    verifyBtn.className = "px-6 py-3.5 bg-[#0050d2] hover:bg-[#0040a8] text-white font-extrabold rounded-2xl text-xs sm:text-sm transition-all duration-300 cursor-pointer shadow-md shadow-[#0050d2]/15 border-0";
                    verifyBtn.removeAttribute('disabled');
                }
            };

            window.verifyQuizCardAnswer = function(qIdx) {
                const data = modulesData[activeModuleIndex];
                const q = data.quiz[qIdx];
                const userChoice = selectedOptions[qIdx];
                const isCorrect = userChoice === q.correct;

                for (let i = 0; i < q.options.length; i++) {
                    const optEl = document.getElementById(`quiz-opt-card-${qIdx}-${i}`);
                    if (optEl) optEl.classList.remove('selected');
                }

                const userOptEl = document.getElementById(`quiz-opt-card-${qIdx}-${userChoice}`);
                const correctOptEl = document.getElementById(`quiz-opt-card-${qIdx}-${q.correct}`);

                if (isCorrect) {
                    if (userOptEl) userOptEl.classList.add('correct');
                    quizScore++;
                } else {
                    if (userOptEl) userOptEl.classList.add('incorrect');
                    if (correctOptEl) correctOptEl.classList.add('correct');
                }

                const feedbackBadge = document.getElementById(`feedback-badge-${qIdx}`);
                const feedbackTitle = document.getElementById(`feedback-title-${qIdx}`);
                const feedbackDesc = document.getElementById(`feedback-desc-${qIdx}`);
                const resultIcon = document.getElementById(`result-icon-${qIdx}`);

                if (isCorrect) {
                    feedbackBadge.className = "w-16 h-16 rounded-[20px] bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl mb-4 shadow-sm border border-emerald-100";
                    feedbackBadge.innerHTML = "🎉";
                    feedbackTitle.innerText = "Jawaban Kamu Benar!";
                    feedbackTitle.className = "text-lg font-black mb-2 text-emerald-600";
                    feedbackDesc.innerText = "Hebat! Pemahaman kamu tentang materi ini sangat baik.";
                    resultIcon.innerText = "🎉";
                } else {
                    feedbackBadge.className = "w-16 h-16 rounded-[20px] bg-rose-50 text-rose-600 flex items-center justify-center text-3xl mb-4 shadow-sm border border-rose-100";
                    feedbackBadge.innerHTML = "❌";
                    feedbackTitle.innerText = "Jawaban Kamu Salah";
                    feedbackTitle.className = "text-lg font-black mb-2 text-rose-600";
                    
                    const correctOptionText = q.options[q.correct];
                    feedbackDesc.innerHTML = `Kurang tepat. Jawaban yang benar adalah:<br><strong class="text-slate-800 mt-1.5 inline-block text-sm bg-slate-50 border border-slate-200/50 py-1.5 px-3 rounded-xl">${correctOptionText}</strong>`;
                    resultIcon.innerText = "❌";
                }

                const cardEl = document.getElementById(`quiz-card-item-${qIdx}`);
                if (cardEl) {
                    cardEl.classList.add('flipped');
                }
            };

            window.slideOutAndNext = function(qIdx) {
                const cardEl = document.getElementById(`quiz-card-item-${qIdx}`);
                if (cardEl) {
                    cardEl.style.transform = '';
                    cardEl.classList.remove('flipped');
                    cardEl.classList.add('move-to-back');
                }
                
                currentQuestionIndex++;
                
                setTimeout(() => {
                    if (currentQuestionIndex < 5) {
                        updateStackTransforms();
                        updateQuizProgressIndicators();
                    } else {
                        showQuizResults();
                    }
                }, 600);
            };

            function showQuizResults() {
                const resultScreen = document.getElementById('quiz-result-screen');
                const resultBadge = document.getElementById('result-badge-container');
                const resultTitle = document.getElementById('result-title');
                const resultDesc = document.getElementById('result-desc');
                const resultCorrect = document.getElementById('result-correct-count');
                const resultStatus = document.getElementById('result-status-badge');
                const resultContinueBtn = document.getElementById('result-continue-btn');

                resultCorrect.innerText = `${quizScore} / 5`;

                const isAdmin = @json($isAdmin);

                if (quizScore >= 4) {
                    resultBadge.className = "w-20 h-20 rounded-[24px] bg-emerald-50 text-emerald-500 flex items-center justify-center text-4xl shadow-sm mb-6 animate-bounce";
                    resultBadge.innerHTML = "🎉";
                    resultTitle.innerText = "Luar Biasa! Kuis Selesai";
                    resultDesc.innerText = "Kamu berhasil menyelesaikan checkpoint ini dengan sangat baik. Progres belajar kamu disimpan secara real-time.";
                    resultStatus.innerText = "LULUS";
                    resultStatus.className = "text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-lg border border-emerald-200";
                    
                    resultContinueBtn.classList.remove('hidden');
                    if (!isAdmin && activeModuleIndex === currentStep) {
                        completeActiveModuleRealtime();
                    }
                } else {
                    resultBadge.className = "w-20 h-20 rounded-[24px] bg-rose-50 text-rose-500 flex items-center justify-center text-4xl shadow-sm mb-6";
                    resultBadge.innerHTML = "❌";
                    resultTitle.innerText = "Belum Lulus Checkpoint";
                    resultDesc.innerText = "Nilai kamu masih di bawah batas kelulusan (minimal 4 benar). Ulangi kuis untuk menuntaskan checkpoint ini.";
                    resultStatus.innerText = "GAGAL";
                    resultStatus.className = "text-xs font-bold text-rose-600 bg-rose-50 px-2.5 py-0.5 rounded-lg border border-rose-200";
                    
                    resultContinueBtn.classList.add('hidden');
                }

                resultScreen.classList.remove('hidden');
                resultScreen.classList.add('flex');
            }

            window.restartQuiz = function() {
                currentQuestionIndex = 0;
                quizScore = 0;
                selectedOptions = [null, null, null, null, null];

                const resultScreen = document.getElementById('quiz-result-screen');
                resultScreen.classList.remove('flex');
                resultScreen.classList.add('hidden');

                renderQuizStack();
            };

            window.closeQuizModalAndUnlock = function() {
                closeQuizModal();
                if (progressChanged && activeModuleIndex < totalLessons - 1) {
                    sessionStorage.setItem('autoOpenModuleIndex', activeModuleIndex + 1);
                    window.location.reload();
                } else if (activeModuleIndex + 1 <= currentStep && activeModuleIndex < totalLessons - 1) {
                    setTimeout(() => {
                        loadModuleContent(activeModuleIndex + 1);
                    }, 300);
                } else {
                    closeLearningView();
                }
            };

            // --- 3D Wobble Tilt Card ---
            const cards = document.querySelectorAll('.wobble-card');
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const width = rect.width;
                    const height = rect.height;
                    const rotateX = ((y / height) - 0.5) * -12;
                    const rotateY = ((x / width) - 0.5) * 12;
                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.025)`;
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
                });
            });

            // --- Scroll Shrink Header ---
            const scrollContainer = document.getElementById('workspace-scroll-container');
            const headerEl = document.querySelector('#learning-view header');
            if (scrollContainer && headerEl) {
                scrollContainer.addEventListener('scroll', () => {
                    if (scrollContainer.scrollTop > 50) {
                        headerEl.classList.add('shrink');
                    } else {
                        headerEl.classList.remove('shrink');
                    }
                });
            }

            // --- Floating Particles ---
            const particleContainer = document.getElementById('particle-container');
            const icons = ['💻', '🚀', '⚡', '📐', '🧠', '✨', '🎓', '🎨', '🔥', '📚'];
            
            for (let i = 0; i < 15; i++) {
                const item = document.createElement('div');
                item.className = 'absolute select-none cursor-pointer transition-all duration-500 hover:scale-150 hover:rotate-[360deg] active:scale-95 text-xl opacity-[0.16] hover:opacity-85 filter drop-shadow-sm pointer-events-auto';
                item.innerText = icons[Math.floor(Math.random() * icons.length)];
                item.style.left = `${Math.random() * 92 + 4}%`;
                item.style.top = `${Math.random() * 85 + 10}%`;
                
                const animName = `float-curric-${i}`;
                const keyframes = `
                    @keyframes ${animName} {
                        0%, 100% { transform: translateY(0px) rotate(0deg); }
                        50% { transform: translateY(${Math.random() * -35 - 20}px) rotate(${Math.random() * 24 - 12}deg); }
                    }
                `;
                const styleSheet = document.createElement('style');
                styleSheet.innerText = keyframes;
                document.head.appendChild(styleSheet);
                
                item.style.animation = `${animName} ${Math.random() * 6 + 8}s ease-in-out infinite`;
                particleContainer.appendChild(item);
                
                item.addEventListener('click', () => {
                    item.style.transform = 'scale(2.2) rotate(360deg)';
                    item.style.opacity = '1';
                    setTimeout(() => {
                        item.style.transform = '';
                        item.style.opacity = '0.16';
                    }, 800);
                });
            }

            // --- Cursor Trails ---
            const body = document.body;
            const trailSymbols = ['{}', '</>', '[]', '()', '=>', '10', 'js', 'html', 'css', 'react', 'ts', 'git'];
            body.addEventListener('mousemove', (e) => {
                if (Math.random() > 0.25) return;
                const element = document.createElement('div');
                element.innerText = trailSymbols[Math.floor(Math.random() * trailSymbols.length)];
                element.className = 'absolute font-mono font-black select-none pointer-events-none text-blue-600/80 drop-shadow-[0_0_5px_rgba(37,99,235,0.5)] z-[9999]';
                element.style.left = `${e.pageX}px`;
                element.style.top = `${e.pageY}px`;
                element.style.fontSize = `${Math.random() * 10 + 11}px`;
                element.style.transition = 'transform 1.1s cubic-bezier(0.1, 0.8, 0.3, 1), opacity 1.4s ease-out';
                element.style.transform = 'translate(-50%, -50%) scale(0.4)';
                element.style.opacity = '1';
                
                body.appendChild(element);
                
                setTimeout(() => {
                    const diffX = (Math.random() - 0.5) * 110;
                    const diffY = -70 - Math.random() * 50;
                    const deg = Math.random() * 360 + 120;
                    element.style.transform = `translate(calc(-50% + ${diffX}px), calc(-50% + ${diffY}px)) scale(0) rotate(${deg}deg)`;
                    element.style.opacity = '0';
                }, 40);
                
                setTimeout(() => {
                    element.remove();
                }, 1500);
            });

            // --- Scroll Reveal ---
            const revealElements = document.querySelectorAll('.reveal-on-scroll');
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                    }
                });
            }, observerOptions);
            revealElements.forEach(el => observer.observe(el));

            // --- Info Modal Logic ---
            const infoModal = document.getElementById('info-modal');
            const openModalBtn = document.getElementById('open-info-btn');
            const closeModalBtn = document.getElementById('close-modal-btn');

            function openModal() {
                infoModal.classList.remove('hidden');
                infoModal.classList.add('flex');
                void infoModal.offsetWidth;
                infoModal.classList.add('show');
                document.body.classList.add('overflow-hidden');
            }
            function closeModal() {
                infoModal.classList.remove('show');
                document.body.classList.remove('overflow-hidden');
                setTimeout(() => {
                    infoModal.classList.remove('flex');
                    infoModal.classList.add('hidden');
                }, 350);
            }
            if (openModalBtn) openModalBtn.addEventListener('click', openModal);
            if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
            infoModal.addEventListener('click', (e) => {
                if (e.target === infoModal) {
                    closeModal();
                }
            });

            @if($isAdmin)
            // --- Admin Modals Logic ---
            let editModeActive = false;
            window.toggleEditMode = function() {
                editModeActive = !editModeActive;
                const toggleBtn = document.getElementById('edit-mode-toggle-btn');
                const indicator = document.getElementById('edit-mode-indicator');
                const text = document.getElementById('edit-mode-text');
                const textMobile = document.getElementById('edit-mode-text-mobile');
                const editModBtn = document.getElementById('admin-edit-module-btn');
                const editModSep = document.getElementById('admin-edit-module-separator');
                const editQuizBtn = document.getElementById('admin-edit-quiz-btn');

                if (editModeActive) {
                    if (toggleBtn) {
                        toggleBtn.classList.remove('text-slate-600', 'border-slate-200', 'bg-white');
                        toggleBtn.classList.add('text-emerald-700', 'border-emerald-200', 'bg-emerald-50');
                    }
                    if (indicator) {
                        indicator.classList.remove('bg-slate-400');
                        indicator.classList.add('bg-emerald-500', 'animate-pulse');
                    }
                    if (text) text.innerText = 'ON';
                    if (textMobile) textMobile.innerText = 'ON';

                    if (editModBtn) editModBtn.classList.remove('hidden');
                    if (editModSep) editModSep.classList.remove('hidden');
                    const addModBtn = document.getElementById('admin-add-module-btn');
                    const addModSep = document.getElementById('admin-add-module-separator');
                    if (addModBtn) addModBtn.classList.remove('hidden');
                    if (addModSep) addModSep.classList.remove('hidden');
                    if (editQuizBtn) editQuizBtn.classList.remove('hidden');
                } else {
                    if (toggleBtn) {
                        toggleBtn.classList.remove('text-emerald-700', 'border-emerald-200', 'bg-emerald-50');
                        toggleBtn.classList.add('text-slate-600', 'border-slate-200', 'bg-white');
                    }
                    if (indicator) {
                        indicator.classList.remove('bg-emerald-500', 'animate-pulse');
                        indicator.classList.add('bg-slate-400');
                    }
                    if (text) text.innerText = 'OFF';
                    if (textMobile) textMobile.innerText = 'OFF';

                    if (editModBtn) editModBtn.classList.add('hidden');
                    if (editModSep) editModSep.classList.add('hidden');
                    const addModBtn = document.getElementById('admin-add-module-btn');
                    const addModSep = document.getElementById('admin-add-module-separator');
                    if (addModBtn) addModBtn.classList.add('hidden');
                    if (addModSep) addModSep.classList.add('hidden');
                    if (editQuizBtn) editQuizBtn.classList.add('hidden');
                }
            };

            const editModuleModal = document.getElementById('edit-module-modal');
            const editQuizModal = document.getElementById('edit-quiz-modal');
            let editingQuizIndex = 0;

            window.openEditModuleModal = function() {
                const data = modulesData[activeModuleIndex];
                document.getElementById('edit-module-id').value = data.id;
                document.getElementById('edit-module-title').value = data.title;
                document.getElementById('edit-module-desc').value = data.desc;
                document.getElementById('edit-module-content-title').value = data.fullTitle;
                
                // Set Quill Editor content
                if (window.quill) {
                    window.quill.clipboard.dangerouslyPasteHTML(data.content || '');
                } else {
                    document.getElementById('edit-module-content-body').value = data.content;
                }

                editModuleModal.classList.remove('hidden');
                editModuleModal.classList.add('flex');
                setTimeout(() => {
                    editModuleModal.classList.add('opacity-100');
                    editModuleModal.querySelector('div').classList.remove('scale-95');
                    editModuleModal.querySelector('div').classList.add('scale-100');
                }, 50);
            };

            window.closeEditModuleModal = function() {
                editModuleModal.classList.remove('opacity-100');
                editModuleModal.querySelector('div').classList.remove('scale-100');
                editModuleModal.querySelector('div').classList.add('scale-95');
                setTimeout(() => {
                    editModuleModal.classList.remove('flex');
                    editModuleModal.classList.add('hidden');
                }, 300);
            };

            window.submitEditModule = function(e) {
                e.preventDefault();
                const moduleId = document.getElementById('edit-module-id').value;
                const csrfToken = document.querySelector('input[name="_token"]').value;

                let contentHTML = '';
                if (window.quill) {
                    contentHTML = window.quill.root.innerHTML;
                } else {
                    contentHTML = document.getElementById('edit-module-content-body').value;
                }

                const data = {
                    title: document.getElementById('edit-module-title').value,
                    desc: document.getElementById('edit-module-desc').value,
                    content_title: document.getElementById('edit-module-content-title').value,
                    content_body: contentHTML,
                };

                fetch(`/admin/module/${moduleId}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(resData => {
                    if (resData.success) {
                        alert(resData.message);
                        window.location.reload();
                    } else {
                        alert('Gagal menyimpan: ' + JSON.stringify(resData.errors || resData.message));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan jaringan.');
                });
            };

            window.openEditQuizModal = function() {
                editingQuizIndex = 0;
                selectQuizEditTab(0);

                editQuizModal.classList.remove('hidden');
                editQuizModal.classList.add('flex');
                setTimeout(() => {
                    editQuizModal.classList.add('opacity-100');
                    editQuizModal.querySelector('div').classList.remove('scale-95');
                    editQuizModal.querySelector('div').classList.add('scale-100');
                }, 50);
            };

            window.closeEditQuizModal = function() {
                editQuizModal.classList.remove('opacity-100');
                editQuizModal.querySelector('div').classList.remove('scale-100');
                editQuizModal.querySelector('div').classList.add('scale-95');
                setTimeout(() => {
                    editQuizModal.classList.remove('flex');
                    editQuizModal.classList.add('hidden');
                }, 300);
            };

            window.selectQuizEditTab = function(idx) {
                editingQuizIndex = idx;
                
                for(let i=0; i<5; i++) {
                    const tabBtn = document.getElementById(`quiz-tab-${i}`);
                    if (i === idx) {
                        tabBtn.className = "px-4 py-2 text-xs font-bold rounded-xl border border-blue-500 bg-blue-50 text-blue-600 transition-all cursor-pointer";
                    } else {
                        tabBtn.className = "px-4 py-2 text-xs font-bold rounded-xl border border-slate-200 bg-white text-slate-600 hover:border-blue-400 transition-all cursor-pointer";
                    }
                }

                const data = modulesData[activeModuleIndex];
                const quizItem = data.quiz[idx];
                
                if (quizItem) {
                    document.getElementById('edit-quiz-id').value = quizItem.id;
                    document.getElementById('edit-quiz-question').value = quizItem.question;
                    document.getElementById('edit-quiz-opt-0').value = quizItem.options[0] || '';
                    document.getElementById('edit-quiz-opt-1').value = quizItem.options[1] || '';
                    document.getElementById('edit-quiz-opt-2').value = quizItem.options[2] || '';
                    document.getElementById('edit-quiz-correct').value = quizItem.correct;
                } else {
                    alert("Data kuis tidak ditemukan!");
                }
            };

            window.submitEditQuiz = function(e) {
                e.preventDefault();
                const quizId = document.getElementById('edit-quiz-id').value;
                const csrfToken = document.querySelector('input[name="_token"]').value;

                const data = {
                    question: document.getElementById('edit-quiz-question').value,
                    options: [
                        document.getElementById('edit-quiz-opt-0').value,
                        document.getElementById('edit-quiz-opt-1').value,
                        document.getElementById('edit-quiz-opt-2').value
                    ],
                    correct: parseInt(document.getElementById('edit-quiz-correct').value, 10)
                };

                fetch(`/admin/quiz/${quizId}/update`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(resData => {
                    if (resData.success) {
                        alert(resData.message);
                        
                        const localQuiz = modulesData[activeModuleIndex].quiz[editingQuizIndex];
                        localQuiz.question = data.question;
                        localQuiz.options = data.options;
                        localQuiz.correct = data.correct;
                        
                        if (editingQuizIndex < 4) {
                            selectQuizEditTab(editingQuizIndex + 1);
                        } else {
                            closeEditQuizModal();
                            window.location.reload();
                        }
                    } else {
                        alert('Gagal menyimpan kuis: ' + JSON.stringify(resData.errors || resData.message));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan jaringan.');
                });
            };

            const addModuleModal = document.getElementById('add-module-modal');

            window.openAddModuleModal = function() {
                document.getElementById('add-module-form').reset();
                if (window.addQuill) {
                    window.addQuill.setText('');
                } else {
                    document.getElementById('add-module-content-body').value = '';
                }

                addModuleModal.classList.remove('hidden');
                addModuleModal.classList.add('flex');
                setTimeout(() => {
                    addModuleModal.classList.add('opacity-100');
                    addModuleModal.querySelector('div').classList.remove('scale-95');
                    addModuleModal.querySelector('div').classList.add('scale-100');
                }, 50);
            };

            window.closeAddModuleModal = function() {
                addModuleModal.classList.remove('opacity-100');
                addModuleModal.querySelector('div').classList.remove('scale-100');
                addModuleModal.querySelector('div').classList.add('scale-95');
                setTimeout(() => {
                    addModuleModal.classList.remove('flex');
                    addModuleModal.classList.add('hidden');
                }, 300);
            };

            window.submitAddModule = function(e) {
                e.preventDefault();
                const csrfToken = document.querySelector('input[name="_token"]').value;

                let contentHTML = '';
                if (window.addQuill) {
                    contentHTML = window.addQuill.root.innerHTML;
                } else {
                    contentHTML = document.getElementById('add-module-content-body').value;
                }

                const data = {
                    title: document.getElementById('add-module-title').value,
                    desc: document.getElementById('add-module-desc').value,
                    content_title: document.getElementById('add-module-content-title').value,
                    content_body: contentHTML,
                };

                fetch(`/admin/path/{{ $path->id }}/module/store`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(resData => {
                    if (resData.success) {
                        alert(resData.message);
                        window.location.reload();
                    } else {
                        alert('Gagal menambahkan modul: ' + JSON.stringify(resData.errors || resData.message));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan jaringan.');
                });
            };

            window.deleteCurrentModule = function() {
                const moduleId = document.getElementById('edit-module-id').value;
                const moduleTitle = document.getElementById('edit-module-title').value;

                if (!confirm(`Apakah Anda yakin ingin menghapus modul "${moduleTitle}" beserta seluruh kuis di dalamnya? Tindakan ini akan menggeser urutan modul lainnya.`)) {
                    return;
                }

                const csrfToken = document.querySelector('input[name="_token"]').value;

                fetch(`/admin/module/${moduleId}/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(resData => {
                    if (resData.success) {
                        alert(resData.message);
                        window.location.reload();
                    } else {
                        alert('Gagal menghapus modul: ' + JSON.stringify(resData.errors || resData.message));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan jaringan.');
                });
            };
            @endif

            @if(!$isAdmin)
            // Real-time update check for regular users
            let lastUpdatedTime = {{ time() }};
            setInterval(() => {
                fetch(`/api/path/{{ $path->slug }}/check-updates?last_updated=${lastUpdatedTime}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.has_updates) {
                            showUpdateNotification();
                            lastUpdatedTime = data.last_updated;
                        }
                    })
                    .catch(err => console.error('Error checking updates:', err));
            }, 8000);

            function showUpdateNotification() {
                if (document.getElementById('update-notification-toast')) return;

                const toast = document.createElement('div');
                toast.id = 'update-notification-toast';
                toast.className = 'fixed bottom-6 right-6 z-[200] bg-slate-900 text-white rounded-2xl p-5 shadow-2xl border border-slate-800 max-w-sm transition-all duration-500 transform translate-y-12 opacity-0 flex flex-col gap-3';
                toast.innerHTML = `
                    <div class="flex items-start gap-3">
                        <span class="text-xl">🔔</span>
                        <div>
                            <h4 class="text-sm font-extrabold text-slate-100">Konten Diperbarui!</h4>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">Admin baru saja memperbarui materi/kuiz di path ini. Silakan refresh halaman untuk melihat perubahan terbaru.</p>
                        </div>
                    </div>
                    <div class="flex gap-2 justify-end mt-1">
                        <button onclick="document.getElementById('update-notification-toast').remove()" class="px-3.5 py-1.5 rounded-xl border border-slate-700 bg-transparent hover:bg-slate-800 text-slate-300 text-xs font-bold transition-all cursor-pointer">
                            Nanti Saja
                        </button>
                        <button onclick="window.location.reload()" class="px-4 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 border-0 text-white text-xs font-bold transition-all shadow-md shadow-blue-500/10 cursor-pointer">
                            Refresh Sekarang
                        </button>
                    </div>
                `;
                document.body.appendChild(toast);
                void toast.offsetWidth;
                toast.classList.remove('translate-y-12', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }
            @endif

            // --- Toggle Sidebar Drawer on Mobile & Desktop ---
            window.toggleSidebar = function() {
                const sidebar = document.getElementById('learning-sidebar');
                const backdrop = document.getElementById('sidebar-backdrop');
                if (!sidebar) return;

                const isDesktop = window.innerWidth >= 768; // md breakpoint

                if (isDesktop) {
                    // Desktop behavior: toggle collapse width and visibility
                    if (sidebar.classList.contains('md:w-[320px]')) {
                        // Collapse
                        sidebar.classList.remove('md:w-[320px]', 'md:translate-x-0');
                        sidebar.classList.add('md:w-0', 'md:translate-x-full', 'overflow-hidden', 'opacity-0', 'border-l-0');
                    } else {
                        // Expand
                        sidebar.classList.remove('md:w-0', 'md:translate-x-full', 'overflow-hidden', 'opacity-0', 'border-l-0');
                        sidebar.classList.add('md:w-[320px]', 'md:translate-x-0');
                    }
                } else {
                    // Mobile behavior: slide drawer
                    if (sidebar.classList.contains('translate-x-full')) {
                        sidebar.classList.remove('translate-x-full');
                        sidebar.classList.add('translate-x-0');
                        if (backdrop) {
                            backdrop.classList.remove('hidden');
                            void backdrop.offsetWidth;
                            backdrop.classList.remove('opacity-0');
                            backdrop.classList.add('opacity-100');
                        }
                    } else {
                        sidebar.classList.remove('translate-x-0');
                        sidebar.classList.add('translate-x-full');
                        if (backdrop) {
                            backdrop.classList.remove('opacity-100');
                            backdrop.classList.add('opacity-0');
                            setTimeout(() => {
                                backdrop.classList.add('hidden');
                            }, 300);
                        }
                    }
                }
            };

        });
    </script>
</body>
</html>
