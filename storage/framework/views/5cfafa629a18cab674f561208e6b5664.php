<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - Fashion AI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #111; }
        .auth-backdrop { position: fixed; inset: 0; z-index: 0; background: url('<?php echo e(asset("images/banners/hero-banner.jpg")); ?>') center/cover no-repeat; filter: blur(6px) brightness(0.5); transform: scale(1.1); }
        .auth-card { position: relative; z-index: 1; width: 460px; max-width: 95vw; background: #fff; border-radius: 16px; box-shadow: 0 25px 60px rgba(0,0,0,0.4); overflow: hidden; padding: 50px 45px; }
        .form-logo { font-family: 'Playfair Display', serif; font-size: 18px; color: #333; letter-spacing: 4px; text-align: center; margin-bottom: 30px; text-transform: uppercase; }
        .form-header { text-align: center; margin-bottom: 25px; }
        .form-header h2 { font-family: 'Playfair Display', serif; font-size: 22px; color: #333; margin-bottom: 8px; }
        .form-header p { color: #999; font-size: 13px; line-height: 1.5; }
        .auth-alert { padding: 10px 14px; border-radius: 8px; margin-bottom: 18px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .auth-alert.error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .auth-alert.success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .form-field { margin-bottom: 18px; }
        .form-field label { display: block; margin-bottom: 6px; font-weight: 500; font-size: 13px; color: #555; }
        .form-field .input-wrap { position: relative; display: flex; align-items: center; }
        .form-field .input-wrap i { position: absolute; left: 14px; color: #ccc; font-size: 15px; }
        .form-field input { width: 100%; padding: 13px 14px 13px 42px; border: 1px solid #e8e8e8; border-radius: 8px; font-size: 14px; transition: all 0.2s; background: #fafafa; color: #333; }
        .form-field input:focus { outline: none; border-color: #d4a574; background: #fff; box-shadow: 0 0 0 3px rgba(212,165,116,0.1); }
        .form-field .error-text { color: #dc2626; font-size: 12px; margin-top: 4px; }
        .form-submit { width: 100%; padding: 13px; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; background: #222; color: #fff; transition: all 0.3s; letter-spacing: 0.5px; }
        .form-submit:hover { background: #444; transform: translateY(-1px); box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .form-switch { text-align: center; font-size: 13px; color: #999; margin-top: 20px; }
        .form-switch a { color: #333; font-weight: 600; text-decoration: none; }
        .form-switch a:hover { text-decoration: underline; }
        .btn-back { position: absolute; top: 20px; right: 20px; z-index: 2; width: 36px; height: 36px; border-radius: 50%; background: rgba(0,0,0,0.05); border: none; color: #999; font-size: 14px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.2s; }
        .btn-back:hover { background: rgba(0,0,0,0.1); color: #333; }
    </style>
</head>
<body>
<div class="auth-backdrop"></div>
<div class="auth-card" style="position: relative;">

    <a href="<?php echo e(route('login')); ?>" class="btn-back"><i class="fa-solid fa-xmark"></i></a>

    <div class="form-logo">FASHION AI</div>

    <div class="form-header">
        <h2>Quên mật khẩu?</h2>
        <p>Nhập email của bạn, chúng tôi sẽ gửi mã xác nhận để đặt lại mật khẩu.</p>
    </div>

    <?php if(session('error')): ?>
        <div class="auth-alert error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="auth-alert success"><i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <form action="<?php echo e(route('password.sendOtp')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-field">
            <label>Email</label>
            <div class="input-wrap">
                <i class="fa-regular fa-envelope"></i>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Nhập email của bạn" required>
            </div>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span class="error-text"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button type="submit" class="form-submit"><i class="fa-solid fa-paper-plane"></i> Gửi mã xác nhận</button>
    </form>

    <p class="form-switch"><a href="<?php echo e(route('login')); ?>"><i class="fa-solid fa-arrow-left"></i> Quay lại đăng nhập</a></p>
</div>
</body>
</html><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>