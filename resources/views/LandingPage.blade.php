<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Path Deck - Start Your Career</title>
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

        /* 3D Tilt Effect */
        .card-tilt {
            transform-style: preserve-3d;
            perspective: 1000px;
        }
        .card-tilt * {
            transform-style: preserve-3d;
        }
        .card-image-lift {
            transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .card-tilt:hover .card-image-lift {
            transform: translateZ(30px) scale(1.04);
        }

        /* Feature Cards Tilt Container */
        .feature-card-tilt {
            transform-style: preserve-3d;
            perspective: 1000px;
            transition: box-shadow 0.3s ease;
        }
        .feature-card-tilt * {
            transform-style: preserve-3d;
        }
        .card-content-lift {
            transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);
            transform: translateZ(0px);
        }
        .feature-card-tilt:hover .card-content-lift {
            transform: translateZ(40px);
        }

        /* Float & Orb Animations */
        @keyframes float-blob {
            0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
            33% { transform: translateY(-30px) scale(1.08) rotate(3deg); }
            66% { transform: translateY(25px) scale(0.92) rotate(-3deg); }
        }
        .animate-float-blob {
            animation: float-blob 12s ease-in-out infinite;
        }

        @keyframes drift-particle {
            0% { transform: translateY(0) translateX(0) rotate(0deg); opacity: 0; }
            10% { opacity: 0.18; }
            90% { opacity: 0.18; }
            100% { transform: translateY(-120px) translateX(40px) rotate(360deg); opacity: 0; }
        }
        .particle {
            position: absolute;
            font-family: monospace;
            font-size: 14px;
            pointer-events: none;
            opacity: 0;
            animation: drift-particle 15s linear infinite;
        }

        /* Reveal on scroll */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), 
                        transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gradient-to-b from-white via-blue-50/15 to-white text-slate-800 antialiased min-h-screen flex flex-col overflow-x-hidden relative">

    <!-- Moving Background Animations & Faded Blue Grid -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <!-- Floating Faded Blobs -->
        <div class="absolute top-[8%] left-[-8%] w-[500px] h-[500px] rounded-full bg-blue-300/10 blur-3xl animate-float-blob" style="animation-duration: 9s;"></div>
        <div class="absolute top-[35%] right-[-12%] w-[550px] h-[550px] rounded-full bg-indigo-300/10 blur-3xl animate-float-blob" style="animation-delay: -3s; animation-duration: 12s;"></div>
        <div class="absolute bottom-[20%] left-[-5%] w-[450px] h-[450px] rounded-full bg-cyan-300/10 blur-3xl animate-float-blob" style="animation-delay: -6s; animation-duration: 8s;"></div>
        <div class="absolute bottom-[5%] right-[5%] w-[400px] h-[400px] rounded-full bg-blue-200/10 blur-3xl animate-float-blob" style="animation-delay: -9s; animation-duration: 10s;"></div>

        <!-- Faded Geometric Pattern Grid in Soft Blue Color -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f6_1px,transparent_1px),linear-gradient(to_bottom,#3b82f6_1px,transparent_1px)] bg-[size:5rem_5rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_80%,transparent_100%)] opacity-[0.06]"></div>

        <!-- Drifting Tech Particles (Spawned by JS) -->
        <div id="particle-container" class="absolute inset-0"></div>
    </div>

    <!-- Reusable Smart Sticky Glassmorphism Navbar -->
    @include('layouts.navbar')

    <!-- Main Content -->
    <main class="grow relative z-10">
        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
                <!-- Left: Text content -->
                <div class="max-w-xl reveal active">
                    <p class="text-xs sm:text-sm font-bold tracking-widest text-blue-600 uppercase mb-4 title-font">Start Your Career</p>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6 tracking-tight title-font">
                        @auth
                            Welcome, {{ auth()->user()->name }}!
                        @else
                            Path Deck
                        @endauth
                    </h1>
                    <p class="text-base sm:text-lg text-slate-600 mb-8 leading-relaxed">
                        Temukan dan kembangkan minat Anda di bidang teknologi melalui jalur pembelajaran terstruktur. Kuasai alat-alat yang sesuai standar industri dan bangun portofolio profesional.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center px-6 py-3.5 border border-transparent text-sm sm:text-base font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 hover:scale-[1.03]">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ url('/register') }}" class="inline-flex justify-center items-center px-6 py-3.5 border border-transparent text-sm sm:text-base font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/20 hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 hover:scale-[1.03]">
                                Register Now
                            </a>
                        @endauth
                        <a href="{{ route('explore.path') }}" class="inline-flex justify-center items-center px-6 py-3.5 border border-slate-200 text-sm sm:text-base font-bold rounded-xl text-blue-600 bg-white hover:bg-slate-50 shadow-sm transition-all duration-300 hover:scale-[1.03]">
                            View Paths &rarr;
                        </a>
                    </div>
                </div>
                
                <!-- Right: Interactive 3D Image Card -->
                <div class="relative w-full h-80 sm:h-96 lg:h-[450px] rounded-2xl overflow-hidden shadow-2xl card-tilt reveal active cursor-pointer" style="transition-delay: 200ms;">
                    <img src="{{ asset('images/fotodashboard.png') }}" alt="PC Gaming Setup" class="absolute inset-0 w-full h-full object-cover card-image-lift transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent z-10"></div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 lg:py-28 bg-gradient-to-b from-blue-600 via-blue-500/85 to-white border-y border-slate-200/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-4 tracking-tight title-font">Why Path Deck?</h2>
                    <p class="text-base sm:text-lg text-blue-100">
                        Path Deck membantu siswa menemukan arah karier IT secara terarah melalui pembelajaran interaktif dan bertahap.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature Card 1 -->
                    <div class="group bg-white rounded-2xl p-8 shadow-md border border-slate-100 hover:border-blue-500/20 feature-card-tilt card-transition reveal cursor-pointer" style="transition-delay: 100ms;">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-6 border border-blue-100/50 group-hover:scale-110 transition-transform duration-300 card-content-lift">
                            <img src="{{ asset('images/FlowIcon.svg') }}" alt="Flow Icon" class="w-6 h-6">
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 title-font card-content-lift">Struktur Flow</h3>
                        <p class="text-slate-500 leading-relaxed text-sm card-content-lift">
                            Modul langkah demi langkah yang dirancang oleh para ahli di bidangnya untuk membawa Anda dari pemula menjadi ahli.
                        </p>
                    </div>

                    <!-- Feature Card 2 -->
                    <div class="group bg-white rounded-2xl p-8 shadow-md border border-slate-100 hover:border-emerald-500/20 feature-card-tilt card-transition reveal cursor-pointer" style="transition-delay: 200ms;">
                        <div class="w-12 h-12 bg-emerald-50/50 rounded-xl flex items-center justify-center mb-6 border border-emerald-100/50 group-hover:scale-110 transition-transform duration-300 card-content-lift">
                            <img src="{{ asset('images/SkillIcon.svg') }}" alt="Skill Icon" class="w-6 h-6">
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 title-font card-content-lift">Skill Validation</h3>
                        <p class="text-slate-500 leading-relaxed text-sm card-content-lift">
                            Proyek-proyek nyata dan kuis yang menguji pengetahuan Anda serta membantu Anda membangun portofolio yang dapat diverifikasi.
                        </p>
                    </div>

                    <!-- Feature Card 3 -->
                    <div class="group bg-white rounded-2xl p-8 shadow-md border border-slate-100 hover:border-indigo-500/20 feature-card-tilt card-transition reveal cursor-pointer" style="transition-delay: 300ms;">
                        <div class="w-12 h-12 bg-indigo-50/50 rounded-xl flex items-center justify-center mb-6 border border-indigo-100/50 group-hover:scale-110 transition-transform duration-300 card-content-lift">
                            <img src="{{ asset('images/CareerIcon.svg') }}" alt="Career Icon" class="w-6 h-6">
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 title-font card-content-lift">Career Focused</h3>
                        <p class="text-slate-500 leading-relaxed text-sm card-content-lift">
                            Produk kami terus diperbarui agar tetap sesuai dengan permintaan pasar terkini dan perkembangan teknologi.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Banner -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20 reveal">
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-3xl shadow-xl shadow-blue-500/10 overflow-hidden relative border border-blue-400/20">
                <!-- Glowing Ambient Gradients Inside Banner -->
                <div class="absolute top-0 right-0 -mr-12 -mt-12 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl pointer-events-none animate-pulse" style="animation-duration: 6s;"></div>
                <div class="absolute bottom-0 left-0 -ml-12 -mb-12 w-80 h-80 rounded-full bg-white opacity-10 blur-3xl pointer-events-none animate-pulse" style="animation-duration: 8s;"></div>
                
                <div class="relative px-6 py-16 sm:px-12 sm:py-20 lg:py-24 text-center">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4 tracking-tight title-font">
                        Ready to find your path?
                    </h2>
                    <p class="mt-4 text-base sm:text-lg leading-6 text-blue-50 max-w-2xl mx-auto mb-8 sm:mb-10 px-4">
                        Bergabunglah dengan ribuan pelajar yang telah mengubah rasa ingin tahu mereka menjadi karier di bidang teknologi.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ url('/register') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-sm sm:text-base font-bold rounded-xl text-blue-700 bg-white hover:bg-slate-50 shadow-md hover:shadow-lg transition-all duration-300 hover:scale-[1.03]">
                            Get Started
                        </a>
                        <a href="{{ route('explore.path') }}" class="inline-flex items-center justify-center px-8 py-3.5 border-2 border-white/30 text-sm sm:text-base font-bold rounded-xl text-white hover:bg-white/10 hover:border-white transition-all duration-300 hover:scale-[1.03]">
                            View Paths
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-50 border-t border-slate-200 mt-auto relative z-10">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
            <p class="text-sm text-slate-500 font-medium">
                &copy; 2026 Path Deck
            </p>
        </div>
    </footer>

    <!-- Interactive Javascript for 3D Tilt, Particle Spawning, and Scroll Reveal -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- 3D Tilt Effect for Hero Image ---
            const heroTilts = document.querySelectorAll('.card-tilt');
            heroTilts.forEach(card => {
                let current = { rotateX: 0, rotateY: 0, scale: 1 };
                let target = { rotateX: 0, rotateY: 0, scale: 1 };
                let animFrameId = null;

                function updateCard() {
                    const lerpFactor = 0.12;
                    current.rotateX += (target.rotateX - current.rotateX) * lerpFactor;
                    current.rotateY += (target.rotateY - current.rotateY) * lerpFactor;
                    current.scale += (target.scale - current.scale) * lerpFactor;

                    card.style.transform = `perspective(1000px) rotateX(${current.rotateX}deg) rotateY(${current.rotateY}deg) scale3d(${current.scale}, ${current.scale}, 1)`;
                    
                    if (Math.abs(current.rotateX - target.rotateX) < 0.01 && 
                        Math.abs(current.rotateY - target.rotateY) < 0.01 && 
                        Math.abs(current.scale - target.scale) < 0.01) {
                        animFrameId = null;
                    } else {
                        animFrameId = requestAnimationFrame(updateCard);
                    }
                }

                card.addEventListener('mousemove', e => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const width = rect.width;
                    const height = rect.height;

                    const xc = (x / width) - 0.5;
                    const yc = (y / height) - 0.5;
                    const maxRotate = 8; // Max tilt rotation

                    target.rotateY = xc * maxRotate;
                    target.rotateX = -yc * maxRotate;
                    target.scale = 1.02;

                    if (!animFrameId) {
                        animFrameId = requestAnimationFrame(updateCard);
                    }
                });

                card.addEventListener('mouseleave', () => {
                    target.rotateX = 0;
                    target.rotateY = 0;
                    target.scale = 1.0;

                    if (!animFrameId) {
                        animFrameId = requestAnimationFrame(updateCard);
                    }
                });
            });

            // --- Feature Cards Wobbly Tilt Physics (Wiggle follow cursor) ---
            const featureTilts = document.querySelectorAll('.feature-card-tilt');
            featureTilts.forEach(card => {
                let current = { rotateX: 0, rotateY: 0, translateX: 0, translateY: 0, scale: 1 };
                let target = { rotateX: 0, rotateY: 0, translateX: 0, translateY: 0, scale: 1 };
                let animFrameId = null;

                function updateCard() {
                    const lerpFactor = 0.08; // Slower lerp for a wobbly/springy organic feel!
                    current.rotateX += (target.rotateX - current.rotateX) * lerpFactor;
                    current.rotateY += (target.rotateY - current.rotateY) * lerpFactor;
                    current.translateX += (target.translateX - current.translateX) * lerpFactor;
                    current.translateY += (target.translateY - current.translateY) * lerpFactor;
                    current.scale += (target.scale - current.scale) * lerpFactor;

                    card.style.transform = `perspective(1000px) rotateX(${current.rotateX}deg) rotateY(${current.rotateY}deg) translate3d(${current.translateX}px, ${current.translateY}px, 0) scale3d(${current.scale}, ${current.scale}, 1)`;
                    
                    if (Math.abs(current.rotateX - target.rotateX) < 0.01 && 
                        Math.abs(current.rotateY - target.rotateY) < 0.01 && 
                        Math.abs(current.translateX - target.translateX) < 0.01 && 
                        Math.abs(current.translateY - target.translateY) < 0.01 && 
                        Math.abs(current.scale - target.scale) < 0.01) {
                        animFrameId = null;
                    } else {
                        animFrameId = requestAnimationFrame(updateCard);
                    }
                }

                card.addEventListener('mousemove', e => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const width = rect.width;
                    const height = rect.height;

                    const xc = (x / width) - 0.5;
                    const yc = (y / height) - 0.5;
                    
                    // Pronounced wobbly rotation and translation
                    const maxRotate = 15; // Max degrees
                    const maxTranslate = 10; // Max px shift

                    target.rotateY = xc * maxRotate;
                    target.rotateX = -yc * maxRotate;
                    target.translateX = xc * maxTranslate;
                    target.translateY = yc * maxTranslate;
                    target.scale = 1.04;

                    // Also change shadow dynamically for extra realism!
                    card.style.boxShadow = `${-xc * 15}px ${-yc * 15}px 25px rgba(37, 99, 235, 0.12)`;

                    if (!animFrameId) {
                        animFrameId = requestAnimationFrame(updateCard);
                    }
                });

                card.addEventListener('mouseleave', () => {
                    target.rotateX = 0;
                    target.rotateY = 0;
                    target.translateX = 0;
                    target.translateY = 0;
                    target.scale = 1.0;
                    card.style.boxShadow = '';

                    if (!animFrameId) {
                        animFrameId = requestAnimationFrame(updateCard);
                    }
                });
            });

            // --- Scroll Reveal Animation ---
            const revealElements = document.querySelectorAll('.reveal');
            const revealOnScroll = () => {
                const windowHeight = window.innerHeight;
                revealElements.forEach(el => {
                    const elementTop = el.getBoundingClientRect().top;
                    const elementVisible = 100; // Trigger distance in px
                    if (elementTop < windowHeight - elementVisible) {
                        el.classList.add('active');
                    }
                });
            };
            window.addEventListener('scroll', revealOnScroll);
            revealOnScroll(); // Trigger initial check

            // --- Interactive Floating Background Emojis ---
            const particleContainer = document.getElementById('particle-container');
            const emojis = ['💻', '🚀', '🎓', '🧠', '☕', '🎮', '⚡', '🧩', '✨', '⭐', '👾', '🐱', '📚', '🎨', '🔥'];
            
            for (let i = 0; i < 22; i++) {
                const item = document.createElement('div');
                item.className = 'absolute select-none cursor-pointer transition-all duration-500 hover:scale-150 hover:rotate-[360deg] active:scale-95 text-xl opacity-20 hover:opacity-85 filter drop-shadow-sm pointer-events-auto';
                item.innerText = emojis[Math.floor(Math.random() * emojis.length)];
                
                // Random starting position
                item.style.left = `${Math.random() * 92 + 4}%`;
                item.style.top = `${Math.random() * 85 + 5}%`;
                
                // Custom floating animation for each emoji
                const animName = `float-custom-${i}`;
                const keyframes = `
                    @keyframes ${animName} {
                        0%, 100% { transform: translateY(0px) rotate(0deg); }
                        50% { transform: translateY(${Math.random() * -40 - 20}px) rotate(${Math.random() * 30 - 15}deg); }
                    }
                `;
                
                const styleSheet = document.createElement('style');
                styleSheet.innerText = keyframes;
                document.head.appendChild(styleSheet);
                
                item.style.animation = `${animName} ${Math.random() * 8 + 6}s ease-in-out infinite`;
                particleContainer.appendChild(item);
                
                // Click reaction
                item.addEventListener('click', () => {
                    item.style.transform = 'scale(2.2) rotate(720deg)';
                    item.style.opacity = '1';
                    setTimeout(() => {
                        item.style.transform = '';
                        item.style.opacity = '0.2';
                    }, 1000);
                });
            }

            // --- Interactive IT/Code-Themed Emitter Trail ---
            const body = document.body;
            const trailSymbols = ['{}', '</>', '[]', '()', '=>', '10', '01', 'js', 'php', 'py', 'git', 'sql', 'sys', 'cmd', 'git'];
            
            body.addEventListener('mousemove', (e) => {
                if (Math.random() > 0.20) return; // Throttle to prevent lagging
                
                const sparkle = document.createElement('div');
                sparkle.innerText = trailSymbols[Math.floor(Math.random() * trailSymbols.length)];
                sparkle.className = 'absolute font-mono font-black select-none pointer-events-none text-blue-600/90 drop-shadow-[0_0_6px_rgba(37,99,235,0.6)] z-[9999]';
                sparkle.style.left = `${e.pageX}px`;
                sparkle.style.top = `${e.pageY}px`;
                sparkle.style.fontSize = `${Math.random() * 10 + 11}px`;
                sparkle.style.transition = 'transform 1s cubic-bezier(0.1, 0.8, 0.3, 1), opacity 1.5s ease-out';
                
                // Start slightly offset and scale down
                sparkle.style.transform = 'translate(-50%, -50%) scale(0.4)';
                sparkle.style.opacity = '1';
                
                body.appendChild(sparkle);
                
                // Animate upwards and outwards
                setTimeout(() => {
                    const travelX = (Math.random() - 0.5) * 130;
                    const travelY = -90 - Math.random() * 70;
                    const rotate = Math.random() * 360 + 180;
                    sparkle.style.transform = `translate(calc(-50% + ${travelX}px), calc(-50% + ${travelY}px)) scale(0) rotate(${rotate}deg)`;
                    sparkle.style.opacity = '0';
                }, 50);
                
                // Remove from DOM
                setTimeout(() => {
                    sparkle.remove();
                }, 1550);
            });
        });
    </script>
</body>
</html>
