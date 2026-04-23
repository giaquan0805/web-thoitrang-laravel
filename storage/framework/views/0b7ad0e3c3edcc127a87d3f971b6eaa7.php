

<?php $__env->startSection('title', 'Giỏ hàng - Fashion AI'); ?>

<?php $__env->startSection('content'); ?>

<div class="container cart-wrapper">

    
    <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 35px; font-size: 14px;">
        <span style="color: #f59e0b; font-weight: 600;">
            <i class="fa-solid fa-bag-shopping"></i> Giỏ hàng
        </span>
        <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
        <span style="color: #ccc;">
            <i class="fa-solid fa-credit-card"></i> Thanh toán
        </span>
        <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
        <span style="color: #ccc;">
            <i class="fa-solid fa-circle-check"></i> Hoàn tất
        </span>
    </div>

    <?php if(session('success')): ?>
        <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-exclamation"></i> <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($cartItems->isEmpty()): ?>
        <div style="text-align: center; padding: 80px 0;">
            <div style="width: 80px; height: 80px; margin: 0 auto 20px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-bag-shopping" style="font-size: 30px; color: #ccc;"></i>
            </div>
            <p style="font-size: 18px; color: #666; margin-bottom: 8px;">Giỏ hàng của bạn đang trống</p>
            <p style="font-size: 14px; color: #999; margin-bottom: 25px;">Hãy khám phá các sản phẩm thời trang mới nhất!</p>
            <a href="<?php echo e(route('home')); ?>" style="display: inline-block; padding: 12px 30px; background: #f59e0b; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 500; transition: 0.3s;">
                <i class="fa-solid fa-arrow-left" style="font-size: 12px;"></i> Tiếp tục mua sắm
            </a>
        </div>
    <?php else: ?>
        <div class="cart-grid">

            
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3 style="font-size: 16px; color: #333;">
                        <i class="fa-solid fa-bag-shopping" style="color: #f59e0b;"></i>
                        <?php echo e($cartItems->count()); ?> sản phẩm trong giỏ
                    </h3>
                </div>

                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="cart-item">

                    <a href="<?php echo e(route('product.show', $item->variant->product->id)); ?>">
                        <img src="<?php echo e(product_image($item->variant->product->thumbnail_url)); ?>"
                             alt="<?php echo e($item->variant->product->name); ?>">
                    </a>

                    <div class="cart-item-info">
                        <h3>
                            <a href="<?php echo e(route('product.show', $item->variant->product->id)); ?>" style="color: #333; text-decoration: none;">
                                <?php echo e($item->variant->product->name); ?>

                            </a>
                        </h3>
                        <p style="margin-top: 4px;">
                            <span style="background: #f0f0f0; padding: 2px 8px; border-radius: 4px; font-size: 12px;">
                                <?php echo e($item->variant->size); ?> / <?php echo e($item->variant->color); ?>

                            </span>
                        </p>
                        <p class="cart-item-price" style="color: #f59e0b;"><?php echo e(number_format($item->variant->product->price, 0, ',', '.')); ?>đ</p>
                    </div>

                    <div class="cart-qty">
                        <form action="<?php echo e(route('cart.update')); ?>" method="POST" style="display: flex; align-items: center; gap: 0;">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="cart_id" value="<?php echo e($item->id); ?>">
                            <button type="submit" name="action" value="decrease" style="border-radius: 6px 0 0 6px;">-</button>
                            <span><?php echo e($item->quantity); ?></span>
                            <button type="submit" name="action" value="increase" style="border-radius: 0 6px 6px 0;">+</button>
                        </form>
                    </div>

                    <div class="cart-item-total">
                        <p style="font-size: 16px;"><?php echo e(number_format($item->variant->product->price * $item->quantity, 0, ',', '.')); ?>đ</p>
                        <form action="<?php echo e(route('cart.remove')); ?>" method="POST" style="margin-top: 8px;">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="cart_id" value="<?php echo e($item->id); ?>">
                            <button type="submit" class="btn-remove" onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                <i class="fa-regular fa-trash-can"></i> Xóa
                            </button>
                        </form>
                    </div>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div>
                <div class="cart-summary">
                    <h3 style="font-size: 16px; margin-bottom: 20px;">
                        <i class="fa-solid fa-receipt" style="color: #f59e0b;"></i> Tóm tắt đơn hàng
                    </h3>

                    <div class="cart-summary-row">
                        <span style="color: #666;">Tạm tính (<?php echo e($cartItems->sum('quantity')); ?> sản phẩm):</span>
                        <span><?php echo e(number_format($total, 0, ',', '.')); ?>đ</span>
                    </div>

                    <div class="cart-summary-row">
                        <span style="color: #666;">Phí vận chuyển:</span>
                        <span class="free"><i class="fa-solid fa-check" style="font-size: 11px;"></i> Miễn phí</span>
                    </div>

                    <div style="border-top: 2px solid #f59e0b; margin: 15px 0; padding-top: 15px;">
                        <div class="cart-summary-row total">
                            <span>Tổng cộng:</span>
                            <span style="color: #f59e0b;"><?php echo e(number_format($total, 0, ',', '.')); ?>đ</span>
                        </div>
                    </div>

                    <a href="<?php echo e(route('checkout.index')); ?>" class="btn-checkout">
                        <i class="fa-solid fa-lock" style="font-size: 13px;"></i> Tiến hành đặt hàng
                    </a>

                    <a href="<?php echo e(route('home')); ?>" class="btn-continue">
                        <i class="fa-solid fa-arrow-left" style="font-size: 12px;"></i> Tiếp tục mua sắm
                    </a>

                    
                    <div style="margin-top: 15px; display: flex; align-items: center; gap: 6px; justify-content: center; color: #999; font-size: 12px;">
                        <i class="fa-solid fa-shield-halved" style="color: #f59e0b;"></i>
                    </div>
                </div>
            </div>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .cart-wrapper { padding: 30px 15px 50px; }

    .cart-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 35px;
    }

    .cart-item {
        display: flex; gap: 16px;
        padding: 18px 0; border-bottom: 1px solid #f0f0f0;
        align-items: center;
    }

    .cart-item img {
        width: 90px; height: 90px;
        object-fit: cover; border-radius: 8px;
        border: 1px solid #eee;
    }

    .cart-item-info { flex: 1; }

    .cart-item-info h3 {
        font-size: 15px; margin-bottom: 2px;
    }

    .cart-item-price {
        font-weight: 600; margin-top: 8px; font-size: 15px;
    }

    .cart-qty form {
        display: flex; align-items: center;
    }

    .cart-qty button {
        width: 32px; height: 32px;
        border: 1.5px solid #e5e5e5; background: #fff;
        cursor: pointer; font-size: 15px;
        transition: 0.2s; color: #555;
    }

    .cart-qty button:hover {
        background: #f59e0b; color: #fff; border-color: #f59e0b;
    }

    .cart-qty span {
        padding: 5px 14px;
        border-top: 1.5px solid #e5e5e5;
        border-bottom: 1.5px solid #e5e5e5;
        min-width: 42px; text-align: center;
        font-weight: 500; font-size: 14px;
    }

    .cart-item-total { text-align: right; min-width: 110px; }

    .cart-item-total p { font-weight: 600; color: #333; }

    .btn-remove {
        background: none; border: none;
        color: #999; cursor: pointer;
        font-size: 13px; transition: 0.2s;
        padding: 4px 0;
    }

    .btn-remove:hover { color: #dc3545; }

    .cart-summary {
        background: #fafafa; padding: 25px;
        border-radius: 12px; border: 1px solid #f0f0f0;
        position: sticky; top: 80px;
    }

    .cart-summary-row {
        display: flex; justify-content: space-between;
        margin-bottom: 10px; font-size: 14px;
    }

    .cart-summary-row.total {
        font-weight: 700; font-size: 18px;
        margin-bottom: 0;
    }

    .cart-summary-row .free {
        color: #28a745; font-weight: 500;
    }

    .btn-checkout {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 14px;
        background: #f59e0b; color: #fff;
        border-radius: 10px; text-decoration: none;
        font-size: 15px; font-weight: 600;
        margin-top: 20px; transition: 0.3s;
    }

    .btn-checkout:hover {
        background: #d97706;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .btn-continue {
        display: flex; align-items: center; justify-content: center; gap: 6px;
        width: 100%; padding: 12px;
        background: #fff; color: #666;
        border: 1.5px solid #e5e5e5; border-radius: 10px;
        text-decoration: none; font-size: 14px;
        margin-top: 10px; transition: 0.2s;
    }

    .btn-continue:hover {
        border-color: #f59e0b; color: #f59e0b;
    }

    @media (max-width: 768px) {
        .cart-grid { grid-template-columns: 1fr; }
        .cart-item { flex-wrap: wrap; }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/cart/index.blade.php ENDPATH**/ ?>