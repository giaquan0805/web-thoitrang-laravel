

<?php $__env->startSection('title', 'Trang chủ - Fashion AI'); ?>

<?php $__env->startSection('content'); ?>

    <?php if($keyword): ?>
        <div class="container" style="margin-top: 20px;">
            <h2>Kết quả tìm kiếm cho: "<?php echo e($keyword); ?>"</h2>
            <p>Tìm thấy <?php echo e(count($products)); ?> sản phẩm.</p>
        </div>
    <?php endif; ?>

    
    <section class="hero-banner">
        <div class="container">
            <h1>Khám Phá Phong Cách Mới</h1>
            <p>Trải nghiệm công nghệ AI thử đồ ngay tại nhà!</p>
            <a href="#products" class="btn-hero">Khám phá ngay <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </section>

    
    <section class="container" style="padding: 50px 15px;">
        <h2 class="section-title">Danh Mục Nổi Bật</h2>
        <div style="display: grid; grid-template-columns: repeat(<?php echo e($categories->count()); ?>, 1fr); gap: 20px; margin-top: 30px;">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('home', ['cat' => $cat->slug])); ?>"
               style="display: block; text-decoration: none; color: #333;">
                <div style="background: #f5f5f5; border-radius: 12px; overflow: hidden; transition: all 0.3s; position: relative;">
                    <?php if($cat->banner_url): ?>
                        <div style="position: relative; height: 200px; overflow: hidden;">
                            <img src="<?php echo e(asset('storage/' . $cat->banner_url)); ?>" alt="<?php echo e($cat->name); ?>"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); padding: 20px 15px 15px;">
                                <h3 style="font-size: 18px; color: #fff; margin-bottom: 3px;"><?php echo e($cat->name); ?></h3>
                                <p style="font-size: 13px; color: rgba(255,255,255,0.8);"><?php echo e($cat->products_count); ?> sản phẩm</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div style="padding: 30px 20px; text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 10px;">
                                <i class="fa-solid <?php echo e($cat->slug === 'nam' ? 'fa-person' : ($cat->slug === 'nu' ? 'fa-person-dress' : 'fa-child')); ?>" style="color: #d4a574;"></i>
                            </div>
                            <h3 style="font-size: 18px; margin-bottom: 5px;"><?php echo e($cat->name); ?></h3>
                            <p style="font-size: 13px; color: #999;"><?php echo e($cat->products_count); ?> sản phẩm</p>
                        </div>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="product-section container" id="products" style="padding-bottom: 20px;">
        <h2 class="section-title">
            <?php echo e($category_slug ? 'Danh mục: ' . ($products->first()->category->name ?? 'Đang cập nhật') : 'Sản Phẩm Nổi Bật'); ?>

        </h2>

        <div class="product-grid">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="product-card">
                    <span class="product-tag"><?php echo e($item->tag); ?></span>
                    <a href="<?php echo e(route('product.show', $item->id)); ?>">
                        <img src="<?php echo e(product_image($item->thumbnail_url)); ?>" alt="<?php echo e($item->name); ?>">
                    </a>
                    <button class="btn-ai-tryon"><i class="fa-solid fa-wand-magic-sparkles"></i> Thử đồ AI</button>
                    <div class="product-info">
                        <h3 class="product-name">
                            <a href="<?php echo e(route('product.show', $item->id)); ?>"><?php echo e($item->name); ?></a>
                        </h3>
                        <p class="product-price"><?php echo e(number_format($item->price, 0, ',', '.')); ?>đ</p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p style="text-align: center; grid-column: 1/-1;">Rất tiếc, không tìm thấy sản phẩm nào.</p>
            <?php endif; ?>
        </div>
    </section>

    <?php if(!$keyword && !$category_slug): ?>

    
    <section style="padding: 20px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; height: 320px;">
                
                <a href="<?php echo e(route('home', ['cat' => 'nu'])); ?>" style="display: block; position: relative; border-radius: 12px; overflow: hidden; height: 100%;">
                    <img src="<?php echo e(asset('images/banners/promo-banner.jpg')); ?>" alt="Bộ sưu tập"
                         style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.1) 60%, transparent 100%);"></div>
                    <div style="position: absolute; bottom: 30px; left: 30px; z-index: 1;">
                        <p style="color: rgba(255,255,255,0.7); font-size: 12px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px;">Bộ sưu tập</p>
                        <h3 style="color: #fff; font-size: 24px; font-weight: 700; margin-bottom: 12px;">Xu hướng mùa hè 2026</h3>
                        <span style="display: inline-block; color: #fff; font-size: 13px; border: 1px solid rgba(255,255,255,0.5); padding: 6px 16px; border-radius: 20px; transition: 0.3s;">
                            Khám phá ngay <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
                        </span>
                    </div>
                </a>

                
                <div style="display: grid; grid-template-rows: 1fr 1fr; gap: 20px; height: 100%;">
                    <a href="<?php echo e(route('home', ['cat' => 'nam'])); ?>" style="display: block; position: relative; border-radius: 12px; overflow: hidden;">
                        <div style="height: 100%; background: linear-gradient(135deg, #d4a574 0%, #b8875a 100%); display: flex; align-items: center; padding: 25px 30px; position: relative;">
                            <div style="position: relative; z-index: 1;">
                                <p style="color: rgba(255,255,255,0.7); font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px;">Ưu đãi đặc biệt</p>
                                <h3 style="color: #fff; font-size: 22px; font-weight: 700; margin-bottom: 6px;">Giảm đến 30%</h3>
                                <span style="color: rgba(255,255,255,0.8); font-size: 13px;">Áo thun, Polo, Sơ mi</span>
                            </div>
                            <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; border-radius: 50%; border: 1.5px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-arrow-right" style="color: #fff; font-size: 16px;"></i>
                            </div>
                            <div style="position: absolute; right: -30px; top: -30px; width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.08);"></div>
                        </div>
                    </a>
                    <a href="#" style="display: block; position: relative; border-radius: 12px; overflow: hidden;">
                        <div style="height: 100%; background: linear-gradient(135deg, #2c3345 0%, #1a1f2e 100%); display: flex; align-items: center; padding: 25px 30px; position: relative;">
                            <div style="position: relative; z-index: 1;">
                                <p style="color: rgba(255,255,255,0.5); font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px;">Công nghệ mới</p>
                                <h3 style="color: #fff; font-size: 22px; font-weight: 700; margin-bottom: 6px;">AI Thử Đồ</h3>
                                <span style="color: rgba(255,255,255,0.6); font-size: 13px;">Trải nghiệm miễn phí</span>
                            </div>
                            <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; border-radius: 50%; border: 1.5px solid rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-wand-magic-sparkles" style="color: rgba(255,255,255,0.5); font-size: 16px;"></i>
                            </div>
                            <div style="position: absolute; right: -30px; bottom: -30px; width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.04);"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    
    <section class="product-section container" style="padding: 30px 15px;">
        <h2 class="section-title">Sản Phẩm Mới Nhất</h2>
        <div class="product-grid">
            <?php $__currentLoopData = $newProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card">
                    <span class="product-tag"><?php echo e($item->tag); ?></span>
                    <a href="<?php echo e(route('product.show', $item->id)); ?>">
                        <img src="<?php echo e(product_image($item->thumbnail_url)); ?>" alt="<?php echo e($item->name); ?>">
                    </a>
                    <button class="btn-ai-tryon"><i class="fa-solid fa-wand-magic-sparkles"></i> Thử đồ AI</button>
                    <div class="product-info">
                        <h3 class="product-name">
                            <a href="<?php echo e(route('product.show', $item->id)); ?>"><?php echo e($item->name); ?></a>
                        </h3>
                        <p class="product-price"><?php echo e(number_format($item->price, 0, ',', '.')); ?>đ</p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <?php if($saleProducts->count() > 0): ?>
    <section class="product-section container" style="padding: 30px 15px;">
        <h2 class="section-title"><i class="fa-solid fa-percent" style="color: #dc3545;"></i> Đang Giảm Giá</h2>
        <div class="product-grid">
            <?php $__currentLoopData = $saleProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card">
                    <span class="product-tag" style="background: #dc3545;"><?php echo e($item->tag); ?></span>
                    <a href="<?php echo e(route('product.show', $item->id)); ?>">
                        <img src="<?php echo e(product_image($item->thumbnail_url)); ?>" alt="<?php echo e($item->name); ?>">
                    </a>
                    <button class="btn-ai-tryon"><i class="fa-solid fa-wand-magic-sparkles"></i> Thử đồ AI</button>
                    <div class="product-info">
                        <h3 class="product-name">
                            <a href="<?php echo e(route('product.show', $item->id)); ?>"><?php echo e($item->name); ?></a>
                        </h3>
                        <p class="product-price"><?php echo e(number_format($item->price, 0, ',', '.')); ?>đ</p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    
    <?php if($hotProducts->count() > 0): ?>
    <section class="product-section container" style="padding: 30px 15px;">
        <h2 class="section-title"><i class="fa-solid fa-fire" style="color: #e74c3c;"></i> Sản Phẩm Bán Chạy</h2>
        <div class="product-grid">
            <?php $__currentLoopData = $hotProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-card">
                    <span class="product-tag"><?php echo e($item->tag); ?></span>
                    <a href="<?php echo e(route('product.show', $item->id)); ?>">
                        <img src="<?php echo e(product_image($item->thumbnail_url)); ?>" alt="<?php echo e($item->name); ?>">
                    </a>
                    <button class="btn-ai-tryon"><i class="fa-solid fa-wand-magic-sparkles"></i> Thử đồ AI</button>
                    <div class="product-info">
                        <h3 class="product-name">
                            <a href="<?php echo e(route('product.show', $item->id)); ?>"><?php echo e($item->name); ?></a>
                        </h3>
                        <p class="product-price"><?php echo e(number_format($item->price, 0, ',', '.')); ?>đ</p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    
    <section style="border-top: 1px solid #eee; padding: 45px 15px; margin-top: 20px;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; text-align: center;">
                <div style="display: flex; align-items: center; gap: 14px; justify-content: center;">
                    <div style="width: 45px; height: 45px; border-radius: 50%; border: 1.5px solid #ddd; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-truck-fast" style="font-size: 16px; color: #555;"></i>
                    </div>
                    <div style="text-align: left;">
                        <h4 style="font-size: 13px; color: #333; margin-bottom: 2px;">Miễn phí vận chuyển</h4>
                        <p style="color: #aaa; font-size: 12px;">Đơn từ 500.000đ</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; justify-content: center;">
                    <div style="width: 45px; height: 45px; border-radius: 50%; border: 1.5px solid #ddd; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-rotate-left" style="font-size: 16px; color: #555;"></i>
                    </div>
                    <div style="text-align: left;">
                        <h4 style="font-size: 13px; color: #333; margin-bottom: 2px;">Đổi trả dễ dàng</h4>
                        <p style="color: #aaa; font-size: 12px;">Trong vòng 60 ngày</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; justify-content: center;">
                    <div style="width: 45px; height: 45px; border-radius: 50%; border: 1.5px solid #ddd; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-wand-magic-sparkles" style="font-size: 16px; color: #555;"></i>
                    </div>
                    <div style="text-align: left;">
                        <h4 style="font-size: 13px; color: #333; margin-bottom: 2px;">AI Thử Đồ</h4>
                        <p style="color: #aaa; font-size: 12px;">Công nghệ tiên tiến</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; justify-content: center;">
                    <div style="width: 45px; height: 45px; border-radius: 50%; border: 1.5px solid #ddd; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-shield" style="font-size: 16px; color: #555;"></i>
                    </div>
                    <div style="text-align: left;">
                        <h4 style="font-size: 13px; color: #333; margin-bottom: 2px;">Chất lượng đảm bảo</h4>
                        <p style="color: #aaa; font-size: 12px;">100% chính hãng</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/home/index.blade.php ENDPATH**/ ?>