<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Front End Developer - Path Deck</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
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
                opacity: 0.15;
            }
        }

        /* Quiz Exit Confirmation Modal transitions */
        #quiz-exit-confirm-modal {
            z-index: 100001 !important;
            transition: opacity 0.25s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .quiz-card-stack-item.move-to-back {
            animation: moveToBack 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards !important;
            pointer-events: none !important;
        }

        /* Interactive Quiz Option Cards */
        .quiz-option-card {
            border: 2px solid #E2E8F0 !important;
            border-radius: 16px !important;
            padding: 16px 20px !important;
            display: flex !important;
            align-items: center !important;
            gap: 16px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            background: white !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #334155 !important;
            width: 100% !important;
            text-align: left !important;
        }
        .quiz-option-card:hover {
            border-color: #94A3B8 !important;
            background-color: #F8FAFC !important;
        }
        .quiz-option-card.selected {
            border-color: #0050d2 !important;
            background-color: #EFF6FF !important;
            color: #0050d2 !important;
        }
        .quiz-opt-indicator {
            width: 20px !important;
            height: 20px !important;
            border-radius: 50% !important;
            border: 2px solid #CBD5E1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex-shrink: 0 !important;
            transition: all 0.2s ease !important;
        }
        .quiz-option-card.selected .quiz-opt-indicator {
            border-color: #0050d2 !important;
        }
        .quiz-opt-dot {
            width: 10px !important;
            height: 10px !important;
            border-radius: 50% !important;
            background-color: #0050d2 !important;
            display: none !important;
        }
        .quiz-option-card.selected .quiz-opt-dot {
            display: block !important;
        }
        .quiz-option-card.correct {
            border-color: #10B981 !important;
            background-color: #F0FDF4 !important;
            color: #15803D !important;
        }
        .quiz-option-card.incorrect {
            border-color: #EF4444 !important;
            background-color: #FEF2F2 !important;
            color: #B91C1C !important;
        }

        /* Shrinkable learning-view header styles */
        #learning-view header {
            transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        }
        #learning-view header.shrink {
            height: 48px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            border-bottom-color: rgba(226, 232, 240, 0.8) !important;
        }

        /* Content Transitions */
        .content-fade {
            transition: opacity 0.35s ease-out, transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .content-fade-enter {
            opacity: 0;
            transform: translateY(12px);
        }

        /* Custom Confetti Animation */
        .confetti-particle {
            position: absolute;
            pointer-events: none;
            z-index: 9999;
            animation: confetti-fall 2.5s ease-out forwards;
        }
        @keyframes confetti-fall {
            0% {
                transform: translateY(0px) rotate(0deg) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(800px) rotate(720deg) scale(0.3);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col overflow-x-hidden relative is-learning-page">

    @include('layouts.navbar')

    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f612_1px,transparent_1px),linear-gradient(to_bottom,#3b82f612_1px,transparent_1px)] bg-[size:5rem_5rem] [mask-image:radial-gradient(ellipse_65%_55%_at_50%_0%,#000_90%,transparent_100%)] opacity-100"></div>
        
        <div class="absolute top-[10%] left-[-5%] w-[450px] h-[450px] rounded-full bg-blue-400/22 blur-3xl animate-float-blob" style="animation-duration: 9s;"></div>
        <div class="absolute top-[45%] right-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-400/18 blur-3xl animate-float-blob" style="animation-delay: -3s; animation-duration: 12s;"></div>
        <div class="absolute bottom-[15%] left-[10%] w-[400px] h-[400px] rounded-full bg-cyan-300/20 blur-3xl animate-float-blob" style="animation-delay: -6s; animation-duration: 10s;"></div>

        <div id="particle-container" class="absolute inset-0 z-0"></div>
    </div>

    <main class="grow relative z-10 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">
        
        @if(session('success'))
            <div class="mb-6 px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-bold flex items-center gap-3 animate-fade-in-up">
                <span>🎉</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        <div id="roadmap-view" class="transition-all duration-350">
            <section class="mb-14 animate-fade-in-up" style="animation-delay: 50ms;">
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-900 rounded-3xl p-8 sm:p-10 shadow-[0_12px_40px_-6px_rgba(37,99,235,0.25)] flex flex-col lg:flex-row items-center gap-10 text-white relative overflow-hidden border-none">
                    
                    <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:3rem_3rem] pointer-events-none"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-blue-400/20 via-transparent to-transparent opacity-70 pointer-events-none"></div>

                    <div class="flex-grow max-w-2xl order-2 lg:order-1 relative z-10">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/15 border border-white/20 text-white mb-4 tracking-wide uppercase">
                            <svg class="w-3.5 h-3.5 text-blue-200 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Career Path
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight title-font mb-4 drop-shadow-sm">
                            FRONT-END DEVELOPER
                        </h1>
                        <p class="text-sm sm:text-base text-blue-50/90 leading-relaxed mb-6 font-medium">
                            Front End Developer adalah profesi yang bertugas membuat tampilan dan antarmuka website atau aplikasi agar menarik, interaktif, dan mudah digunakan pengguna. Pekerjaan ini menggunakan teknologi seperti HTML, CSS, dan JavaScript serta bekerja sama dengan UI/UX Designer dan Back End Developer untuk menciptakan pengalaman pengguna yang optimal.
                        </p>
                        
                        <button id="open-info-btn" class="inline-flex items-center gap-2 px-4 py-2 border border-white/20 hover:border-white/40 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 transition-all duration-300 shadow-sm cursor-pointer hover:scale-[1.03]">
                            Informasi Umum
                            <svg class="w-4 h-4 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="w-full lg:w-[380px] h-60 sm:h-72 rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 group relative cursor-pointer order-1 lg:order-2 flex-shrink-0 z-10">
                        <img src="https://images.unsplash.com/photo-1547082299-de196ea013d6?w=600&auto=format&fit=crop&q=80" alt="Path Wireframe Mockup" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/40 to-transparent"></div>
                    </div>

                </div>
            </section>

            <section class="mb-14 animate-fade-in-up" style="animation-delay: 100ms;">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200/60 pb-6 mb-10">
                    <div class="flex items-center gap-4">
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight title-font flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                            Learning Curriculum
                        </h2>
                        
                        <form action="{{ route('path.frontend.reset') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 border border-red-200 hover:border-red-400 rounded-xl text-xs font-bold text-red-600 bg-red-50/50 hover:bg-red-50 transition-all duration-300 shadow-sm cursor-pointer hover:scale-[1.03]" title="Reset Detail Progress">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89H18.21" />
                                </svg>
                                Mulai dari Awal
                            </button>
                        </form>
                    </div>
                    
                    @php
                        $percentVal = min(100, round(($currentStep / 7) * 100));
                    @endphp
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <span class="text-xs font-bold text-slate-400 whitespace-nowrap">Your Progress</span>
                        <div class="w-full sm:w-44 bg-slate-200/70 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-blue-600 h-2.5 rounded-full shadow-sm transition-all duration-1000" style="width: {{ $percentVal }}%"></div>
                        </div>
                        <span class="text-xs font-extrabold text-blue-600 whitespace-nowrap bg-blue-50 border border-blue-100/50 px-2 py-0.5 rounded-lg">{{ $percentVal }}%</span>
                    </div>
                </div>

                <div class="relative max-w-5xl mx-auto px-2 py-4">
                    
                    <div class="absolute timeline-line top-0 bottom-0 left-1/2 w-1.5 bg-slate-200 -translate-x-1/2 z-0 rounded-full overflow-hidden">
                        <div class="absolute top-0 w-full bg-gradient-to-b from-blue-400 via-blue-600 to-indigo-600 rounded-full shadow-[0_0_12px_rgba(59,130,246,0.8)]" style="height: {{ $percentVal }}%; transition: height 1.2s cubic-bezier(0.25, 1, 0.5, 1);">
                            <div class="absolute bottom-0 left-0 right-0 h-4 bg-white animate-pulse rounded-full shadow-[0_0_15px_#fff]"></div>
                        </div>
                    </div>

                    <div class="space-y-12 relative z-10">
                        
                        @php
                            $curriculum = [
                                [
                                    'title' => 'Pengenalan',
                                    'desc' => 'Mempelajari peran, tugas, dan prospek karir Front-End Developer.',
                                    'side' => 'left',
                                    'icon' => '01',
                                ],
                                [
                                    'title' => 'Dasar-Dasar HTML',
                                    'desc' => 'Mempelajari sintaks dasar, struktur dokumen, tag headings, paragraf, gambar, dan tautan.',
                                    'side' => 'right',
                                    'icon' => '02',
                                ],
                                [
                                    'title' => 'CSS',
                                    'desc' => 'Mempelajari penataan halaman web, model kotak (box model), flexbox, grid, dan media queries.',
                                    'side' => 'left',
                                    'icon' => '03',
                                ],
                                [
                                    'title' => 'JavaScript',
                                    'desc' => 'Mempelajari logika pemrograman dasar, manipulasi DOM, penanganan event, dan Fetch API.',
                                    'side' => 'right',
                                    'icon' => '04',
                                ],
                                [
                                    'title' => 'Framework dan Library Modern',
                                    'desc' => 'Mempelajari konsep Component-Based UI, Virtual DOM, dan SPA menggunakan React/Vue.',
                                    'side' => 'left',
                                    'icon' => '05',
                                ],
                                [
                                    'title' => 'Alat dan Teknik Pengembangan',
                                    'desc' => 'Mempelajari manajemen package (NPM), version control (Git), dan debugging dengan Chrome DevTools.',
                                    'side' => 'right',
                                    'icon' => '06',
                                ],
                                [
                                    'title' => 'Deployment & Hosting',
                                    'desc' => 'Mempelajari proses deploy proyek web ke server cloud hosting (Vercel, Netlify) agar online.',
                                    'side' => 'left',
                                    'icon' => '07',
                                ],
                            ];
                        @endphp

                        @foreach($curriculum as $index => $module)
                            @php
                                // Determine dynamic state for each card index
                                $status = '';
                                if ($index < $currentStep) {
                                    $status = 'Completed';
                                } elseif ($index == $currentStep) {
                                    $status = 'Active';
                                } else {
                                    $status = 'Locked';
                                }

                                // Set node statuses & styles
                                $nodeIcon = '';
                                $nodeColor = 'bg-white border-slate-300 text-slate-400 shadow-sm';
                                
                                if ($status === 'Completed') {
                                    $nodeColor = 'bg-blue-600 border-blue-600 text-white shadow-md shadow-blue-500/20';
                                } elseif ($status === 'Active') {
                                    $nodeColor = 'bg-white border-blue-500 border-4 text-blue-600 shadow-md shadow-blue-500/10 animate-bounce';
                                } else {
                                    $nodeIcon = 'locked';
                                    $nodeColor = 'bg-slate-100 border-slate-200 text-slate-300';
                                }

                                // Dynamic badge layout Classes
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
                                
                                <div class="w-full md:w-[44%] {{ $module['side'] === 'left' ? 'order-1' : 'order-3 opacity-0 pointer-events-none md:block hidden' }}">
                                    @if($module['side'] === 'left')
                                        @if($status !== 'Locked')
                                            <div onclick="openLearningView({{ $index }})" class="group wobble-card bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:bg-blue-600 hover:border-blue-600 hover:shadow-[0_16px_36px_-8px_rgba(37,99,235,0.22)] cursor-pointer transition-all duration-300 {{ $status === 'Active' ? 'card-active-glow' : '' }}">
                                                <div class="inner-lift flex items-start gap-4">
                                                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center font-extrabold text-xs text-blue-600 flex-shrink-0 group-hover:bg-white/20 group-hover:border-white/30 group-hover:text-white transition-colors duration-300">
                                                        {{ $module['icon'] }}
                                                    </div>
                                                    <div class="flex-grow">
                                                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-white transition-colors duration-300">
                                                                {{ $module['title'] }}
                                                            </h3>
                                                            <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $badgeClass }} group-hover:bg-white/25 group-hover:border-transparent group-hover:text-white transition-colors duration-300 font-mono">
                                                                {{ $status }}
                                                            </span>
                                                        </div>
                                                        <p class="text-xs sm:text-sm text-slate-500 group-hover:text-blue-50 transition-colors duration-300 mb-5 leading-relaxed">
                                                            {{ $module['desc'] }}
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
                                                    <div class="w-12 h-12 rounded-xl bg-slate-200/80 border border-slate-300/40 flex items-center justify-center font-extrabold text-xs text-slate-400 flex-shrink-0">
                                                        🔒
                                                    </div>
                                                    <div class="flex-grow">
                                                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                            <h3 class="text-base sm:text-lg font-extrabold text-slate-400">
                                                                {{ $module['title'] }}
                                                            </h3>
                                                            <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $badgeClass }} font-mono">
                                                                Locked
                                                            </span>
                                                        </div>
                                                        <p class="text-xs sm:text-sm text-slate-400 mb-5 leading-relaxed">
                                                            {{ $module['desc'] }}
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

                                <div class="timeline-node absolute left-1/2 -translate-x-1/2 w-10 h-10 rounded-full flex items-center justify-center z-10 {{ $nodeColor }} order-2 my-4 md:my-0">
                                    @if($nodeIcon === 'locked')
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    @else
                                        <div class="w-2.5 h-2.5 rounded-full bg-current"></div>
                                    @endif
                                </div>

                                <div class="w-full md:w-[44%] {{ $module['side'] === 'right' ? 'order-3' : 'order-1 opacity-0 pointer-events-none md:block hidden' }}">
                                    @if($module['side'] === 'right')
                                        @if($status !== 'Locked')
                                            <div onclick="openLearningView({{ $index }})" class="group wobble-card bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:bg-blue-600 hover:border-blue-600 hover:shadow-[0_16px_36px_-8px_rgba(37,99,235,0.22)] cursor-pointer transition-all duration-300 {{ $status === 'Active' ? 'card-active-glow' : '' }}">
                                                <div class="inner-lift flex items-start gap-4">
                                                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center font-extrabold text-xs text-blue-600 flex-shrink-0 group-hover:bg-white/20 group-hover:border-white/30 group-hover:text-white transition-colors duration-300">
                                                        {{ $module['icon'] }}
                                                    </div>
                                                    <div class="flex-grow">
                                                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-white transition-colors duration-300">
                                                                {{ $module['title'] }}
                                                            </h3>
                                                            <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $badgeClass }} group-hover:bg-white/25 group-hover:border-transparent group-hover:text-white transition-colors duration-300 font-mono">
                                                                {{ $status }}
                                                            </span>
                                                        </div>
                                                        <p class="text-xs sm:text-sm text-slate-500 group-hover:text-blue-50 transition-colors duration-300 mb-5 leading-relaxed">
                                                            {{ $module['desc'] }}
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
                                                    <div class="w-12 h-12 rounded-xl bg-slate-200/80 border border-slate-300/40 flex items-center justify-center font-extrabold text-xs text-slate-400 flex-shrink-0">
                                                        🔒
                                                    </div>
                                                    <div class="flex-grow">
                                                        <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                            <h3 class="text-base sm:text-lg font-extrabold text-slate-400">
                                                                {{ $module['title'] }}
                                                            </h3>
                                                            <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $badgeClass }} font-mono">
                                                                Locked
                                                            </span>
                                                        </div>
                                                        <p class="text-xs sm:text-sm text-slate-400 mb-5 leading-relaxed">
                                                            {{ $module['desc'] }}
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

        <div id="learning-view" class="hidden opacity-0 fixed inset-0 bg-white z-[60] flex flex-col overflow-hidden font-sans transition-all duration-350">
            
            <header class="h-16 border-b border-slate-200 bg-white px-8 flex justify-between items-center shrink-0">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl sm:text-2xl font-bold tracking-tight text-[#0050d2] flex items-center gap-2">
                        <svg class="h-6 w-6 text-[#0050d2]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-8-4-8 4v10l8 4 8-4V7z" />
                        </svg>
                        <span class="title-font font-black">Path Deck</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-500 hover:text-[#0050d2] transition-colors">Dashboard</a>
                    <a href="{{ route('explore.path') }}" class="relative text-sm font-semibold text-[#0050d2] py-5">
                        Explore path
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#0050d2]"></span>
                    </a>
                    <span class="h-6 w-px bg-slate-200"></span>
                    
                    <button class="text-[#0050d2] hover:opacity-85 transition-opacity cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    
                    <button class="text-[#0050d2] hover:opacity-85 transition-opacity cursor-pointer">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            </header>

            <div class="grow flex overflow-hidden">
                
                <div class="flex-grow flex flex-col overflow-hidden bg-white">
                    
                    <div class="h-20 border-b border-slate-200 px-12 flex justify-between items-center bg-white shrink-0">
                        <div>
                            <span class="text-[10px] font-extrabold text-[#0050d2] uppercase tracking-wider block">CURRENT LESSON</span>
                            <h2 id="workspace-lesson-title" class="text-xl font-extrabold text-slate-900 mt-1">Pengenalan</h2>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span id="workspace-progress-fraction" class="text-sm font-extrabold text-slate-800 font-mono">1/7</span>
                            <span class="h-6 w-px bg-slate-200"></span>
                            <button id="marks-btn" onclick="toggleCurrentModuleMark()" class="flex items-center gap-1.5 text-sm font-extrabold text-[#0050d2] hover:opacity-80 transition-opacity cursor-pointer">
                                <svg id="marks-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                </svg>
                                <span id="marks-text">Marks</span>
                            </button>
                            <span class="h-6 w-px bg-slate-200"></span>
                            <button onclick="closeLearningView()" class="flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 border border-slate-200 rounded-xl px-3 py-1.5 bg-slate-50 transition-all duration-200 cursor-pointer shadow-sm active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Keluar
                            </button>
                        </div>
                    </div>

                    <div id="workspace-scroll-container" class="grow overflow-y-auto px-12 py-10 bg-white">
                        <div class="max-w-4xl mx-auto">
                            
                            <div id="workspace-content-container" class="mb-10">
                                <h1 id="workspace-content-title" class="text-4xl font-extrabold text-slate-950 leading-tight mb-6">
                                    Apa itu Frontend Developer?
                                </h1>
                                <div id="workspace-content-body" class="text-[15px] leading-relaxed text-slate-600 space-y-6">
                                </div>
                            </div>

                            <!-- Quiz Card -->
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
                                    <div>
                                        <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0050d2] hover:bg-[#0040a8] text-white rounded-xl text-xs font-bold shadow-md shadow-[#0050d2]/10 transition-all duration-300">
                                            Mulai Kuis Sekarang
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Completed Card -->
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

                </div>
                
                <!-- Right Pane: sidebar untuk list learning path detail -->
                <aside class="w-[320px] border-l border-slate-200 bg-[#F2F7FF] flex flex-col shrink-0 overflow-y-auto">
                    
                    <div class="bg-[#0050d2] p-6 text-white shrink-0">
                        <span class="text-[9px] font-extrabold tracking-widest text-blue-200/80 uppercase block mb-1">LEARNING PATH</span>
                        <h3 class="text-lg font-black tracking-tight mb-6">Front-End Developer</h3>
                        
                        <span class="text-[10px] font-bold text-blue-100 block mb-1.5">Progres</span>
                        <div class="w-full bg-white/20 rounded-full h-1.5 overflow-hidden mb-2">
                            <div id="sidebar-progress-bar" class="bg-white h-1.5 rounded-full transition-all duration-1000" style="width: 0%"></div>
                        </div>
                        <span id="sidebar-progress-text" class="text-[11px] font-bold text-blue-100/90 block">0 of 7 lessons completed</span>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-base font-extrabold text-slate-800 mb-4 tracking-tight">Library</h3>
                        <div id="sidebar-library-list" class="divide-y divide-slate-200/60 border-t border-b border-slate-200/60">
                        </div>
                    </div>

                </aside>

            </div>
        </div>

        <!-- quiz interaktif (page) -->
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
                    </div>
                </div>

                <!-- hasil quiz -->
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
                        
                        <button id="result-continue-btn" onclick="closeQuizModalAndUnlock()" class="w-full inline-flex items-center justify-center px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl text-sm shadow-lg shadow-blue-500/25 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] cursor-pointer">
                            Lanjutkan Belajar
                        </button>
                        
                        <button id="result-retry-btn" onclick="restartQuiz()" class="w-full mt-3 inline-flex items-center justify-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold rounded-2xl text-sm transition-all duration-300 hover:scale-[1.02] active:scale-[0.98] cursor-pointer">
                            Coba Lagi
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Quiz Exit Confirmationn -->
    <div id="quiz-exit-confirm-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-sm opacity-0">
        <div class="bg-white rounded-[28px] max-w-md w-full p-8 shadow-[0_24px_60px_-15px_rgba(0,0,0,0.3)] border border-slate-100 flex flex-col items-center text-center transform scale-95 transition-all duration-300">
            <div class="w-16 h-16 rounded-[20px] bg-amber-50 text-amber-500 border border-amber-100 flex items-center justify-center text-3xl mb-5 shadow-sm">
                ⚠️
            </div>
            <h3 class="text-xl font-bold text-slate-950 mb-3 title-font">Keluar dari Kuis?</h3>
            <p class="text-sm text-slate-500 leading-relaxed mb-6 font-medium">Apakah kamu yakin ingin menghentikan kuis? Kuis akan diulang dari awal jika kamu keluar sekarang.</p>
            <div class="flex gap-3 w-full">
                <button onclick="confirmExitQuiz(true)" class="flex-1 py-3.5 bg-rose-600 hover:bg-rose-700 text-white font-extrabold rounded-2xl text-sm transition-all duration-200 cursor-pointer shadow-md shadow-rose-500/10 active:scale-95">
                    Ya, Keluar
                </button>
                <button onclick="confirmExitQuiz(false)" class="flex-1 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold rounded-2xl text-sm transition-all duration-200 cursor-pointer active:scale-95">
                    Tidak, Lanjut
                </button>
            </div>
        </div>
    </div>

    <div id="info-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-sm opacity-0">
        <div id="modal-container" class="bg-white rounded-[28px] max-w-4xl w-full overflow-hidden flex flex-col md:flex-row shadow-[0_24px_60px_-15px_rgba(0,0,0,0.3)] relative transform scale-90 translate-y-8 transition-all duration-500 max-h-[90vh] md:max-h-none overflow-y-auto md:overflow-y-visible">
            
            <button id="close-modal-btn" class="absolute top-4 right-4 z-50 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-800 transition-colors shadow-sm cursor-pointer border border-slate-200/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="w-full md:w-[35%] bg-[#f0f4ff] p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden shrink-0">
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f605_1px,transparent_1px),linear-gradient(to_bottom,#3b82f605_1px,transparent_1px)] bg-[size:1.5rem_1.5rem] opacity-70"></div>
                
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center font-extrabold text-xs text-white shadow-md shadow-blue-500/30 mb-6">
                        HTML
                    </div>
                    
                    <h2 class="text-2xl font-black text-slate-900 leading-tight mb-4 title-font">
                        Front-End<br>Developer
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
                    <img src="https://images.unsplash.com/photo-1547082299-de196ea013d6?w=600&auto=format&fit=crop&q=80" alt="Frontend Coding" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950/20 to-transparent"></div>
                </div>
            </div>

            <div class="w-full md:w-[65%] p-6 sm:p-8 flex flex-col justify-between shrink-0 overflow-y-auto max-h-[60vh] md:max-h-none">
                <div>
                    <span class="text-xs font-black tracking-wider text-slate-400 uppercase block mb-3 font-mono">
                        DESKRIPSI KARIR
                    </span>
                    
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium mb-6">
                        Arsitektur Frontend adalah disiplin ilmu yang merancang dan memelihara integritas struktural aplikasi web yang kompleks. Anda tidak hanya menulis kode, Anda membangun fondasi antarmuka web yang terukur dan berkinerja tinggi. Peran ini melibatkan penetapan standar sistem desain, mengatur pola manajemen status, dan memastikan bahwa kinerja tetap optimal bahkan saat platform berkembang.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        
                        <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4 flex flex-col justify-between">
                            <span class="text-xs font-bold text-slate-400 block mb-1">
                                Estimasi Gaji
                            </span>
                            <div>
                                <span class="text-sm sm:text-base font-black text-blue-600 block">
                                    Rp 5.750.000 -
                                </span>
                                <span class="text-sm sm:text-base font-black text-blue-600 inline">
                                    Rp 15.000.000
                                </span>
                                <span class="text-xs font-bold text-slate-500">
                                    / bulan
                                </span>
                            </div>
                        </div>

                        <div class="border border-slate-200/80 rounded-2xl p-4">
                            <span class="text-xs font-bold text-slate-400 block mb-3">
                                Skill yang harus kamu kuasai
                            </span>
                            <div class="grid grid-cols-2 gap-2">
                                <span class="inline-flex items-center gap-1 px-2 py-1 border border-slate-200 rounded-lg text-[9px] font-bold text-slate-700 bg-white">
                                    <span class="text-blue-500 font-mono text-[9px] font-bold">&lt;&gt;</span> HTML
                                </span>
                                <span class="inline-flex items-center gap-1 px-2 py-1 border border-slate-200 rounded-lg text-[9px] font-bold text-slate-700 bg-white">
                                    <span class="text-blue-500 font-mono text-[9px] font-bold">&lt;&gt;</span> CSS
                                </span>
                                <span class="inline-flex items-center gap-1 px-2 py-1 border border-slate-200 rounded-lg text-[9px] font-bold text-slate-700 bg-white">
                                    <span class="text-blue-500 font-mono text-[9px] font-bold">&lt;&gt;</span> JAVASCRIPT
                                </span>
                                <span class="inline-flex items-center gap-1 px-2 py-1 border border-slate-200 rounded-lg text-[9px] font-bold text-slate-700 bg-white">
                                    <span class="text-blue-500 font-mono text-[9px] font-bold">&lt;&gt;</span> React
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="bg-blue-50/20 border border-blue-100/30 rounded-2xl p-5">
                        <h4 class="text-xs sm:text-sm font-black text-slate-800 tracking-tight title-font mb-4">
                            Cocok buat kamu yang...
                        </h4>
                        <ul class="space-y-3.5 text-xs text-slate-600 font-medium">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Menyukai detail yang sangat presisi hingga tingkat piksel dan pola desain yang sangat rapi.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Senang menjembatani kesenjangan antara desain dan teknik tingkat tinggi.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Ingin membangun sistem modular yang dapat diskalakan hingga jutaan pengguna.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- Global Learning Path Variables ---
            let currentStep = {{ $currentStep }};
            let activeModuleIndex = 0;
            let progressChanged = false;
            let selectedOptions = [null, null, null, null, null];
            let currentQuestionIndex = 0;
            let quizScore = 0;

            // Check if we should auto open a module from a previous redirect/reload
            const autoOpenIndex = sessionStorage.getItem('autoOpenModuleIndex');
            if (autoOpenIndex !== null) {
                sessionStorage.removeItem('autoOpenModuleIndex');
                const idx = parseInt(autoOpenIndex, 10);
                // Open learning view directly with delay to let layout load
                setTimeout(() => {
                    openLearningView(idx);
                }, 400);
            }

        // --- Modules Detailed Data (Custom Content & Interactive Quizzes) ---
        const modulesData = [
            {
                title: "Pengenalan",
                fullTitle: "Apa itu Frontend Developer?",
                content: `
                    <p class="text-[15px] leading-relaxed text-slate-600 mb-6">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                    <div class="h-0.5 w-48 bg-gradient-to-r from-[#0050d2] to-transparent my-8"></div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4 border-l-4 border-[#0050d2] pl-3">Frontend Developer ngapain?</h3>
                    <p class="text-[15px] leading-relaxed text-slate-600 mb-4">
                        Untuk membangun itu semua, seorang Frontend Developer menggunakan tiga pilar teknologi utama:
                    </p>
                    <ul class="space-y-3.5 text-slate-600 pl-4 list-disc mb-6">
                        <li><strong>HTML:</strong> Sebagai struktur atau kerangka dasar halaman.</li>
                        <li><strong>CSS:</strong> Sebagai pakaian yang mengatur gaya, warna, dan keindahan tampilan.</li>
                        <li><strong>JavaScript:</strong> Sebagai otot atau sistem saraf yang memberikan logika interaktif (seperti memunculkan menu dropdown atau pop-up modal).</li>
                    </ul>
                `,
                quiz: [
                    {
                        question: "Apa tiga pilar teknologi utama dalam pengembangan Frontend?",
                        options: [
                            "A. PHP, SQL, Python",
                            "B. HTML, CSS, JavaScript",
                            "C. Java, Swift, Kotlin"
                        ],
                        correct: 1
                    },
                    {
                        question: "Teknologi mana yang berfungsi sebagai kerangka dasar/struktur halaman web?",
                        options: [
                            "A. CSS",
                            "B. JavaScript",
                            "C. HTML"
                        ],
                        correct: 2
                    },
                    {
                        question: "Apa fungsi utama JavaScript pada Frontend?",
                        options: [
                            "A. Menyimpan data ke database",
                            "B. Memberikan logika interaktif pada halaman web",
                            "C. Mengatur gaya dan warna elemen"
                        ],
                        correct: 1
                    },
                    {
                        question: "Siapa yang bertanggung jawab atas logika server dan database?",
                        options: [
                            "A. Frontend Developer",
                            "B. Backend Developer",
                            "C. UI/UX Designer"
                        ],
                        correct: 1
                    },
                    {
                        question: "Apa peran utama dari seorang Frontend Developer?",
                        options: [
                            "A. Menulis query database",
                            "B. Merancang antarmuka pengguna yang interaktif dan responsif di browser",
                            "C. Membuat server web menggunakan Linux"
                        ],
                        correct: 1
                    }
                ]
            },
            {
                title: "Dasar-Dasar HTML",
                fullTitle: "Menguasai Struktur Halaman Web dengan HTML",
                content: `
                    <p class="text-slate-600 leading-relaxed mb-6">
                        HTML (HyperText Markup Language) adalah bahasa standar wajib bagi setiap web developer. HTML mendefinisikan struktur konten web menggunakan sistem tag (seperti <code>&lt;h1&gt;</code> untuk heading, <code>&lt;p&gt;</code> untuk paragraf, dan <code>&lt;a&gt;</code> untuk tautan).
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Tag-Tag HTML Penting
                    </h3>
                    <ul class="space-y-3.5 text-slate-600 pl-4 list-disc mb-6">
                        <li><strong>Tag Heading (&lt;h1&gt; hingga &lt;h6&gt;):</strong> Digunakan untuk membuat judul dan subjudul terstruktur.</li>
                        <li><strong>Tag Paragraph (&lt;p&gt;):</strong> Digunakan untuk menulis blok teks atau paragraf konten.</li>
                        <li><strong>Tag Link (&lt;a href="..."&gt;) & Image (&lt;img src="..."&gt;):</strong> Menghubungkan halaman dan menampilkan media gambar.</li>
                        <li><strong>Semantic HTML:</strong> Menggunakan tag yang berarti seperti <code>&lt;header&gt;</code>, <code>&lt;article&gt;</code>, dan <code>&lt;footer&gt;</code> agar ramah SEO.</li>
                    </ul>
                `,
                quiz: [
                    {
                        question: "Manakah tag HTML yang digunakan untuk membuat judul utama paling besar?",
                        options: [
                            "A. &lt;h6&gt;",
                            "B. &lt;title&gt;",
                            "C. &lt;h1&gt;"
                        ],
                        correct: 2
                    },
                    {
                        question: "Tag HTML apa yang digunakan untuk memasukkan gambar?",
                        options: [
                            "A. &lt;img&gt;",
                            "B. &lt;image&gt;",
                            "C. &lt;a&gt;"
                        ],
                        correct: 0
                    },
                    {
                        question: "Mengapa Semantic HTML sangat direkomendasikan?",
                        options: [
                            "A. Membuat website memuat lebih cepat",
                            "B. Membantu mesin pencari (SEO) memahami struktur halaman web",
                            "C. Otomatis mewarnai tombol menjadi biru"
                        ],
                        correct: 1
                    },
                    {
                        question: "Tag HTML mana yang digunakan untuk membuat hyperlink?",
                        options: [
                            "A. &lt;link&gt;",
                            "B. &lt;href&gt;",
                            "C. &lt;a&gt;"
                        ],
                        correct: 2
                    },
                    {
                        question: "Tag HTML manakah yang digunakan untuk membuat daftar berurutan (numbered list)?",
                        options: [
                            "A. &lt;ul&gt;",
                            "B. &lt;ol&gt;",
                            "C. &lt;li&gt;"
                        ],
                        correct: 1
                    }
                ]
            },
            {
                title: "CSS",
                fullTitle: "Mempercantik Tampilan Halaman Web dengan CSS",
                content: `
                    <p class="text-slate-600 leading-relaxed mb-6">
                        CSS (Cascading Style Sheets) bertanggung jawab untuk membuat website terlihat profesional dan memikat mata. Dengan CSS, Anda bisa mengatur tata letak, warna latar, tipografi, jarak (margin & padding), hingga efek transisi dan animasi.
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Konsep Kunci CSS
                    </h3>
                    <ul class="space-y-3.5 text-slate-600 pl-4 list-disc mb-6">
                        <li><strong>Box Model:</strong> Setiap elemen adalah kotak dengan Margin (luar), Border (garis), Padding (dalam), dan Content.</li>
                        <li><strong>Flexbox:</strong> Sistem tata letak satu dimensi yang memudahkan perataan elemen secara horizontal/vertikal.</li>
                        <li><strong>CSS Grid:</strong> Sistem tata letak dua dimensi (baris dan kolom) untuk tata letak halaman yang lebih kompleks.</li>
                        <li><strong>Media Queries:</strong> Teknik membuat halaman responsif sesuai ukuran layar perangkat.</li>
                    </ul>
                `,
                quiz: [
                    {
                        question: "Properti CSS apa yang digunakan untuk mengatur jarak di luar border suatu elemen?",
                        options: [
                            "A. padding",
                            "B. margin",
                            "C. spacing"
                        ],
                        correct: 1
                    },
                    {
                        question: "Sistem tata letak CSS 2D yang menggunakan baris dan kolom disebut?",
                        options: [
                            "A. Flexbox",
                            "B. Block Model",
                            "C. CSS Grid"
                        ],
                        correct: 2
                    },
                    {
                        question: "Apa kegunaan utama dari Media Queries pada CSS?",
                        options: [
                            "A. Memutar video di halaman web",
                            "B. Mengatur gaya tampilan agar responsif di berbagai ukuran layar",
                            "C. Menghubungkan CSS dengan JavaScript"
                        ],
                        correct: 1
                    },
                    {
                        question: "Properti CSS mana yang digunakan untuk mengubah warna teks suatu elemen?",
                        options: [
                            "A. color",
                            "B. text-color",
                            "C. background-color"
                        ],
                        correct: 0
                    },
                    {
                        question: "Nilai position mana yang membuat elemen tetap di posisinya saat halaman di-scroll?",
                        options: [
                            "A. absolute",
                            "B. relative",
                            "C. fixed"
                        ],
                        correct: 2
                    }
                ]
            },
            {
                title: "JavaScript",
                fullTitle: "Logika dan Interaksi Dinamis dengan JavaScript",
                content: `
                    <p class="text-slate-600 leading-relaxed mb-6">
                        JavaScript (JS) adalah bahasa pemrograman wajib untuk membuat web menjadi interaktif. JS berjalan di browser klien dan memungkinkan Anda mengubah elemen HTML, memvalidasi form, meminta data dari server (API), serta membuat game sederhana.
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Materi Pembelajaran JavaScript
                    </h3>
                    <ul class="space-y-3.5 text-slate-600 pl-4 list-disc mb-6">
                        <li><strong>Variabel & Tipe Data:</strong> Menggunakan <code>let</code>, <code>const</code> untuk menyimpan teks, angka, atau objek.</li>
                        <li><strong>DOM Manipulation:</strong> Menyeleksi dan mengubah konten HTML atau gaya CSS secara dinamis via script.</li>
                        <li><strong>Event Listeners:</strong> Mendeteksi interaksi pengguna seperti klik tombol (<code>click</code>) atau input text.</li>
                        <li><strong>Fetch API:</strong> Mengirim dan mengambil data dari server eksternal secara asinkronus (AJAX).</li>
                    </ul>
                `,
                quiz: [
                    {
                        question: "Manakah perintah JS yang digunakan untuk menyeleksi elemen HTML berdasarkan ID?",
                        options: [
                            "A. document.selectId()",
                            "B. document.getElementById()",
                            "C. document.querySelector(\".class\")"
                        ],
                        correct: 1
                    },
                    {
                        question: "Kata kunci mana yang terbaik digunakan untuk mendeklarasikan variabel yang nilainya konstan?",
                        options: [
                            "A. var",
                            "B. let",
                            "C. const"
                        ],
                        correct: 2
                    },
                    {
                        question: "Apa fungsi dari Event Listener di JavaScript?",
                        options: [
                            "A. Mendengarkan musik latar belakang",
                            "B. Merespons interaksi pengguna seperti klik, ketik, atau scroll",
                            "C. Menghapus database secara otomatis"
                        ],
                        correct: 1
                    },
                    {
                        question: "Bagaimana cara menulis komentar satu baris di JavaScript?",
                        options: [
                            "A. // komentar",
                            "B. &lt;!-- komentar --&gt;",
                            "C. /* komentar */"
                        ],
                        correct: 0
                    },
                    {
                        question: "Tipe data manakah di JavaScript yang mewakili nilai benar atau salah?",
                        options: [
                            "A. String",
                            "B. Boolean",
                            "C. Number"
                        ],
                        correct: 1
                    }
                ]
            },
            {
                title: "Framework dan Library Modern",
                fullTitle: "Mengenal Library & Framework Frontend Modern",
                content: `
                    <p class="text-slate-600 leading-relaxed mb-6">
                        Seiring aplikasi web menjadi semakin kompleks, menulis kode JavaScript murni (Vanilla JS) bisa menjadi sangat rumit. Oleh karena itu, developer modern beralih menggunakan library dan framework seperti React.js, Vue.js, atau Angular.
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Mengapa memakai Framework?
                    </h3>
                    <ul class="space-y-3.5 text-slate-600 pl-4 list-disc mb-6">
                        <li><strong>Component-Based:</strong> Membagi tampilan web menjadi komponen kecil yang bisa digunakan berulang kali.</li>
                        <li><strong>Virtual DOM:</strong> Mempercepat update tampilan web dengan hanya memperbarui bagian yang berubah saja.</li>
                        <li><strong>State Management:</strong> Mengelola data aplikasi secara terpusat agar konsisten di setiap halaman.</li>
                        <li><strong>Single Page Application (SPA):</strong> Halaman web terasa sangat cepat karena tidak perlu memuat ulang seluruh halaman saat navigasi.</li>
                    </ul>
                `,
                quiz: [
                    {
                        question: "Konsep membagi UI menjadi bagian-bagian kecil yang reusable disebut?",
                        options: [
                            "A. Component-Based",
                            "B. Flexbox layout",
                            "C. Database Schema"
                        ],
                        correct: 0
                    },
                    {
                        question: "ReactJS dikembangkan oleh perusahaan mana?",
                        options: [
                            "A. Google",
                            "B. Meta / Facebook",
                            "C. Microsoft"
                        ],
                        correct: 1
                    },
                    {
                        question: "Keuntungan utama dari Single Page Application (SPA) adalah?",
                        options: [
                            "A. Dapat berjalan tanpa internet",
                            "B. Navigasi halaman yang instan tanpa loading reload seluruh halaman",
                            "C. Otomatis membackup database"
                        ],
                        correct: 1
                    },
                    {
                        question: "Di antara berikut ini, manakah yang merupakan framework progresif berbasis JavaScript?",
                        options: [
                            "A. Laravel",
                            "B. Vue.js",
                            "C. Django"
                        ],
                        correct: 1
                    },
                    {
                        question: "Apa kegunaan dari State Management library seperti Redux atau Vuex?",
                        options: [
                            "A. Mengatur routing halaman",
                            "B. Mengelola status/data aplikasi secara terpusat",
                            "C. Mempercepat koneksi database"
                        ],
                        correct: 1
                    }
                ]
            },
            {
                title: "Alat dan Teknik Pengembangan",
                fullTitle: "Meningkatkan Produktivitas dengan DevTools & Git",
                content: `
                    <p class="text-slate-600 leading-relaxed mb-6">
                        Seorang Frontend Developer profesional tidak hanya menulis kode, tetapi juga menguasai alat bantu (tools) untuk melakukan debugging, mengelola paket dependensi, serta berkolaborasi menggunakan Version Control System.
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Tools Wajib Developer
                    </h3>
                    <ul class="space-y-3.5 text-slate-600 pl-4 list-disc mb-6">
                        <li><strong>Git & GitHub:</strong> Sistem untuk merekam riwayat perubahan kode dan berkolaborasi dalam tim.</li>
                        <li><strong>Chrome DevTools:</strong> Alat bawaan browser untuk memeriksa elemen HTML, menguji CSS, dan memantau performa.</li>
                        <li><strong>NPM / Yarn:</strong> Package manager untuk menginstal library eksternal yang dibutuhkan proyek.</li>
                        <li><strong>Bundler (Vite / Webpack):</strong> Mengompilasi dan mengoptimalkan aset web (JS, CSS, gambar) untuk produksi.</li>
                    </ul>
                `,
                quiz: [
                    {
                        question: "Perintah Git apa yang digunakan untuk merekam perubahan ke dalam riwayat lokal?",
                        options: [
                            "A. git push",
                            "B. git pull",
                            "C. git commit"
                        ],
                        correct: 2
                    },
                    {
                        question: "Di mana Anda dapat menemukan Chrome DevTools untuk menguji dan men-debug kode secara langsung di browser?",
                        options: [
                            "A. Di dalam file settings Windows",
                            "B. Dengan menekan tombol F12 atau klik kanan -> Inspect Element",
                            "C. Di dalam dashboard cPanel"
                        ],
                        correct: 1
                    },
                    {
                        question: "Apa fungsi utama NPM (Node Package Manager)?",
                        options: [
                            "A. Mengelola database relasional",
                            "B. Menginstal dan mengelola library eksternal untuk proyek JavaScript",
                            "C. Melakukan compile file PHP"
                        ],
                        correct: 1
                    },
                    {
                        question: "Perintah Git mana yang digunakan untuk mengunduh perubahan dari repositori remote ke repositori lokal Anda?",
                        options: [
                            "A. git push",
                            "B. git clone",
                            "C. git pull"
                        ],
                        correct: 2
                    },
                    {
                        question: "Apa kegunaan dari bundler seperti Vite atau Webpack?",
                        options: [
                            "A. Menulis kode HTML secara otomatis",
                            "B. Menggabungkan dan mengoptimalkan aset/file kode agar siap dideploy",
                            "C. Menguji performa server hosting"
                        ],
                        correct: 1
                    }
                ]
            },
            {
                title: "Deployment & Hosting",
                fullTitle: "Menerbitkan Proyek Web ke Internet",
                content: `
                    <p class="text-slate-600 leading-relaxed mb-6">
                        Setelah proyek Frontend selesai dibuat, langkah terakhir adalah meng-hosting website agar bisa diakses oleh semua orang di seluruh dunia melalui internet.
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Langkah Penerbitan Web
                    </h3>
                    <ul class="space-y-3.5 text-slate-600 pl-4 list-disc mb-6">
                        <li><strong>Membeli Domain:</strong> Menentukan nama alamat website Anda (misalnya: <code>www.namakamu.com</code>).</li>
                        <li><strong>Memilih Platform Hosting Frontend:</strong> Layanan gratis dan cepat seperti <strong>Vercel</strong>, <strong>Netlify</strong>, atau <strong>GitHub Pages</strong>.</li>
                        <li><strong>Continuous Integration / Continuous Deployment (CI/CD):</strong> Otomatis memperbarui website di hosting setiap kali Anda melakukan <code>git push</code> ke GitHub.</li>
                        <li><strong>Optimasi Performa & SEO:</strong> Memastikan website memuat cepat, ramah mobile, dan terdaftar di Google Search.</li>
                    </ul>
                `,
                quiz: [
                    {
                        question: "Manakah platform hosting populer yang dirancang khusus untuk mempublikasikan proyek frontend secara gratis?",
                        options: [
                            "A. Vercel",
                            "B. MySQL Server",
                            "C. Apache HTTP Server"
                        ],
                        correct: 0
                    },
                    {
                        question: "Apa kepanjangan dari CI/CD dalam siklus hidup software?",
                        options: [
                            "A. Code Integration / Cloud Database",
                            "B. Continuous Integration / Continuous Deployment",
                            "C. Control Interface / Client Development"
                        ],
                        correct: 1
                    },
                    {
                        question: "Apa fungsi dari domain internet?",
                        options: [
                            "A. Menyimpan file gambar website",
                            "B. Alamat unik teks agar mempermudah pengguna membuka halaman website",
                            "C. Mengamankan file database"
                        ],
                        correct: 1
                    },
                    {
                        question: "Apa kegunaan utama dari sertifikat SSL/HTTPS pada suatu website?",
                        options: [
                            "A. Mengurangi biaya hosting",
                            "B. Mengenkripsi lalu lintas data dan meningkatkan keamanan website",
                            "C. Mempercepat waktu loading gambar"
                        ],
                        correct: 1
                    },
                    {
                        question: "Manakah dari berkas berikut yang biasanya dikonfigurasi untuk memberi tahu robot mesin pencari bagian mana dari situs yang tidak boleh diindeks?",
                        options: [
                            "A. index.html",
                            "B. sitemap.xml",
                            "C. robots.txt"
                        ],
                        correct: 2
                    }
                ]
            }
        ];

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
            if (index > currentStep) {
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

        // --- Workspace Module Content Loader ---
        window.loadModuleContent = function(index) {
            activeModuleIndex = index;
            const data = modulesData[index];

            // Update topbar headers
            document.getElementById('workspace-lesson-title').innerText = data.title;
            document.getElementById('workspace-progress-fraction').innerText = `${index + 1}/7`;

            // Scroll the content area back to top
            const scrollContainer = document.getElementById('workspace-scroll-container');
            if (scrollContainer) {
                scrollContainer.scrollTop = 0;
            }

            // Update text content area with fade effect
            const titleEl = document.getElementById('workspace-content-title');
            const bodyEl = document.getElementById('workspace-content-body');
            
            titleEl.classList.add('content-fade-enter');
            bodyEl.classList.add('content-fade-enter');

            setTimeout(() => {
                titleEl.innerText = data.fullTitle;
                bodyEl.innerHTML = data.content;

                titleEl.classList.remove('content-fade-enter');
                bodyEl.classList.remove('content-fade-enter');
            }, 100);

            // Update Marks Button style based on completed state
            const marksIcon = document.getElementById('marks-icon');
            
            if (index < currentStep) {
                marksIcon.setAttribute('fill', '#0050d2');
                document.getElementById('workspace-quiz-card').classList.add('hidden');
                document.getElementById('workspace-quiz-completed-card').classList.remove('hidden');
            } else {
                marksIcon.setAttribute('fill', 'none');
                document.getElementById('workspace-quiz-card').classList.remove('hidden');
                document.getElementById('workspace-quiz-completed-card').classList.add('hidden');
            }

            // Next button text settings
            const nextBtn = document.getElementById('workspace-next-btn');
            if (nextBtn) {
                if (index === 6) {
                    nextBtn.innerHTML = `Selesai <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>`;
                } else {
                    nextBtn.innerHTML = `Next <svg class="w-4 h-4 text-[#0050d2]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>`;
                }
            }

            renderSidebarProgress();
            renderSidebarLibrary();
        };

        // --- Sidebar Render Handlers ---
        function renderSidebarProgress() {
            const completedCount = currentStep; // 0 to 7 completed
            const pct = Math.min(100, Math.round((completedCount / 7) * 100));
            document.getElementById('sidebar-progress-bar').style.width = `${pct}%`;
            document.getElementById('sidebar-progress-text').innerText = `${completedCount} of 7 lessons completed`;
        }

        function renderSidebarLibrary() {
            const listEl = document.getElementById('sidebar-library-list');
            listEl.innerHTML = '';

            modulesData.forEach((mod, idx) => {
                const isCompleted = idx < currentStep;
                const isActive = idx === activeModuleIndex;
                const isLocked = idx > currentStep;

                let iconHtml = '';
                let textClass = 'text-slate-600 font-medium';
                let itemClass = 'bg-transparent border-b border-slate-200/60';
                let clickAction = `onclick="loadModuleContent(${idx})"`;

                if (isActive) {
                    textClass = 'text-slate-900 font-bold';
                    iconHtml = `
                        <span class="w-4.5 h-4.5 rounded-full border-2 border-[#0050d2] flex items-center justify-center shrink-0">
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
            if (activeModuleIndex === 6) {
                // If it is the last module, close the view and reload (which reflects the timeline changes)
                closeLearningView();
                return;
            }

            if (activeModuleIndex < currentStep) {
                // Already completed, can proceed to next module freely
                loadModuleContent(activeModuleIndex + 1);
            } else {
                // Current active module: must complete checkpoint first
                alert('Selesaikan checkpoint kuis terlebih dahulu untuk membuka modul berikutnya!');
            }
        };

        // --- Toggle Checkpoint Mark ---
        window.toggleCurrentModuleMark = function() {
            if (activeModuleIndex < currentStep) {
                // Already completed
                return;
            }

            if (activeModuleIndex === currentStep) {
                // Complete it via AJAX POST
                completeActiveModuleRealtime();
            }
        };

        // --- Complete Active Step via AJAX ---
        function completeActiveModuleRealtime() {
            const csrfToken = document.querySelector('input[name="_token"]').value;

            fetch("{{ route('path.frontend.complete') }}", {
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
                // Fallback completion locally in case of DB connection issues
                currentStep++;
                progressChanged = true;
                triggerConfetti();
                loadModuleContent(activeModuleIndex);
            });
        }

        // --- Quiz System Logic (Stacked 3D Flip Card Deck) ---
        window.launchInteractiveQuiz = function() {
            const data = modulesData[activeModuleIndex];
            
            // Set header title
            document.getElementById('quiz-modal-lesson-title').innerText = data.title;
            
            // Reset state
            currentQuestionIndex = 0;
            quizScore = 0;
            selectedOptions = [null, null, null, null, null];

            // Hide results screen
            const resultScreen = document.getElementById('quiz-result-screen');
            resultScreen.classList.remove('flex');
            resultScreen.classList.add('hidden');

            // Render all cards
            renderQuizStack();

            // Open Modal with scale/fade transitions
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
                // Just close normally
                closeQuizModal();
            } else {
                // Show confirmation modal
                const confirmModal = document.getElementById('quiz-exit-confirm-modal');
                if (confirmModal) {
                    confirmModal.classList.remove('hidden');
                    confirmModal.classList.add('flex');
                    // Trigger reflow for transition
                    void confirmModal.offsetWidth;
                    confirmModal.classList.add('opacity-100');
                    confirmModal.querySelector('div').classList.add('scale-100');
                }
            }
        };

        window.confirmExitQuiz = function(shouldExit) {
            const confirmModal = document.getElementById('quiz-exit-confirm-modal');
            if (confirmModal) {
                confirmModal.classList.remove('opacity-100');
                confirmModal.querySelector('div').classList.remove('scale-100');
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
                                        <button id="quiz-confirm-btn-${qIdx}" disabled onclick="verifyQuizCardAnswer(${qIdx})" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-slate-100 text-slate-400 font-extrabold rounded-2xl text-xs sm:text-sm transition-all duration-300 cursor-not-allowed">
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
                                        <button onclick="slideOutAndNext(${qIdx})" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-2xl text-xs sm:text-sm transition-all duration-300 shadow-md shadow-blue-500/20 cursor-pointer">
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
                
                // If it already went to the back, we don't overwrite its styles
                if (card.classList.contains('move-to-back')) {
                    return;
                }

                if (relativeIndex < 0) {
                    card.classList.add('move-to-back');
                    card.style.pointerEvents = 'none';
                    return;
                }
                
                // Active Card
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

            // Enable verify button
            const verifyBtn = document.getElementById(`quiz-confirm-btn-${qIdx}`);
            if (verifyBtn) {
                verifyBtn.className = "px-6 py-3 bg-[#0050d2] hover:bg-[#0040a8] text-white font-extrabold rounded-2xl text-xs sm:text-sm transition-all duration-300 cursor-pointer shadow-md shadow-[#0050d2]/15";
                verifyBtn.removeAttribute('disabled');
            }
        };

        window.verifyQuizCardAnswer = function(qIdx) {
            const data = modulesData[activeModuleIndex];
            const q = data.quiz[qIdx];
            const userChoice = selectedOptions[qIdx];
            const isCorrect = userChoice === q.correct;

            // Highlight choice cards on front side
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

            // Fill Back side feedback
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

            // Add flip animation class
            const cardEl = document.getElementById(`quiz-card-item-${qIdx}`);
            if (cardEl) {
                cardEl.classList.add('flipped');
            }
        };

        window.slideOutAndNext = function(qIdx) {
            const cardEl = document.getElementById(`quiz-card-item-${qIdx}`);
            if (cardEl) {
                cardEl.style.transform = ''; // Clear inline styles so keyframe animations can work
                cardEl.classList.remove('flipped'); // Unflip it as it goes to the back
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
            }, 600); // Trigger transition after the swing out phase starts
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

            if (quizScore >= 4) {
                // Pass (Lulus)
                resultBadge.className = "w-20 h-20 rounded-[24px] bg-emerald-50 text-emerald-500 flex items-center justify-center text-4xl shadow-sm mb-6 animate-bounce";
                resultBadge.innerHTML = "🎉";
                resultTitle.innerText = "Luar Biasa! Kuis Selesai";
                resultDesc.innerText = "Kamu berhasil menyelesaikan checkpoint ini dengan sangat baik. Progres belajar kamu disimpan secara real-time.";
                resultStatus.innerText = "LULUS";
                resultStatus.className = "text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-lg border border-emerald-200";
                
                resultContinueBtn.classList.remove('hidden');
                // Auto mark completed in DB if it's the active step
                if (activeModuleIndex === currentStep) {
                    completeActiveModuleRealtime();
                }
            } else {
                // Fail (Gagal)
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

            // Hide results screen
            const resultScreen = document.getElementById('quiz-result-screen');
            resultScreen.classList.remove('flex');
            resultScreen.classList.add('hidden');

            renderQuizStack();
        };

        window.closeQuizModalAndUnlock = function() {
            closeQuizModal();
            // Automatically select next module if it has just been unlocked
            if (progressChanged && activeModuleIndex < 6) {
                sessionStorage.setItem('autoOpenModuleIndex', activeModuleIndex + 1);
                window.location.reload();
            } else if (activeModuleIndex + 1 <= currentStep && activeModuleIndex < 6) {
                setTimeout(() => {
                    loadModuleContent(activeModuleIndex + 1);
                }, 300);
            } else {
                closeLearningView();
            }
        };

        // --- Interactive 3D Cursor-Wobble / Tilt Card Effect ---
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

        // --- Workspace Header Scroll Shrink Effect ---
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

        // --- Background Tech/Emoji Floating Particle Elements ---
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

        // --- Interactive IT/Code-Themed Cursor Trails ---
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

        // --- Scroll Down Reveal Animation ---
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

        // --- Mini Card Modal (Informasi Umum) Logic ---
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
    });
    </script>
</body>
</html>
