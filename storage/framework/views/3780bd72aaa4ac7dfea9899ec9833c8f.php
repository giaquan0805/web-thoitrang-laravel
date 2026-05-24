

<?php $__env->startSection('title', 'Bộ sưu tập - Fashion AI'); ?>

<?php $__env->startSection('content'); ?>

<div class="container" style="padding: 40px 15px 60px;">

    <div style="text-align: center; margin-bottom: 40px;">
        <h2 style="font-size: 28px; font-weight: 700; margin-bottom: 8px;">Bộ Sưu Tập</h2>
        <p style="color: #999; font-size: 14px;">Khám phá các bộ sưu tập thời trang được tuyển chọn</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px;">
        <?php $__empty_1 = true; $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('collections.show', $col->id)); ?>" style="text-decoration: none; color: #333;">
            <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08); transition: all 0.3s; background: #fff;">
                <div style="height: 220px; overflow: hidden; position: relative;">
                    <?php if($col->banner_url): ?>
                        <img src="<?php echo e(asset('storage/' . $col->banner_url)); ?>" alt="<?php echo e($col->name); ?>"
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                    <?php else: ?>
                        <div style="height: 100%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-layer-group" style="font-size: 40px; color: rgba(255,255,255,0.5);"></i>
                        </div>
                    <?php endif; ?>
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.6)); padding: 20px 15px 15px;">
                        <h3 style="color: #fff; font-size: 20px; font-weight: 600;"><?php echo e($col->name); ?></h3>
                        <p style="color: rgba(255,255,255,0.8); font-size: 13px;"><?php echo e($col->products_count); ?> sản phẩm</p>
                    </div>
                </div>
                <?php if($col->description): ?>
                <div style="padding: 15px;">
                    <p style="color: #666; font-size: 13px; line-height: 1.5;"><?php echo e(\Illuminate\Support\Str::limit($col->description, 100)); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 60px 0;">
            <i class="fa-solid fa-layer-group" style="font-size: 40px; color: #ddd; margin-bottom: 15px; display: block;"></i>
            <p style="color: #999; font-size: 16px;">Chưa có bộ sưu tập nào.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .container > div:last-child > a > div:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    .container > div:last-child > a > div:hover img {
        transform: scale(1.05);
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/collections/index.blade.php ENDPATH**/ ?>