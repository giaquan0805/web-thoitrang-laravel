

<?php $__env->startSection('title', 'Lịch sử đơn hàng - Fashion AI'); ?>

<?php $__env->startSection('content'); ?>

<div class="container account-wrapper">
    <div class="account-grid">

        
        <div class="account-sidebar">
            <div class="account-avatar">
                <div class="account-avatar-circle" style="background: #f59e0b;">
                    <span><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></span>
                </div>
                <p><?php echo e(Auth::user()->name); ?></p>
                <small><?php echo e(Auth::user()->email); ?></small>
            </div>

            <ul class="account-menu">
                <li>
                    <a href="<?php echo e(route('account.profile')); ?>">
                        <i class="fa-regular fa-user"></i> Thông tin tài khoản
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('account.orders')); ?>" class="active">
                        <i class="fa-solid fa-bag-shopping"></i> Lịch sử đơn hàng
                    </a>
                </li>
                <li>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-logout">
                            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        
        <div class="account-content">
            <h3><i class="fa-solid fa-bag-shopping" style="color: #f59e0b;"></i> Lịch sử đơn hàng</h3>

            <?php if($orders->isEmpty()): ?>
                <div style="text-align: center; padding: 50px 0;">
                    <div style="width: 70px; height: 70px; margin: 0 auto 15px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-bag-shopping" style="font-size: 26px; color: #ccc;"></i>
                    </div>
                    <p style="color: #666; margin-bottom: 6px;">Bạn chưa có đơn hàng nào</p>
                    <p style="color: #999; font-size: 13px; margin-bottom: 20px;">Hãy khám phá các sản phẩm thời trang!</p>
                    <a href="<?php echo e(route('home')); ?>" style="display: inline-block; padding: 10px 24px; background: #f59e0b; color: #fff; border-radius: 8px; text-decoration: none; font-size: 14px;">
                        Mua sắm ngay
                    </a>
                </div>
            <?php else: ?>
                <div style="font-size: 13px; color: #999; margin-bottom: 15px;"><?php echo e($orders->count()); ?> đơn hàng</div>

                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $statusConfig = [
                        0 => ['label' => 'Chờ xác nhận', 'icon' => 'fa-clock', 'bg' => '#fff3cd', 'color' => '#856404'],
                        1 => ['label' => 'Đang giao', 'icon' => 'fa-truck', 'bg' => '#cce5ff', 'color' => '#004085'],
                        2 => ['label' => 'Hoàn thành', 'icon' => 'fa-circle-check', 'bg' => '#d4edda', 'color' => '#155724'],
                        3 => ['label' => 'Đã hủy', 'icon' => 'fa-circle-xmark', 'bg' => '#f8d7da', 'color' => '#721c24'],
                    ];
                    $status = $statusConfig[$order->status];
                ?>
                <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; margin-bottom: 16px; overflow: hidden;">

                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; border-bottom: 1px solid #f5f5f5; background: #fafafa;">
                        <div>
                            <span style="font-weight: 600; font-size: 15px; color: #333;">Đơn hàng #<?php echo e($order->id); ?></span>
                            <span style="color: #999; font-size: 13px; margin-left: 10px;">
                                <i class="fa-regular fa-clock" style="font-size: 11px;"></i>
                                <?php echo e(\Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i')); ?>

                            </span>
                        </div>
                        <span style="padding: 5px 14px; border-radius: 20px; font-size: 13px; font-weight: 500;
                            background: <?php echo e($status['bg']); ?>; color: <?php echo e($status['color']); ?>; display: flex; align-items: center; gap: 5px;">
                            <i class="fa-solid <?php echo e($status['icon']); ?>" style="font-size: 11px;"></i>
                            <?php echo e($status['label']); ?>

                        </span>
                    </div>

                    
                    <div style="padding: 12px 20px;">
                        <?php $__currentLoopData = $order->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; <?php echo e(!$loop->last ? 'border-bottom: 1px solid #f5f5f5;' : ''); ?>">
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <img src="<?php echo e(product_image($detail->variant->product->thumbnail_url)); ?>"
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #eee;">
                                <div>
                                    <p style="font-size: 14px; font-weight: 500; margin-bottom: 3px;"><?php echo e($detail->variant->product->name); ?></p>
                                    <span style="background: #f0f0f0; padding: 2px 6px; border-radius: 4px; font-size: 11px; color: #666;">
                                        <?php echo e($detail->variant->size); ?> / <?php echo e($detail->variant->color); ?>

                                    </span>
                                    <span style="color: #999; font-size: 12px; margin-left: 6px;">x<?php echo e($detail->quantity); ?></span>
                                </div>
                            </div>
                            <span style="font-weight: 500; font-size: 14px;"><?php echo e(number_format($detail->price * $detail->quantity, 0, ',', '.')); ?>đ</span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; border-top: 1px solid #f0f0f0; background: #fafafa;">
                        <span style="font-size: 13px; color: #666; display: flex; align-items: center; gap: 6px;">
                            <?php if($order->payment_method === 'COD'): ?>
                                <i class="fa-solid fa-money-bill-wave" style="color: #28a745;"></i> Thanh toán khi nhận hàng
                            <?php else: ?>
                                <i class="fa-solid fa-building-columns" style="color: #f59e0b;"></i> Chuyển khoản
                            <?php endif; ?>
                        </span>
                        <span style="font-weight: 700; font-size: 16px; color: #f59e0b;">
                            Tổng: <?php echo e(number_format($order->total_price, 0, ',', '.')); ?>đ
                        </span>
                    </div>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .account-wrapper { padding: 40px 15px 60px; }

    .account-grid {
        display: grid; grid-template-columns: 280px 1fr; gap: 30px;
    }

    .account-sidebar {
        background: #fff; border-radius: 12px;
        border: 1px solid #f0f0f0; padding: 25px;
        height: fit-content; position: sticky; top: 80px;
    }

    .account-avatar { text-align: center; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f0; }

    .account-avatar-circle {
        width: 65px; height: 65px; border-radius: 50%;
        background: #f59e0b; display: flex; align-items: center;
        justify-content: center; margin: 0 auto 12px;
    }

    .account-avatar-circle span { color: #fff; font-size: 24px; font-weight: 700; }

    .account-avatar p { font-weight: 600; font-size: 16px; color: #333; }
    .account-avatar small { color: #999; font-size: 13px; }

    .account-menu { list-style: none; }
    .account-menu li { margin-bottom: 4px; }

    .account-menu a {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px; border-radius: 8px;
        color: #666; text-decoration: none;
        font-size: 14px; transition: 0.2s;
    }

    .account-menu a:hover { background: #f5f5f5; color: #333; }
    .account-menu a.active { background: #fffbeb; color: #f59e0b; font-weight: 500; }

    .btn-logout {
        display: flex; align-items: center; gap: 10px;
        width: 100%; padding: 10px 14px; border-radius: 8px;
        background: none; border: none; color: #999;
        cursor: pointer; font-size: 14px; transition: 0.2s;
        text-align: left;
    }
    .btn-logout:hover { background: #fef2f2; color: #dc3545; }

    .account-content {
        background: #fff; border-radius: 12px;
        border: 1px solid #f0f0f0; padding: 30px;
    }

    .account-content h3 {
        font-size: 18px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 8px;
    }

    @media (max-width: 768px) {
        .account-grid { grid-template-columns: 1fr; }
        .account-sidebar { position: static; }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/account/orders.blade.php ENDPATH**/ ?>