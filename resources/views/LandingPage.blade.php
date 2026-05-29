<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Path Deck</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- ini Bagian Navigasi Atas fi -->
    <header class="navbar">
        <div class="logo">Path Deck</div>
        <nav class="nav-links">
            <a href="#">Dashboard</a>
            <a href="#">Explore path</a>
            <a href="{{ url('/login') }}">Login</a>
            <a href="{{ url('/register') }}" class="btn btn-primary">Register</a>
        </nav>
    </header>

    <main>
        <!-- Bagian Utamanya -->
        <section class="hero">
            <div class="hero-content">
                <h2 class="subtitle">START YOUR CAREER</h2>
                <h1 class="title">Path Deck</h1>
                <p class="description">
                    Temukan dan kembangkan minat Anda di bidang teknologi melalui jalur pembelajaran terstruktur. Kuasai alat-alat yang sesuai standar industri dan bangun portofolio profesional.
                </p>
                <div class="hero-buttons">
                    <a href="Register.blade.php" class="btn btn-primary">Register Now</a>
                    <a href="#" class="btn btn-outline">View Paths</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/fotodashboard.png') }}" alt="Ilustrasi Path Deck">
            </div>
        </section>

        <!-- Bagian Fitur -->
        <section class="features">
            <h2 class="section-title">Why Path Deck?</h2>
            <p class="section-subtitle">Path Deck membantu siswa menemukan arah karier IT secara terarah melalui pembelajaran interaktif dan bertahap.</p>

            <div class="card-container">
                <!-- Kartu Fitur 1 -->
                <div class="card">
                    <div class="card-icon">
                        <img src="{{ asset('images/FlowIcon.svg') }}" alt="Flow Icon">
                    </div>
                    <h3>Struktur Flow</h3>
                    <p>Modul langkah demi langkah yang dirancang oleh para ahli di bidangnya untuk membawa Anda dari pemula menjadi ahli.</p>
                </div>

                <!-- Kartu Fitur 2 -->
                <div class="card">
                    <div class="card-icon">
                        <img src="{{ asset('images/SkillIcon.svg') }}" alt="Skill Icon">
                    </div>
                    <h3>Skill Validation</h3>
                    <p>Proyek-proyek nyata dan kuis yang menguji pengetahuan Anda serta membantu Anda membangun portofolio yang dapat diverifikasi.</p>
                </div>

                <!-- Kartu Fitur 3 -->
                <div class="card">
                    <div class="card-icon">
                        <img src="{{ asset('images/CareerIcon.svg') }}" alt="Career Icon">
                    </div>
                    <h3>Career Focused</h3>
                    <p>Produk kami terus diperbarui agar tetap sesuai dengan permintaan pasar terkini dan perkembangan teknologi.</p>
                </div>
            </div>
        </section>

        <!-- Bagian Call to Action -->
        <section class="cta-bottom">
             <h2 class="cta-title">Ready to find your path?</h2>
             <p class="cta-desc">Bergabunglah dengan ribuan pelajar yang telah mengubah rasa ingin tahu mereka menjadi karier di bidang teknologi.</p>
             <a href="Login.blade.php" class="btn btn-white">Get Started</a>
        </section>
    </main>

    <!-- Bagian Footer -->
    <footer>
        <p>@ 2026 Path Deck</p>
    </footer>
</body>
</html>
