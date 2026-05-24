<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin - Fashion AI'); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; display: flex; transition: background 0.3s, color 0.3s; }

        /* ===== LIGHT THEME ===== */
        [data-theme="light"] body, [data-theme="light"] { background: #f0f2f5; color: #333; }
        [data-theme="light"] .sidebar { background: #2c3345; }
        [data-theme="light"] .topbar { background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.08); }
        [data-theme="light"] .topbar h4 { color: #333; }
        [data-theme="light"] .card { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        [data-theme="light"] .stat-card { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        [data-theme="light"] table th { background: #f8f9fa; color: #666; }
        [data-theme="light"] table td { border-bottom-color: #f5f5f5; }
        [data-theme="light"] .form-control { background: #fff; border-color: #ddd; color: #333; }
        [data-theme="light"] .notif-dropdown { background: #fff; box-shadow: 0 10px 40px rgba(0,0,0,0.15); }
        [data-theme="light"] .notif-item { color: #333; }
        [data-theme="light"] .notif-item p:last-child { color: #999; }

        /* ===== DARK THEME ===== */
        [data-theme="dark"] body, [data-theme="dark"] { background: #1a1d23; color: #e0e0e0; }
        [data-theme="dark"] .sidebar { background: #12151a; }
        [data-theme="dark"] .topbar { background: #222730; box-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        [data-theme="dark"] .topbar h4 { color: #e0e0e0; }
        [data-theme="dark"] .card { background: #222730; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        [data-theme="dark"] .card-header { border-bottom-color: #333; }
        [data-theme="dark"] .card-header h5 { color: #e0e0e0; }
        [data-theme="dark"] .stat-card { background: #222730; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        [data-theme="dark"] .stat-card .stat-value { color: #e0e0e0; }
        [data-theme="dark"] .stat-card .stat-label { color: #888; }
        [data-theme="dark"] table th { background: #2a2f38; color: #aaa; border-bottom-color: #333; }
        [data-theme="dark"] table td { color: #ccc; border-bottom-color: #2a2f38; }
        [data-theme="dark"] table tr:hover td { background: #2a2f38; }
        [data-theme="dark"] .form-control { background: #2a2f38; border-color: #444; color: #e0e0e0; }
        [data-theme="dark"] .form-control:focus { border-color: #4a9eff; }
        [data-theme="dark"] .btn-primary { background: #4a9eff; }
        [data-theme="dark"] .notif-dropdown { background: #222730; box-shadow: 0 10px 40px rgba(0,0,0,0.4); }
        [data-theme="dark"] .notif-dropdown > div:first-child { border-bottom-color: #333; color: #e0e0e0; }
        [data-theme="dark"] .notif-item { border-bottom-color: #2a2f38 !important; }
        [data-theme="dark"] .notif-item p:first-child { color: #e0e0e0; }
        [data-theme="dark"] .notif-item p:last-child { color: #888; }
        [data-theme="dark"] .notif-item:hover { background: #2a2f38 !important; }
        [data-theme="dark"] .content > div[style*="background: #d4edda"] { background: #1a3a2a !important; color: #7dcea0 !important; }
        [data-theme="dark"] .content > div[style*="background: #f8d7da"] { background: #3a1a1a !important; color: #e88 !important; }

        /* Sidebar */
        .sidebar {
            width: 250px; min-height: 100vh;
            color: #fff; position: fixed; top: 0; left: 0; z-index: 50;
        }
        .sidebar-brand {
            padding: 20px; font-size: 20px; font-weight: bold;
            border-bottom: 1px solid #ffffff15; text-align: center;
            letter-spacing: 0.5px;
        }
        .sidebar-menu { padding: 15px 0; }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 20px; color: #a0aec0; text-decoration: none;
            transition: all 0.2s; border-left: 3px solid transparent; font-size: 14px;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: #ffffff10; color: #fff;
            border-left: 3px solid #4a9eff;
        }
        .sidebar-menu .menu-title {
            padding: 10px 20px; font-size: 11px;
            color: #ffffff40; text-transform: uppercase; letter-spacing: 1px;
        }

        /* Main content */
        .main-content { margin-left: 250px; flex: 1; min-height: 100vh; }
        .topbar {
            padding: 12px 25px;
            display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 40;
        }
        .topbar h4 { font-size: 18px; }
        .content { padding: 25px; }

        /* Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
        .stat-card { padding: 20px; border-radius: 10px; }
        .stat-card .stat-icon {
            width: 50px; height: 50px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; margin-bottom: 15px;
        }
        .stat-card .stat-value { font-size: 24px; font-weight: bold; }
        .stat-card .stat-label { font-size: 13px; margin-top: 5px; }

        /* Table */
        .card { border-radius: 10px; overflow: hidden; }
        .card-header {
            padding: 15px 20px; border-bottom: 1px solid #f0f0f0;
            display: flex; justify-content: space-between; align-items: center;
        }
        .card-header h5 { font-size: 16px; }
        .card-body { padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table th { padding: 12px 15px; text-align: left; font-size: 13px; border-bottom: 1px solid #eee; }
        table td { padding: 12px 15px; font-size: 14px; }
        table tr:last-child td { border-bottom: none; }

        /* Buttons */
        .btn { padding: 8px 16px; border-radius: 6px; border: none; cursor: pointer; font-size: 13px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #2c3345; color: #fff; }
        .btn-success { background: #28a745; color: #fff; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-danger { background: #dc3545; color: #fff; }
        .btn-sm { padding: 5px 10px; font-size: 12px; }

        /* Badge */
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-info { background: #cce5ff; color: #004085; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-danger { background: #f8d7da; color: #721c24; }

        /* Form */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; transition: 0.2s; }
        .form-control:focus { outline: none; border-color: #4a9eff; }

        /* Topbar actions */
        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        .topbar-btn {
            width: 38px; height: 38px; border-radius: 10px; border: none;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 17px; transition: 0.2s; position: relative;
        }
        [data-theme="light"] .topbar-btn { background: #f0f2f5; color: #666; }
        [data-theme="light"] .topbar-btn:hover { background: #e2e5ea; }
        [data-theme="dark"] .topbar-btn { background: #2a2f38; color: #aaa; }
        [data-theme="dark"] .topbar-btn:hover { background: #353b47; }

        .admin-avatar {
            width: 36px; height: 36px; border-radius: 10px;
            background: #4a9eff; color: #fff; display: flex;
            align-items: center; justify-content: center;
            font-weight: 600; font-size: 14px;
        }

        .notif-dropdown { display: none; position: absolute; right: 0; top: 45px; width: 320px; border-radius: 12px; z-index: 100; overflow: hidden; }
        .notif-dropdown.show { display: block !important; }
        .notif-item { display: flex; gap: 12px; padding: 12px 18px; text-decoration: none; border-bottom: 1px solid #f5f5f5; transition: 0.2s; }

        @media (max-width: 768px) {
            .sidebar { width: 0; }
            .main-content { margin-left: 0; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

    
    <?php
        $newOrderCount = \App\Models\Order::where('status', 0)->count();
        $unreadMsgCount = \App\Models\Message::where('is_read', 0)->count();
        $newReviewCount = \App\Models\Review::where('created_at', '>=', now()->subDays(7))->count();
        $totalNotif = $newOrderCount + $unreadMsgCount;
    ?>
    <div class="sidebar">
        <div class="sidebar-brand" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="fa-solid fa-store"></i> Fashion AI
        </div>
        <div class="sidebar-menu">
            <div class="menu-title">Tổng quan</div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>

            <div class="menu-title">Quản lý</div>
            <a href="<?php echo e(route('admin.products.index')); ?>" class="<?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-shirt"></i> Sản phẩm
            </a>
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="<?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-tags"></i> Danh mục
            </a>
            <a href="<?php echo e(route('admin.collections.index')); ?>" class="<?php echo e(request()->routeIs('admin.collections.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-layer-group"></i> Bộ sưu tập
            </a>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-bag-shopping"></i> Đơn hàng
                <?php if($newOrderCount > 0): ?>
                    <span style="margin-left: auto; background: #dc3545; color: #fff; font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: 600;"><?php echo e($newOrderCount); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="<?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-users"></i> Người dùng
            </a>
            <a href="<?php echo e(route('admin.messages.index')); ?>" class="<?php echo e(request()->routeIs('admin.messages.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-envelope"></i> Tin nhắn
                <?php if($unreadMsgCount > 0): ?>
                    <span style="margin-left: auto; background: #dc3545; color: #fff; font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: 600;"><?php echo e($unreadMsgCount); ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo e(route('admin.reviews.index')); ?>" class="<?php echo e(request()->routeIs('admin.reviews.*') ? 'active' : ''); ?>">
                <i class="fa-solid fa-star"></i> Đánh giá
                <?php if($newReviewCount > 0): ?>
                    <span style="margin-left: auto; background: #f59e0b; color: #fff; font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: 600;"><?php echo e($newReviewCount); ?></span>
                <?php endif; ?>
            </a>

            <div class="menu-title">Tài khoản</div>
            <a href="<?php echo e(route('home')); ?>" target="_blank">
                <i class="fa-solid fa-globe"></i> Xem website
            </a>
            <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" style="width:100%; background:none; border:none; cursor:pointer; display:flex; align-items:center; gap:10px; padding:12px 20px; color:#ccc; font-size:14px;">
                    <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                </button>
            </form>
        </div>
    </div>

    
    <div class="main-content">
        <div class="topbar">
            <h4><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h4>

            <div class="topbar-actions">
                
                <button class="topbar-btn" onclick="toggleTheme()" title="Đổi giao diện sáng/tối" id="theme-btn">
                    <i class="fa-solid fa-moon" id="theme-icon"></i>
                </button>

                
                <div style="position: relative;">
                    <button class="topbar-btn" onclick="document.getElementById('notif-dropdown').classList.toggle('show')">
                        <i class="fa-regular fa-bell"></i>
                        <?php if($totalNotif > 0): ?>
                            <span style="position: absolute; top: 2px; right: 2px; width: 16px; height: 16px; border-radius: 50%; background: #dc3545; color: #fff; font-size: 9px; display: flex; align-items: center; justify-content: center; font-weight: 600;"><?php echo e($totalNotif); ?></span>
                        <?php endif; ?>
                    </button>

                    <div id="notif-dropdown" class="notif-dropdown">
                        <div style="padding: 14px 18px; border-bottom: 1px solid #f0f0f0; font-weight: 600; font-size: 15px; display: flex; justify-content: space-between; align-items: center;">
                            Thông báo
                            <?php if($totalNotif > 0): ?>
                                <span style="background: #dc3545; color: #fff; font-size: 11px; padding: 2px 8px; border-radius: 10px;"><?php echo e($totalNotif); ?> mới</span>
                            <?php endif; ?>
                        </div>
                        <div style="max-height: 300px; overflow-y: auto;">
                            <?php if($newOrderCount > 0): ?>
                                <a href="<?php echo e(route('admin.orders.index')); ?>" class="notif-item" style="background: #fffbeb;">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #fee2e2; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="fa-solid fa-bag-shopping" style="color: #dc3545; font-size: 14px;"></i>
                                    </div>
                                    <div>
                                        <p style="font-size: 13px; font-weight: 500;"><?php echo e($newOrderCount); ?> đơn hàng mới</p>
                                        <p style="font-size: 12px;">Chờ xác nhận</p>
                                    </div>
                                </a>
                            <?php endif; ?>
                            <?php if($unreadMsgCount > 0): ?>
                                <a href="<?php echo e(route('admin.messages.index')); ?>" class="notif-item" style="background: #fffbeb;">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #dbeafe; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="fa-solid fa-envelope" style="color: #2563eb; font-size: 14px;"></i>
                                    </div>
                                    <div>
                                        <p style="font-size: 13px; font-weight: 500;"><?php echo e($unreadMsgCount); ?> tin nhắn chưa đọc</p>
                                        <p style="font-size: 12px;">Cần phản hồi</p>
                                    </div>
                                </a>
                            <?php endif; ?>
                            <?php if($newReviewCount > 0): ?>
                                <a href="<?php echo e(route('admin.reviews.index')); ?>" class="notif-item">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #fef3c7; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="fa-solid fa-star" style="color: #f59e0b; font-size: 14px;"></i>
                                    </div>
                                    <div>
                                        <p style="font-size: 13px; font-weight: 500;"><?php echo e($newReviewCount); ?> đánh giá mới</p>
                                        <p style="font-size: 12px;">Trong 7 ngày qua</p>
                                    </div>
                                </a>
                            <?php endif; ?>
                            <?php if($totalNotif == 0): ?>
                                <div style="padding: 30px; text-align: center; font-size: 13px;">
                                    <i class="fa-regular fa-bell-slash" style="font-size: 24px; margin-bottom: 8px; display: block; color: #ddd;"></i>
                                    Không có thông báo mới
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div style="display: flex; align-items: center; gap: 10px; margin-left: 5px;">
                    <div class="admin-avatar"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></div>
                    <span style="font-size: 14px; font-weight: 500;"><?php echo e(Auth::user()->name); ?></span>
                </div>
            </div>
        </div>

        <div class="content">
            <?php if(session('success')): ?>
                <div style="background: #d4edda; color: #155724; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px;">
                    <i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px;">
                    <i class="fa-solid fa-circle-xmark"></i> <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        // Dark/Light theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('admin-theme', next);
            updateThemeIcon(next);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('theme-icon');
            if (theme === 'dark') {
                icon.className = 'fa-solid fa-sun';
            } else {
                icon.className = 'fa-solid fa-moon';
            }
        }

        // Load saved theme
        const savedTheme = localStorage.getItem('admin-theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        updateThemeIcon(savedTheme);

        // Đóng dropdown thông báo khi click ngoài
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('notif-dropdown');
            const bell = dropdown?.parentElement;
            if (dropdown && !bell.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    </script>
</body>
</html><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>