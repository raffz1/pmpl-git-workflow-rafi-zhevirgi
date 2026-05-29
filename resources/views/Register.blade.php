<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Path Deck</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <main class="login-container">
        <a href="index.html">
            <div class="login-logo">Path Deck</div>
        </a>
        
        <div class="login-card">
            <div class="login-header">
                <h2>Create Account</h2>
                <p>Start your learning journey today.</p>
            </div>
            <form action="#" method="POST" class="login-form">
 
                <div class="form-group">
                    <label for="nama">NAMA</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required>
                </div>

                <div class="form-group">
                    <label for="email">EMAIL</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
                </div>

                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" id="password" name="password" placeholder="Buat password Anda" required>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>

            <div class="login-footer">
                <p>Apakah Sudah Punya Akun? <a href="{{ url('/login') }}">Login</a></p>
            </div>
        </div>
    </main>

    <!-- Bagian Footer -->
    <footer>
        <p>@ 2026 Path Deck</p>
    </footer>
</body>
</html>