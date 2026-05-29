<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Path Deck</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased text-slate-800 bg-white">

    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600 tracking-tight">
                        Path Deck
                    </a>
                </div>
                
                <!-- Right: Nav Links & Icons -->
                <div class="hidden sm:flex items-center space-x-8">
                    <div class="flex space-x-8 h-full">
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-blue-600 text-sm font-medium text-slate-900">
                            Dashboard
                        </a>
                        <a href="{{ route('explore.path') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-slate-500 hover:text-slate-700 hover:border-slate-300">
                            Explore path
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="h-6 w-px bg-slate-300"></div>
                        <button type="button" class="text-blue-600 hover:text-blue-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>
                        
                        <!-- Logout / Profile Button -->
                        <div class="relative">
                            <form method="POST" action="{{ route('logout') }}" title="Logout">
                                @csrf
                                <button type="submit" class="text-blue-600 hover:text-white hover:bg-blue-600 flex items-center justify-center h-8 w-8 rounded-full border border-blue-600 bg-white transition-colors">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Header Section -->
        <header class="mb-10">
            <h1 class="text-[32px] font-bold text-slate-900 tracking-tight">Welcome Back, {{ $userName ?? 'Student' }}!</h1>
        </header>

        <!-- Progress Logic -->
        <div class="">
            @if(isset($progressCount) && $progressCount > 0)
                <!-- State: Progress Exists -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column (Span 2) -->
                    <div class="lg:col-span-2 space-y-10">
                        
                        <!-- Continue Learning Section -->
                        <section>
                            <h2 class="text-2xl font-bold text-slate-900 mb-4">Continue Learning</h2>
                            
                            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm flex flex-col md:flex-row gap-6 relative">
                                <!-- Badge absolute positioned top right -->
                                <div class="absolute top-6 right-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-600">
                                        30% Complete
                                    </span>
                                </div>

                                <!-- Course Image -->
                                <div class="w-full md:w-48 h-32 rounded-lg overflow-hidden flex-shrink-0 bg-slate-100">
                                    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=400&h=300&fit=crop" alt="Course Thumbnail" class="w-full h-full object-cover">
                                </div>
                                
                                <!-- Course Info -->
                                <div class="flex-grow flex flex-col justify-center">
                                    <h3 class="text-xl font-bold text-slate-900 mb-6 pr-24">Front End Developer</h3>
                                    
                                    <!-- Progress Bar -->
                                    <div class="w-full bg-slate-100 rounded-full h-2 mb-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 30%"></div>
                                    </div>
                                    <p class="text-[13px] text-slate-500 mb-4">Modul 1 : Dasar-dasar HTML</p>
                                    
                                    <div>
                                        <button class="inline-flex items-center justify-center px-5 py-2 border border-transparent text-sm font-medium rounded bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                            Continue &rarr;
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Quick Access Section -->
                        <section>
                            <h2 class="text-2xl font-bold text-slate-900 mb-4">Quick Access</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Library Card -->
                                <div class="bg-white border border-slate-200 rounded-lg p-5 flex items-center gap-4 hover:border-blue-300 hover:shadow-sm transition-all cursor-pointer">
                                    <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[15px] font-bold text-slate-900">Library</h4>
                                        <p class="text-[13px] text-slate-500 mt-0.5">Lihat semua modul yang tersedia</p>
                                    </div>
                                </div>

                                <!-- Activity Card -->
                                <div class="bg-white border border-slate-200 rounded-lg p-5 flex items-center gap-4 hover:border-blue-300 hover:shadow-sm transition-all cursor-pointer">
                                    <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[15px] font-bold text-slate-900">Activity</h4>
                                        <p class="text-[13px] text-slate-500 mt-0.5">Lacak riwayat pembelajaran Anda</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6 pt-10 lg:pt-0">
                        
                        <!-- Your Progress Card -->
                        <div class="bg-white border border-slate-200 rounded-lg p-6">
                            <h3 class="text-[17px] font-bold text-slate-900 mb-6">Your Progress</h3>
                            
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-[15px] text-slate-600">Completed Lessons</span>
                                    <span class="text-[15px] font-bold text-slate-700">12/45</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[15px] text-slate-600">Quiz Average</span>
                                    <span class="text-[15px] font-bold text-slate-700">92%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Upcoming Event Card -->
                        <div class="bg-white border border-slate-200 rounded-lg p-6">
                            <h3 class="text-[17px] font-bold text-slate-900 mb-1">Upcoming Event</h3>
                            <p class="text-[14px] text-slate-600 mb-6">Completed Lessons</p> <!-- Replicating exactly from the image text -->
                            
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-[14px] font-bold text-slate-900">Live Coding</h4>
                                    <p class="text-[12px] text-slate-500 mt-0.5">14:00 PM &bull; Zoom Meeting</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            @else
                <!-- State: Blank State -->
                <div class="text-center py-20 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-300">
                    <p class="text-slate-600 italic">"Yah, kamu belum mengerjakan apa-apa, ayo mulai pilih bidangmu dan seberapa mahir kamu"</p>
                    <a href="{{ url('/explore') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Mulai Eksplorasi</a>
                </div>
            @endif
        </div>

    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-slate-50 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm text-slate-500">@ 2026 Path Deck</p>
        </div>
    </footer>

</body>
</html>
