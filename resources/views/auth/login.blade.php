<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Fashion AI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: #111;
        }

        /* Ảnh nền mờ */
        .auth-backdrop {
            position: fixed; inset: 0; z-index: 0;
            background: url('{{ asset("images/banners/hero-banner.jpg") }}') center/cover no-repeat;
            filter: blur(6px) brightness(0.5);
            transform: scale(1.1);
        }

        /* Card chính */
        .auth-card {
            position: relative; z-index: 1;
            display: flex; width: 900px; max-width: 95vw;
            background: #fff; border-radius: 16px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            overflow: hidden; min-height: 520px;
        }

        /* Nửa trái - Ảnh */
        .auth-card-image {
            flex: 1; position: relative;
            background: url('{{ asset("images/banners/hero-banner.jpg") }}') center/cover no-repeat;
            min-height: 100%;
        }

        .auth-card-image::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(160, 110, 50, 0.3) 0%, rgba(80, 50, 20, 0.5) 100%);
        }

        .image-brand {
            position: absolute; top: 30px; left: 30px; z-index: 1;
            font-family: 'Playfair Display', serif;
            font-size: 22px; color: #fff; letter-spacing: 2px;
        }

        .image-text {
            position: absolute; bottom: 40px; left: 30px; right: 30px; z-index: 1;
        }

        .image-text h2 {
            font-family: 'Playfair Display', serif;
            font-size: 26px; color: #fff; margin-bottom: 8px;
            line-height: 1.3;
        }

        .image-text p {
            color: rgba(255,255,255,0.8); font-size: 13px; line-height: 1.5;
        }

        /* Nửa phải - Form */
        .auth-card-form {
            flex: 1; padding: 50px 45px;
            display: flex; flex-direction: column; justify-content: center;
        }

        .form-logo {
            font-family: 'Playfair Display', serif;
            font-size: 18px; color: #333; letter-spacing: 4px;
            text-align: center; margin-bottom: 30px; text-transform: uppercase;
        }

        .form-header { text-align: center; margin-bottom: 30px; }

        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 22px; color: #333; margin-bottom: 6px;
        }

        .form-header p { color: #999; font-size: 13px; }
        .form-header p span { color: #d4a574; font-style: italic; }

        /* Alert */
        .auth-alert {
            padding: 10px 14px; border-radius: 8px; margin-bottom: 18px;
            font-size: 13px; display: flex; align-items: center; gap: 8px;
        }
        .auth-alert.error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .auth-alert.success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

        /* Input */
        .form-field { margin-bottom: 18px; }

        .form-field .input-wrap {
            position: relative; display: flex; align-items: center;
        }

        .form-field .input-wrap i {
            position: absolute; left: 14px;
            color: #ccc; font-size: 15px;
        }

        .form-field input {
            width: 100%; padding: 13px 14px 13px 42px;
            border: 1px solid #e8e8e8; border-radius: 8px;
            font-size: 14px; transition: all 0.2s;
            background: #fafafa; color: #333;
        }

        .form-field input:focus {
            outline: none; border-color: #d4a574;
            background: #fff; box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
        }

        .form-field input::placeholder { color: #bbb; }

        .form-field .error-text {
            color: #dc2626; font-size: 12px; margin-top: 4px; padding-left: 4px;
        }

        /* Options row */
        .form-options {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 22px; font-size: 13px;
        }

        .form-options label {
            display: flex; align-items: center; gap: 6px;
            color: #888; cursor: pointer;
        }

        .form-options label input { accent-color: #d4a574; }

        .form-options a { color: #d4a574; text-decoration: none; font-weight: 500; }
        .form-options a:hover { text-decoration: underline; }

        /* Submit */
        .form-submit {
            width: 100%; padding: 13px; border: none; border-radius: 8px;
            font-size: 15px; font-weight: 600; cursor: pointer;
            background: #222; color: #fff;
            transition: all 0.3s; letter-spacing: 0.5px;
        }

        .form-submit:hover {
            background: #444;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Divider */
        .form-divider {
            display: flex; align-items: center; gap: 12px;
            margin: 22px 0; color: #ddd; font-size: 12px;
        }
        .form-divider::before, .form-divider::after {
            content: ''; flex: 1; height: 1px; background: #eee;
        }

        /* Switch */
        .form-switch {
            text-align: center; font-size: 13px; color: #999;
        }
        .form-switch a { color: #333; font-weight: 600; text-decoration: none; }
        .form-switch a:hover { text-decoration: underline; }

        /* Back button */
        .btn-back {
            position: absolute; top: 20px; right: 20px; z-index: 2;
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(0,0,0,0.05); border: none;
            color: #999; font-size: 14px;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; transition: 0.2s; cursor: pointer;
        }
        .btn-back:hover { background: rgba(0,0,0,0.1); color: #333; }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-card { flex-direction: column; min-height: auto; }
            .auth-card-image { min-height: 200px; }
            .auth-card-form { padding: 30px 25px; }
            .image-brand { font-size: 18px; }
            .image-text h2 { font-size: 20px; }
        }
    </style>
</head>
<body>

<div class="auth-backdrop"></div>

<div class="auth-card">

    {{-- Nửa trái - Ảnh --}}
    <div class="auth-card-image">
        <div class="image-brand">FASHION AI</div>
        <div class="image-text">
            <h2>Khám phá phong cách<br>thời trang của bạn</h2>
            <p>Công nghệ AI thử đồ tiên tiến nhất</p>
        </div>
    </div>

    {{-- Nửa phải - Form --}}
    <div class="auth-card-form" style="position: relative;">

        <a href="{{ route('home') }}" class="btn-back">
            <i class="fa-solid fa-xmark"></i>
        </a>

        <div class="form-logo">FASHION AI</div>

        <div class="form-header">
            <h2>Discover the</h2>
            <p><span>latest trends now.</span></p>
        </div>

        @if(session('error'))
            <div class="auth-alert error">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="auth-alert success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-field">
                <div class="input-wrap">
                    <i class="fa-regular fa-user"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                </div>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-field">
                <div class="input-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember"> Ghi nhớ
                </label>
                <a href="#">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="form-submit">Sign in</button>
        </form>

        <div class="form-divider">or</div>

        <p class="form-switch">
            Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
        </p>
    </div>

</div>

</body>
</html>