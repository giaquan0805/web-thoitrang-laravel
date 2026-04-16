@extends('layouts.app')

@section('title', 'Lịch sử đơn hàng - Fashion AI')

@section('content')

<div class="container account-wrapper">
    <div class="account-grid">

        {{-- Sidebar --}}
        <div class="account-sidebar">
            <div class="account-avatar">
                <div class="account-avatar-circle">
                    <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <p>{{ Auth::user()->name }}</p>
                <small>{{ Auth::user()->email }}</small>
            </div>

            <ul class="account-menu">
                <li>
                    <a href="{{ route('account.profile') }}">
                        👤 Thông tin tài khoản
                    </a>
                </li>
                <li>
                    <a href="{{ route('account.orders') }}" class="active">
                        📦 Lịch sử đơn hàng
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">🚪 Đăng xuất</button>
                    </form>
                </li>
            </ul>
        </div>

        {{-- Danh sách đơn hàng --}}
        <div class="account-content">
            <h3>Lịch sử đơn hàng</h3>

            @if($orders->isEmpty())
                <div class="order-empty">
                    <p>Bạn chưa có đơn hàng nào.</p>
                    <a href="{{ route('home') }}">Mua sắm ngay</a>
                </div>
            @else
                @foreach($orders as $order)
                @php
                    $badges = ['badge-warning', 'badge-info', 'badge-success', 'badge-danger'];
                    $labels = ['⏳ Chờ xác nhận', '🚚 Đang giao', '✅ Hoàn thành', '❌ Đã hủy'];
                    $bgColors = ['#fff3cd', '#cce5ff', '#d4edda', '#f8d7da'];
                    $textColors = ['#856404', '#004085', '#155724', '#721c24'];
                @endphp
                <div class="order-card">

                    <div class="order-card-header">
                        <div>
                            <span>Đơn hàng #{{ $order->id }}</span>
                            <small>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</small>
                        </div>
                        <span style="padding: 5px 12px; border-radius: 20px; font-size: 13px;
                            background: {{ $bgColors[$order->status] }};
                            color: {{ $textColors[$order->status] }};">
                            {{ $labels[$order->status] }}
                        </span>
                    </div>

                    <div class="order-card-body">
                        @foreach($order->details as $detail)
                        <div class="order-card-item">
                            <img src="{{ product_image($detail->variant->product->thumbnail_url) }}">
                            <div class="order-card-item-info">
                                <p>{{ $detail->variant->product->name }}</p>
                                <small>Size: {{ $detail->variant->size }} | Màu: {{ $detail->variant->color }} x{{ $detail->quantity }}</small>
                            </div>
                            <span>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="order-card-footer">
                        <small>{{ $order->payment_method === 'COD' ? '💵 Thanh toán khi nhận hàng' : '🏦 Chuyển khoản' }}</small>
                        <strong>Tổng: {{ number_format($order->total_price, 0, ',', '.') }}đ</strong>
                    </div>

                </div>
                @endforeach
            @endif
        </div>

    </div>
</div>

@endsection