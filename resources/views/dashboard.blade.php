<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Path Deck</title>
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
        
        /* Custom Transition */
        .card-transition {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                        box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), 
                        border-color 0.4s ease;
        }

        /* 3D Tilt Effect */
        .card-tilt {
            transform-style: preserve-3d;
            perspective: 1000px;
        }
        .card-tilt * {
            transform-style: preserve-3d;
        }

        /* Ambient Blobs Animations */
        @keyframes float-blob {
            0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
            33% { transform: translateY(-20px) scale(1.06) rotate(2deg); }
            66% { transform: translateY(15px) scale(0.94) rotate(-2deg); }
        }
        .animate-float-blob {
            animation: float-blob 11s ease-in-out infinite;
        }

        /* Fade In Up */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col overflow-x-hidden relative">

    <!-- Top Navigation Bar -->
    @include('layouts.navbar')

    <!-- Main Content Wrapper with Soft Gradients & Blue Theme Accents -->
    <div class="relative flex-grow min-h-screen bg-gradient-to-b from-slate-50 via-blue-50/10 to-slate-50 py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
        
        <!-- Faded Geometric Pattern Grid -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f60a_1px,transparent_1px),linear-gradient(to_bottom,#3b82f60a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_80%,transparent_100%)] pointer-events-none z-0"></div>

        <!-- Ambient Blue Floating Blobs -->
        <div class="absolute top-[15%] left-[-8%] w-[450px] h-[450px] rounded-full bg-blue-300/15 blur-3xl pointer-events-none animate-float-blob" style="animation-duration: 9s;"></div>
        <div class="absolute bottom-[10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-300/10 blur-3xl pointer-events-none animate-float-blob" style="animation-delay: -4s; animation-duration: 13s;"></div>

        <!-- Drifting Emojis and Symbols Container -->
        <div id="particle-container" class="absolute inset-0 overflow-hidden pointer-events-none z-0"></div>

        <main class="max-w-7xl mx-auto w-full relative z-10">
            
            <!-- Header Section -->
            <header class="mb-10 animate-fade-in-up" style="animation-delay: 50ms;">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight title-font">
                    Welcome Back, <span class="bg-gradient-to-r from-blue-600 via-blue-500 to-indigo-600 bg-clip-text text-transparent inline-block hover:scale-[1.02] transition-transform duration-300">{{ $userName }}</span>!
                </h1>
                <p class="text-sm sm:text-base text-slate-500 mt-2 font-medium min-h-[40px] sm:min-h-[24px]">
                    <span id="typing-text">Pantau progres belajar dan asah terus keahlian IT kamu di Path Deck.</span><span class="inline-block w-[2px] h-[1.1em] bg-blue-600 ml-1 animate-pulse align-middle" id="typing-cursor"></span>
                </p>
            </header>

            <!-- Success Alert Notification -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-sm font-semibold flex items-center gap-3 animate-fade-in-up">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Main Layout Grid -->
            <div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column (Span 2) -->
                    <div class="lg:col-span-2 space-y-10">
                        
                        <!-- Continue Learning Section -->
                        <section class="animate-fade-in-up" style="animation-delay: 100ms;">
                            <h2 class="text-xl font-bold text-slate-900 mb-5 title-font flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                                Continue Learning
                            </h2>
                            
                            @if($activePath)
                                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.04)] flex flex-col sm:flex-row gap-6 relative group hover:border-blue-200 hover:shadow-[0_12px_32px_-8px_rgba(59,130,246,0.12)] transition-all duration-300">
                                    <!-- Progress Badge in Top Right -->
                                    <div class="absolute top-6 right-6">
                                        <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                            {{ $activePath['progress'] }}% Complete
                                        </span>
                                    </div>

                                    <!-- Course Image (Cover) -->
                                    <div class="w-full sm:w-48 h-36 rounded-xl overflow-hidden flex-shrink-0 bg-slate-100 border border-slate-200/50 shadow-sm relative">
                                        <img src="{{ $activePath['image'] }}" alt="Course Thumbnail" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                                    </div>
                                    
                                    <!-- Course Info -->
                                    <div class="flex-grow flex flex-col justify-between pt-2 sm:pt-0">
                                        <div>
                                            <h3 class="text-xl font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors duration-300 pr-24">
                                                {{ $activePath['title'] }}
                                            </h3>
                                            <p class="text-[13px] font-semibold text-slate-400 mt-1 uppercase tracking-wider">
                                                {{ $activePath['module'] }}
                                            </p>
                                        </div>
                                        
                                        <!-- Progress Bar -->
                                        <div class="mt-5 mb-5">
                                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                                <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $activePath['progress'] }}%"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between">
                                            <a href="{{ $activePath['url'] ?? url('/explore') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-600/10 hover:shadow-lg hover:shadow-blue-600/20 transition-all duration-300 hover:scale-[1.03]">
                                                Continue &rarr;
                                            </a>

                                            <!-- Reset Progress Form Link -->
                                            <form action="{{ route('dashboard.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/reset progres belajar ini?')">
                                                @csrf
                                                <button type="submit" class="text-xs font-semibold text-slate-400 hover:text-rose-500 transition-colors py-1 px-2.5 rounded-lg hover:bg-slate-100">
                                                    Reset Path
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 sm:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.04)] hover:shadow-md transition-all duration-300">
                                    <div class="border border-slate-200/60 bg-slate-50/10 rounded-2xl py-8 px-4 text-center mb-6">
                                        <p class="text-sm font-semibold text-slate-400">
                                            Yahh, kamu belum ada progres apa pun, yuk mulai dari sekarang!
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <a href="{{ url('/explore') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-bold rounded-xl bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-300 hover:scale-[1.03]">
                                            Eksplor &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </section>

                        <!-- Quick Access Section -->
                        <section class="animate-fade-in-up" style="animation-delay: 200ms;">
                            <h2 class="text-xl font-bold text-slate-900 mb-5 title-font flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                                Quick Access
                            </h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Library Card -->
                                <a href="{{ url('/explore') }}" class="group bg-white border border-slate-200/80 rounded-2xl p-5 flex items-center gap-4 hover:border-blue-400 hover:shadow-[0_8px_24px_-4px_rgba(59,130,246,0.08)] transition-all duration-300 hover:-translate-y-0.5 cursor-pointer">
                                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors duration-300">Library</h4>
                                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Lihat semua modul yang tersedia</p>
                                    </div>
                                </a>

                                <!-- Activity Card -->
                                <div class="group bg-white border border-slate-200/80 rounded-2xl p-5 flex items-center gap-4 hover:border-blue-400 hover:shadow-[0_8px_24px_-4px_rgba(59,130,246,0.08)] transition-all duration-300 hover:-translate-y-0.5 cursor-pointer">
                                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2zm9-4h2a2 2 0 002-2V9a2 2 0 00-2-2h-2a2 2 0 00-2 2v6a2 2 0 002 2zm-4 4h4a2 2 0 002-2v-6a2 2 0 00-2-2h-4a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors duration-300">Activity</h4>
                                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Lacak riwayat pembelajaran Anda</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6 lg:pt-0">
                        
                        <!-- Your Progress Card -->
                        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.04)] hover:shadow-md transition-all duration-300 animate-fade-in-up" style="animation-delay: 250ms;">
                            <h3 class="text-lg font-extrabold text-slate-900 mb-6 title-font flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                                YOUR PROGRESS
                            </h3>
                            
                            <div class="space-y-5">
                                @if($activePath)
                                    <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                                        <span class="text-sm font-medium text-slate-500">Completed Lessons</span>
                                        <span class="text-sm font-extrabold text-slate-800 bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100">{{ $activePath['lessons'] }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-slate-500">Quiz Average</span>
                                        <span class="text-sm font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">{{ $activePath['quiz'] }}</span>
                                    </div>
                                @else
                                    <div class="border border-slate-200 bg-slate-50/10 rounded-2xl py-6 px-4 text-center">
                                        <span class="text-sm font-semibold text-slate-400">belum ada progres</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                                        <span class="text-sm font-medium text-slate-500">Quiz Average</span>
                                        <span class="text-xs font-extrabold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-100">0%</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Marked Modules Card -->
                        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.04)] hover:shadow-md transition-all duration-300 animate-fade-in-up" style="animation-delay: 300ms;">
                            <h3 class="text-lg font-extrabold text-slate-900 title-font flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                                MARKED
                            </h3>
                            <p class="text-xs font-semibold text-slate-400 mt-1 uppercase tracking-wider mb-6">Lanjutkan yang sudah kamu tandai</p>
                            
                            <div class="space-y-4 max-h-[350px] overflow-y-auto pr-1">
                                @forelse($markedModules as $mod)
                                    @php
                                        $url = '#';
                                        if ($mod->path) {
                                            switch($mod->path->slug) {
                                                case 'frontend': $url = route('path.detail.frontend'); break;
                                                case 'backend': $url = route('path.detail.backend'); break;
                                                case 'uiux': $url = route('path.detail.uiux'); break;
                                                case 'fullstack': $url = route('path.detail.fullstack'); break;
                                                case 'project-manager': $url = route('path.detail.pm'); break;
                                                default: $url = route('path.detail.dynamic', $mod->path->slug); break;
                                            }
                                            $url .= '?open_module_id=' . $mod->id;
                                        }
                                    @endphp
                                    <a href="{{ $url }}" class="flex items-center gap-4 p-3 bg-blue-50/20 border border-slate-100 hover:border-blue-200 rounded-xl hover:bg-blue-50 transition-all duration-300 group block">
                                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white flex-shrink-0 shadow-md group-hover:scale-105 transition-transform">
                                            <span class="text-xs font-black font-mono">{{ $mod->icon }}</span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-sm font-extrabold text-slate-900 truncate group-hover:text-blue-600 transition-colors">{{ $mod->title }}</h4>
                                            <p class="text-xs text-slate-400 mt-0.5 truncate">{{ $mod->path->title ?? 'Learning Path' }}</p>
                                        </div>
                                        <div class="text-[#0050d2] opacity-0 group-hover:opacity-100 transition-opacity">
                                            &rarr;
                                        </div>
                                    </a>
                                @empty
                                    <div class="border border-dashed border-slate-200 rounded-2xl py-8 px-4 text-center">
                                        <p class="text-xs font-semibold text-slate-400">Belum ada modul yang ditandai</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-slate-50 py-8 mt-auto relative z-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm text-slate-500 font-medium">&copy; 2026 Path Deck</p>
        </div>
    </footer>

    <!-- Background Drift Script and Emitter -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const particleContainer = document.getElementById('particle-container');
            const emojis = ['💻', '🚀', '🎓', '🧠', '☕', '⚡', '✨', '⭐', '👾', '📚', '🔥'];
            
            for (let i = 0; i < 15; i++) {
                const item = document.createElement('div');
                item.className = 'absolute select-none cursor-pointer transition-all duration-500 hover:scale-150 hover:rotate-[360deg] active:scale-95 text-xl opacity-[0.08] hover:opacity-75 filter drop-shadow-sm pointer-events-auto';
                item.innerText = emojis[Math.floor(Math.random() * emojis.length)];
                
                item.style.left = `${Math.random() * 92 + 4}%`;
                item.style.top = `${Math.random() * 80 + 10}%`;
                
                const animName = `float-dash-${i}`;
                const keyframes = `
                    @keyframes ${animName} {
                        0%, 100% { transform: translateY(0px) rotate(0deg); }
                        50% { transform: translateY(${Math.random() * -35 - 15}px) rotate(${Math.random() * 20 - 10}deg); }
                    }
                `;
                
                const styleSheet = document.createElement('style');
                styleSheet.innerText = keyframes;
                document.head.appendChild(styleSheet);
                
                item.style.animation = `${animName} ${Math.random() * 6 + 7}s ease-in-out infinite`;
                particleContainer.appendChild(item);
                
                item.addEventListener('click', () => {
                    item.style.transform = 'scale(2.2) rotate(720deg)';
                    item.style.opacity = '1';
                    setTimeout(() => {
                        item.style.transform = '';
                        item.style.opacity = '0.08';
                    }, 1000);
                });
            }

            // --- Interactive IT/Code-Themed Emitter Trail ---
            const body = document.body;
            const trailSymbols = ['{}', '</>', '[]', '()', '=>', '10', '01', 'js', 'php', 'py', 'git', 'sql', 'sys'];
            
            body.addEventListener('mousemove', (e) => {
                if (Math.random() > 0.22) return;
                
                const sparkle = document.createElement('div');
                sparkle.innerText = trailSymbols[Math.floor(Math.random() * trailSymbols.length)];
                sparkle.className = 'absolute font-mono font-black select-none pointer-events-none text-blue-600/90 drop-shadow-[0_0_6px_rgba(37,99,235,0.6)] z-[9999]';
                sparkle.style.left = `${e.pageX}px`;
                sparkle.style.top = `${e.pageY}px`;
                sparkle.style.fontSize = `${Math.random() * 10 + 11}px`;
                sparkle.style.transition = 'transform 1s cubic-bezier(0.1, 0.8, 0.3, 1), opacity 1.5s ease-out';
                
                sparkle.style.transform = 'translate(-50%, -50%) scale(0.4)';
                sparkle.style.opacity = '1';
                
                body.appendChild(sparkle);
                
                setTimeout(() => {
                    const travelX = (Math.random() - 0.5) * 120;
                    const travelY = -80 - Math.random() * 60;
                    const rotate = Math.random() * 360 + 180;
                    sparkle.style.transform = `translate(calc(-50% + ${travelX}px), calc(-50% + ${travelY}px)) scale(0) rotate(${rotate}deg)`;
                    sparkle.style.opacity = '0';
                }, 50);
                
                setTimeout(() => {
                    sparkle.remove();
                }, 1550);
            });

            // --- Typing Animation for Tagline ---
            const phrases = [
                "Pantau progres belajar dan asah terus keahlian IT kamu di Path Deck.",
                "Tingkatkan skill kamu dan gapai karir impian sekarang juga.",
                "Jelajahi berbagai pilihan learning path terstruktur dan interaktif.",
                "Belajar teknologi terbaru kapan saja dan di mana saja sesukamu.",
                "Asah potensi dirimu dan jadilah developer handal masa depan."
            ];
            
            const typingTextSpan = document.getElementById('typing-text');
            
            let phraseIndex = 0;
            let charIndex = phrases[0].length;
            let isDeleting = true;
            let typingSpeed = 60;
            let erasingSpeed = 30;
            let delayBetweenPhrases = 3000;
            
            function typeEffect() {
                if (!typingTextSpan) return;
                const currentPhrase = phrases[phraseIndex];
                
                if (isDeleting) {
                    typingTextSpan.textContent = currentPhrase.substring(0, charIndex - 1) || "\u200B";
                    charIndex--;
                    typingSpeed = erasingSpeed;
                } else {
                    typingTextSpan.textContent = currentPhrase.substring(0, charIndex + 1);
                    charIndex++;
                    typingSpeed = 60;
                }
                
                if (!isDeleting && charIndex === currentPhrase.length) {
                    isDeleting = true;
                    setTimeout(typeEffect, delayBetweenPhrases);
                    return;
                }
                
                if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    phraseIndex = (phraseIndex + 1) % phrases.length;
                    setTimeout(typeEffect, 400);
                    return;
                }
                
                setTimeout(typeEffect, typingSpeed);
            }
            
            setTimeout(typeEffect, delayBetweenPhrases);
        });
    </script>
</body>
</html>
