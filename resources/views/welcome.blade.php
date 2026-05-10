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
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <style>
            body { 
                font-family: 'Inter', sans-serif; 
            }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

        <!-- Navigation Bar -->
        <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Left: Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="/" class="text-xl sm:text-2xl font-bold text-blue-600 tracking-tight">Path Deck</a>
                    </div>
                    
                    <!-- Middle: Nav Links (Hidden on mobile) -->
                    <div class="hidden md:flex space-x-8">
                        <a href="#" class="text-slate-900 inline-flex items-center px-1 pt-1 border-b-2 border-blue-600 font-medium text-sm transition-colors">Dashboard</a>
                        <a href="#" class="text-slate-500 hover:text-slate-900 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-slate-300 font-medium text-sm transition-colors">Explore path</a>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center space-x-3 sm:space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ url('/login') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition-colors">Login</a>
                            <a href="{{ url('/register') }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="grow">
            <!-- Hero Section -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Left: Text content -->
                    <div class="max-w-xl">
                        <p class="text-xs sm:text-sm font-bold tracking-widest text-blue-600 uppercase mb-4">Start Your Career</p>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6 tracking-tight">
                            Path Deck
                        </h1>
                        <p class="text-base sm:text-lg text-slate-600 mb-8 leading-relaxed">
                            Temukan dan kembangkan minat Anda di bidang teknologi melalui jalur pembelajaran terstruktur. Kuasai alat-alat yang sesuai standar industri dan bangun portofolio profesional.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ url('/register') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm sm:text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-md hover:shadow-lg transition-all">
                                Register Now
                            </a>
                            <a href="{{ url('/login') }}" class="inline-flex justify-center items-center px-6 py-3 border border-slate-300 text-sm sm:text-base font-medium rounded-lg text-blue-600 bg-white hover:bg-slate-50 shadow-sm transition-all">
                                Login &rarr;
                            </a>
                        </div>
                    </div>
                    
                    <!-- Right: Image -->
                    <div class="relative w-full h-72 sm:h-96 lg:h-[480px] rounded-2xl overflow-hidden shadow-2xl group">
                        <!-- Unsplash placeholder related to PC / gaming / tech setup -->
                        <img src="https://images.unsplash.com/photo-1598550476439-6847785fcea6?q=80&w=2070&auto=format&fit=crop" alt="PC Gaming Setup" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-linear-to-t from-slate-900/30 to-transparent"></div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="bg-white py-16 lg:py-24 border-t border-slate-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <h2 class="text-3xl font-bold text-slate-900 sm:text-4xl mb-4 tracking-tight">Why Path Deck?</h2>
                        <p class="text-base sm:text-lg text-slate-600 px-4">
                            Path Deck membantu siswa menemukan arah karier IT secara terarah melalui pembelajaran interaktif dan bertahap.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Card 1 -->
                        <div class="bg-white rounded-2xl p-8 shadow-[0_4px_24px_-8px_rgba(0,0,0,0.1)] border border-slate-50 hover:-translate-y-1 transition-transform duration-300">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-6 border border-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Struktur Flow</h3>
                            <p class="text-slate-600 leading-relaxed text-sm">
                                Modul langkah demi langkah yang dirancang oleh para ahli di bidangnya untuk membawa Anda dari pemula menjadi ahli.
                            </p>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-white rounded-2xl p-8 shadow-[0_4px_24px_-8px_rgba(0,0,0,0.1)] border border-slate-50 hover:-translate-y-1 transition-transform duration-300">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-6 border border-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Skill Validation</h3>
                            <p class="text-slate-600 leading-relaxed text-sm">
                                Proyek-proyek nyata dan kuis yang menguji pengetahuan Anda serta membantu Anda membangun portofolio yang dapat diverifikasi.
                            </p>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-white rounded-2xl p-8 shadow-[0_4px_24px_-8px_rgba(0,0,0,0.1)] border border-slate-50 hover:-translate-y-1 transition-transform duration-300">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-6 border border-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Career Focused</h3>
                            <p class="text-slate-600 leading-relaxed text-sm">
                                Produk kami terus diperbarui agar tetap sesuai dengan permintaan pasar terkini dan perkembangan teknologi.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Banner -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
                <div class="bg-linear-to-br from-blue-500 to-blue-700 rounded-3xl shadow-xl overflow-hidden relative">
                    <!-- Decorative subtle elements -->
                    <div class="absolute top-0 right-0 -mr-12 -mt-12 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 -ml-12 -mb-12 w-80 h-80 rounded-full bg-white opacity-10 blur-3xl pointer-events-none"></div>
                    
                    <div class="relative px-6 py-12 sm:px-12 sm:py-20 lg:py-24 text-center">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white mb-4 tracking-tight">
                            Ready to find your path?
                        </h2>
                        <p class="mt-4 text-base sm:text-lg leading-6 text-blue-100 max-w-2xl mx-auto mb-8 sm:mb-10 px-4">
                            Bergabunglah dengan ribuan pelajar yang telah mengubah rasa ingin tahu mereka menjadi karier di bidang teknologi.
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <a href="{{ url('/register') }}" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 border border-transparent text-sm sm:text-base font-medium rounded-lg text-blue-700 bg-white hover:bg-slate-50 shadow-md transition-colors">
                                Get Started
                            </a>
                            <a href="#" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 border-2 border-white/40 text-sm sm:text-base font-medium rounded-lg text-white hover:bg-white/10 hover:border-white transition-colors">
                                View Paths
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-slate-50 border-t border-slate-200 mt-auto">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
                <p class="text-sm text-slate-500 font-medium">
                    &copy; 2026 Path Deck
                </p>
            </div>
        </footer>
    </body>
</html>
