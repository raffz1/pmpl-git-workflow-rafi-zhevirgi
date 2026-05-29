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

        /* 3D Tilt/Wobble Effect for Curriculum Cards */
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
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col overflow-x-hidden relative">

    <!-- Top Navigation Bar -->
    @include('layouts.navbar')

    <!-- Interactive Background & Effects -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <!-- Faded Blue Grid Overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f607_1px,transparent_1px),linear-gradient(to_bottom,#3b82f607_1px,transparent_1px)] bg-[size:5rem_5rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_80%,transparent_100%)] opacity-80"></div>
        
        <!-- Ambient Glowing Blobs -->
        <div class="absolute top-[10%] left-[-5%] w-[450px] h-[450px] rounded-full bg-blue-300/10 blur-3xl animate-float-blob" style="animation-duration: 9s;"></div>
        <div class="absolute top-[45%] right-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-300/10 blur-3xl animate-float-blob" style="animation-delay: -3s; animation-duration: 12s;"></div>
        <div class="absolute bottom-[15%] left-[10%] w-[400px] h-[400px] rounded-full bg-cyan-200/10 blur-3xl animate-float-blob" style="animation-delay: -6s; animation-duration: 10s;"></div>

        <!-- Drifting Particles Container -->
        <div id="particle-container" class="absolute inset-0 z-0"></div>
    </div>

    <!-- Main Content Area -->
    <main class="grow relative z-10 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Career Path Header Card (Redesigned matching image mockup) -->
        <section class="mb-14 animate-fade-in-up" style="animation-delay: 50ms;">
            <div class="bg-gradient-to-br from-white via-blue-50/5 to-white border border-slate-200/60 rounded-3xl p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col lg:flex-row items-center gap-10">
                
                <!-- Left: Text Information -->
                <div class="flex-grow max-w-2xl order-2 lg:order-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 border border-blue-100 text-blue-600 mb-4 tracking-wide uppercase">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Career Path
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight title-font mb-4">
                        FRONT-END DEVELOPER
                    </h1>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed mb-6 font-medium">
                        Front End Developer adalah profesi yang bertugas membuat tampilan dan antarmuka website atau aplikasi agar menarik, interaktif, dan mudah digunakan pengguna. Pekerjaan ini menggunakan teknologi seperti HTML, CSS, dan JavaScript serta bekerja sama dengan UI/UX Designer dan Back End Developer untuk menciptakan pengalaman pengguna yang optimal.
                    </p>
                    
                    <!-- Information Trigger Button -->
                    <button class="inline-flex items-center gap-2 px-4 py-2 border border-slate-200 hover:border-blue-400 rounded-xl text-xs font-bold text-slate-700 bg-white hover:bg-blue-50/30 transition-all duration-300 shadow-sm cursor-pointer hover:scale-[1.03]" onclick="alert('Jalur pembelajaran Front End Developer dirancang agar siswa memahami HTML, CSS, JavaScript, hingga modern framework untuk menciptakan website premium.')">
                        Informasi Umum
                        <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Right: Mockup Image inside rounded frame with shadow/glow -->
                <div class="w-full lg:w-[380px] h-60 sm:h-72 rounded-2xl overflow-hidden shadow-2xl border-4 border-blue-500/20 group relative cursor-pointer order-1 lg:order-2 flex-shrink-0">
                    <img src="https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=600&auto=format&fit=crop&q=80" alt="Path Wireframe Mockup" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/20 to-transparent"></div>
                </div>

            </div>
        </section>

        <!-- Curriculum Section Header & Progress Bar -->
        <section class="mb-14 animate-fade-in-up" style="animation-delay: 100ms;">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200/60 pb-6 mb-10">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight title-font flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                        Learning Curriculum
                    </h2>
                </div>
                <!-- Progress display -->
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <span class="text-xs font-bold text-slate-400 whitespace-nowrap">Your Progress</span>
                    <div class="w-full sm:w-44 bg-slate-200/70 rounded-full h-2 overflow-hidden">
                        <div class="bg-blue-600 h-2 rounded-full shadow-sm" style="width: 15%"></div>
                    </div>
                    <span class="text-xs font-extrabold text-blue-600 whitespace-nowrap bg-blue-50 border border-blue-100/50 px-2 py-0.5 rounded-lg">15%</span>
                </div>
            </div>

            <!-- Vertical Timeline Section -->
            <div class="relative max-w-5xl mx-auto px-2 py-4">
                
                <!-- Central vertical axis timeline line -->
                <div class="absolute timeline-line top-0 bottom-0 left-1/2 w-0.5 bg-slate-200/80 -translate-x-1/2 z-0"></div>

                <!-- Curriculum Modules Grid Loop -->
                <div class="space-y-12 relative z-10">
                    
                    @php
                        $curriculum = [
                            [
                                'title' => 'Pendahuluan',
                                'badge' => 'Completed',
                                'desc' => 'mempelajari dasar pengembangan tampilan website.',
                                'action_label' => 'Review',
                                'side' => 'left',
                                'icon' => 'HTML',
                            ],
                            [
                                'title' => 'Pengenalan HTML',
                                'badge' => 'Active',
                                'desc' => 'mempelajari struktur dasar dan elemen HTML.',
                                'action_label' => 'Start Learning',
                                'side' => 'right',
                                'icon' => 'HTML',
                            ],
                            [
                                'title' => 'Pendalaman HTML',
                                'badge' => 'Unlocked',
                                'desc' => 'mempelajari form, tabel, semantic, dan multimedia.',
                                'action_label' => 'Start Learning',
                                'side' => 'left',
                                'icon' => 'HTML',
                            ],
                            [
                                'title' => 'Pengenalan CSS',
                                'badge' => 'Unlocked',
                                'desc' => 'mempelajari styling dan tampilan website.',
                                'action_label' => 'Start Learning',
                                'side' => 'right',
                                'icon' => 'HTML',
                            ],
                            [
                                'title' => 'Pendalaman CSS',
                                'badge' => 'Unlocked',
                                'desc' => 'mempelajari animasi, flexbox, dan grid layout.',
                                'action_label' => 'Start Learning',
                                'side' => 'left',
                                'icon' => 'HTML',
                            ],
                            [
                                'title' => 'Layout Responsive',
                                'badge' => 'Unlocked',
                                'desc' => 'mempelajari tampilan website di berbagai perangkat.',
                                'action_label' => 'Start Learning',
                                'side' => 'right',
                                'icon' => 'HTML',
                            ],
                            [
                                'title' => 'Quiz',
                                'badge' => 'Unlocked',
                                'desc' => 'Selesaikan kuis untuk lanjut ke card selanjutnya!',
                                'action_label' => 'Start Learning',
                                'side' => 'left',
                                'icon' => 'HTML',
                            ],
                        ];
                    @endphp

                    @foreach($curriculum as $index => $module)
                        @php
                            // Set node statuses & styles
                            $nodeIcon = '';
                            $nodeColor = 'bg-white border-slate-300 text-slate-400 shadow-sm';
                            
                            if ($module['badge'] === 'Completed') {
                                $nodeColor = 'bg-blue-600 border-blue-600 text-white shadow-md shadow-blue-500/20';
                            } elseif ($module['badge'] === 'Active') {
                                $nodeColor = 'bg-white border-blue-500 border-4 text-blue-600 shadow-md shadow-blue-500/10';
                            } else {
                                // Locked status: render a lock icon inside the timeline node
                                $nodeIcon = 'locked';
                                $nodeColor = 'bg-slate-50 border-slate-200 text-slate-300';
                            }

                            // Dynamic badge layout Classes
                            $badgeClass = '';
                            switch($module['badge']) {
                                case 'Completed':
                                    $badgeClass = 'bg-emerald-50 border border-emerald-100 text-emerald-600';
                                    break;
                                case 'Active':
                                    $badgeClass = 'bg-blue-50 border border-blue-100 text-blue-600';
                                    break;
                                default:
                                    $badgeClass = 'bg-slate-100 border border-slate-200/60 text-slate-400';
                                    break;
                            }
                        @endphp

                        <div class="flex flex-col md:flex-row items-center justify-between w-full relative">
                            
                            <!-- Left Card (Occupies left on desktop) -->
                            <div class="w-full md:w-[44%] {{ $module['side'] === 'left' ? 'order-1' : 'order-3 opacity-0 pointer-events-none md:block hidden' }}">
                                @if($module['side'] === 'left')
                                    <!-- Curriculum Card Component -->
                                    <div class="group wobble-card bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:bg-blue-600 hover:border-blue-600 hover:shadow-[0_16px_36px_-8px_rgba(37,99,235,0.22)] cursor-pointer">
                                        <div class="inner-lift flex items-start gap-4">
                                            <!-- Module Brand badge -->
                                            <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center font-extrabold text-xs text-blue-600 flex-shrink-0 group-hover:bg-white/20 group-hover:border-white/30 group-hover:text-white transition-colors duration-300">
                                                {{ $module['icon'] }}
                                            </div>
                                            <!-- Module Body Info -->
                                            <div class="flex-grow">
                                                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-white transition-colors duration-300">
                                                        {{ $module['title'] }}
                                                    </h3>
                                                    <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $badgeClass }} group-hover:bg-white/25 group-hover:border-transparent group-hover:text-white transition-colors duration-300 font-mono">
                                                        {{ $module['badge'] }}
                                                    </span>
                                                </div>
                                                <p class="text-xs sm:text-sm text-slate-500 group-hover:text-blue-50 transition-colors duration-300 mb-5 leading-relaxed">
                                                    {{ $module['desc'] }}
                                                </p>
                                                <!-- Action Link -->
                                                <div>
                                                    <a href="{{ auth()->check() ? route('explore.enroll', 1) : url('/login') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold rounded-xl bg-slate-50 text-slate-600 border border-slate-200/60 hover:bg-blue-50 hover:text-blue-600 group-hover:bg-white group-hover:text-blue-600 group-hover:border-white transition-all duration-300 shadow-sm cursor-pointer hover:no-underline">
                                                        {{ $module['action_label'] }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                    <div class="group wobble-card bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:bg-blue-600 hover:border-blue-600 hover:shadow-[0_16px_36px_-8px_rgba(37,99,235,0.22)] cursor-pointer">
                                        <div class="inner-lift flex items-start gap-4">
                                            <!-- Module Brand badge -->
                                            <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center font-extrabold text-xs text-blue-600 flex-shrink-0 group-hover:bg-white/20 group-hover:border-white/30 group-hover:text-white transition-colors duration-300">
                                                {{ $module['icon'] }}
                                            </div>
                                            <!-- Module Body Info -->
                                            <div class="flex-grow">
                                                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900 group-hover:text-white transition-colors duration-300">
                                                        {{ $module['title'] }}
                                                    </h3>
                                                    <span class="inline-block px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $badgeClass }} group-hover:bg-white/25 group-hover:border-transparent group-hover:text-white transition-colors duration-300 font-mono">
                                                        {{ $module['badge'] }}
                                                    </span>
                                                </div>
                                                <p class="text-xs sm:text-sm text-slate-500 group-hover:text-blue-50 transition-colors duration-300 mb-5 leading-relaxed">
                                                    {{ $module['desc'] }}
                                                </p>
                                                <!-- Action Link -->
                                                <div>
                                                    <a href="{{ auth()->check() ? route('explore.enroll', 1) : url('/login') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-extrabold rounded-xl bg-slate-50 text-slate-600 border border-slate-200/60 hover:bg-blue-50 hover:text-blue-600 group-hover:bg-white group-hover:text-blue-600 group-hover:border-white transition-all duration-300 shadow-sm cursor-pointer hover:no-underline">
                                                        {{ $module['action_label'] }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

    <!-- Interactive JS Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- Interactive 3D Cursor-Wobble / Tilt Card Effect ---
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
            const icons = ['💻', '🚀', '⚡', '📐', '🧠', '✨', '🎓', '🎨', '🔥', '📚'];
            
            for (let i = 0; i < 15; i++) {
                const item = document.createElement('div');
                item.className = 'absolute select-none cursor-pointer transition-all duration-500 hover:scale-150 hover:rotate-[360deg] active:scale-95 text-xl opacity-[0.06] hover:opacity-70 filter drop-shadow-sm pointer-events-auto';
                item.innerText = icons[Math.floor(Math.random() * icons.length)];
                
                item.style.left = `${Math.random() * 92 + 4}%`;
                item.style.top = `${Math.random() * 85 + 10}%`;
                
                const animName = `float-curric-${i}`;
                const keyframes = `
                    @keyframes ${animName} {
                        0%, 100% { transform: translateY(0px) rotate(0deg); }
                        50% { transform: translateY(${Math.random() * -30 - 15}px) rotate(${Math.random() * 16 - 8}deg); }
                    }
                `;
                
                const styleSheet = document.createElement('style');
                styleSheet.innerText = keyframes;
                document.head.appendChild(styleSheet);
                
                item.style.animation = `${animName} ${Math.random() * 6 + 8}s ease-in-out infinite`;
                particleContainer.appendChild(item);
                
                item.addEventListener('click', () => {
                    item.style.transform = 'scale(2) rotate(360deg)';
                    item.style.opacity = '1';
                    setTimeout(() => {
                        item.style.transform = '';
                        item.style.opacity = '0.06';
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
        });
    </script>
</body>
</html>
