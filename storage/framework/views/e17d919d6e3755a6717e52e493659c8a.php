

<?php $__env->startSection('title', 'Sửa sản phẩm'); ?>
<?php $__env->startSection('page-title', 'Sửa sản phẩm'); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-pen-to-square" style="color: #f57c00;"></i> Sửa sản phẩm: <?php echo e($product->name); ?></h5>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-sm" style="background: #eee; color: #333;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">

        
        <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $product->name)); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><span style="color:red;font-size:12px;"><?php echo e($message); ?></span><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id', $product->category_id) == $cat->id ? 'selected' : ''); ?>>
                            <?php echo e($cat->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Giá (đồng)</label>
                    <input type="number" name="price" class="form-control" value="<?php echo e(old('price', $product->price)); ?>" required min="0">
                </div>

                <div class="form-group">
                    <label>Tag</label>
                    <select name="tag" class="form-control">
                        <option value="Mới" <?php echo e(old('tag', $product->tag) == 'Mới' ? 'selected' : ''); ?>>Mới</option>
                        <option value="Nổi bật" <?php echo e(old('tag', $product->tag) == 'Nổi bật' ? 'selected' : ''); ?>>Nổi bật</option>
                        <option value="Bán chạy" <?php echo e(old('tag', $product->tag) == 'Bán chạy' ? 'selected' : ''); ?>>Bán chạy</option>
                        <option value="Sale" <?php echo e(old('tag', $product->tag) == 'Sale' ? 'selected' : ''); ?>>Sale</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label><i class="fa-regular fa-image" style="color: #1976d2;"></i> Ảnh chính</label>
                    <?php if($product->thumbnail_url): ?>
                    <div style="margin-bottom: 10px;">
                        <img src="<?php echo e(product_image($product->thumbnail_url)); ?>"
                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px;">
                        <p style="font-size: 12px; color: #666; margin-top: 5px;">Ảnh hiện tại</p>
                    </div>
                    <?php endif; ?>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    <p style="font-size: 12px; color: #999; margin-top: 5px;">Để trống nếu không muốn đổi ảnh</p>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label><i class="fa-solid fa-images" style="color: #7b1fa2;"></i> Thêm ảnh chi tiết</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    <p style="font-size: 12px; color: #999; margin-top: 5px;">Chọn nhiều ảnh để thêm (giữ Ctrl + click). Ảnh cũ vẫn được giữ lại.</p>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Mô tả sản phẩm</label>
                    <textarea name="description" class="form-control" rows="4"><?php echo e(old('description', $product->description)); ?></textarea>
                </div>
            </div>

            <div style="margin-top: 15px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk"></i> Cập nhật
                </button>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn" style="background: #eee; color: #333; margin-left: 10px;">Hủy</a>
            </div>
        </form>

        
        <?php if($product->images->count() > 0): ?>
        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee;">
            <h4 style="margin-bottom: 15px;"><i class="fa-solid fa-images" style="color: #7b1fa2;"></i> Ảnh chi tiết hiện có (<?php echo e($product->images->count()); ?> ảnh)</h4>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="position: relative; width: 100px; height: 100px;">
                    <img src="<?php echo e(asset('storage/' . $img->image_url)); ?>"
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px; border: 1px solid #eee;">
                    <form action="<?php echo e(route('admin.product-images.destroy', $img->id)); ?>" method="POST"
                          onsubmit="return confirm('Xóa ảnh này?')"
                          style="position: absolute; top: -6px; right: -6px;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" style="width: 22px; height: 22px; border-radius: 50%; background: #dc3545; color: #fff; border: 2px solid #fff; font-size: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 0;">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        
        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee;">
            <h4 style="margin-bottom: 15px;"><i class="fa-solid fa-layer-group" style="color: #1976d2;"></i> Biến thể sản phẩm (Size & Màu)</h4>

            <?php if($product->variants->count() > 0): ?>
            <table style="width:100%; margin-bottom: 20px; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align:left; padding: 8px; background:#f5f5f5; width: 25%;">Size</th>
                        <th style="text-align:left; padding: 8px; background:#f5f5f5; width: 25%;">Màu</th>
                        <th style="text-align:left; padding: 8px; background:#f5f5f5; width: 25%;">Tồn kho</th>
                        <th style="text-align:center; padding: 8px; background:#f5f5f5; width: 25%;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <form action="<?php echo e(route('admin.variants.update', $variant->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <td style="padding: 8px; border-bottom: 1px solid #eee;">
                                <input type="text" name="size" value="<?php echo e($variant->size); ?>" class="form-control" style="padding: 6px 10px; font-size: 13px;">
                            </td>
                            <td style="padding: 8px; border-bottom: 1px solid #eee;">
                                <input type="text" name="color" value="<?php echo e($variant->color); ?>" class="form-control" style="padding: 6px 10px; font-size: 13px;">
                            </td>
                            <td style="padding: 8px; border-bottom: 1px solid #eee;">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <input type="number" name="stock_quantity" value="<?php echo e($variant->stock_quantity); ?>" class="form-control" min="0" style="padding: 6px 10px; font-size: 13px; width: 80px;">
                                    <?php if($variant->stock_quantity == 0): ?>
                                        <span style="color: #dc3545; font-size: 11px; white-space: nowrap;">Hết hàng</span>
                                    <?php elseif($variant->stock_quantity <= 5): ?>
                                        <span style="color: #f57c00; font-size: 11px; white-space: nowrap;">Sắp hết</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td style="padding: 8px; border-bottom: 1px solid #eee; text-align: center; white-space: nowrap;">
                                <button type="submit" class="btn btn-sm btn-success" title="Lưu">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Xóa"
                                        onclick="if(confirm('Xóa biến thể này?')) document.getElementById('delete-variant-<?php echo e($variant->id); ?>').submit();">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </td>
                        </form>
                    </tr>
                    <form id="delete-variant-<?php echo e($variant->id); ?>" action="<?php echo e(route('admin.variants.destroy', $variant->id)); ?>" method="POST" style="display:none;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                    </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
            <p style="color: #999; margin-bottom: 15px;">Chưa có biến thể nào.</p>
            <?php endif; ?>

            <h5 style="margin-bottom: 10px;"><i class="fa-solid fa-plus" style="color: #28a745;"></i> Thêm biến thể mới</h5>
            <form action="<?php echo e(route('admin.variants.store', $product->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Size</label>
                        <input type="text" name="size" class="form-control" placeholder="S, M, L, XL, 29...">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Màu sắc</label>
                        <input type="text" name="color" class="form-control" placeholder="Đen, Trắng, Xanh...">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Tồn kho</label>
                        <input type="number" name="stock_quantity" class="form-control" value="10" min="0">
                    </div>
                    <button type="submit" class="btn btn-success">+ Thêm</button>
                </div>
            </form>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>