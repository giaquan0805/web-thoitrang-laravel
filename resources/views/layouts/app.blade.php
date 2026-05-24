<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fashion AI')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>

    @include('partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Nút liên hệ nổi góc dưới phải --}}
    <div style="position: fixed; bottom: 25px; right: 25px; z-index: 999; display: flex; flex-direction: column; gap: 12px; align-items: center;">
        {{-- Nút Zalo --}}
        <a href="https://zalo.me/0383880857" target="_blank" class="float-btn float-bounce" style="width: 55px; height: 55px; border-radius: 50%; background: #0068ff; display: flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 4px 15px rgba(0, 104, 255, 0.4); position: relative;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg" alt="Zalo" style="width: 30px; height: 30px;">
            <span class="float-ping" style="position: absolute; inset: -3px; border-radius: 50%; border: 2px solid #0068ff; animation: ping 1.5s ease-out infinite;"></span>
        </a>
        {{-- Nút Điện thoại --}}
        <a href="tel:0383880857" class="float-btn float-bounce2" style="width: 55px; height: 55px; border-radius: 50%; background: #28a745; display: flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4); position: relative;">
            <i class="fa-solid fa-phone" style="color: #fff; font-size: 20px;"></i>
            <span class="float-ping" style="position: absolute; inset: -3px; border-radius: 50%; border: 2px solid #28a745; animation: ping 1.5s ease-out infinite 0.3s;"></span>
        </a>
    </div>

    <style>
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        @keyframes ping {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.4); opacity: 0; }
        }
        .float-bounce { animation: bounce 2s ease-in-out infinite; }
        .float-bounce2 { animation: bounce 2s ease-in-out infinite 0.5s; }
        .float-btn:hover {
            transform: scale(1.15) !important;
            animation: none;
        }
    </style>

    @stack('scripts')
</body>
</html>