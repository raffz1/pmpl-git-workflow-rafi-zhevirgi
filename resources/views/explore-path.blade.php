<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Explore Career Paths - Path Deck</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Modern Google Fonts -->
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

            /* Custom Transition for Spring Effect */
            .card-transition {
                transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1), 
                            box-shadow 0.5s cubic-bezier(0.25, 1, 0.5, 1), 
                            border-color 0.5s ease;
            }

            /* Custom Colored Soft Shadows for Light Theme */
            .glow-cyan:hover {
                box-shadow: 0 20px 30px -10px rgba(6, 182, 212, 0.2);
                border-color: #06b6d4;
            }
            .glow-green:hover {
                box-shadow: 0 20px 30px -10px rgba(34, 197, 94, 0.2);
                border-color: #22c55e;
            }
            .glow-pink:hover {
                box-shadow: 0 20px 30px -10px rgba(236, 72, 153, 0.2);
                border-color: #ec4899;
            }
            .glow-orange:hover {
                box-shadow: 0 20px 30px -10px rgba(249, 115, 22, 0.2);
                border-color: #f97316;
            }
            .glow-yellow:hover {
                box-shadow: 0 20px 30px -10px rgba(234, 179, 8, 0.2);
                border-color: #eab308;
            }

            /* 3D Parallax Card Effects */
            .card-tilt {
                transform-style: preserve-3d;
                perspective: 1000px;
            }
            
            .card-tilt * {
                transform-style: preserve-3d;
            }

            /* Child elements default transitions */
            .card-image-container,
            .card-icon-container,
            .card-title,
            .card-description,
            .card-cta-container {
                transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
                transform: translateZ(0px);
            }

            /* 3D Layers translation on hover */
            .card-tilt:hover .card-image-container {
                transform: translateZ(25px);
            }
            .card-tilt:hover .card-icon-container {
                transform: translateZ(45px) rotate(6deg) scale(1.1);
            }
            .card-tilt:hover .card-title {
                transform: translateZ(35px);
            }
            .card-tilt:hover .card-description {
                transform: translateZ(15px);
            }
            .card-tilt:hover .card-cta-container {
                transform: translateZ(30px);
            }

            /* Ambient Animations */
            @keyframes float-blob {
                0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
                33% { transform: translateY(-20px) scale(1.08) rotate(3deg); }
                66% { transform: translateY(15px) scale(0.92) rotate(-3deg); }
            }
            .animate-float-blob {
                animation: float-blob 10s ease-in-out infinite;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .animate-fade-in-up {
                animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                opacity: 0;
            }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col overflow-x-hidden">

        <!-- Top Navigation Bar -->
        @include('layouts.navbar')

        <!-- Main Wrapper with Soft Background & Floating Animations -->
        <div class="relative flex-grow min-h-screen bg-gradient-to-b from-white via-blue-50/20 to-white py-16 px-4 overflow-hidden">
            <!-- Geometric Grid Pattern Overlay -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f60a_1px,transparent_1px),linear-gradient(to_bottom,#3b82f60a_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] pointer-events-none"></div>

            <!-- Soft Floating Ambient Blobs -->
            <div class="absolute top-[10%] left-[-5%] w-96 h-96 rounded-full bg-cyan-200/15 blur-3xl pointer-events-none animate-float-blob"></div>
            <div class="absolute top-[40%] right-[-5%] w-[450px] h-[450px] rounded-full bg-pink-200/15 blur-3xl pointer-events-none animate-float-blob" style="animation-delay: -3s; animation-duration: 12s;"></div>
            <div class="absolute bottom-[10%] left-[10%] w-80 h-80 rounded-full bg-indigo-200/15 blur-3xl pointer-events-none animate-float-blob" style="animation-delay: -6s; animation-duration: 10s;"></div>

            <!-- Drifting Emojis and Symbols Container -->
            <div id="particle-container" class="absolute inset-0 overflow-hidden pointer-events-none z-0"></div>

            <!-- Light Abstract Floating Geometric SVGs -->
            <div class="absolute top-24 left-[15%] pointer-events-none opacity-30 animate-pulse" style="animation-duration: 4s;">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" class="text-blue-500" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            </div>
            <div class="absolute top-[40%] right-[15%] pointer-events-none opacity-30 animate-spin" style="animation-duration: 20s;">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" class="text-indigo-400" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-dasharray="4 4"/></svg>
            </div>
            <div class="absolute bottom-40 left-[8%] pointer-events-none opacity-20 animate-bounce" style="animation-duration: 6s;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" class="text-pink-400" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4"/></svg>
            </div>

            <!-- Content Container -->
            <div class="max-w-7xl mx-auto relative z-10">
                
                <!-- Hero Section -->
                <div class="max-w-4xl mb-12 sm:mb-16 animate-fade-in-up" style="animation-delay: 50ms;">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight tracking-tight mb-4">
                        Explore Your Path
                    </h1>
                    <p class="text-base sm:text-lg text-slate-500 leading-relaxed font-normal">
                        Pilih jalur pembelajaran khusus yang dirancang untuk mencapai tingkat kemahiran sesuai standar industri. <br class="hidden sm:inline">Setiap jalur merupakan program terstruktur yang dirancang untuk mencapai penguasaan yang mendalam.
                    </p>
                </div>

                <!-- Career Cards Grid Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20 items-stretch">
                    @foreach($paths as $index => $path)
                        @php
                            $glowClass = '';
                            $accentBarColor = '';
                            $gradientClasses = '';
                            switch($path['theme']) {
                                case 'cyan':
                                    $glowClass = 'glow-cyan';
                                    $accentBarColor = 'bg-cyan-500';
                                    $gradientClasses = 'from-blue-400 to-blue-700'; // Front End: biru muda & biru tua
                                    break;
                                case 'green':
                                    $glowClass = 'glow-green';
                                    $accentBarColor = 'bg-green-500';
                                    $gradientClasses = 'from-blue-600 to-emerald-600'; // Back End: biru & hijau
                                    break;
                                case 'pink':
                                    $glowClass = 'glow-pink';
                                    $accentBarColor = 'bg-pink-500';
                                    $gradientClasses = 'from-blue-600 to-pink-500'; // UI/UX: biru & pink
                                    break;
                                case 'orange':
                                    $glowClass = 'glow-orange';
                                    $accentBarColor = 'bg-orange-500';
                                    $gradientClasses = 'from-blue-600 to-orange-500'; // Full Stack: biru & orange
                                    break;
                                case 'yellow':
                                    $glowClass = 'glow-yellow';
                                    $accentBarColor = 'bg-yellow-500';
                                    $gradientClasses = 'from-blue-600 to-yellow-500'; // PM: biru & kuning
                                    break;
                            }
                        @endphp

                        <!-- Interactive Career Card (Wrapped in click link) -->
                        <a href="{{ $path['slug'] === 'frontend' ? route('path.detail.frontend') : ($path['slug'] === 'backend' ? route('path.detail.backend') : ($path['slug'] === 'fullstack' ? route('path.detail.fullstack') : ($path['slug'] === 'project-manager' ? route('path.detail.pm') : ($path['slug'] === 'uiux' ? route('path.detail.uiux') : (auth()->check() ? route('explore.enroll', $path['id']) : url('/login')))))) }}" class="group relative rounded-2xl border border-slate-200 bg-white overflow-hidden flex flex-col card-transition card-tilt shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] {{ $glowClass }} animate-fade-in-up cursor-pointer hover:no-underline hover:border-transparent z-10" style="animation-delay: {{ ($index + 1) * 100 }}ms;">
                            <!-- Hover Gradient Background Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-br {{ $gradientClasses }} opacity-0 group-hover:opacity-100 transition-all duration-500 z-0"></div>

                            <!-- Dynamic Glass Glare Overlay -->
                            <div class="card-glare absolute inset-0 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20" style="background: radial-gradient(circle 250px at var(--x, 50%) var(--y, 50%), rgba(255,255,255,0.2) 0%, transparent 80%);"></div>

                            <!-- Card Image Header -->
                            <div class="card-image-container relative h-44 w-full overflow-hidden bg-slate-100 border-b border-slate-100 flex-shrink-0 z-10">
                                <img src="{{ $path['image'] }}" alt="{{ $path['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-50"></div>
                                
                                <!-- A subtle colored accent bar on top of card -->
                                <div class="absolute top-0 inset-x-0 h-1.5 transition-all duration-300 {{ $accentBarColor }}"></div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 sm:p-8 flex-grow flex flex-col justify-between relative z-10">
                                <div>
                                    <!-- Tech Icon Box -->
                                    <div class="mb-5">
                                        <div class="card-icon-container w-12 h-12 rounded-xl bg-blue-50 border border-blue-100/50 flex items-center justify-center text-blue-600 font-extrabold text-[13px] tracking-wider shadow-sm transition-all duration-300 group-hover:bg-white/20 group-hover:text-white group-hover:border-white/30">
                                            @if($path['icon'] === 'frontend')
                                                HTML
                                            @elseif($path['icon'] === 'backend')
                                                PHP
                                            @elseif($path['icon'] === 'uiux')
                                                <!-- Nib Icon -->
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            @elseif($path['icon'] === 'fullstack')
                                                <!-- Layers Icon -->
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 17l10 5 10-5M2 12l10 5 10-5M12 2L2 7l10 5 10-5-10-5z" />
                                                </svg>
                                            @elseif($path['icon'] === 'pm')
                                                <!-- Package Icon -->
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7.5 12 3 4 7.5M20 7.5v9L12 21M20 7.5 12 12M4 7.5v9L12 21M4 7.5 12 12M12 12v9" />
                                                </svg>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <h3 class="card-title title-font text-2xl font-bold text-slate-900 mb-3 group-hover:text-white transition-colors duration-300">
                                        {{ $path['title'] }}
                                    </h3>
                                    <p class="card-description text-slate-500 text-sm sm:text-base leading-relaxed group-hover:text-blue-50 transition-colors duration-300">
                                        {{ $path['description'] }}
                                    </p>
                                </div>
                                
                                <!-- Click Indicator at Bottom Right -->
                                <div class="card-cta-container mt-6 flex items-center justify-end text-blue-600 font-semibold text-sm opacity-0 group-hover:opacity-100 group-hover:text-white transition-all duration-300">
                                    <span>Mulai Belajar</span>
                                    <svg class="w-4 h-4 ml-1.5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>

        </div>

        <!-- Footer -->
        <footer class="border-t border-slate-200 bg-slate-50 py-8 mt-auto relative z-20">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-sm text-slate-500 font-medium">
                    &copy; 2026 Path Deck
                </p>
            </div>
        </footer>

        <!-- Javascript for 3D Interactive Tilt Effect -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const cards = document.querySelectorAll('.card-tilt');
                
                cards.forEach(card => {
                    // Current anim values
                    let current = {
                        rotateX: 0,
                        rotateY: 0,
                        translateY: 0,
                        shadowX: 0,
                        shadowY: 4,
                        glareX: 50,
                        glareY: 50,
                        glareOpacity: 0
                    };
                    
                    // Target anim values
                    let target = {
                        rotateX: 0,
                        rotateY: 0,
                        translateY: 0,
                        shadowX: 0,
                        shadowY: 4,
                        glareX: 50,
                        glareY: 50,
                        glareOpacity: 0
                    };
                    
                    let animFrameId = null;
                    let isHovered = false;
                    
                    // Detect path glow color
                    let glowColor = 'rgba(0, 0, 0, 0.05)';
                    if (card.classList.contains('glow-cyan')) {
                        glowColor = 'rgba(6, 182, 212, 0.25)';
                    } else if (card.classList.contains('glow-green')) {
                        glowColor = 'rgba(34, 197, 94, 0.25)';
                    } else if (card.classList.contains('glow-pink')) {
                        glowColor = 'rgba(236, 72, 153, 0.25)';
                    } else if (card.classList.contains('glow-orange')) {
                        glowColor = 'rgba(249, 115, 22, 0.25)';
                    } else if (card.classList.contains('glow-yellow')) {
                        glowColor = 'rgba(234, 179, 8, 0.25)';
                    }
                    
                    function updateCard() {
                        if (!isHovered && Math.abs(current.rotateX - target.rotateX) < 0.01 && Math.abs(current.rotateY - target.rotateY) < 0.01 && Math.abs(current.translateY - target.translateY) < 0.01) {
                            // Reset back to static and cancel loop
                            card.style.transform = '';
                            card.style.boxShadow = '';
                            const glare = card.querySelector('.card-glare');
                            if (glare) glare.style.opacity = '0';
                            animFrameId = null;
                            return;
                        }
                        
                        // Lerp calculations
                        const lerpFactor = 0.12; // lower is smoother/slower
                        current.rotateX += (target.rotateX - current.rotateX) * lerpFactor;
                        current.rotateY += (target.rotateY - current.rotateY) * lerpFactor;
                        current.translateY += (target.translateY - current.translateY) * lerpFactor;
                        current.shadowX += (target.shadowX - current.shadowX) * lerpFactor;
                        current.shadowY += (target.shadowY - current.shadowY) * lerpFactor;
                        current.glareX += (target.glareX - current.glareX) * lerpFactor;
                        current.glareY += (target.glareY - current.glareY) * lerpFactor;
                        current.glareOpacity += (target.glareOpacity - current.glareOpacity) * lerpFactor;
                        
                        // Apply transforms (we scale slightly when active)
                        const scale = isHovered ? 1.03 : 1.0;
                        card.style.transform = `perspective(1000px) translateY(${current.translateY}px) rotateX(${current.rotateX}deg) rotateY(${current.rotateY}deg) scale3d(${scale}, ${scale}, 1)`;
                        
                        // Apply shadow
                        if (isHovered || current.translateY < -0.5) {
                            card.style.boxShadow = `${current.shadowX}px ${current.shadowY}px 32px -8px ${glowColor}`;
                        } else {
                            card.style.boxShadow = '';
                        }
                        
                        // Apply glare
                        const glare = card.querySelector('.card-glare');
                        if (glare) {
                            glare.style.opacity = current.glareOpacity;
                            glare.style.setProperty('--x', `${current.glareX}px`);
                            glare.style.setProperty('--y', `${current.glareY}px`);
                        }
                        
                        animFrameId = requestAnimationFrame(updateCard);
                    }
                    
                    card.addEventListener('mouseenter', () => {
                        isHovered = true;
                        target.translateY = -15; // float up 15px
                        target.glareOpacity = 1;
                        if (!animFrameId) {
                            animFrameId = requestAnimationFrame(updateCard);
                        }
                    });
                    
                    card.addEventListener('mousemove', e => {
                        const rect = card.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        
                        const width = rect.width;
                        const height = rect.height;
                        
                        const xc = (x / width) - 0.5;
                        const yc = (y / height) - 0.5;
                        
                        const maxRotate = 10; // degrees
                        
                        target.rotateY = xc * maxRotate;
                        target.rotateX = -yc * maxRotate;
                        target.shadowX = -xc * 16;
                        target.shadowY = -yc * 16 + 20; // offsets shadow downward when card is lifted
                        
                        target.glareX = x;
                        target.glareY = y;
                    });
                    
                    card.addEventListener('mouseleave', () => {
                        isHovered = false;
                        target.rotateX = 0;
                        target.rotateY = 0;
                        target.translateY = 0;
                        target.shadowX = 0;
                        target.shadowY = 4;
                        target.glareOpacity = 0;
                    });
                });

                // --- Interactive Floating Background Emojis ---
                const particleContainer = document.getElementById('particle-container');
                const emojis = ['💻', '🚀', '🎓', '🧠', '☕', '🎮', '⚡', '🧩', '✨', '⭐', '👾', '🐱', '📚', '🎨', '🔥'];
                
                for (let i = 0; i < 18; i++) {
                    const item = document.createElement('div');
                    item.className = 'absolute select-none cursor-pointer transition-all duration-500 hover:scale-150 hover:rotate-[360deg] active:scale-95 text-xl opacity-[0.12] hover:opacity-80 filter drop-shadow-sm pointer-events-auto';
                    item.innerText = emojis[Math.floor(Math.random() * emojis.length)];
                    
                    item.style.left = `${Math.random() * 92 + 4}%`;
                    item.style.top = `${Math.random() * 85 + 5}%`;
                    
                    const animName = `float-explore-${i}`;
                    const keyframes = `
                        @keyframes ${animName} {
                            0%, 100% { transform: translateY(0px) rotate(0deg); }
                            50% { transform: translateY(${Math.random() * -45 - 15}px) rotate(${Math.random() * 26 - 13}deg); }
                        }
                    `;
                    
                    const styleSheet = document.createElement('style');
                    styleSheet.innerText = keyframes;
                    document.head.appendChild(styleSheet);
                    
                    item.style.animation = `${animName} ${Math.random() * 7 + 7}s ease-in-out infinite`;
                    particleContainer.appendChild(item);
                    
                    item.addEventListener('click', () => {
                        item.style.transform = 'scale(2.2) rotate(720deg)';
                        item.style.opacity = '1';
                        setTimeout(() => {
                            item.style.transform = '';
                            item.style.opacity = '0.12';
                        }, 1000);
                    });
                }

                // --- Interactive IT/Code-Themed Emitter Trail ---
                const body = document.body;
                const trailSymbols = ['{}', '</>', '[]', '()', '=>', '10', '01', 'js', 'php', 'py', 'git', 'sql', 'sys', 'cmd', 'git'];
                
                body.addEventListener('mousemove', (e) => {
                    if (Math.random() > 0.20) return;
                    
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
                        const travelX = (Math.random() - 0.5) * 130;
                        const travelY = -90 - Math.random() * 70;
                        const rotate = Math.random() * 360 + 180;
                        sparkle.style.transform = `translate(calc(-50% + ${travelX}px), calc(-50% + ${travelY}px)) scale(0) rotate(${rotate}deg)`;
                        sparkle.style.opacity = '0';
                    }, 50);
                    
                    setTimeout(() => {
                        sparkle.remove();
                    }, 1550);
                });
            });
        </script>
    </body>
</html>
