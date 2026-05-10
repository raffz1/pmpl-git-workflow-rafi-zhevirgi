<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Path Deck</title>
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
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center h-14 items-center">
                <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600 tracking-tight hover:text-blue-700 transition-colors">
                    Path Deck
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content: Centered Card -->
    <main class="flex-grow flex items-center justify-center p-4 py-12">
        <div class="w-full max-w-[420px] bg-white border border-slate-200 rounded-sm shadow-sm p-8">
            
            <!-- Headers -->
            <div class="text-center mb-8">
                <h1 class="text-[15px] font-bold text-slate-900 mb-1">Create Account</h1>
                <p class="text-[13px] text-slate-500">Start your learning journey today.</p>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="#" class="space-y-5">
                @csrf
                
                <!-- Nama Field -->
                <div>
                    <label for="name" class="block text-[11px] font-medium text-slate-800 uppercase tracking-wide mb-1.5">
                        Nama
                    </label>
                    <input type="text" id="name" name="name" required autofocus
                        class="block w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-colors outline-none"
                    >
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-[11px] font-medium text-slate-800 uppercase tracking-wide mb-1.5">
                        Email
                    </label>
                    <input type="email" id="email" name="email" required
                        class="block w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-colors outline-none"
                    >
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-[11px] font-medium text-slate-800 uppercase tracking-wide mb-1.5">
                        Password
                    </label>
                    <input type="password" id="password" name="password" required
                        class="block w-full px-3 py-2 bg-slate-50/50 border border-slate-200 rounded text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600 focus:bg-white transition-colors outline-none"
                    >
                </div>

                <!-- Checkbox -->
                <div class="flex items-start pt-1">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required
                            class="w-3.5 h-3.5 text-blue-600 bg-slate-50 border-slate-300 rounded-sm focus:ring-blue-500"
                        >
                    </div>
                    <div class="ml-2.5 text-[13px]">
                        <label for="terms" class="text-slate-600">
                            I agree to the 
                            <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> 
                            and 
                            <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>.
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-1">
                    <button type="submit" 
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Register
                    </button>
                </div>
            </form>

            <!-- Bottom Link -->
            <div class="mt-8 text-center">
                <p class="text-[13px] text-slate-800">
                    Apakah Sudah Punya Akun? 
                    <a href="{{ url('/login') }}" class="text-blue-600 font-medium hover:underline transition-colors">
                        Login
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
