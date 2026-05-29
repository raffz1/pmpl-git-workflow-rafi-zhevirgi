<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile - Path Deck</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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

        /* 3D Tilt/Wobble Effect for Pathway Progress Cards */
        .wobble-card {
            transform-style: preserve-3d;
            perspective: 1000px;
            transition: transform 0.15s ease-out, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        .wobble-card * {
            transform-style: preserve-3d;
            backface-visibility: hidden;
        }
        .inner-lift {
            transition: transform 0.25s cubic-bezier(0.25, 1, 0.5, 1);
            transform: translateZ(0px);
        }
        .wobble-card:hover .inner-lift {
            transform: translateZ(25px);
        }

        /* Ambient Background Blobs Animation */
        @keyframes float-blob {
            0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
            33% { transform: translateY(-20px) scale(1.05) rotate(2deg); }
            66% { transform: translateY(15px) scale(0.95) rotate(-2deg); }
        }
        .animate-float-blob {
            animation: float-blob 11s ease-in-out infinite;
        }

        /* Fade In Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        /* Modal Transition Animations */
        #edit-modal {
            transition: opacity 0.3s ease-out;
        }
        #edit-modal.show {
            opacity: 1;
        }
        #edit-modal.show #modal-container {
            transform: scale(1) translateY(0);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col overflow-x-hidden relative">

    <!-- Top Navigation Bar -->
    @include('layouts.navbar')

    <!-- Ambient Glowing Background Decor (Matching other pages, clean & out of the way) -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <!-- Faded Blue Grid Overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#3b82f610_1px,transparent_1px),linear-gradient(to_bottom,#3b82f610_1px,transparent_1px)] bg-[size:5rem_5rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_90%,transparent_100%)] opacity-100"></div>
        
        <!-- Glowing Blobs -->
        <div class="absolute top-[8%] left-[-8%] w-[450px] h-[450px] rounded-full bg-blue-400/20 blur-3xl animate-float-blob" style="animation-duration: 9s;"></div>
        <div class="absolute top-[35%] right-[-12%] w-[500px] h-[500px] rounded-full bg-indigo-400/15 blur-3xl animate-float-blob" style="animation-delay: -3s; animation-duration: 12s;"></div>
        <div class="absolute bottom-[8%] left-[4%] w-[400px] h-[400px] rounded-full bg-cyan-300/18 blur-3xl animate-float-blob" style="animation-delay: -6s; animation-duration: 10s;"></div>
    </div>

    <!-- Main Content Area -->
    <main class="grow relative z-10 max-w-5xl mx-auto w-full px-4 sm:px-6 py-8">

        @if(session('success'))
            <div class="mb-6 px-4 py-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-bold flex items-center gap-3 animate-fade-in-up">
                <span>🎉</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 px-4 py-3 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm font-bold flex flex-col gap-1.5 animate-fade-in-up">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <span>⚠️</span>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Profile Card & Facebook-Style Header Layout -->
        <section class="mb-10 animate-fade-in-up" style="animation-delay: 50ms;">
            <div class="bg-white rounded-3xl border border-slate-200/60 overflow-hidden shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)]">
                
                <!-- 1. Cover Photo Area -->
                <div class="h-48 sm:h-64 md:h-72 w-full relative overflow-hidden bg-slate-900 group">
                    @if($user->cover_photo)
                        <img id="cover-photo-img" src="{{ $user->cover_photo }}" alt="Cover Background" class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-102">
                    @else
                        <!-- Default high-quality abstract cover background -->
                        <img id="cover-photo-img" src="https://images.unsplash.com/photo-1579546929518-9e396f3cc809?w=1200&auto=format&fit=crop&q=80" alt="Default Cover" class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-102">
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                </div>

                <!-- 2. Avatar, Meta & Action Layout (Strictly in the white box below the cover photo) -->
                <div class="px-6 sm:px-8 pb-6 relative flex flex-col md:flex-row items-center md:items-start justify-between gap-6">
                    
                    <!-- Left Section: Avatar (overlapping cover) + Identity (strictly below cover) -->
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6 w-full md:w-auto text-center md:text-left">
                        <!-- Profile Image Frame -->
                        <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-full overflow-hidden border-4 border-white bg-slate-100 shadow-xl shrink-0 -mt-16 sm:-mt-20 md:-mt-24 relative z-20 cursor-pointer">
                            @if($user->profile_photo)
                                <img id="profile-avatar-img" src="{{ $user->profile_photo }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <div id="profile-avatar-placeholder" class="w-full h-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-extrabold text-4xl select-none">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Name and Role Title Info (Strictly below the cover photo) -->
                        <div class="pt-4 flex-grow">
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 title-font tracking-tight">
                                {{ $user->name }}
                            </h1>
                            
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-3 gap-y-1.5 mt-2">
                                <span class="text-sm font-semibold text-slate-500 bg-slate-100/80 px-2.5 py-0.5 rounded-lg border border-slate-200/50">
                                    {{ $user->username ? '@' . $user->username : '@' . Str::slug($user->name) }}
                                </span>
                                
                                <span class="text-sm font-medium text-slate-400">
                                    {{ $user->email }}
                                </span>
                                
                                <span class="w-1.5 h-1.5 bg-slate-300 rounded-full hidden md:inline-block"></span>
                                
                                @if($dominantTitle)
                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold bg-blue-50 border border-blue-100 text-blue-600 shadow-sm font-mono tracking-wide uppercase">
                                        {{ $dominantTitle }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold bg-slate-100 border border-slate-200 text-slate-400 font-mono tracking-wide">
                                        Kamu belum memiliki title
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Section: Edit Profile Button -->
                    <div class="pt-4 flex-shrink-0 mt-4 md:mt-0">
                        <button id="open-edit-btn" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/10 hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-300 hover:scale-[1.03] cursor-pointer">
                            <svg class="w-4 h-4 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Edit Profil
                        </button>
                    </div>

                </div>
            </div>
        </section>

        <!-- Learning Progress Recap (Completed Paths) -->
        <section class="mb-10 animate-fade-in-up" style="animation-delay: 150ms;">
            <div class="border-b border-slate-200 pb-5 mb-8">
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight title-font flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-blue-600 rounded-full inline-block"></span>
                    Progress Hasil Belajar
                </h2>
                <p class="text-xs text-slate-400 mt-1 font-medium">Rekapitulasi progres belajar Anda di semua pathway secara real-time.</p>
            </div>

            <!-- Pathway Progress Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                @foreach($pathDetails as $path)
                    <!-- Progress Card -->
                    <div class="group wobble-card bg-white border border-slate-200/80 rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_16px_36px_-8px_rgba(0,0,0,0.06)] transition-all duration-300">
                        <div class="inner-lift flex flex-col justify-between h-full gap-4">
                            
                            <!-- Header: Title & Badge -->
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-base font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors duration-300">
                                        {{ $path['name'] }}
                                    </h3>
                                    <span class="text-[11px] font-bold text-slate-400">
                                        {{ $path['step'] }} dari {{ $path['total'] }} modul selesai
                                    </span>
                                </div>
                                
                                <!-- Status Badge -->
                                @if($path['completed'])
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-emerald-50 border border-emerald-100 text-emerald-600 font-mono">
                                        Selesai 🎉
                                    </span>
                                @elseif($path['step'] > 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-blue-50 border border-blue-100 text-blue-600 font-mono animate-pulse">
                                        Belajar 📚
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 border border-slate-200 text-slate-400 font-mono">
                                        Belum Mulai
                                    </span>
                                @endif
                            </div>

                            <!-- Progress Bar -->
                            <div>
                                <div class="flex justify-between items-center mb-1.5">
                                    <span class="text-[11px] font-bold text-slate-400">Progres Pembelajaran</span>
                                    <span class="text-xs font-extrabold text-slate-700 bg-slate-100 border border-slate-200 px-1.5 py-0.5 rounded-md font-mono">{{ $path['progress'] }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200/20">
                                    <div class="bg-gradient-to-r {{ $path['color'] }} h-2 rounded-full transition-all duration-1000" style="width: {{ $path['progress'] }}%"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-slate-50 py-8 mt-auto relative z-20">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <p class="text-sm text-slate-500 font-medium">&copy; 2026 Path Deck</p>
        </div>
    </footer>

    <!-- Edit Profile Modal -->
    <div id="edit-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-sm opacity-0">
        
        <!-- Modal Card Container -->
        <div id="modal-container" class="bg-white rounded-[28px] max-w-xl w-full overflow-hidden flex flex-col shadow-[0_24px_60px_-15px_rgba(0,0,0,0.3)] relative transform scale-90 translate-y-8 transition-all duration-500 max-h-[90vh] overflow-y-auto">
            
            <!-- Close Button (Absolute) -->
            <button id="close-modal-btn" class="absolute top-4 right-4 z-50 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-800 transition-colors shadow-sm cursor-pointer border border-slate-200/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Header -->
            <div class="px-6 pt-6 pb-4 border-b border-slate-100">
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight title-font flex items-center gap-2">
                    Edit Profil Anda
                </h2>
                <p class="text-xs text-slate-400 mt-1 font-medium">Perbarui username, foto profil, email, dan password Anda secara real-time.</p>
            </div>

            <!-- Modal Form Content -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col grow">
                @csrf
                <div class="px-6 py-4 space-y-5 grow">
                    
                    <!-- 1. Username Field (Neatly Styled Input Group to prevent overlapping) -->
                    <div>
                        <label for="username" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username</label>
                        <div class="flex rounded-xl overflow-hidden border border-slate-200 focus-within:border-blue-500 transition-all bg-slate-50/50 focus-within:bg-white">
                            <span class="inline-flex items-center px-3.5 text-slate-400 font-extrabold text-sm select-none border-r border-slate-200/60 bg-slate-100/50">@</span>
                            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="block w-full px-4 py-2.5 text-sm focus:outline-none bg-transparent font-semibold" placeholder="usernamebaru">
                        </div>
                    </div>

                    <!-- 2. Name Field -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="block w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 bg-slate-50/50 focus:bg-white transition-all font-semibold" placeholder="Nama Lengkap">
                    </div>

                    <!-- 3. Email Field -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="block w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 bg-slate-50/50 focus:bg-white transition-all font-semibold" placeholder="email@contoh.com">
                    </div>

                    <!-- 4. Profile Photo Field -->
                    <div>
                        <label for="profile_photo" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Profil (Avatar)</label>
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                    </div>

                    <!-- 5. Cover Photo Field -->
                    <div>
                        <label for="cover_photo" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Background Cover</label>
                        <input type="file" name="cover_photo" id="cover_photo" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer">
                    </div>

                    <!-- 6. Password Fields (Optional) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Baru (Opsional)</label>
                            <input type="password" name="password" id="password" class="block w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 bg-slate-50/50 focus:bg-white transition-all font-semibold" placeholder="••••••••">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 bg-slate-50/50 focus:bg-white transition-all font-semibold" placeholder="••••••••">
                        </div>
                    </div>

                </div>

                <!-- Modal Footer Actions -->
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" id="cancel-edit-btn" class="px-4 py-2.5 border border-slate-200 hover:border-slate-300 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/10 hover:shadow-lg hover:shadow-blue-500/20 transition-all cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Interactive JS Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- Interactive 3D Cursor-Wobble / Tilt Card Effect ---
            const cards = document.querySelectorAll('.wobble-card');
            
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const width = rect.width;
                    const height = rect.height;
                    
                    const rotateX = ((y / height) - 0.5) * -10;
                    const rotateY = ((x / width) - 0.5) * 10;
                    
                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
                });
            });

            // --- Edit Profile Modal Logic ---
            const editModal = document.getElementById('edit-modal');
            const openEditBtn = document.getElementById('open-edit-btn');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const cancelEditBtn = document.getElementById('cancel-edit-btn');

            function openModal() {
                editModal.classList.remove('hidden');
                editModal.classList.add('flex');
                void editModal.offsetWidth;
                editModal.classList.add('show');
                document.body.classList.add('overflow-hidden');
            }

            function closeModal() {
                editModal.classList.remove('show');
                document.body.classList.remove('overflow-hidden');
                setTimeout(() => {
                    editModal.classList.remove('flex');
                    editModal.classList.add('hidden');
                }, 300);
            }

            if (openEditBtn) openEditBtn.addEventListener('click', openModal);
            if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
            if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeModal);

            // Close when clicking overlay backdrop
            editModal.addEventListener('click', (e) => {
                if (e.target === editModal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>
