

<?php $__env->startSection('title', 'Quản lý sản phẩm'); ?>
<?php $__env->startSection('page-title', 'Quản lý sản phẩm'); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-box-open" style="color: #1976d2;"></i> Danh sách sản phẩm</h5>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">+ Thêm sản phẩm</a>
    </div>

    
    <div style="padding: 15px 20px; border-bottom: 1px solid #f0f0f0; background: #fafafa;">
        <form action="<?php echo e(route('admin.products.index')); ?>" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên sản phẩm..."
                   value="<?php echo e(request('keyword')); ?>" style="width: 250px; padding: 8px 12px;">

            <select name="category" class="form-control" style="width: 160px; padding: 8px 12px;">
                <option value="">-- Danh mục --</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                        <?php echo e($cat->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="tag" class="form-control" style="width: 140px; padding: 8px 12px;">
                <option value="">-- Tag --</option>
                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tag); ?>" <?php echo e(request('tag') == $tag ? 'selected' : ''); ?>>
                        <?php echo e($tag); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">
                <i class="fa-solid fa-magnifying-glass"></i> Tìm
            </button>

            <?php if(request('keyword') || request('category') || request('tag')): ?>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn" style="background: #eee; color: #333; padding: 8px 16px;">
                    <i class="fa-solid fa-xmark"></i> Xóa lọc
                </a>
            <?php endif; ?>

            <span style="margin-left: auto; font-size: 13px; color: #999;">
                Tìm thấy <?php echo e($products->total()); ?> sản phẩm
            </span>
        </form>
    </div>

    <div class="card-body" style="padding: 0;">
        <table>
            <thead>
                <tr>
                    <th>
                        <a href="<?php echo e(route('admin.products.index', array_merge(request()->query(), ['sort' => 'id', 'dir' => request('sort') == 'id' && request('dir') == 'desc' ? 'asc' : 'desc']))); ?>"
                           style="text-decoration: none; color: #666;">
                            # <?php echo request('sort') == 'id' ? (request('dir') == 'asc' ? '&#9650;' : '&#9660;') : ''; ?>

                        </a>
                    </th>
                    <th>Ảnh</th>
                    <th>
                        <a href="<?php echo e(route('admin.products.index', array_merge(request()->query(), ['sort' => 'name', 'dir' => request('sort') == 'name' && request('dir') == 'asc' ? 'desc' : 'asc']))); ?>"
                           style="text-decoration: none; color: #666;">
                            Tên sản phẩm <?php echo request('sort') == 'name' ? (request('dir') == 'asc' ? '&#9650;' : '&#9660;') : ''; ?>

                        </a>
                    </th>
                    <th>Danh mục</th>
                    <th>
                        <a href="<?php echo e(route('admin.products.index', array_merge(request()->query(), ['sort' => 'price', 'dir' => request('sort') == 'price' && request('dir') == 'desc' ? 'asc' : 'desc']))); ?>"
                           style="text-decoration: none; color: #666;">
                            Giá <?php echo request('sort') == 'price' ? (request('dir') == 'asc' ? '&#9650;' : '&#9660;') : ''; ?>

                        </a>
                    </th>
                    <th>Tồn kho</th>
                    <th>Tag</th>
                    <th style="text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $totalStock = $product->variants->sum('stock_quantity');
                ?>
                <tr>
                    <td><?php echo e($product->id); ?></td>
                    <td>
                        <img src="<?php echo e($product->thumbnail_url && file_exists(public_path('storage/'.$product->thumbnail_url)) ? asset('storage/'.$product->thumbnail_url) : asset($product->thumbnail_url)); ?>"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                    </td>
                    <td style="font-weight: 500;"><?php echo e($product->name); ?></td>
                    <td><?php echo e($product->category->name ?? 'N/A'); ?></td>
                    <td><?php echo e(number_format($product->price, 0, ',', '.')); ?>đ</td>
                    <td>
                        <?php if($product->variants->count() == 0): ?>
                            <span style="color: #999; font-size: 12px;">Chưa có</span>
                        <?php elseif($totalStock == 0): ?>
                            <span style="color: #dc3545; font-weight: 500;">Hết hàng</span>
                        <?php elseif($totalStock <= 5): ?>
                            <span style="color: #f57c00; font-weight: 500;"><?php echo e($totalStock); ?> <span style="font-size: 11px; color: #999;">(sắp hết)</span></span>
                        <?php else: ?>
                            <span style="color: #28a745; font-weight: 500;"><?php echo e($totalStock); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                            $tagColors = [
                                'Mới' => 'badge-info',
                                'Sale' => 'badge-danger',
                                'Bán chạy' => 'badge-success',
                                'Hot' => 'badge-warning',
                            ];
                            $badgeClass = $tagColors[$product->tag] ?? 'badge-info';
                        ?>
                        <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($product->tag); ?></span>
                    </td>
                    <td style="text-align: center; white-space: nowrap;">
                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                           class="btn btn-sm btn-warning">Sửa</a>
                        <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                              onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                              style="display: inline-block;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" style="text-align: center; color: #999; padding: 30px;">
                        <i class="fa-solid fa-box-open" style="font-size: 24px; color: #ddd; display: block; margin-bottom: 8px;"></i>
                        Không tìm thấy sản phẩm nào.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if($products->hasPages()): ?>
    <div style="padding: 15px 20px; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-size: 13px; color: #999;">
            Hiển thị <?php echo e($products->firstItem()); ?>–<?php echo e($products->lastItem()); ?> / <?php echo e($products->total()); ?> sản phẩm
        </span>
        <div style="display: flex; gap: 4px;">
            
            <?php if($products->onFirstPage()): ?>
                <span style="padding: 6px 12px; border: 1px solid #eee; border-radius: 4px; color: #ccc; font-size: 13px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            <?php else: ?>
                <a href="<?php echo e($products->previousPageUrl()); ?>" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            <?php endif; ?>

            
            <?php for($i = 1; $i <= $products->lastPage(); $i++): ?>
                <?php if($i == $products->currentPage()): ?>
                    <span style="padding: 6px 12px; border: 1px solid #2c3345; border-radius: 4px; background: #2c3345; color: #fff; font-size: 13px;"><?php echo e($i); ?></span>
                <?php else: ?>
                    <a href="<?php echo e($products->url($i)); ?>" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;"><?php echo e($i); ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            
            <?php if($products->hasMorePages()): ?>
                <a href="<?php echo e($products->nextPageUrl()); ?>" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            <?php else: ?>
                <span style="padding: 6px 12px; border: 1px solid #eee; border-radius: 4px; color: #ccc; font-size: 13px;">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/admin/products/index.blade.php ENDPATH**/ ?>