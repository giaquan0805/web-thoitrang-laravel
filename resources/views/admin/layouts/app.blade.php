<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Fashion AI')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; }

        /* Sidebar */
        .sidebar {
            width: 250px; min-height: 100vh; background: #1a1a2e;
            color: #fff; position: fixed; top: 0; left: 0;
        }
        .sidebar-brand {
            padding: 20px; font-size: 20px; font-weight: bold;
            border-bottom: 1px solid #ffffff20; text-align: center;
        }
        .sidebar-menu { padding: 15px 0; }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 20px; color: #ccc; text-decoration: none;
            transition: all 0.2s;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: #ffffff15; color: #fff;
            border-left: 3px solid #e94560;
        }
        .sidebar-menu .menu-title {
            padding: 10px 20px; font-size: 11px;
            color: #ffffff50; text-transform: uppercase; letter-spacing: 1px;
        }

        /* Main content */
        .main-content {
            margin-left: 250px; flex: 1; min-height: 100vh;
        }
        .topbar {
            background: #fff; padding: 15px 25px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .topbar h4 { font-size: 18px; color: #333; }
        .topbar .admin-info { display: flex; align-items: center; gap: 10px; color: #666; }
        .content { padding: 25px; }

        /* Cards */
        .stats-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 20px; margin-bottom: 25px;
        }
        .stat-card {
            background: #fff; padding: 20px; border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .stat-card .stat-icon {
            width: 50px; height: 50px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; margin-bottom: 15px;
        }
        .stat-card .stat-value { font-size: 24px; font-weight: bold; color: #333; }
        .stat-card .stat-label { font-size: 13px; color: #999; margin-top: 5px; }

        /* Table */
        .card {
            background: #fff; border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06); overflow: hidden;
        }
        .card-header {
            padding: 15px 20px; border-bottom: 1px solid #f0f0f0;
            display: flex; justify-content: space-between; align-items: center;
        }
        .card-header h5 { font-size: 16px; color: #333; }
        .card-body { padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table th {
            background: #f8f9fa; padding: 12px 15px;
            text-align: left; font-size: 13px; color: #666;
            border-bottom: 1px solid #eee;
        }
        table td { padding: 12px 15px; border-bottom: 1px solid #f5f5f5; font-size: 14px; }
        table tr:last-child td { border-bottom: none; }
        table tr:hover td { background: #fafafa; }

        /* Buttons */
        .btn {
            padding: 8px 16px; border-radius: 6px; border: none;
            cursor: pointer; font-size: 13px; text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #1a1a2e; color: #fff; }
        .btn-success { background: #28a745; color: #fff; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-danger { background: #dc3545; color: #fff; }
        .btn-sm { padding: 5px 10px; font-size: 12px; }

        /* Badge */
        .badge {
            padding: 4px 10px; border-radius: 20px;
            font-size: 12px; font-weight: 500;
        }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-info { background: #cce5ff; color: #004085; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }

        /* Form */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px; }
        .form-control {
            width: 100%; padding: 10px; border: 1px solid #ddd;
            border-radius: 6px; font-size: 14px;
        }
        .form-control:focus { outline: none; border-color: #1a1a2e; }

        @media (max-width: 768px) {
            .sidebar { width: 0; }
            .main-content { margin-left: 0; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-brand">
            ⚡ Fashion AI Admin
        </div>
        <div class="sidebar-menu">
            <div class="menu-title">Tổng quan</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>

            <div class="menu-title">Quản lý</div>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="fa-solid fa-shirt"></i> Sản phẩm
            </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Danh mục
            </a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bag-shopping"></i> Đơn hàng
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Người dùng
            </a>

            <div class="menu-title">Tài khoản</div>
            <a href="{{ route('home') }}" target="_blank">
                <i class="fa-solid fa-globe"></i> Xem website
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="width:100%; background:none; border:none; cursor:pointer; display:flex; align-items:center; gap:10px; padding:12px 20px; color:#ccc; font-size:14px;">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </button>
            </form>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="topbar">
            <h4>@yield('page-title', 'Dashboard')</h4>
            <div class="admin-info">
                <i class="fa-regular fa-user"></i>
                <span>{{ Auth::user()->name }}</span>
            </div>
        </div>

        <div class="content">
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px;">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px;">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>