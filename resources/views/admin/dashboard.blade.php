@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin')
@section('page-title', 'Dashboard')

@section('content')

{{-- Thống kê tổng quan --}}
<div class="stats-grid">
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <div class="stat-label">Tổng sản phẩm</div>
                <div class="stat-value">{{ $totalProducts }}</div>
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
                <div class="stat-value">{{ $totalOrders }}</div>
                @if($ordersLastMonth > 0)
                    @php $orderChange = round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100); @endphp
                    <div style="font-size: 12px; margin-top: 4px; color: {{ $orderChange >= 0 ? '#28a745' : '#dc3545' }};">
                        <i class="fa-solid fa-arrow-{{ $orderChange >= 0 ? 'up' : 'down' }}"></i>
                        {{ abs($orderChange) }}% so với tháng trước
                    </div>
                @endif
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
                <div class="stat-value">{{ $totalUsers }}</div>
                @if($usersLastMonth > 0)
                    @php $userChange = round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100); @endphp
                    <div style="font-size: 12px; margin-top: 4px; color: {{ $userChange >= 0 ? '#28a745' : '#dc3545' }};">
                        <i class="fa-solid fa-arrow-{{ $userChange >= 0 ? 'up' : 'down' }}"></i>
                        {{ abs($userChange) }}% so với tháng trước
                    </div>
                @endif
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
                <div class="stat-value" style="font-size: 20px;">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
                @if($revenueLastMonth > 0)
                    @php $revenueChange = round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100); @endphp
                    <div style="font-size: 12px; margin-top: 4px; color: {{ $revenueChange >= 0 ? '#28a745' : '#dc3545' }};">
                        <i class="fa-solid fa-arrow-{{ $revenueChange >= 0 ? 'up' : 'down' }}"></i>
                        {{ abs($revenueChange) }}% so với tháng trước
                    </div>
                @endif
            </div>
            <div class="stat-icon" style="background: #fff3e0; color: #f57c00;">
                <i class="fa-solid fa-coins"></i>
            </div>
        </div>
    </div>
</div>

{{-- Biểu đồ --}}
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">

    {{-- Biểu đồ doanh thu 7 ngày --}}
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

    {{-- Biểu đồ đơn hàng theo trạng thái --}}
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
                        Chờ xác nhận: <strong>{{ $ordersByStatus['pending'] }}</strong>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #17a2b8; display: inline-block;"></span>
                        Đang giao: <strong>{{ $ordersByStatus['shipping'] }}</strong>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #28a745; display: inline-block;"></span>
                        Hoàn thành: <strong>{{ $ordersByStatus['completed'] }}</strong>
                    </div>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #dc3545; display: inline-block;"></span>
                        Đã hủy: <strong>{{ $ordersByStatus['cancelled'] }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Top sản phẩm bán chạy + Sản phẩm theo danh mục --}}
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">

    {{-- Top sản phẩm bán chạy --}}
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
                    @forelse($topProducts as $index => $product)
                    <tr>
                        <td>
                            @if($index == 0)
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: #fff3cd; color: #d4a017; font-weight: bold; font-size: 13px;">1</span>
                            @elseif($index == 1)
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: #e8e8e8; color: #757575; font-weight: bold; font-size: 13px;">2</span>
                            @elseif($index == 2)
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: #fde0cc; color: #cd7f32; font-weight: bold; font-size: 13px;">3</span>
                            @else
                                <span style="color: #999; font-weight: bold;">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="{{ product_image($product->thumbnail_url) }}" alt=""
                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
                                <div>
                                    <div style="font-weight: 500;">{{ Str::limit($product->name, 30) }}</div>
                                    <div style="font-size: 12px; color: #999;">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: center; font-weight: bold;">{{ $product->total_sold }}</td>
                        <td style="text-align: right; color: #28a745; font-weight: 500;">
                            {{ number_format($product->total_revenue, 0, ',', '.') }}đ
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #999;">Chưa có dữ liệu bán hàng.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Sản phẩm theo danh mục --}}
    <div class="card">
        <div class="card-header">
            <h5><i class="fa-solid fa-tags" style="color: #388e3c;"></i> Sản phẩm theo danh mục</h5>
        </div>
        <div class="card-body">
            @foreach($productsByCategory as $cat)
            <div style="margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 14px;">
                    <span>{{ $cat->name }}</span>
                    <span style="font-weight: bold;">{{ $cat->products_count }}</span>
                </div>
                <div style="background: #f0f0f0; border-radius: 10px; height: 8px; overflow: hidden;">
                    @php
                        $percent = $totalProducts > 0 ? ($cat->products_count / $totalProducts) * 100 : 0;
                        $colors = ['#1976d2', '#7b1fa2', '#388e3c', '#f57c00', '#dc3545'];
                        $color = $colors[$loop->index % count($colors)];
                    @endphp
                    <div style="width: {{ $percent }}%; height: 100%; background: {{ $color }}; border-radius: 10px; transition: width 0.5s;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Đơn hàng gần đây --}}
<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-clock-rotate-left" style="color: #f57c00;"></i> Đơn hàng gần đây</h5>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm">Xem tất cả</a>
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
                @forelse($recentOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #e3f2fd; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #1976d2; font-size: 13px;">
                                {{ strtoupper(substr($order->user->name ?? 'N', 0, 1)) }}
                            </div>
                            <span>{{ $order->user->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td style="font-weight: 500;">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                    <td>
                        <span style="background: #f0f0f0; padding: 3px 8px; border-radius: 4px; font-size: 12px;">
                            {{ $order->payment_method }}
                        </span>
                    </td>
                    <td>
                        @php
                            $badges = ['badge-warning', 'badge-info', 'badge-success', 'badge-danger'];
                            $labels = ['Chờ xác nhận', 'Đang giao', 'Hoàn thành', 'Đã hủy'];
                        @endphp
                        <span class="badge {{ $badges[$order->status] }}">
                            {{ $labels[$order->status] }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-warning">Chi tiết</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #999;">Chưa có đơn hàng nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// === BIỂU ĐỒ DOANH THU 7 NGÀY ===
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueData = @json($revenueLast7Days);

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
const statusData = @json($ordersByStatus);

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
@endpush