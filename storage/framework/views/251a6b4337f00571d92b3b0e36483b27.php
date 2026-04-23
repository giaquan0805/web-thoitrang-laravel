

<?php $__env->startSection('title', 'Quản lý đơn hàng'); ?>
<?php $__env->startSection('page-title', 'Quản lý đơn hàng'); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-bag-shopping" style="color: #7b1fa2;"></i> Danh sách đơn hàng</h5>
    </div>

    
    <div style="padding: 0 20px; border-bottom: 1px solid #f0f0f0; display: flex; gap: 0;">
        <?php
            $currentStatus = request('status');
            $tabs = [
                '' => ['label' => 'Tất cả', 'count' => $statusCounts['all'], 'color' => '#333'],
                '0' => ['label' => 'Chờ xác nhận', 'count' => $statusCounts['pending'], 'color' => '#856404'],
                '1' => ['label' => 'Đang giao', 'count' => $statusCounts['shipping'], 'color' => '#004085'],
                '2' => ['label' => 'Hoàn thành', 'count' => $statusCounts['completed'], 'color' => '#155724'],
                '3' => ['label' => 'Đã hủy', 'count' => $statusCounts['cancelled'], 'color' => '#721c24'],
            ];
        ?>
        <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $isActive = (string)$currentStatus === (string)$value; ?>
            <a href="<?php echo e(route('admin.orders.index', array_merge(request()->except('status', 'page'), $value !== '' ? ['status' => $value] : []))); ?>"
               style="padding: 12px 18px; text-decoration: none; font-size: 13px; font-weight: 500;
                      color: <?php echo e($isActive ? $tab['color'] : '#999'); ?>;
                      border-bottom: 2px solid <?php echo e($isActive ? $tab['color'] : 'transparent'); ?>;">
                <?php echo e($tab['label']); ?>

                <span style="background: <?php echo e($isActive ? $tab['color'] : '#eee'); ?>; color: <?php echo e($isActive ? '#fff' : '#999'); ?>;
                             padding: 1px 7px; border-radius: 10px; font-size: 11px; margin-left: 4px;">
                    <?php echo e($tab['count']); ?>

                </span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div style="padding: 12px 20px; border-bottom: 1px solid #f0f0f0; background: #fafafa;">
        <form action="<?php echo e(route('admin.orders.index')); ?>" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <?php if(request('status') !== null && request('status') !== ''): ?>
                <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
            <?php endif; ?>
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên khách hàng hoặc SĐT..."
                   value="<?php echo e(request('keyword')); ?>" style="width: 300px; padding: 8px 12px;">
            <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">
                <i class="fa-solid fa-magnifying-glass"></i> Tìm
            </button>
            <?php if(request('keyword')): ?>
                <a href="<?php echo e(route('admin.orders.index', request('status') !== null ? ['status' => request('status')] : [])); ?>"
                   class="btn" style="background: #eee; color: #333; padding: 8px 16px;">
                    <i class="fa-solid fa-xmark"></i> Xóa tìm
                </a>
            <?php endif; ?>
            <span style="margin-left: auto; font-size: 13px; color: #999;">
                <?php echo e($orders->total()); ?> đơn hàng
            </span>
        </form>
    </div>

    <div class="card-body" style="padding: 0;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th style="text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $badges = ['badge-warning', 'badge-info', 'badge-success', 'badge-danger'];
                    $labels = ['Chờ xác nhận', 'Đang giao', 'Hoàn thành', 'Đã hủy'];
                ?>
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
                    <td><?php echo e($order->shipping_phone); ?></td>
                    <td style="font-weight: 500;"><?php echo e(number_format($order->total_price, 0, ',', '.')); ?>đ</td>
                    <td>
                        <span style="background: #f0f0f0; padding: 3px 8px; border-radius: 4px; font-size: 12px;">
                            <?php echo e($order->payment_method); ?>

                        </span>
                    </td>
                    <td>
                        <span class="badge <?php echo e($badges[$order->status]); ?>">
                            <?php echo e($labels[$order->status]); ?>

                        </span>
                    </td>
                    <td style="font-size: 13px; color: #666;"><?php echo e(\Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i')); ?></td>
                    <td style="text-align: center;">
                        <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-sm btn-warning">Chi tiết</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" style="text-align: center; color: #999; padding: 30px;">
                        <i class="fa-solid fa-bag-shopping" style="font-size: 24px; color: #ddd; display: block; margin-bottom: 8px;"></i>
                        Không tìm thấy đơn hàng nào.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if($orders->hasPages()): ?>
    <div style="padding: 15px 20px; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-size: 13px; color: #999;">
            Hiển thị <?php echo e($orders->firstItem()); ?>–<?php echo e($orders->lastItem()); ?> / <?php echo e($orders->total()); ?> đơn hàng
        </span>
        <div style="display: flex; gap: 4px;">
            <?php if($orders->onFirstPage()): ?>
                <span style="padding: 6px 12px; border: 1px solid #eee; border-radius: 4px; color: #ccc; font-size: 13px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            <?php else: ?>
                <a href="<?php echo e($orders->previousPageUrl()); ?>" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            <?php endif; ?>

            <?php for($i = 1; $i <= $orders->lastPage(); $i++): ?>
                <?php if($i == $orders->currentPage()): ?>
                    <span style="padding: 6px 12px; border: 1px solid #2c3345; border-radius: 4px; background: #2c3345; color: #fff; font-size: 13px;"><?php echo e($i); ?></span>
                <?php else: ?>
                    <a href="<?php echo e($orders->url($i)); ?>" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;"><?php echo e($i); ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if($orders->hasMorePages()): ?>
                <a href="<?php echo e($orders->nextPageUrl()); ?>" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">
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
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web-thoitrang\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>