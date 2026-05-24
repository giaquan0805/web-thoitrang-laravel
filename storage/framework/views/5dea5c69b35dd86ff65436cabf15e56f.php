<?php $__env->startSection('title', 'Dashboard - Admin'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="stats-grid">
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <div class="stat-label">Tổng sản phẩm</div>
                <div class="stat-value"><?php echo e($totalProducts); ?></div>
            </div>
            <div class="stat-icon" style="background: #e3f2fd; color: #1976d2;">
                <i class="fa-solid fa-shirt"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <div class="stat-label">Tổng đơn hàng</div>
                <div class="stat-value"><?php echo e($totalOrders); ?></div>
                <?php if($ordersLastMonth > 0): ?>
                    <?php $orderChange = round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100); ?>
                    <div style="font-size: 12px; margin-top: 4px; color: <?php echo e($orderChange >= 0 ? '#28a745' : '#dc3545'); ?>;">
                        <i class="fa-solid fa-arrow-<?php echo e($orderChange >= 0 ? 'up' : 'down'); ?>"></i>
                        <?php echo e(abs($orderChange)); ?>% so với tháng trước
                    </div>
                <?php endif; ?>
            </div>
            <div class="stat-icon" style="background: #f3e5f5; color: #7b1fa2;">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <div class="stat-label">Người dùng</div>
                <div class="stat-value"><?php echo e($totalUsers); ?></div>
                <?php if($usersLastMonth > 0): ?>
                    <?php $userChange = round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100); ?>
                    <div style="font-size: 12px; margin-top: 4px; color: <?php echo e($userChange >= 0 ? '#28a745' : '#dc3545'); ?>;">
                        <i class="fa-solid fa-arrow-<?php echo e($userChange >= 0 ? 'up' : 'down'); ?>"></i>
                        <?php echo e(abs($userChange)); ?>% so với tháng trước
                    </div>
                <?php endif; ?>
            </div>
            <div class="stat-icon" style="background: #e8f5e9; color: #388e3c;">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <div class="stat-label">Doanh thu</div>
                <div class="stat-value" style="font-size: 20px;"><?php echo e(number_format($totalRevenue, 0, ',', '.')); ?>đ</div>
                <?php if($revenueLastMonth > 0): ?>
                    <?php $revenueChange = round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100); ?>
                    <div style="font-size: 12px; margin-top: 4px; color: <?php echo e($revenueChange >= 0 ? '#28a745' : '#dc3545'); ?>;">
                        <i class="fa-solid fa-arrow-<?php echo e($revenueChange >= 0 ? 'up' : 'down'); ?>"></i>
                        <?php echo e(abs($revenueChange)); ?>% so với tháng trước
                    </div>
                <?php endif; ?>
            </div>
            <div class="stat-icon" style="background: #fff3e0; color: #f57c00;">
                <i class="fa-solid fa-coins"></i>
            </div>
        </div>
    </div>
</div>


