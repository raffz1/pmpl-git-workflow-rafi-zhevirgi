<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UI/UX Designer - Path Deck</title>
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
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col overflow-x-hidden relative">

    <!-- Top Navigation Bar -->
    @include('layouts.navbar')

    <!-- Interactive Background & Effects -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <!-- Faded Blue Grid Overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f612_1px,transparent_1px),linear-gradient(to_bottom,#3b82f612_1px,transparent_1px)] bg-[size:5rem_5rem] [mask-image:radial-gradient(ellipse_65%_55%_at_50%_0%,#000_90%,transparent_100%)] opacity-100"></div>
        
        <!-- Ambient Glowing Blobs -->
        <div class="absolute top-[10%] left-[-5%] w-[450px] h-[450px] rounded-full bg-blue-400/22 blur-3xl animate-float-blob" style="animation-duration: 9s;"></div>
        <div class="absolute top-[45%] right-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-400/18 blur-3xl animate-float-blob" style="animation-delay: -3s; animation-duration: 12s;"></div>
        <div class="absolute bottom-[15%] left-[10%] w-[400px] h-[400px] rounded-full bg-cyan-300/20 blur-3xl animate-float-blob" style="animation-delay: -6s; animation-duration: 10s;"></div>

        <!-- Drifting Particles Container -->
        <div id="particle-container" class="absolute inset-0 z-0"></div>
    </div>

    <!-- Main Content Area -->
    <main class="grow relative z-10 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">
        
        @if(session('success'))
            <div class="mb-6 px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-bold flex items-center gap-3 animate-fade-in-up">
                <span>🎉</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Career Path Header Card -->
        <section class="mb-14 animate-fade-in-up" style="animation-delay: 50ms;">
            <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-900 rounded-3xl p-8 sm:p-10 shadow-[0_12px_40px_-6px_rgba(37,99,235,0.25)] flex flex-col lg:flex-row items-center gap-10 text-white relative overflow-hidden border-none">
                
                <!-- Graphic overlay grid -->
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
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight title-font mb-4 drop-shadow-sm">
                        UI/UX DESIGNER
                    </h1>
                    <p class="text-sm sm:text-base text-blue-50/90 leading-relaxed mb-6 font-medium">
                        UI/UX Designer bertanggung jawab membuat tampilan aplikasi menarik dan nyaman digunakan. Mereka melakukan riset pengguna untuk memahami kebutuhan dan kebiasaan pengguna aplikasi. UI fokus pada desain visual, sedangkan UX fokus pada pengalaman pengguna. Profesi ini membutuhkan kreativitas, empati, dan kemampuan problem solving.
                    </p>
                    
                    <!-- Information Trigger Button -->
                    <button id="open-info-btn" class="inline-flex items-center gap-2 px-4 py-2 border border-white/20 hover:border-white/40 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 transition-all duration-300 shadow-sm cursor-pointer hover:scale-[1.03]">
                        Informasi Umum
                        <svg class="w-4 h-4 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Right: Mockup Image inside rounded frame with shadow/glow -->
                <div class="w-full lg:w-[380px] h-60 sm:h-72 rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 group relative cursor-pointer order-1 lg:order-2 flex-shrink-0 z-10">
                    <img src="https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=600&auto=format&fit=crop&q=80" alt="UIUX Wireframe Mockup" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
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
                    
                    <!-- Reset Progress Form -->
                    <form action="{{ route('path.uiux.reset') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 border border-red-200 hover:border-red-400 rounded-xl text-xs font-bold text-red-600 bg-red-50/50 hover:bg-red-50 transition-all duration-300 shadow-sm cursor-pointer hover:scale-[1.03]" title="Reset Detail Progress">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89H18.21" />
                            </svg>
                            Mulai dari Awal
                        </button>
                    </form>
                </div>
                
                @php
                    $percentVal = min(100, round(($currentStep / 10) * 100));
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
                
                <!-- Central vertical axis timeline line with animated running blue line path -->
                <div class="absolute timeline-line top-0 bottom-0 left-1/2 w-1.5 bg-slate-200 -translate-x-1/2 z-0 rounded-full overflow-hidden">
                    <div class="absolute top-0 w-full bg-gradient-to-b from-blue-400 via-blue-600 to-indigo-600 rounded-full shadow-[0_0_12px_rgba(59,130,246,0.8)]" style="height: {{ $percentVal }}%; transition: height 1.2s cubic-bezier(0.25, 1, 0.5, 1);">
                        <!-- Pulsing running laser dot -->
                        <div class="absolute bottom-0 left-0 right-0 h-4 bg-white animate-pulse rounded-full shadow-[0_0_15px_#fff]"></div>
                    </div>
                </div>

                <!-- Curriculum Modules Grid Loop -->
                <div class="space-y-12 relative z-10">
                    
                    @php
                        $curriculum = [
                            [
                                'title' => 'Dasar desain visual',
                                'desc' => 'mempelajari prinsip desain dan estetika.',
                                'side' => 'left',
                            ],
                            [
                                'title' => 'Typography, warna, layout',
                                'desc' => 'mempelajari kombinasi font dan warna.',
                                'side' => 'right',
                            ],
                            [
                                'title' => 'Design thinking',
                                'desc' => 'mempelajari proses penyelesaian masalah pengguna.',
                                'side' => 'left',
                            ],
                            [
                                'title' => 'User research',
                                'desc' => 'mempelajari analisis kebutuhan pengguna.',
                                'side' => 'right',
                            ],
                            [
                                'title' => 'Wireframe & user flow',
                                'desc' => 'mempelajari struktur dan alur aplikasi.',
                                'side' => 'left',
                            ],
                            [
                                'title' => 'Figma / design tools',
                                'desc' => 'mempelajari tools desain digital.',
                                'side' => 'right',
                            ],
                            [
                                'title' => 'Prototyping',
                                'desc' => 'mempelajari simulasi interaksi aplikasi.',
                                'side' => 'left',
                            ],
                            [
                                'title' => 'Design system',
                                'desc' => 'mempelajari konsistensi komponen desain.',
                                'side' => 'right',
                            ],
                            [
                                'title' => 'Usability testing',
                                'desc' => 'mempelajari pengujian pengalaman pengguna.',
                                'side' => 'left',
                            ],
                            [
                                'title' => 'QUIZ',
                                'desc' => 'Selesaikan kuis untuk lanjut ke card selanjutnya!',
                                'side' => 'right',
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
                            
                            <!-- Left Card (Occupies left on desktop) -->
                            <div class="w-full md:w-[44%] {{ $module['side'] === 'left' ? 'order-1' : 'order-3 opacity-0 pointer-events-none md:block hidden' }}">
                                @if($module['side'] === 'left')
                                    <!-- Curriculum Card Component -->
                                    @if($status !== 'Locked')
                                        <!-- Active or Completed card -->
                                        <div class="group wobble-card bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:bg-blue-600 hover:border-blue-600 hover:shadow-[0_16px_36px_-8px_rgba(37,99,235,0.22)] cursor-pointer transition-all duration-300 {{ $status === 'Active' ? 'card-active-glow' : '' }}">
                                            <div class="inner-lift flex items-start gap-4">
                                                <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center font-extrabold text-xs text-blue-600 flex-shrink-0 group-hover:bg-white/20 group-hover:border-white/30 group-hover:text-white transition-colors duration-300">
                                                    <!-- Fountain Pen SVG Icon -->
                                                    <svg class="w-5 h-5 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
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
                                                            <form action="{{ route('path.uiux.complete') }}" method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold rounded-xl bg-slate-50 text-slate-600 border border-slate-200/60 hover:bg-blue-50 hover:text-blue-600 group-hover:bg-white group-hover:text-blue-600 group-hover:border-white transition-all duration-300 shadow-sm cursor-pointer hover:no-underline">
                                                                    Start Learning
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200 group-hover:bg-white/20 group-hover:text-white group-hover:border-white/30 transition-all duration-300 shadow-sm cursor-default">
                                                                Review
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Locked card -->
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

                            <!-- Timeline Center Circle Indicator -->
                            <div class="timeline-node absolute left-1/2 -translate-x-1/2 w-10 h-10 rounded-full flex items-center justify-center z-10 {{ $nodeColor }} order-2 my-4 md:my-0">
                                @if($nodeIcon === 'locked')
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                @else
                                    <div class="w-2.5 h-2.5 rounded-full bg-current"></div>
                                @endif
                            </div>

                            <!-- Right Card (Occupies right on desktop) -->
                            <div class="w-full md:w-[44%] {{ $module['side'] === 'right' ? 'order-3' : 'order-1 opacity-0 pointer-events-none md:block hidden' }}">
                                @if($module['side'] === 'right')
                                    <!-- Curriculum Card Component -->
                                    @if($status !== 'Locked')
                                        <!-- Active or Completed card -->
                                        <div class="group wobble-card bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:bg-blue-600 hover:border-blue-600 hover:shadow-[0_16px_36px_-8px_rgba(37,99,235,0.22)] cursor-pointer transition-all duration-300 {{ $status === 'Active' ? 'card-active-glow' : '' }}">
                                            <div class="inner-lift flex items-start gap-4">
                                                <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center font-extrabold text-xs text-blue-600 flex-shrink-0 group-hover:bg-white/20 group-hover:border-white/30 group-hover:text-white transition-colors duration-300">
                                                    <!-- Fountain Pen SVG Icon -->
                                                    <svg class="w-5 h-5 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
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
                                                            <form action="{{ route('path.uiux.complete') }}" method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold rounded-xl bg-slate-50 text-slate-600 border border-slate-200/60 hover:bg-blue-50 hover:text-blue-600 group-hover:bg-white group-hover:text-blue-600 group-hover:border-white transition-all duration-300 shadow-sm cursor-pointer hover:no-underline">
                                                                    Start Learning
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200 group-hover:bg-white/20 group-hover:text-white group-hover:border-white/30 transition-all duration-300 shadow-sm cursor-default">
                                                                Review
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Locked card -->
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

    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-slate-50 py-8 mt-auto relative z-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm text-slate-500 font-medium">&copy; 2026 Path Deck</p>
        </div>
    </footer>

    <!-- Mini Card Modal (Informasi Umum) -->
    <div id="info-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-sm opacity-0">
        <!-- Modal Card Container -->
        <div id="modal-container" class="bg-white rounded-[28px] max-w-4xl w-full overflow-hidden flex flex-col md:flex-row shadow-[0_24px_60px_-15px_rgba(0,0,0,0.3)] relative transform scale-90 translate-y-8 transition-all duration-500 max-h-[90vh] md:max-h-none overflow-y-auto md:overflow-y-visible">
            
            <!-- Close Button (Absolute) -->
            <button id="close-modal-btn" class="absolute top-4 right-4 z-50 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-800 transition-colors shadow-sm cursor-pointer border border-slate-200/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Left Section: Side info panel -->
            <div class="w-full md:w-[35%] bg-[#f0f4ff] p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden shrink-0">
                <!-- Decorative Top Grid pattern -->
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f605_1px,transparent_1px),linear-gradient(to_bottom,#3b82f605_1px,transparent_1px)] bg-[size:1.5rem_1.5rem] opacity-70"></div>
                
                <div class="relative z-10">
                    <!-- Icon badge -->
                    <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center font-extrabold text-xs text-white shadow-md shadow-blue-500/30 mb-6">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    
                    <!-- Title -->
                    <h2 class="text-2xl font-black text-slate-900 leading-tight mb-4 title-font">
                        UI/UX<br>Designer
                    </h2>
                    
                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-3 py-1 bg-blue-600 text-white rounded-full text-xs font-bold shadow-sm">
                            Profesional
                        </span>
                        <span class="px-3 py-1 bg-blue-500 text-white rounded-full text-xs font-bold shadow-sm">
                            Advanced
                        </span>
                    </div>
                </div>

                <!-- Bottom Image -->
                <div class="w-full h-48 md:h-64 rounded-2xl overflow-hidden shadow-md mt-6 relative border border-white z-10">
                    <img src="https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=600&auto=format&fit=crop&q=80" alt="UIUX Designer Creative Discussion" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950/20 to-transparent"></div>
                </div>
            </div>

            <!-- Right Section: Details Panel -->
            <div class="w-full md:w-[65%] p-6 sm:p-8 flex flex-col justify-between shrink-0 overflow-y-auto max-h-[60vh] md:max-h-none">
                <div>
                    <!-- Deskripsi Karir Header -->
                    <span class="text-xs font-black tracking-wider text-slate-400 uppercase block mb-3 font-mono">
                        DESKRIPSI KARIR
                    </span>
                    
                    <!-- Deskripsi Karir Body Text -->
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium mb-6">
                        UI/UX Designer adalah profesi yang berfokus pada desain tampilan dan pengalaman pengguna dalam aplikasi digital. Peran ini memastikan aplikasi terlihat menarik, mudah digunakan, dan nyaman bagi pengguna. UI Designer fokus pada visual, sedangkan UX Designer fokus pada alur dan pengalaman pengguna. Karir ini cocok bagi yang kreatif dan memiliki empati terhadap kebutuhan pengguna.
                    </p>

                    <!-- Two columns -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        
                        <!-- Estimasi Gaji Box -->
                        <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4 flex flex-col justify-between">
                            <span class="text-xs font-bold text-slate-400 block mb-1">
                                Estimasi Gaji
                            </span>
                            <div>
                                <span class="text-sm sm:text-base font-black text-blue-600 block">
                                    Rp 4.500.000 -
                                </span>
                                <span class="text-sm sm:text-base font-black text-blue-600 inline">
                                    Rp 15.000.000
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
                            <div class="grid grid-cols-2 gap-2">
                                <span class="inline-flex items-center gap-1 px-2 py-1 border border-slate-200 rounded-lg text-[9px] font-bold text-slate-700 bg-white">
                                    <span class="text-blue-500 font-mono text-[9px] font-bold">&lt;&gt;</span> Figma
                                </span>
                                <span class="inline-flex items-center gap-1 px-2 py-1 border border-slate-200 rounded-lg text-[9px] font-bold text-slate-700 bg-white">
                                    <span class="text-blue-500 font-mono text-[9px] font-bold">&lt;&gt;</span> Prototyping
                                </span>
                                <span class="inline-flex items-center gap-1 px-2 py-1 border border-slate-200 rounded-lg text-[9px] font-bold text-slate-700 bg-white">
                                    <span class="text-blue-500 font-mono text-[9px] font-bold">&lt;&gt;</span> Wireframing
                                </span>
                                <span class="inline-flex items-center gap-1 px-2 py-1 border border-slate-200 rounded-lg text-[9px] font-bold text-slate-700 bg-white">
                                    <span class="text-blue-500 font-mono text-[9px] font-bold">&lt;&gt;</span> Design System
                                </span>
                            </div>
                        </div>

                    </div>

                    <!-- Cocok buat kamu yang... Checklist -->
                    <div class="bg-blue-50/20 border border-blue-100/30 rounded-2xl p-5">
                        <h4 class="text-xs sm:text-sm font-black text-slate-800 tracking-tight title-font mb-4">
                            Cocok buat kamu yang...
                        </h4>
                        <ul class="space-y-3.5 text-xs text-slate-600 font-medium">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Menyukai desain visual dan kreativitas.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Tertarik memahami perilaku pengguna aplikasi.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Suka membuat tampilan yang rapi dan interaktif.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Interactive JS Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- Interactive 3D Cursor-Wobble / Tilt Card Effect (Only applied to unlocked wobble cards) ---
            const cards = document.querySelectorAll('.wobble-card');
            
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left; // x coordinate inside element
                    const y = e.clientY - rect.top;  // y coordinate inside element
                    
                    const width = rect.width;
                    const height = rect.height;
                    
                    // Rotate calculation: limit rotation max 12 deg
                    const rotateX = ((y / height) - 0.5) * -12;
                    const rotateY = ((x / width) - 0.5) * 12;
                    
                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.025)`;
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
                });
            });

            // --- Background Tech/Emoji Floating Particle Elements ---
            const particleContainer = document.getElementById('particle-container');
            const icons = ['🎨', '🖋️', '📐', '🧠', '✨', '🎓', '🔥', '📚', '⚙️', '📱', '💻', '💡', '💬', '👀', '📌'];
            
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
            const trailSymbols = ['figma', 'prototype', 'wireframe', 'ux', 'ui', 'user', 'persona', 'flow', 'testing', 'design', 'components', 'colors', 'fonts', 'typography'];
            
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
            const modalContainer = document.getElementById('modal-container');
            const openModalBtn = document.getElementById('open-info-btn');
            const closeModalBtn = document.getElementById('close-modal-btn');

            function openModal() {
                infoModal.classList.remove('hidden');
                infoModal.classList.add('flex');
                // Force layout reflow
                void infoModal.offsetWidth;
                infoModal.classList.add('show');
                document.body.classList.add('overflow-hidden');
            }

            function closeModal() {
                infoModal.classList.remove('show');
                document.body.classList.remove('overflow-hidden');
                // Wait for fade transition duration (350ms)
                setTimeout(() => {
                    infoModal.classList.remove('flex');
                    infoModal.classList.add('hidden');
                }, 350);
            }

            if (openModalBtn) openModalBtn.addEventListener('click', openModal);
            if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);

            // Close when clicking overlay backdrop
            infoModal.addEventListener('click', (e) => {
                if (e.target === infoModal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>
