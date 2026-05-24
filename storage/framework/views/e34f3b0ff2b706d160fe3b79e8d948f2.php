

<?php $__env->startSection('title', 'Quản lý bộ sưu tập'); ?>
<?php $__env->startSection('page-title', 'Quản lý bộ sưu tập'); ?>

<?php $__env->startSection('content'); ?>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 25px;">
    <div class="stat-card">
        <div style="font-size: 13px; color: #999;">Tổng bộ sưu tập</div>
        <div style="font-size: 24px; font-weight: 700; margin-top: 5px;"><?php echo e($collections->total()); ?></div>
    </div>
    <div class="stat-card">
        <div style="font-size: 13px; color: #999;">Đang hoạt động</div>
        <div style="font-size: 24px; font-weight: 700; color: #28a745; margin-top: 5px;"><?php echo e($collections->where('status', 1)->count()); ?></div>
    </div>
    <div class="stat-card">
        <div style="font-size: 13px; color: #999;">Bản nháp</div>
        <div style="font-size: 24px; font-weight: 700; color: #999; margin-top: 5px;"><?php echo e($collections->where('status', 0)->count()); ?></div>
    </div>
    <div class="stat-card">
        <div style="font-size: 13px; color: #999;">Tổng sản phẩm</div>
        <div style="font-size: 24px; font-weight: 700; color: #1976d2; margin-top: 5px;"><?php echo e($collections->sum('products_count')); ?></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-layer-group" style="color: #7b1fa2;"></i> Bộ sưu tập</h5>
        <a href="<?php echo e(route('admin.collections.create')); ?>" class="btn btn-success">
            <i class="fa-solid fa-plus"></i> Tạo bộ sưu tập
        </a>
    </div>
    <div class="card-body">

        <form action="<?php echo e(route('admin.collections.index')); ?>" method="GET" style="display: flex; gap: 10px; margin-bottom: 20px;">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm bộ sưu tập..." value="<?php echo e(request('keyword')); ?>" style="max-width: 300px;">
            <select name="status" class="form-control" style="max-width: 180px;">
                <option value="">Tất cả trạng thái</option>
                <option value="1" <?php echo e(request('status') === '1' ? 'selected' : ''); ?>>Đang hoạt động</option>
                <option value="0" <?php echo e(request('status') === '0' ? 'selected' : ''); ?>>Bản nháp</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i> Tìm</button>
        </form>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
            <?php $__empty_1 = true; $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div style="border: 1px solid #f0f0f0; border-radius: 12px; overflow: hidden;">
                <div style="height: 160px; overflow: hidden; background: #f5f5f5;">
                    <?php if($col->banner_url): ?>
                        <img src="<?php echo e(asset('storage/' . $col->banner_url)); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: #ccc;">
                            <i class="fa-solid fa-image" style="font-size: 40px;"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div style="padding: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <h4 style="font-size: 16px; font-weight: 600;"><?php echo e($col->name); ?></h4>
                        <?php if($col->status): ?>
                            <span style="padding: 3px 10px; border-radius: 12px; font-size: 11px; background: #d4edda; color: #155724;">Hoạt động</span>
                        <?php else: ?>
                            <span style="padding: 3px 10px; border-radius: 12px; font-size: 11px; background: #e2e3e5; color: #383d41;">Nháp</span>
                        <?php endif; ?>
                    </div>
                    <p style="color: #999; font-size: 13px; margin-bottom: 12px;"><?php echo e($col->products_count); ?> sản phẩm · <?php echo e($col->created_at->format('d/m/Y')); ?></p>
                    <div style="display: flex; gap: 8px;">
                        <a href="<?php echo e(route('admin.collections.edit', $col->id)); ?>" class="btn btn-sm btn-primary" style="flex: 1; text-align: center;">
                            <i class="fa-solid fa-pen"></i> Sửa
                        </a>
                        <form action="<?php echo e(route('admin.collections.destroy', $col->id)); ?>" method="POST" onsubmit="return confirm('Xóa bộ sưu tập này?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p style="grid-column: 1/-1; text-align: center; padding: 40px; color: #999;">Chưa có bộ sưu tập nào.</p>
            <?php endif; ?>
        </div>

        <div style="margin-top: 15px;"><?php echo e($collections->appends(request()->query())->links()); ?></div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/admin/collections/index.blade.php ENDPATH**/ ?>