<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">

    
    <div class="card">
        <div class="card-header">
            <h5><i class="fa-solid fa-chart-column" style="color: #1976d2;"></i> Doanh thu 7 ngày gần nhất</h5>
        </div>
        <div class="card-body">
            <div style="position: relative; height: 280px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <h5><i class="fa-solid fa-chart-pie" style="color: #7b1fa2;"></i> Đơn hàng theo trạng thái</h5>
        </div>
        <div class="card-body" style="display: flex; flex-direction: column; align-items: center;">
            <div style="position: relative; height: 220px; width: 100%;">
                <canvas id="orderStatusChart"></canvas>
            </div>
            <div style="margin-top: 15px; width: 100%;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 13px;">
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #ffc107; display: inline-block;"></span>
                        Chờ xác nhận: <strong><?php echo e($ordersByStatus['pending']); ?></strong>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #17a2b8; display: inline-block;"></span>
                        Đang giao: <strong><?php echo e($ordersByStatus['shipping']); ?></strong>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #28a745; display: inline-block;"></span>
                        Hoàn thành: <strong><?php echo e($ordersByStatus['completed']); ?></strong>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #dc3545; display: inline-block;"></span>
                        Đã hủy: <strong><?php echo e($ordersByStatus['cancelled']); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">

    
    <div class="card">
        <div class="card-header">
            <h5><i class="fa-solid fa-fire" style="color: #e74c3c;"></i> Top sản phẩm bán chạy</h5>
        </div>
        <div class="card-body" style="padding: 0;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Sản phẩm</th>
                        <th style="text-align: center;">Đã bán</th>
                        <th style="text-align: right;">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <?php if($index == 0): ?>
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: #fff3cd; color: #d4a017; font-weight: bold; font-size: 13px;">1</span>
                            <?php elseif($index == 1): ?>
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: #e8e8e8; color: #757575; font-weight: bold; font-size: 13px;">2</span>
                            <?php elseif($index == 2): ?>
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: #fde0cc; color: #cd7f32; font-weight: bold; font-size: 13px;">3</span>
                            <?php else: ?>
                                <span style="color: #999; font-weight: bold;"><?php echo e($index + 1); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="<?php echo e(product_image($product->thumbnail_url)); ?>" alt=""
                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
                                <div>
                                    <div style="font-weight: 500;"><?php echo e(Str::limit($product->name, 30)); ?></div>
                                    <div style="font-size: 12px; color: #999;"><?php echo e(number_format($product->price, 0, ',', '.')); ?>đ</div>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: center; font-weight: bold;"><?php echo e($product->total_sold); ?></td>
                        <td style="text-align: right; color: #28a745; font-weight: 500;">
                            <?php echo e(number_format($product->total_revenue, 0, ',', '.')); ?>đ
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: #999;">Chưa có dữ liệu bán hàng.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header">
            <h5><i class="fa-solid fa-tags" style="color: #388e3c;"></i> Sản phẩm theo danh mục</h5>
        </div>
        <div class="card-body">
            <?php $__currentLoopData = $productsByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 14px;">
                    <span><?php echo e($cat->name); ?></span>
                    <span style="font-weight: bold;"><?php echo e($cat->products_count); ?></span>
                </div>
                <div style="background: #f0f0f0; border-radius: 10px; height: 8px; overflow: hidden;">
                    <?php
                        $percent = $totalProducts > 0 ? ($cat->products_count / $totalProducts) * 100 : 0;
                        $colors = ['#1976d2', '#7b1fa2', '#388e3c', '#f57c00', '#dc3545'];
                        $color = $colors[$loop->index % count($colors)];
                    ?>
                    <div style="width: <?php echo e($percent); ?>%; height: 100%; background: <?php echo e($color); ?>; border-radius: 10px; transition: width 0.5s;"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-clock-rotate-left" style="color: #f57c00;"></i> Đơn hàng gần đây</h5>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-primary btn-sm">Xem tất cả</a>
    </div>
    <div class="card-body" style="padding: 0;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>#<?php echo e($order->id); ?></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #e3f2fd; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #1976d2; font-size: 13px;">
                                <?php echo e(strtoupper(substr($order->user->name ?? 'N', 0, 1))); ?>

                            </div>
                            <span><?php echo e($order->user->name ?? 'N/A'); ?></span>
                        </div>
                    </td>
                    <td style="font-weight: 500;"><?php echo e(number_format($order->total_price, 0, ',', '.')); ?>đ</td>
                    <td>
                        <span style="background: #f0f0f0; padding: 3px 8px; border-radius: 4px; font-size: 12px;">
                            <?php echo e($order->payment_method); ?>

                        </span>
                    </td>
                    <td>
                        <?php
                            $badges = ['badge-warning', 'badge-info', 'badge-success', 'badge-danger'];
                            $labels = ['Chờ xác nhận', 'Đang giao', 'Hoàn thành', 'Đã hủy'];
                        ?>
                        <span class="badge <?php echo e($badges[$order->status]); ?>">
                            <?php echo e($labels[$order->status]); ?>

                        </span>
                    </td>
                    <td><?php echo e(\Carbon\Carbon::parse($order->order_date)->format('d/m/Y')); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-warning">Chi tiết</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #999;">Chưa có đơn hàng nào.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// === BIỂU ĐỒ DOANH THU 7 NGÀY ===
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueData = <?php echo json_encode($revenueLast7Days, 15, 512) ?>;

new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: revenueData.map(item => item.date),
        datasets: [{
            label: 'Doanh thu (đ)',
            data: revenueData.map(item => item.revenue),
            backgroundColor: 'rgba(25, 118, 210, 0.7)',
            borderColor: '#1976d2',
            borderWidth: 1,
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(ctx) {
                        return new Intl.NumberFormat('vi-VN').format(ctx.raw) + 'đ';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        if (value >= 1000000) return (value / 1000000) + 'tr';
                        if (value >= 1000) return (value / 1000) + 'k';
                        return value;
                    }
                },
                grid: { color: '#f0f0f0' }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});

// === BIỂU ĐỒ ĐƠN HÀNG THEO TRẠNG THÁI ===
const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
const statusData = <?php echo json_encode($ordersByStatus, 15, 512) ?>;

new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Chờ xác nhận', 'Đang giao', 'Hoàn thành', 'Đã hủy'],
        datasets: [{
            data: [statusData.pending, statusData.shipping, statusData.completed, statusData.cancelled],
            backgroundColor: ['#ffc107', '#17a2b8', '#28a745', '#dc3545'],
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: { display: false }
        }
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>