<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Path Deck</title>
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
<body class="min-h-screen flex flex-col antialiased text-slate-800">

    <!-- Top Navigation Bar -->
    @include('layouts.navbar')

    <!-- Main Content: Centered Card -->
    <main class="flex-grow flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-[420px] bg-white border border-slate-200 rounded-sm shadow-sm p-8">
            
            <!-- Headers -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-slate-900 mb-1">Login</h1>
                <p class="text-[13px] text-slate-500">Welcome back to your learning path.</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ url('/login') }}" class="space-y-5">
                @csrf

                @if($errors->any())
                    <div class="p-3 bg-red-50 text-red-600 text-sm rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-[11px] font-bold text-slate-900 uppercase tracking-wide mb-1.5">
                        Email
                    </label>
                    <input type="email" id="email" name="email" required autofocus
                        class="block w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-colors outline-none"
                    >
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-[11px] font-bold text-slate-900 uppercase tracking-wide">
                            Password
                        </label>
                        <a href="#" class="text-[12px] text-blue-600 hover:text-blue-500 hover:underline transition-colors">
                            Lupa Password?
                        </a>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="block w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-colors outline-none"
                    >
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Login
                    </button>
                </div>
            </form>

            <!-- Bottom Link -->
            <div class="mt-8 text-center">
                <p class="text-[13px] text-slate-800">
                    Apakah Sudah Daftar Akun? 
                    <a href="{{ url('/register') }}" class="text-blue-600 font-medium hover:underline transition-colors">
                        Register
                    </a>
                </p>
            </div>
            
        </div>
    </main>

    <!-- Page Footer -->
    <footer class="py-6 border-t border-slate-200 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-[13px] text-slate-500 font-medium">
                &copy; 2026 Path Deck
            </p>
        </div>
    </footer>

</body>
</html>
