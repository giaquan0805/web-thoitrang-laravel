

<?php $__env->startSection('title', $collection->name . ' - Fashion AI'); ?>

<?php $__env->startSection('content'); ?>


<?php if($collection->banner_url): ?>
<section style="width: 100%; overflow: hidden;">
    <img src="<?php echo e(asset('storage/' . $collection->banner_url)); ?>" alt="<?php echo e($collection->name); ?>"
         style="width: 100%; display: block;">
</section>
<?php endif; ?>


<div class="container" style="padding: 40px 15px 60px;">

    <?php if(!$collection->banner_url): ?>
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 8px;"><?php echo e($collection->name); ?></h1>
        <?php if($collection->description): ?>
            <p style="color: #666; font-size: 14px;"><?php echo e($collection->description); ?></p>
        <?php endif; ?>
        <p style="color: #999; font-size: 13px; margin-top: 6px;"><?php echo e($collection->products->count()); ?> sản phẩm</p>
    </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
        <?php $__empty_1 = true; $__currentLoopData = $collection->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="product-card">
                <span class="product-tag"><?php echo e($item->tag); ?></span>
                <a href="<?php echo e(route('product.show', $item->id)); ?>">
                    <img src="<?php echo e(product_image($item->thumbnail_url)); ?>" alt="<?php echo e($item->name); ?>">
                </a>
                <div class="product-info">
                    <h3 class="product-name">
                        <a href="<?php echo e(route('product.show', $item->id)); ?>"><?php echo e($item->name); ?></a>
                    </h3>
                    <p class="product-price"><?php echo e(number_format($item->price, 0, ',', '.')); ?>đ</p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p style="text-align: center; grid-column: 1/-1; padding: 40px 0; color: #999;">Bộ sưu tập chưa có sản phẩm nào.</p>
        <?php endif; ?>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="<?php echo e(route('collections.index')); ?>" style="color: #999; font-size: 14px; text-decoration: none;">
            <i class="fa-solid fa-arrow-left"></i> Xem tất cả bộ sưu tập
        </a>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/collections/show.blade.php ENDPATH**/ ?>