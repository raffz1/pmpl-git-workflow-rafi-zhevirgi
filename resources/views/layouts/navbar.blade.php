<!-- 
    integrasi tailwind css dengan logika tampilan
    - navbar didesain melayang (floating style) menggunakan utility kelas Tailwind CSS.
    - menggunakan border modern, sudut bulat (`rounded-[14px]`), efek bayangan (`shadow`), dan transisi halus (`transition-all`).
    - desain responsif secara bawaan (`hidden md:flex` untuk desktop, `md:hidden` untuk hamburger mobile menu).
-->
<nav id="main-navbar" class="sticky top-4 z-50 mx-auto w-full max-w-7xl px-4 transition-all duration-500 ease-out" style="transform: translateY(0); opacity: 1;">
    <div id="navbar-container" class="bg-white border border-slate-200 rounded-[14px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)] transition-all duration-500 ease-out relative">
        <div id="navbar-inner" class="flex justify-between items-center h-14 sm:h-16 px-4 sm:px-6 transition-all duration-500 ease-out">
            <!-- 
                LOGIKA WELCOME PAGE & KETERBATASAN AKSES
                - tautan logo: mengarahkan pengguna yang sudah login ke dashboard utama (`route('dashboard')`).
                - jika belum login (guest), logo akan mengarahkannya kembali ke welcome page (`url('/')`).
            -->
            <div class="shrink-0 flex items-center">
                <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="group text-xl sm:text-2xl font-bold tracking-tight bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center gap-2 transition-transform duration-300 hover:scale-105">
                    <svg class="h-6 w-6 text-blue-600 group-hover:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-8-4-8 4v10l8 4 8-4V7z" />
                    </svg>
                    <span>Path Deck</span>
                </a>
            </div>
            
            <!-- Middle: Nav Links (Visible on desktop, hidden on mobile) -->
            <div class="hidden md:flex space-x-8 h-full items-center">
                <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="relative font-bold text-sm transition-colors py-2 group {{ Request::is('dashboard') || (Request::is('/') && !auth()->check()) ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                    Dashboard
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 transition-all duration-300 {{ Request::is('dashboard') || (Request::is('/') && !auth()->check()) ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                <a href="{{ route('explore.path') }}" class="relative font-bold text-sm transition-colors py-2 group {{ Request::is('explore') || Request::is('explore/*') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                    Explore path
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 transition-all duration-300 {{ Request::is('explore') || Request::is('explore/*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                @auth
                <a href="{{ route('profile.show') }}" class="relative font-bold text-sm transition-colors py-2 group {{ Request::is('profile') ? 'text-blue-600' : 'text-slate-600 hover:text-blue-600' }}">
                    Profile
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 transition-all duration-300 {{ Request::is('profile') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                @endauth
            </div>
 
            <!-- Right: Actions (Visible on desktop, hidden on mobile) -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <!-- tampilan navigasi saat pengguna sudah terautentikasi (Menu logout dan profil) -->
                    <div class="h-6 w-px bg-slate-200"></div>
                    <a href="{{ route('profile.show') }}" class="flex items-center gap-2.5 group">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ auth()->user()->profile_photo }}" class="h-8 w-8 rounded-full border border-blue-200 group-hover:border-blue-500 transition-all object-cover">
                        @else
                            <div class="h-8 w-8 rounded-full border border-blue-200 group-hover:border-blue-500 transition-all bg-blue-50 flex items-center justify-center text-blue-600 font-extrabold text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-xs font-semibold text-slate-500 group-hover:text-blue-600 transition-colors uppercase tracking-wider">Hi, {{ explode(' ', auth()->user()->name)[0] }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:text-white hover:bg-blue-600 flex items-center justify-center h-9 w-9 rounded-xl border border-blue-200 hover:border-transparent bg-blue-50/50 transition-all duration-300 hover:scale-105 cursor-pointer" title="Logout">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                @else
                    <!-- tampilan navigasi saat pengguna belum login (tombol login & register) -->
                    <div class="h-6 w-px bg-slate-200"></div>
                    <a href="{{ url('/login') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors py-2">Login</a>
                    <a href="{{ url('/register') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-xl shadow-md shadow-blue-500/10 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/20">
                        Register
                    </a>
                @endauth
            </div>

            <!-- Hamburger Button (Visible on mobile only) -->
            <div class="flex items-center md:hidden">
                <button id="mobile-menu-toggle" type="button" class="text-slate-600 hover:text-blue-600 focus:outline-none p-1.5 rounded-lg border border-slate-200 bg-slate-50 transition-all cursor-pointer">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-dropdown-menu" class="hidden absolute top-[calc(100%+8px)] left-0 right-0 bg-white border border-slate-200 rounded-2xl shadow-xl p-4 flex flex-col gap-3 z-50 transition-all duration-300 origin-top transform scale-95 opacity-0">
            <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-all {{ Request::is('dashboard') || (Request::is('/') && !auth()->check()) ? 'bg-blue-50/50 text-blue-600' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('explore.path') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-all {{ Request::is('explore') || Request::is('explore/*') ? 'bg-blue-50/50 text-blue-600' : '' }}">
                Explore path
            </a>
            @auth
                <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 transition-all {{ Request::is('profile') ? 'bg-blue-50/50 text-blue-600' : '' }}">
                    Profile
                </a>
                <div class="h-px bg-slate-100 my-1"></div>
                <div class="flex items-center justify-between px-4 py-2">
                    <div class="flex items-center gap-2">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ auth()->user()->profile_photo }}" class="h-8 w-8 rounded-full border border-blue-200 object-cover">
                        @else
                            <div class="h-8 w-8 rounded-full border border-blue-200 bg-blue-50 flex items-center justify-center text-blue-600 font-extrabold text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hi, {{ explode(' ', auth()->user()->name)[0] }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-red-100 bg-red-50 text-red-600 text-xs font-bold hover:bg-red-600 hover:text-white transition-all cursor-pointer">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="h-px bg-slate-100 my-1"></div>
                <div class="grid grid-cols-2 gap-2 mt-1">
                    <a href="{{ url('/login') }}" class="flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-bold text-slate-700 hover:bg-slate-100 transition-all text-center">
                        Login
                    </a>
                    <a href="{{ url('/register') }}" class="flex items-center justify-center px-4 py-2.5 rounded-xl bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 transition-all text-center shadow-md shadow-blue-500/10">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let lastScrollTop = 0;
        const navbar = document.getElementById('main-navbar');
        const navContainer = document.getElementById('navbar-container');
        const navInner = document.getElementById('navbar-inner');
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const dropdownMenu = document.getElementById('mobile-dropdown-menu');

        // Scroll Shrink & Trans Animations
        window.addEventListener('scroll', () => {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 40) {
                navbar.style.top = '8px';
                navInner.style.height = '48px';
                navContainer.classList.add('shadow-md', 'bg-slate-50', 'border-slate-200/85');
                navContainer.classList.remove('shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)]', 'bg-white', 'border-slate-200');
            } else {
                navbar.style.top = '16px';
                navInner.style.height = '56px';
                navContainer.classList.add('shadow-[0_4px_20px_-4px_rgba(0,0,0,0.02)]', 'bg-white', 'border-slate-200');
                navContainer.classList.remove('shadow-md', 'bg-slate-50', 'border-slate-200/85');
            }

            lastScrollTop = scrollTop;
        });

        // Mobile Menu Dropdown Toggle Handler
        if (toggleBtn && dropdownMenu) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.classList.remove('hidden');
                    void dropdownMenu.offsetWidth; // trigger reflow
                    dropdownMenu.classList.remove('scale-95', 'opacity-0');
                    dropdownMenu.classList.add('scale-100', 'opacity-100');
                } else {
                    dropdownMenu.classList.remove('scale-100', 'opacity-100');
                    dropdownMenu.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        dropdownMenu.classList.add('hidden');
                    }, 300);
                }
            });

            document.addEventListener('click', (e) => {
                if (!dropdownMenu.contains(e.target) && !toggleBtn.contains(e.target)) {
                    if (!dropdownMenu.classList.contains('hidden')) {
                        dropdownMenu.classList.remove('scale-100', 'opacity-100');
                        dropdownMenu.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            dropdownMenu.classList.add('hidden');
                        }, 300);
                    }
                }
            });
        }
    });
