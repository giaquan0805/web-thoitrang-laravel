@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin')
@section('page-title', 'Dashboard')

@section('content')

{{-- Thống kê tổng quan --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #e3f2fd;">📦</div>
        <div class="stat-value">{{ $totalProducts }}</div>
        <div class="stat-label">Tổng sản phẩm</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #f3e5f5;">🛒</div>
        <div class="stat-value">{{ $totalOrders }}</div>
        <div class="stat-label">Tổng đơn hàng</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #e8f5e9;">👥</div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-label">Người dùng</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fff3e0;">💰</div>
        <div class="stat-value">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
        <div class="stat-label">Doanh thu</div>
    </div>
</div>

{{-- Đơn hàng gần đây --}}
<div class="card">
    <div class="card-header">
        <h5>📋 Đơn hàng gần đây</h5>
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
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td>{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                    <td>{{ $order->payment_method }}</td>
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