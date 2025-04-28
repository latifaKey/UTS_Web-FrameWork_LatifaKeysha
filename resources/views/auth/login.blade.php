<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Booking Lapangan Olahraga</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --primary-color: #4e73df;
            --primary-dark: #2e59d9;
            --primary-light: #6f8bef;
            --secondary-color: #f8f9fa;
            --text-color: #5a5c69;
            --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        body {
            background: linear-gradient(135deg, #f5f7fb 0%, #e4e7f5 100%);
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-color);
            position: relative;
            overflow-x: hidden;
        }

        /* Background animated shapes */
        body::before, body::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            z-index: -1;
            opacity: 0.4;
            animation: float 15s infinite ease-in-out;
        }

        body::before {
            background: linear-gradient(to right, var(--primary-color), var(--primary-light));
            top: -100px;
            left: -100px;
        }

        body::after {
            background: linear-gradient(to right, var(--primary-light), #7a9cf9);
            bottom: -100px;
            right: -100px;
            animation-delay: 5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(10px, 15px) rotate(5deg); }
            50% { transform: translate(5px, 25px) rotate(0deg); }
            75% { transform: translate(15px, 10px) rotate(-5deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }

        .login-container {
            margin: 1.5rem;
            width: 100%;
            max-width: 440px;
        }

        .login-form {
            background-color: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transform: translateY(30px);
            opacity: 0;
            animation: slideUp 0.8s ease forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-header {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header h4 {
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .login-header::before {
            content: "";
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            width: 150px;
            height: 150px;
            border-radius: 50%;
            top: -50px;
            right: -50px;
            z-index: 1;
        }

        .login-header::after {
            content: "";
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            width: 100px;
            height: 100px;
            border-radius: 50%;
            bottom: -30px;
            left: -30px;
            z-index: 1;
        }

        .login-body {
            padding: 2rem;
        }

        .login-form .form-control {
            padding: 0.8rem 1rem;
            font-size: 1rem;
            border: 1px solid #e0e2e9;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .login-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        }

        .login-form .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            border: none;
            padding: 0.8rem;
            font-weight: 500;
            font-size: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.25);
            transition: all 0.3s ease;
        }

        .login-form .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(78, 115, 223, 0.35);
        }

        .login-form label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-icon {
            display: flex;
            align-items: center;
            position: relative;
            margin-bottom: 0.5rem;
        }

        .form-icon i {
            position: absolute;
            left: 16px;
            color: #adb5bd;
            z-index: 2;
            font-size: 16px;
        }

        .form-icon input {
            padding-left: 48px;
            height: 50px;
            font-size: 15px;
        }

        .form-icon input::placeholder {
            font-weight: 300;
            opacity: 0.7;
        }

        .form-icon input:focus {
            padding-left: 48px;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        }

        .alert {
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            animation: fadeInDown 0.5s;
        }

        .alert-danger {
            background-color: rgba(231, 74, 59, 0.1);
            border-left: 4px solid #e74a3b;
            color: #a52a21;
        }

        .error-shake {
            animation: shakeX 0.82s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shakeX {
            10%, 90% { transform: translateX(-1px); }
            20%, 80% { transform: translateX(2px); }
            30%, 50%, 70% { transform: translateX(-4px); }
            40%, 60% { transform: translateX(4px); }
        }

        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid currentColor;
            border-right-color: transparent;
            animation: spin 0.75s linear infinite;
            margin-right: 10px;
            display: none;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .link-animation {
            position: relative;
            display: inline-block;
        }

        .link-animation::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary-color);
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease;
        }

        .link-animation:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form animate__animated animate__fadeIn">
            <div class="login-header">
                <h4 class="animate__animated animate__fadeInDown">
                    <i class="fas fa-calendar-check me-2"></i>
                    Login Aplikasi
                </h4>
                <p class="animate__animated animate__fadeIn animate__delay-1s mb-0">Booking Lapangan Olahraga</p>
            </div>

            <div class="login-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4 error-shake" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4 error-shake" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Email atau password salah!</strong> Silahkan periksa kembali.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" id="loginForm">
                    @csrf
                    <div class="mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                        <label for="email" class="form-label">Email</label>
                        <div class="form-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email anda..." autocomplete="email">
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 animate__animated animate__fadeInUp animate__delay-2s">
                        <label for="password" class="form-label">Password</label>
                        <div class="form-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Masukkan password anda..." autocomplete="current-password">
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 mt-4 animate__animated animate__fadeInUp animate__delay-3s">
                        <button type="submit" class="btn btn-primary" id="loginButton">
                            <span class="spinner" id="loginSpinner"></span>
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4 animate__animated animate__fadeIn animate__delay-4s">
                    <p class="mb-0">Belum punya akun?
                        <a href="{{ route('register') }}" class="text-decoration-none text-primary fw-medium link-animation">
                            Daftar disini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        const loginSpinner = document.getElementById('loginSpinner');

        // Add loading animation when form submits
        loginForm.addEventListener('submit', function(e) {
            // Prevent the default form submission
            e.preventDefault();

            loginButton.disabled = true;
            loginSpinner.style.display = 'inline-block';
            loginButton.querySelector('.fas').style.display = 'none';

            // Submit the form directly without setTimeout to avoid CSRF token expiration
            setTimeout(function() {
                loginForm.submit();
            }, 800);
        });
    });
    </script>
</body>
</html>
