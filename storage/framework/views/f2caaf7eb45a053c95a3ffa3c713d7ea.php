<?php
$total_items = 0;
if (Auth::check()) {
    $total_items = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
}
?>

<div class="topbar">
    <div class="container">
        <p>Miễn phí vận chuyển cho đơn hàng từ 500k • Đổi trả trong 60 ngày</p>
    </div>
</div>

<header id="header">
    <div class="container flex-between">

        <div class="logo">
            <a href="<?php echo e(route('home')); ?>">
                <h2>FASHION AI</h2>
            </a>
        </div>

        <nav class="main-menu">
            <ul id="nav">
                <li><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
                <li><a href="#">Mới</a></li>

                <li class="has-mega">
                    <a href="<?php echo e(route('home', ['cat' => 'nam'])); ?>">Nam <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i></a>
                    <div class="mega-content">
                        <ul class="sub-column">
                            <li class="column-title">ÁO NAM</li>
                            <li><a href="#">Áo thun</a></li>
                            <li><a href="#">Áo sơ mi</a></li>
                            <li><a href="#">Áo Polo</a></li>
                        </ul>
                        <ul class="sub-column">
                            <li class="column-title">QUẦN NAM</li>
                            <li><a href="#">Quần Jean</a></li>
                            <li><a href="#">Quần Short</a></li>
                            <li><a href="#">Quần dài</a></li>
                        </ul>
                        <ul class="sub-column">
                            <li class="column-title">QUẦN LÓT NAM</li>
                            <li><a href="#">Tam Giác</a></li>
                            <li><a href="#">Boxer</a></li>
                            <li><a href="#">Short ngủ</a></li>
                        </ul>
                    </div>
                </li>

                <li class="has-mega">
                    <a href="<?php echo e(route('home', ['cat' => 'nu'])); ?>">Nữ <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i></a>
                    <div class="mega-content">
                        <ul class="sub-column">
                            <li class="column-title">ÁO NỮ</li>
                            <li><a href="#">Áo thun</a></li>
                            <li><a href="#">Áo sơ mi</a></li>
                            <li><a href="#">Áo Croptop</a></li>
                        </ul>
                        <ul class="sub-column">
                            <li class="column-title">QUẦN & CHÂN VÁY</li>
                            <li><a href="#">Quần Jean</a></li>
                            <li><a href="#">Quần Legging</a></li>
                            <li><a href="#">Chân váy</a></li>
                        </ul>
                        <ul class="sub-column">
                            <li class="column-title">ĐỒ MẶC NGOÀI</li>
                            <li><a href="#">Váy liền thân</a></li>
                            <li><a href="#">Áo Blazer</a></li>
                            <li><a href="#">Đồ tập Gym</a></li>
                        </ul>
                    </div>
                </li>

                <li><a href="#" class="menu-sale">Sale</a></li>
                <li><a href="#">Bộ sưu tập</a></li>
            </ul>
        </nav>

        <div class="user-actions">
            <form action="<?php echo e(route('home')); ?>" method="GET" style="display: inline-block;">
                <input type="text" name="keyword" placeholder="Tìm sản phẩm..." style="padding: 5px; border-radius: 5px; border: 1px solid #ddd;">
                <button type="submit" style="background: none; border: none; cursor: pointer;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('account.profile')); ?>"><i class="fa-regular fa-user"></i></a>
                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none;">
                    <?php echo csrf_field(); ?>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"><i class="fa-regular fa-user"></i></a>
            <?php endif; ?>

            <a href="<?php echo e(route('cart.index')); ?>" class="cart-icon" style="position: relative;">
                <i class="fa-solid fa-bag-shopping"></i>
                <span class="cart-count"><?php echo e($total_items); ?></span>
            </a>
        </div>

    </div>
</header><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/partials/header.blade.php ENDPATH**/ ?>