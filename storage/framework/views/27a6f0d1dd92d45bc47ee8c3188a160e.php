

<?php $__env->startSection('title', 'Tài khoản - Fashion AI'); ?>

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
                    <a href="<?php echo e(route('account.profile')); ?>" class="active">
                        <i class="fa-regular fa-user"></i> Thông tin tài khoản
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('account.orders')); ?>">
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
            <h3><i class="fa-regular fa-user" style="color: #f59e0b;"></i> Thông tin tài khoản</h3>

            <?php if(session('success')): ?>
                <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('account.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="account-form-group">
                    <label>Họ tên</label>
                    <div style="position: relative;">
                        <i class="fa-regular fa-user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb;"></i>
                        <input type="text" name="name" value="<?php echo e(Auth::user()->name); ?>" required style="padding-left: 38px;">
                    </div>
                    <?php $__errorArgs = ['name'];
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

                <div class="account-form-group">
                    <label>Email</label>
                    <div style="position: relative;">
                        <i class="fa-regular fa-envelope" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb;"></i>
                        <input type="email" value="<?php echo e(Auth::user()->email); ?>" disabled style="padding-left: 38px;">
                    </div>
                </div>

                <div class="account-form-group">
                    <label>Mật khẩu mới <small style="color:#999; font-weight:normal;">(để trống nếu không đổi)</small></label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-lock" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 14px;"></i>
                        <input type="password" name="password" placeholder="Nhập mật khẩu mới" style="padding-left: 38px;">
                    </div>
                </div>

                <div class="account-form-group" style="margin-bottom: 25px;">
                    <label>Xác nhận mật khẩu mới</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-lock" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 14px;"></i>
                        <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" style="padding-left: 38px;">
                    </div>
                </div>

                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
                </button>
            </form>
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
        font-size: 18px; margin-bottom: 25px;
        display: flex; align-items: center; gap: 8px;
    }

    .account-form-group { margin-bottom: 18px; }

    .account-form-group label {
        display: block; margin-bottom: 6px;
        font-weight: 500; font-size: 14px; color: #555;
    }

    .account-form-group input {
        width: 100%; padding: 11px 12px;
        border: 1.5px solid #e5e5e5; border-radius: 8px;
        font-size: 14px; transition: 0.2s; background: #fafafa;
    }

    .account-form-group input:focus {
        outline: none; border-color: #f59e0b;
        background: #fff; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }

    .account-form-group input:disabled {
        background: #f0f0f0; color: #999; cursor: not-allowed;
    }

    .account-form-group .error-text { color: #dc2626; font-size: 12px; margin-top: 4px; }

    .btn-save {
        padding: 12px 28px; background: #f59e0b; color: #fff;
        border: none; border-radius: 8px; font-size: 14px;
        font-weight: 600; cursor: pointer; transition: 0.3s;
        display: inline-flex; align-items: center; gap: 6px;
    }

    .btn-save:hover {
        background: #d97706;
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    @media (max-width: 768px) {
        .account-grid { grid-template-columns: 1fr; }
        .account-sidebar { position: static; }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/account/profile.blade.php ENDPATH**/ ?>