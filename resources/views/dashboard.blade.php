<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
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
<body class="h-full flex antialiased text-slate-800">

    <!-- Sidebar -->
    <aside class="hidden md:flex flex-col w-64 bg-white border-r border-slate-200 h-screen fixed">
        <div class="h-16 flex items-center px-6 border-b border-slate-200">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600 tracking-tight hover:text-blue-700 transition-colors">
                Path Deck
            </a>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 bg-blue-50 text-blue-700 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-50 hover:text-slate-900 rounded-lg font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Explore Paths
            </a>
        </nav>
        
        <div class="p-4 border-t border-slate-200">
            <form method="POST" action="#">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-red-50 hover:text-red-600 rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Header -->
    <div class="md:hidden fixed top-0 w-full h-16 bg-white border-b border-slate-200 z-50 flex items-center justify-between px-4">
        <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">Path Deck</a>
        <div class="flex gap-4">
            <a href="#" class="text-slate-600 font-medium">Explore</a>
            <a href="#" class="text-slate-600 font-medium text-red-600">Logout</a>
        </div>
    </div>

    <!-- Main Content Area -->
    <main class="flex-1 md:ml-64 min-h-screen pt-16 md:pt-0 p-6 lg:p-10">
        
        <!-- Header Section -->
        <header class="mb-10 mt-4 md:mt-0">
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Halo, {{ $userName ?? 'Student' }}! 👋</h1>
            <p class="text-slate-600 text-lg">Selamat datang kembali, ayo lanjutkan perjalanan belajarmu.</p>
        </header>

        <!-- Progress Logic -->
        <div class="mt-8">
            @if($progressCount > 0)
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <h3 class="font-bold">UI/UX Design</h3>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-4">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                    </div>
                    <p class="text-sm mt-2 text-gray-500">45% Selesai</p>
                </div>
            @else
                <div class="text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed">
                    <p class="text-gray-600 italic">"Yah, kamu belum mengerjakan apa-apa, ayo mulai pilih bidangmu dan seberapa mahir kamu"</p>
                    <a href="/explore" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg">Mulai Eksplorasi</a>
                </div>
            @endif
        </div>

    </main>

</body>
</html>
