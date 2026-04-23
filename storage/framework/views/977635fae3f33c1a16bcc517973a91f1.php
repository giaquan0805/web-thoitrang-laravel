

<?php $__env->startSection('title', 'Đặt hàng - Fashion AI'); ?>

<?php $__env->startSection('content'); ?>

<div class="container checkout-wrapper">

    
    <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 35px; font-size: 14px;">
        <a href="<?php echo e(route('cart.index')); ?>" style="color: #999; text-decoration: none;">
            <i class="fa-solid fa-bag-shopping"></i> Giỏ hàng
        </a>
        <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
        <span style="color: #f59e0b; font-weight: 600;">
            <i class="fa-solid fa-credit-card"></i> Thanh toán
        </span>
        <i class="fa-solid fa-chevron-right" style="font-size: 10px; color: #ccc;"></i>
        <span style="color: #ccc;">
            <i class="fa-solid fa-circle-check"></i> Hoàn tất
        </span>
    </div>

    <?php if(session('error')): ?>
        <div style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-exclamation"></i> <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="checkout-grid">

        
        <div class="checkout-form">
            <h3><i class="fa-solid fa-truck" style="color: #f59e0b;"></i> Thông tin giao hàng</h3>

            <form action="<?php echo e(route('checkout.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="checkout-form-group">
                    <label>Họ tên người nhận</label>
                    <div style="position: relative;">
                        <i class="fa-regular fa-user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb;"></i>
                        <input type="text" name="shipping_name" value="<?php echo e(Auth::user()->name); ?>" required
                               style="padding-left: 38px;">
                    </div>
                    <?php $__errorArgs = ['shipping_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error-text"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="checkout-form-group">
                    <label>Số điện thoại</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-phone" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 13px;"></i>
                        <input type="text" name="shipping_phone" placeholder="0xxx xxx xxx" required
                               style="padding-left: 38px;">
                    </div>
                    <?php $__errorArgs = ['shipping_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error-text"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="checkout-form-group">
                    <label>Địa chỉ giao hàng</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-location-dot" style="position: absolute; left: 12px; top: 14px; color: #bbb; font-size: 14px;"></i>
                        <textarea name="shipping_address" required rows="3" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố"
                                  style="padding-left: 38px;"></textarea>
                    </div>
                    <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error-text"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="payment-options">
                    <label style="margin-bottom: 12px; font-size: 15px;"><i class="fa-regular fa-credit-card" style="color: #f59e0b;"></i> Phương thức thanh toán</label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="COD" checked>
                        <div class="payment-option-content">
                            <div style="width: 36px; height: 36px; border-radius: 8px; background: #f0fdf4; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-money-bill-wave" style="color: #28a745; font-size: 14px;"></i>
                            </div>
                            <div>
                                <span style="font-weight: 500; font-size: 14px;">Thanh toán khi nhận hàng</span>
                                <span style="font-size: 12px; color: #999; display: block;">Thanh toán bằng tiền mặt khi nhận hàng (COD)</span>
                            </div>
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="banking">
                        <div class="payment-option-content">
                            <div style="width: 36px; height: 36px; border-radius: 8px; background: #fffbeb; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-building-columns" style="color: #f59e0b; font-size: 14px;"></i>
                            </div>
                            <div>
                                <span style="font-weight: 500; font-size: 14px;">Chuyển khoản ngân hàng</span>
                                <span style="font-size: 12px; color: #999; display: block;">Chuyển khoản qua tài khoản ngân hàng</span>
                            </div>
                        </div>
                    </label>
                </div>

                <button type="submit" class="btn-order">
                    <i class="fa-solid fa-lock" style="font-size: 13px;"></i> Xác nhận đặt hàng
                </button>
            </form>
        </div>

        
        <div>
            <h3 style="margin-bottom: 15px;"><i class="fa-solid fa-receipt" style="color: #f59e0b;"></i> Đơn hàng của bạn</h3>
            <div class="order-summary">

                <div style="font-size: 13px; color: #999; margin-bottom: 12px;"><?php echo e($cartItems->count()); ?> sản phẩm</div>

                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="order-item">
                    <div class="order-item-left">
                        <div style="position: relative;">
                            <img src="<?php echo e(product_image($item->variant->product->thumbnail_url)); ?>">
                            <span style="position: absolute; top: -6px; right: -6px; width: 20px; height: 20px; border-radius: 50%; background: #f59e0b; color: #fff; font-size: 11px; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                <?php echo e($item->quantity); ?>

                            </span>
                        </div>
                        <div>
                            <p><?php echo e($item->variant->product->name); ?></p>
                            <span style="background: #f0f0f0; padding: 2px 6px; border-radius: 4px; font-size: 11px;">
                                <?php echo e($item->variant->size); ?> / <?php echo e($item->variant->color); ?>

                            </span>
                        </div>
                    </div>
                    <span style="font-weight: 500; white-space: nowrap;"><?php echo e(number_format($item->variant->product->price * $item->quantity, 0, ',', '.')); ?>đ</span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div style="border-top: 1px solid #eee; margin-top: 15px; padding-top: 15px;">
                    <div class="order-total-row">
                        <span style="color: #666;">Tạm tính:</span>
                        <span><?php echo e(number_format($total, 0, ',', '.')); ?>đ</span>
                    </div>
                    <div class="order-total-row">
                        <span style="color: #666;">Phí vận chuyển:</span>
                        <span class="free"><i class="fa-solid fa-check" style="font-size: 11px;"></i> Miễn phí</span>
                    </div>
                </div>

                <div style="border-top: 2px solid #f59e0b; margin-top: 12px; padding-top: 12px;">
                    <div class="order-total-row final">
                        <span>Tổng cộng:</span>
                        <span style="color: #f59e0b;"><?php echo e(number_format($total, 0, ',', '.')); ?>đ</span>
                    </div>
                </div>
            </div>

            
            <div style="margin-top: 15px; display: flex; align-items: center; gap: 8px; justify-content: center; color: #999; font-size: 12px;">
                <i class="fa-solid fa-shield-halved" style="color: #f59e0b;"></i>
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .checkout-wrapper { padding: 30px 15px 50px; }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 35px;
    }

    .checkout-form h3 {
        margin-bottom: 22px; font-size: 18px;
        display: flex; align-items: center; gap: 8px;
    }

    .checkout-form-group { margin-bottom: 18px; }

    .checkout-form-group label {
        display: block; margin-bottom: 6px;
        font-weight: 500; font-size: 14px; color: #555;
    }

    .checkout-form-group input,
    .checkout-form-group textarea {
        width: 100%; padding: 11px 12px;
        border: 1.5px solid #e5e5e5; border-radius: 8px;
        font-size: 14px; transition: all 0.2s;
        background: #fafafa;
    }

    .checkout-form-group input:focus,
    .checkout-form-group textarea:focus {
        outline: none; border-color: #f59e0b;
        background: #fff; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .checkout-form-group .error-text {
        color: #dc2626; font-size: 12px; margin-top: 4px;
    }

    .payment-options { margin-bottom: 25px; }

    .payment-option {
        display: flex; align-items: center; gap: 12px;
        cursor: pointer; padding: 12px 14px;
        border: 1.5px solid #e5e5e5; border-radius: 10px;
        margin-bottom: 10px; transition: all 0.2s;
    }

    .payment-option:has(input:checked) {
        border-color: #f59e0b;
        background: #fffbeb;
    }

    .payment-option input[type="radio"] {
        accent-color: #f59e0b; width: 16px; height: 16px;
        flex-shrink: 0;
    }

    .payment-option-content {
        display: flex; align-items: center; gap: 12px;
    }

    .btn-order {
        width: 100%; padding: 14px;
        background: #f59e0b; color: #fff;
        border: none; border-radius: 10px;
        font-size: 15px; font-weight: 600;
        cursor: pointer; transition: all 0.3s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    .btn-order:hover {
        background: #d97706;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .order-summary {
        background: #fafafa; padding: 22px;
        border-radius: 12px; border: 1px solid #f0f0f0;
    }

    .order-item {
        display: flex; justify-content: space-between;
        align-items: center; padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .order-item:last-of-type { border-bottom: none; }

    .order-item-left {
        display: flex; gap: 12px; align-items: center;
    }

    .order-item-left img {
        width: 55px; height: 55px;
        object-fit: cover; border-radius: 8px;
        border: 1px solid #eee;
    }

    .order-item-left p {
        font-size: 14px; font-weight: 500; margin-bottom: 4px;
    }

    .order-total-row {
        display: flex; justify-content: space-between;
        margin-bottom: 6px; font-size: 14px;
    }

    .order-total-row.final {
        font-weight: 700; font-size: 18px;
        margin-bottom: 0;
    }

    .order-total-row .free {
        color: #28a745; font-weight: 500;
    }

    @media (max-width: 768px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/checkout/index.blade.php ENDPATH**/ ?>