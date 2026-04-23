<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Admin - Fashion AI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh; display: flex;
            align-items: center; justify-content: center;
            background: #f0f2f5;
        }

        .admin-login-card {
            width: 420px; max-width: 95vw;
            background: #fff; border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .admin-login-header {
            background: #2c3345; padding: 30px;
            text-align: center; color: #fff;
        }

        .admin-login-header .brand {
            font-size: 22px; font-weight: 700;
            letter-spacing: 2px; margin-bottom: 6px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .admin-login-header p {
            color: rgba(255,255,255,0.6); font-size: 13px;
        }

        .admin-login-body { padding: 35px 30px; }

        .admin-alert {
            padding: 10px 14px; border-radius: 8px; margin-bottom: 18px;
            font-size: 13px; display: flex; align-items: center; gap: 8px;
        }
        .admin-alert.error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        .admin-field { margin-bottom: 18px; }

        .admin-field label {
            display: block; margin-bottom: 6px;
            font-weight: 500; font-size: 13px; color: #555;
        }

        .admin-field .input-wrap {
            position: relative; display: flex; align-items: center;
        }

        .admin-field .input-wrap i {
            position: absolute; left: 14px; color: #bbb; font-size: 15px;
        }

        .admin-field input {
            width: 100%; padding: 12px 14px 12px 42px;
            border: 1.5px solid #e5e5e5; border-radius: 8px;
            font-size: 14px; transition: all 0.2s;
            background: #fafafa;
        }

        .admin-field input:focus {
            outline: none; border-color: #2c3345;
            background: #fff; box-shadow: 0 0 0 3px rgba(44, 51, 69, 0.1);
        }

        .admin-submit {
            width: 100%; padding: 13px; border: none; border-radius: 8px;
            font-size: 15px; font-weight: 600; cursor: pointer;
            background: #2c3345; color: #fff;
            transition: all 0.3s; margin-top: 5px;
        }

        .admin-submit:hover {
            background: #3d4a5e;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(44, 51, 69, 0.3);
        }

        .admin-login-footer {
            text-align: center; padding: 0 30px 25px;
            font-size: 13px; color: #999;
        }

        .admin-login-footer a {
            color: #2c3345; font-weight: 500; text-decoration: none;
        }
        .admin-login-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="admin-login-card">
    <div class="admin-login-header">
        <div class="brand">
            <i class="fa-solid fa-store"></i> Fashion AI
        </div>
        <p>Đăng nhập trang quản trị</p>
    </div>

    <div class="admin-login-body">
        @if(session('error'))
            <div class="admin-alert error">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <div class="admin-field">
                <label>Email</label>
                <div class="input-wrap">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@fashionai.com" required>
                </div>
            </div>

            <div class="admin-field">
                <label>Mật khẩu</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
            </div>

            <button type="submit" class="admin-submit">
                <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
            </button>
        </form>
    </div>

    <div class="admin-login-footer">
        <a href="{{ route('home') }}"><i class="fa-solid fa-arrow-left"></i> Về trang chủ</a>
    </div>
</div>

</body>
</html>