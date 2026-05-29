<!-- Floating Glassmorphic Navbar -->
<nav id="main-navbar" class="sticky top-4 z-50 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8 transition-all duration-500 ease-out" style="transform: translateY(0); opacity: 1;">
    <div id="navbar-container" class="bg-white border border-slate-200/40 rounded-2xl shadow-lg shadow-slate-100/40 transition-all duration-500 ease-out">
        <div id="navbar-inner" class="flex justify-between items-center h-16 px-6 transition-all duration-500 ease-out">
            <!-- Left: Logo with Hover Animation -->
            <div class="shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="group text-xl sm:text-2xl font-bold tracking-tight bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center gap-2 transition-transform duration-300 hover:scale-105">
                    <svg class="h-6 w-6 text-blue-600 group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-8-4-8 4v10l8 4 8-4V7z" />
                    </svg>
                    <span>Path Deck</span>
                </a>
            </div>
            
            <!-- Middle: Nav Links (Hidden on mobile) with Sliding Hover Underline -->
            <div class="hidden md:flex space-x-8 h-full items-center">
                <a href="{{ url('/dashboard') }}" class="relative font-semibold text-sm transition-colors py-2 group {{ Request::is('dashboard') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                    Dashboard
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 transition-all duration-300 {{ Request::is('dashboard') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                <a href="{{ route('explore.path') }}" class="relative font-semibold text-sm transition-colors py-2 group {{ Request::is('explore') || Request::is('explore/*') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                    Explore path
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 transition-all duration-300 {{ Request::is('explore') || Request::is('explore/*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                @auth
                <a href="{{ route('profile.show') }}" class="relative font-semibold text-sm transition-colors py-2 group {{ Request::is('profile') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                    Profile
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 transition-all duration-300 {{ Request::is('profile') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                @endauth
            </div>

            <!-- Right: Actions with Premium Hover States -->
            <div class="flex items-center space-x-4">
                @auth
                    <div class="h-6 w-px bg-slate-200"></div>
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 group">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ auth()->user()->profile_photo }}" class="h-8 w-8 rounded-full border border-blue-200 group-hover:border-blue-500 transition-all object-cover">
                        @else
                            <div class="h-8 w-8 rounded-full border border-blue-200 group-hover:border-blue-500 transition-all bg-blue-50/80 flex items-center justify-center text-blue-600 font-extrabold text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-xs font-semibold text-slate-500 group-hover:text-blue-600 transition-colors uppercase tracking-wider hidden sm:inline">Hi, {{ auth()->user()->name ?? 'User' }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" title="Logout">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:text-white hover:bg-blue-600 flex items-center justify-center h-9 w-9 rounded-xl border border-blue-200 hover:border-transparent bg-blue-50/50 transition-all duration-300 hover:scale-105" title="Logout">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                @else
                    <div class="h-6 w-px bg-slate-200"></div>
                    <a href="{{ url('/login') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors py-2">Login</a>
                    <a href="{{ url('/register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-xl shadow-md shadow-blue-500/10 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/20">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let lastScrollTop = 0;
        const navbar = document.getElementById('main-navbar');
        const navContainer = document.getElementById('navbar-container');
        const navInner = document.getElementById('navbar-inner');

        window.addEventListener('scroll', () => {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // 1. Shrink/Expand height and padding based on scroll offset
            if (scrollTop > 40) {
                // Scrolled: compact state (solid light-grey bg)
                navbar.style.top = '8px';
                navInner.style.height = '48px';
                navContainer.classList.add('shadow-md', 'bg-slate-50', 'border-slate-200/80');
                navContainer.classList.remove('shadow-lg', 'bg-white', 'border-slate-200/40');
            } else {
                // Top: normal state (solid white bg)
                navbar.style.top = '16px';
                navInner.style.height = '64px';
                navContainer.classList.add('shadow-lg', 'bg-white', 'border-slate-200/40');
                navContainer.classList.remove('shadow-md', 'bg-slate-50', 'border-slate-200/80');
            }

            // 2. Slide translation hide/show based on scroll direction (only if scrolled down past 150px)
            if (scrollTop > 150) {
                if (scrollTop > lastScrollTop) {
                    // Scroll Down: shrink and translate slightly up, but DO NOT hide completely
                    navbar.style.transform = 'translateY(-12px)';
                    navbar.style.opacity = '0.9';
                } else {
                    // Scroll Up: slide back down and show fully
                    navbar.style.transform = 'translateY(0)';
                    navbar.style.opacity = '1';
                }
            } else {
                navbar.style.transform = 'translateY(0)';
                navbar.style.opacity = '1';
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    });
</script>
