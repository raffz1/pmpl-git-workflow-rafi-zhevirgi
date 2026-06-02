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
        @php $isAdmin = auth()->check() && auth()->user()->isAdmin(); @endphp

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
                <div class="max-w-7xl mb-12 sm:mb-16 animate-fade-in-up flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6" style="animation-delay: 50ms;">
                    <div class="max-w-4xl">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight tracking-tight mb-4">
                            Explore Your Path
                        </h1>
                        <p class="text-base sm:text-lg text-slate-500 leading-relaxed font-normal">
                            Pilih jalur pembelajaran khusus yang dirancang untuk mencapai tingkat kemahiran sesuai standar industri. <br class="hidden sm:inline">Setiap jalur merupakan program terstruktur yang dirancang untuk mencapai penguasaan yang mendalam.
                        </p>
                    </div>
                    @if($isAdmin)
                    <div class="shrink-0 self-start sm:self-center flex items-center gap-3">
                        <!-- Add Path Button -->
                        <button id="admin-add-path-btn" onclick="openAddPathModal()" class="hidden flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-blue-600 hover:bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 bg-white transition-all duration-200 cursor-pointer shadow-sm active:scale-95">
                            ➕ Tambah Path Baru
                        </button>

                        <button id="edit-mode-toggle-btn" onclick="toggleEditMode()" class="flex items-center gap-2 text-xs font-bold text-slate-600 border border-slate-200 rounded-xl px-4 py-2.5 bg-white transition-all duration-200 cursor-pointer shadow-sm hover:bg-slate-50">
                            <span class="w-2 h-2 rounded-full bg-slate-400 transition-colors duration-300" id="edit-mode-indicator"></span>
                            <span>Edit Mode: <strong id="edit-mode-text">OFF</strong></span>
                        </button>
                    </div>
                    @endif
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
                        <a href="{{ auth()->check() ? route('path.detail.dynamic', $path['slug']) : route('login') }}" class="group relative rounded-2xl border border-slate-200 bg-white overflow-hidden flex flex-col card-transition card-tilt shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] {{ $glowClass }} animate-fade-in-up cursor-pointer hover:no-underline hover:border-transparent z-10" style="animation-delay: {{ ($index + 1) * 100 }}ms;">
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

                                @if($isAdmin)
                                    <!-- Edit Path Button Overlay -->
                                    <button type="button" onclick="event.preventDefault(); event.stopPropagation(); openEditPathModal({{ json_encode($path) }})" class="admin-edit-path-btn hidden absolute top-4 right-4 z-30 w-10 h-10 rounded-xl bg-white/90 hover:bg-white text-slate-800 flex items-center justify-center shadow-lg transition-transform hover:scale-105 border border-slate-200 cursor-pointer" title="Edit Path Card">
                                        <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                @endif
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

        @if($isAdmin)
        <!-- Edit Path Modal -->
        <div id="edit-path-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
            <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl border border-slate-100 transition-transform duration-300 scale-95 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="text-xl font-bold text-slate-900 title-font flex items-center gap-2">
                        <span class="w-2.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                        Edit Path Card: <span id="modal-path-title-display"></span>
                    </h3>
                    <button type="button" onclick="closeEditPathModal()" class="w-8 h-8 rounded-full hover:bg-slate-200 text-slate-400 hover:text-slate-600 flex items-center justify-center transition-colors border-0 bg-transparent cursor-pointer text-sm">
                        ✕
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <form id="edit-path-form" onsubmit="submitEditPath(event)" class="flex-grow overflow-y-auto p-8 space-y-6">
                    @csrf
                    <input type="hidden" id="edit-path-id" name="id">

                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Path</label>
                        <input type="text" id="edit-path-title" name="title" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                    </div>

                    <!-- Image URL -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Image URL</label>
                        <input type="text" id="edit-path-image" name="image" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Short Description</label>
                        <textarea id="edit-path-description" name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm"></textarea>
                    </div>

                    <!-- Career Description -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Detailed Career Description</label>
                        <textarea id="edit-path-career_description" name="career_description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm"></textarea>
                    </div>

                    <!-- Two columns: theme & salary -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Theme -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tema Warna</label>
                            <select id="edit-path-theme" name="theme" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm bg-white">
                                <option value="cyan">Cyan (Front End)</option>
                                <option value="green">Green (Back End)</option>
                                <option value="pink">Pink (UI/UX)</option>
                                <option value="orange">Orange (Full Stack)</option>
                                <option value="yellow">Yellow (Project Manager)</option>
                            </select>
                        </div>

                        <!-- Salary Range -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Salary Range</label>
                            <input type="text" id="edit-path-salary" name="salary_range" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                        </div>
                    </div>

                    <!-- Skills -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Skills (Comma-separated)</label>
                        <input type="text" id="edit-path-skills" placeholder="e.g. HTML, CSS, React" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                    </div>

                    <!-- Suitability criteria -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kriteria Kecocokan (Enter-separated)</label>
                        <textarea id="edit-path-suitability" rows="3" placeholder="Satu baris untuk satu kriteria..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm"></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                        <button type="button" onclick="deleteCurrentPath()" class="px-6 py-3 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 font-bold rounded-2xl text-sm transition-all cursor-pointer">
                            🗑️ Hapus Path
                        </button>
                        <div class="flex gap-3">
                            <button type="button" onclick="closeEditPathModal()" class="px-6 py-3 border border-slate-200 bg-transparent hover:bg-slate-50 text-slate-500 font-bold rounded-2xl text-sm transition-colors cursor-pointer">
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

        <!-- Add Path Modal -->
        <div id="add-path-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
            <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl border border-slate-100 transition-transform duration-300 scale-95 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="text-xl font-bold text-slate-900 title-font flex items-center gap-2">
                        <span class="w-2.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                        Tambah Path Karir Baru
                    </h3>
                    <button type="button" onclick="closeAddPathModal()" class="w-8 h-8 rounded-full hover:bg-slate-200 text-slate-400 hover:text-slate-600 flex items-center justify-center transition-colors border-0 bg-transparent cursor-pointer text-sm">
                        ✕
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <form id="add-path-form" onsubmit="submitAddPath(event)" class="flex-grow overflow-y-auto p-8 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Path</label>
                            <input type="text" id="add-path-title" name="title" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm" placeholder="e.g. DevOps Engineer">
                        </div>

                        <!-- Slug -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Slug URL (Unique)</label>
                            <input type="text" id="add-path-slug" name="slug" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm" placeholder="e.g. devops">
                        </div>
                    </div>

                    <!-- Image URL -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Image URL</label>
                        <input type="text" id="add-path-image" name="image" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm" placeholder="e.g. https://images.unsplash.com/photo-...">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Short Description</label>
                        <textarea id="add-path-description" name="description" required rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm" placeholder="Kuasai cara mengotomatisasi pipeline integrasi..."></textarea>
                    </div>

                    <!-- Career Description -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Detailed Career Description</label>
                        <textarea id="add-path-career_description" name="career_description" required rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm" placeholder="DevOps Engineer bertanggung jawab untuk..."></textarea>
                    </div>

                    <!-- Two columns: theme & salary -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Theme -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tema Warna</label>
                            <select id="add-path-theme" name="theme" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm bg-white">
                                <option value="cyan">Cyan (Front End theme)</option>
                                <option value="green">Green (Back End theme)</option>
                                <option value="pink">Pink (UI/UX theme)</option>
                                <option value="orange">Orange (Full Stack theme)</option>
                                <option value="yellow">Yellow (Project Manager theme)</option>
                            </select>
                        </div>

                        <!-- Salary Range -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Salary Range</label>
                            <input type="text" id="add-path-salary" name="salary_range" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm" placeholder="e.g. Rp 8.000.000 - Rp 20.000.000">
                        </div>
                    </div>

                    <!-- Skills -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Skills (Comma-separated)</label>
                        <input type="text" id="add-path-skills" required placeholder="e.g. Docker, Kubernetes, CI/CD" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm">
                    </div>

                    <!-- Suitability criteria -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kriteria Kecocokan (Enter-separated)</label>
                        <textarea id="add-path-suitability" required rows="3" placeholder="Satu baris untuk satu kriteria..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 font-medium text-slate-800 text-sm"></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" onclick="closeAddPathModal()" class="px-6 py-3 border border-slate-200 bg-transparent hover:bg-slate-50 text-slate-500 font-bold rounded-2xl text-sm transition-colors cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 border-0 text-white font-bold rounded-2xl text-sm transition-all shadow-md shadow-blue-500/10 cursor-pointer">
                            Tambah Path
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const editModal = document.getElementById('edit-path-modal');
                const editForm = document.getElementById('edit-path-form');

                let editModeActive = false;
                window.toggleEditMode = function() {
                    editModeActive = !editModeActive;
                    const toggleBtn = document.getElementById('edit-mode-toggle-btn');
                    const indicator = document.getElementById('edit-mode-indicator');
                    const text = document.getElementById('edit-mode-text');
                    const editPathBtns = document.querySelectorAll('.admin-edit-path-btn');

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

                        editPathBtns.forEach(btn => btn.classList.remove('hidden'));
                        const addPathBtn = document.getElementById('admin-add-path-btn');
                        if (addPathBtn) addPathBtn.classList.remove('hidden');
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

                        editPathBtns.forEach(btn => btn.classList.add('hidden'));
                        const addPathBtn = document.getElementById('admin-add-path-btn');
                        if (addPathBtn) addPathBtn.classList.add('hidden');
                    }
                };

                window.openEditPathModal = function(path) {
                    document.getElementById('edit-path-id').value = path.id;
                    document.getElementById('edit-path-title').value = path.title;
                    document.getElementById('modal-path-title-display').innerText = path.title;
                    document.getElementById('edit-path-image').value = path.image;
                    document.getElementById('edit-path-description').value = path.description;
                    document.getElementById('edit-path-career_description').value = path.career_description || '';
                    document.getElementById('edit-path-theme').value = path.theme;
                    document.getElementById('edit-path-salary').value = path.salary_range;

                    // Skills array to comma string
                    const skillsStr = Array.isArray(path.skills) ? path.skills.join(', ') : '';
                    document.getElementById('edit-path-skills').value = skillsStr;

                    // Suitability array to enter-separated string
                    const suitabilityStr = Array.isArray(path.suitability) ? path.suitability.join('\n') : '';
                    document.getElementById('edit-path-suitability').value = suitabilityStr;

                    // Open modal
                    editModal.classList.remove('hidden');
                    editModal.classList.add('flex');
                    setTimeout(() => {
                        editModal.classList.add('opacity-100');
                        editModal.querySelector('div').classList.remove('scale-95');
                        editModal.querySelector('div').classList.add('scale-100');
                    }, 50);
                    document.body.classList.add('overflow-hidden');
                };

                window.closeEditPathModal = function() {
                    editModal.classList.remove('opacity-100');
                    editModal.querySelector('div').classList.remove('scale-100');
                    editModal.querySelector('div').classList.add('scale-95');
                    setTimeout(() => {
                        editModal.classList.remove('flex');
                        editModal.classList.add('hidden');
                    }, 300);
                    document.body.classList.remove('overflow-hidden');
                };

                window.submitEditPath = function(e) {
                    e.preventDefault();
                    const pathId = document.getElementById('edit-path-id').value;
                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    // Split skills
                    const skillsVal = document.getElementById('edit-path-skills').value
                        .split(',')
                        .map(s => s.trim())
                        .filter(s => s.length > 0);

                    // Split suitability
                    const suitabilityVal = document.getElementById('edit-path-suitability').value
                        .split('\n')
                        .map(s => s.trim())
                        .filter(s => s.length > 0);

                    const data = {
                        title: document.getElementById('edit-path-title').value,
                        image: document.getElementById('edit-path-image').value,
                        description: document.getElementById('edit-path-description').value,
                        career_description: document.getElementById('edit-path-career_description').value,
                        theme: document.getElementById('edit-path-theme').value,
                        salary_range: document.getElementById('edit-path-salary').value,
                        skills: skillsVal,
                        suitability: suitabilityVal
                    };

                    fetch(`/admin/path/${pathId}/update`, {
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

                window.deleteCurrentPath = function() {
                    const pathId = document.getElementById('edit-path-id').value;
                    const pathTitle = document.getElementById('modal-path-title-display').innerText;
                    
                    if (!confirm(`Apakah Anda yakin ingin menghapus path "${pathTitle}" beserta seluruh modul dan kuis di dalamnya? Tindakan ini tidak dapat dibatalkan.`)) {
                        return;
                    }
                    
                    const csrfToken = document.querySelector('input[name="_token"]').value;
                    
                    fetch(`/admin/path/${pathId}/delete`, {
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
                            alert('Gagal menghapus path: ' + JSON.stringify(resData.errors || resData.message));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan jaringan.');
                    });
                };

                const addModal = document.getElementById('add-path-modal');

                window.openAddPathModal = function() {
                    document.getElementById('add-path-form').reset();
                    addModal.classList.remove('hidden');
                    addModal.classList.add('flex');
                    setTimeout(() => {
                        addModal.classList.add('opacity-100');
                        addModal.querySelector('div').classList.remove('scale-95');
                        addModal.querySelector('div').classList.add('scale-100');
                    }, 50);
                    document.body.classList.add('overflow-hidden');
                };

                window.closeAddPathModal = function() {
                    addModal.classList.remove('opacity-100');
                    addModal.querySelector('div').classList.remove('scale-100');
                    addModal.querySelector('div').classList.add('scale-95');
                    setTimeout(() => {
                        addModal.classList.remove('flex');
                        addModal.classList.add('hidden');
                    }, 300);
                    document.body.classList.remove('overflow-hidden');
                };

                window.submitAddPath = function(e) {
                    e.preventDefault();
                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    const data = {
                        title: document.getElementById('add-path-title').value,
                        slug: document.getElementById('add-path-slug').value,
                        image: document.getElementById('add-path-image').value,
                        description: document.getElementById('add-path-description').value,
                        career_description: document.getElementById('add-path-career_description').value,
                        theme: document.getElementById('add-path-theme').value,
                        salary_range: document.getElementById('add-path-salary').value,
                        skills: document.getElementById('add-path-skills').value,
                        suitability: document.getElementById('add-path-suitability').value
                    };

                    fetch('/admin/path/store', {
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
                            alert('Gagal membuat path: ' + JSON.stringify(resData.errors || resData.message));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan jaringan.');
                    });
                };
            });
        </script>
        @endif
    </body>
</html>
