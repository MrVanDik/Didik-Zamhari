<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Klinik Sehat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2a9d8f;
            --secondary-color: #1d7874;
            --accent-color: #e76f51;
            --light-bg: #f1faee;
            --dark-text: #264653;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(to right, #e0f2f1, #b2dfdb);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .medical-shape {
            position: absolute;
            opacity: 0.1;
            z-index: 0;
        }
        
        .shape-1 {
            top: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Cpath d='M256 0C114.6 0 0 114.6 0 256s114.6 256 256 256s256-114.6 256-256S397.4 0 256 0zM368 344c0 13.25-10.75 24-24 24s-24-10.75-24-24V288h-128v56C192 357.3 181.3 368 168 368S144 357.3 144 344V168c0-13.25 10.75-24 24-24S192 154.8 192 168v56h128V168c0-13.25 10.75-24 24-24s24 10.75 24 24V344z' fill='%23264653'/%3E%3C/svg%3E");
            background-size: contain;
        }
        
        .shape-2 {
            bottom: -120px;
            right: -120px;
            width: 400px;
            height: 400px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512'%3E%3Cpath d='M128 160h320v192H128V160zm400 96c0 26.51 21.49 48 48 48v96c0 26.51-21.49 48-48 48H48c-26.51 0-48-21.49-48-48v-96c26.51 0 48-21.49 48-48s-21.49-48-48-48v-96c0-26.51 21.49-48 48-48h480c26.51 0 48 21.49 48 48v96c-26.51 0-48 21.49-48 48zm-48-104c0-13.255-10.745-24-24-24H120c-13.255 0-24 10.745-24 24v208c0 13.255 10.745 24 24 24h336c13.255 0 24-10.745 24-24V152z' fill='%23264653'/%3E%3C/svg%3E");
            background-size: contain;
            transform: rotate(45deg);
        }
        
        .login-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            min-height: 550px;
            z-index: 10;
            position: relative;
        }
        
        .login-left {
            background: linear-gradient(to bottom right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cpath fill='rgba(255,255,255,0.05)' d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z'%3E%3C/path%3E%3C/svg%3E");
            opacity: 0.3;
        }
        
        .login-right {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: white;
        }
        
        .clinic-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .clinic-icon {
            width: 80px;
            height: 80px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            box-shadow: 0 5px 15px rgba(42, 157, 143, 0.3);
        }
        
        .clinic-icon i {
            font-size: 40px;
            color: white;
        }
        
        .clinic-header h1 {
            font-weight: 700;
            font-size: 28px;
            color: var(--dark-text);
            margin-bottom: 5px;
        }
        
        .clinic-header p {
            color: #666;
            font-size: 16px;
        }
        
        .form-control {
            padding: 15px 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            transition: all 0.3s;
            font-size: 15px;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(42, 157, 143, 0.15);
        }
        
        .input-group-text {
            background: transparent;
            border-right: 0;
            padding: 0 20px;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-login {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 15px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 16px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(42, 157, 143, 0.4);
        }
        
        .features-list {
            list-style: none;
            padding: 0;
            margin-top: 30px;
        }
        
        .features-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            font-size: 15px;
        }
        
        .features-list i {
            background: rgba(255, 255, 255, 0.2);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 14px;
        }
        
        .support-contact {
            margin-top: 30px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            text-align: center;
        }
        
        .support-contact p {
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .support-contact a {
            color: white;
            font-weight: 600;
            text-decoration: none;
        }
        
        @media (max-width: 992px) {
            .login-left {
                display: none;
            }
            
            .login-container {
                max-width: 500px;
            }
        }
        
        .floating-label {
            position: relative;
            margin-bottom: 25px;
        }
        
        .floating-label label {
            position: absolute;
            top: 50%;
            left: 60px;
            transform: translateY(-50%);
            pointer-events: none;
            transition: 0.3s ease all;
            color: #777;
            background: white;
            padding: 0 8px;
        }
        
        .floating-label input:focus ~ label,
        .floating-label input:not(:placeholder-shown) ~ label {
            top: -10px;
            left: 20px;
            font-size: 12px;
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
            z-index: 5;
        }
        
        .emergency-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff3f0;
            border-left: 4px solid var(--accent-color);
            border-radius: 5px;
            font-size: 14px;
        }
        
        .emergency-info strong {
            color: var(--accent-color);
        }
    </style>
</head>
<body>
    <div class="medical-shape shape-1"></div>
    <div class="medical-shape shape-2"></div>
    
    <div class="login-container">
        <div class="row g-0">
            <div class="col-lg-6 login-left">
                <h2 class="mb-3">Sistem Manajemen Klinik Sehat</h2>
                <p class="mb-4">Akses sistem manajemen terpadu untuk tenaga medis dan administrasi</p>
                
                <ul class="features-list">
                    <li><i class="fas fa-stethoscope"></i> Kelola data pasien dengan aman</li>
                    <li><i class="fas fa-calendar-check"></i> Jadwalkan janji temu pasien</li>
                    <li><i class="fas fa-pills"></i> Pantau stok obat dan inventaris</li>
                    <li><i class="fas fa-chart-line"></i> Laporan statistik kesehatan</li>
                    <li><i class="fas fa-file-medical"></i> Rekam medis elektronik</li>
                </ul>
                
                <div class="support-contact">
                    <p>Butuh bantuan? Hubungi tim IT support</p>
                    <a href="tel:+62123456789"><i class="fas fa-phone-alt me-2"></i> (021) 1234-5678</a>
                </div>
            </div>
            
            <div class="col-lg-6 login-right">
                <div class="clinic-header">
                    <div class="clinic-icon">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <h1>Klinik Sehat</h1>
                    <p>Sistem Manajemen Terpadu</p>
                </div>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="floating-label">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder=" ">
                        </div>
                        <label for="email">Username / Email</label>
                        
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="floating-label">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="current-password" placeholder=" ">
                            <span class="password-toggle" id="passwordToggle">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <label for="password">Kata Sandi</label>
                        
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="float-end text-decoration-none">Lupa Kata Sandi?</a>
                        @endif
                    </div>
                    
                    <button type="submit" class="btn btn-login w-100 mb-4">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk
                    </button>
                    
                    <div class="emergency-info">
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Informasi Darurat</strong>
                        <p class="mb-0 mt-1">Untuk akses darurat medis, hubungi unit gawat darurat di <strong>119</strong></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('passwordToggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Periksa nilai input saat dimuat (untuk autofill browser)
        document.querySelectorAll('.form-control').forEach(input => {
            if (input.value !== '') {
                input.parentElement.parentElement.classList.add('focused');
            }
            
            input.addEventListener('focus', () => {
                input.parentElement.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', () => {
                if (input.value === '') {
                    input.parentElement.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>
</html>