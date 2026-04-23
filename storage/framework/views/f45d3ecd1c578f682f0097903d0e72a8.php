<?php $__env->startSection('title', $product->name . ' - Fashion AI'); ?>

<?php $__env->startSection('content'); ?>

<div class="product-detail">

    
    <div class="product-images">
        <div class="main-image">
            <img id="main-img"
                 src="<?php echo e(product_image($product->thumbnail_url)); ?>"
                 alt="<?php echo e($product->name); ?>">
        </div>

        <div class="thumbnail-list">
            <?php if($product->thumbnail_url): ?>
                <img src="<?php echo e(product_image($product->thumbnail_url)); ?>"
                     alt="<?php echo e($product->name); ?>"
                     class="thumb-active"
                     onclick="changeMainImage(this, '<?php echo e(product_image($product->thumbnail_url)); ?>')">
            <?php endif; ?>

            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="<?php echo e(product_image($img->image_url)); ?>"
                     alt="<?php echo e($product->name); ?>"
                     onclick="changeMainImage(this, '<?php echo e(product_image($img->image_url)); ?>')">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="product-info-detail">
        <span class="product-tag"><?php echo e($product->tag); ?></span>
        <h1><?php echo e($product->name); ?></h1>
        <p class="detail-price"><?php echo e(number_format($product->price, 0, ',', '.')); ?>đ</p>
        <p class="detail-desc"><?php echo e($product->description); ?></p>

        
        <div class="variant-section">
            <label>Màu sắc: <span id="selected-color-text" style="font-weight: 400; color: #666;"></span></label>
            <div class="color-options">
                <?php $__currentLoopData = $product->variants->unique('color'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button class="color-btn <?php echo e($index === 0 ? 'active' : ''); ?>"
                            onclick="selectColor(this, '<?php echo e($variant->color); ?>')"
                            data-color="<?php echo e($variant->color); ?>">
                        <?php echo e($variant->color); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="variant-section">
            <label>Chọn Size: <span id="stock-info" style="font-weight: 400; font-size: 13px; color: #999;"></span></label>
            <div class="size-options" id="size-options">
                <?php $__currentLoopData = $product->variants->unique('size'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button class="size-btn"
                            onclick="selectSize(this, '<?php echo e($variant->size); ?>')"
                            data-size="<?php echo e($variant->size); ?>">
                        <?php echo e($variant->size); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="qty-section">
            <label>Số lượng:</label>
            <div class="qty-control">
                <button onclick="changeQty(-1)">-</button>
                <span id="qty">1</span>
                <button onclick="changeQty(1)">+</button>
            </div>
        </div>

        
        <div class="product-actions">
            <button class="btn-ai-tryon"><i class="fa-solid fa-wand-magic-sparkles"></i> Thử đồ AI</button>
            <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_variant_id" id="selected_variant"
                       value="<?php echo e($product->variants->first()->id ?? ''); ?>">
                <input type="hidden" name="quantity" id="selected_qty" value="1">
                <button type="submit" class="btn-add-cart" id="btn-add-cart">
                    <i class="fa-solid fa-bag-shopping"></i> Thêm vào giỏ
                </button>
            </form>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Dữ liệu tất cả variants từ database
const variants = <?php echo json_encode($product->variants, 15, 512) ?>;

let selectedColor = '<?php echo e($product->variants->first()->color ?? ''); ?>';
let selectedSize = '';
let qty = 1;

// Khởi tạo: hiển thị màu đầu tiên
document.getElementById('selected-color-text').innerText = selectedColor;

function selectColor(btn, color) {
    // Highlight nút màu
    document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    selectedColor = color;
    document.getElementById('selected-color-text').innerText = color;

    // Reset size đã chọn
    selectedSize = '';
    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));

    // Cập nhật size nào còn hàng cho màu này
    updateSizeAvailability();
    updateVariant();
}

function selectSize(btn, size) {
    // Kiểm tra size này có hết hàng không
    if (btn.classList.contains('disabled')) return;

    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    selectedSize = size;

    updateVariant();
}

function updateSizeAvailability() {
    document.querySelectorAll('.size-btn').forEach(btn => {
        const size = btn.dataset.size;
        const variant = variants.find(v => v.color === selectedColor && v.size === size);

        btn.classList.remove('disabled');
        btn.title = '';

        if (!variant) {
            btn.classList.add('disabled');
            btn.title = 'Không có size này cho màu đã chọn';
        } else if (variant.stock_quantity <= 0) {
            btn.classList.add('disabled');
            btn.title = 'Hết hàng';
        }
    });
}

function updateVariant() {
    const variant = variants.find(v => v.color === selectedColor && v.size === selectedSize);
    const stockInfo = document.getElementById('stock-info');
    const btnAdd = document.getElementById('btn-add-cart');

    if (variant) {
        document.getElementById('selected_variant').value = variant.id;

        if (variant.stock_quantity > 0 && variant.stock_quantity <= 5) {
            stockInfo.innerHTML = '<span style="color: #f59e0b;">Chỉ còn ' + variant.stock_quantity + ' sản phẩm</span>';
        } else if (variant.stock_quantity > 5) {
            stockInfo.innerHTML = '<span style="color: #28a745;">Còn hàng</span>';
        } else {
            stockInfo.innerHTML = '<span style="color: #dc3545;">Hết hàng</span>';
        }

        btnAdd.disabled = variant.stock_quantity <= 0;
    } else {
        stockInfo.innerText = '';
    }
}

function changeQty(delta) {
    qty = Math.max(1, qty + delta);
    document.getElementById('qty').innerText = qty;
    document.getElementById('selected_qty').value = qty;
}

function changeMainImage(thumb, imageUrl) {
    document.getElementById('main-img').src = imageUrl;
    document.querySelectorAll('.thumbnail-list img').forEach(img => img.classList.remove('thumb-active'));
    thumb.classList.add('thumb-active');
}

// Khởi tạo: cập nhật size availability
updateSizeAvailability();
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.thumbnail-list img {
    border: 2px solid transparent;
    opacity: 0.6;
    transition: all 0.2s;
    cursor: pointer;
}
.thumbnail-list img:hover { opacity: 1; }
.thumbnail-list img.thumb-active {
    border-color: #f59e0b;
    opacity: 1;
}

/* Nút chọn màu */
.color-options {
    display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px;
}
.color-btn {
    padding: 8px 18px; border: 1.5px solid #ddd;
    border-radius: 8px; background: #fff;
    cursor: pointer; font-size: 13px; font-weight: 500;
    transition: all 0.2s; color: #333;
}
.color-btn:hover {
    border-color: #f59e0b;
}
.color-btn.active {
    border-color: #f59e0b;
    background: #fffbeb;
    color: #d97706;
    font-weight: 600;
}

/* Nút chọn size */
.size-btn.disabled {
    opacity: 0.35;
    cursor: not-allowed;
    text-decoration: line-through;
    pointer-events: none;
}

.size-btn.active {
    border-color: #f59e0b;
    background: #f59e0b;
    color: #fff;
}

/* Nút thêm giỏ disabled */
.btn-add-cart:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/product/show.blade.php ENDPATH**/ ?>