</script>

@auth
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let lastGlobalUpdatedTime = {{ time() }};
        
        // Poll for updates every 8 seconds
        setInterval(() => {
            fetch(`/api/check-global-updates?last_updated=${lastGlobalUpdatedTime}`)
                .then(res => res.json())
                .then(data => {
                    if (data.has_updates) {
                        showGlobalUpdateNotification();
                        lastGlobalUpdatedTime = data.last_updated;
                    }
                })
                .catch(err => console.error('Error checking updates:', err));
        }, 8000);
    });

    function showGlobalUpdateNotification() {
        if (document.getElementById('global-update-notification-toast')) return;

        const toast = document.createElement('div');
        toast.id = 'global-update-notification-toast';
        toast.className = 'fixed bottom-6 right-6 z-[200] bg-slate-900 text-white rounded-2xl p-5 shadow-2xl border border-slate-800 max-w-sm transition-all duration-500 transform translate-y-12 opacity-0 flex flex-col gap-3';
        toast.innerHTML = `
            <div class="flex items-start gap-3">
                <span class="text-xl">🔔</span>
                <div>
                    <h4 class="text-sm font-extrabold text-slate-100">Konten Diperbarui!</h4>
                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Admin baru saja memperbarui materi/kuiz di platform. Silakan refresh halaman untuk melihat perubahan terbaru.</p>
                </div>
            </div>
            <div class="flex gap-2 justify-end mt-1">
                <button onclick="document.getElementById('global-update-notification-toast').remove()" class="px-3.5 py-1.5 rounded-xl border border-slate-700 bg-transparent hover:bg-slate-800 text-slate-300 text-xs font-bold transition-all cursor-pointer">
                    Nanti Saja
                </button>
                <button onclick="window.location.reload()" class="px-4 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 border-0 text-white text-xs font-bold transition-all shadow-md shadow-blue-500/10 cursor-pointer">
                    Refresh Sekarang
                </button>
            </div>
        `;
        document.body.appendChild(toast);
        void toast.offsetWidth;
        toast.classList.remove('translate-y-12', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
    }
</script>

@if(session('pending_update_notification'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            showGlobalUpdateNotification();
        }, 1000);
    });
</script>
@endif
@endauth
