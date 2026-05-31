<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Path Deck</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <main class="login-container">
        <div class="login-logo">Path Deck</div>
        
        <div class="login-card">
            <div class="login-header">
                <h2>Login</h2>
                <p>Welcome back to your learning path.</p>
            </div>

            <!-- bagian Form a -->
            <form action="{{ url('/login-proses') }}" method="POST" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="email">EMAIL</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
                </div>
                <div class="form-group">
                    <div class="label-row">
                        <label for="password">PASSWORD</label>
                        <a href="#" class="forgot-password">Lupa Password?</a>
                    </div>
                    <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

            <div class="login-footer">
                <p>Apakah Sudah Daftar Akun? <a href="{{ url('/register') }}">Daftar Sekarang</a></p>
            </div>
        </div>
    </main>

    <!-- Bagian Footer -->
    <footer>
        <p>@ 2026 Path Deck</p>
    </footer>
</body>
</html>