@extends('layouts.app')

@section('title', 'Đặt hàng - Fashion AI')

@section('content')

<div class="container checkout-wrapper">
    <h2>Đặt hàng</h2>

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="checkout-grid">

        {{-- Form thông tin giao hàng --}}
        <div class="checkout-form">
            <h3>Thông tin giao hàng</h3>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="checkout-form-group">
                    <label>Họ tên người nhận</label>
                    <input type="text" name="shipping_name" value="{{ Auth::user()->name }}" required>
                    @error('shipping_name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="checkout-form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="shipping_phone" required>
                    @error('shipping_phone')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="checkout-form-group">
                    <label>Địa chỉ giao hàng</label>
                    <textarea name="shipping_address" required rows="3"></textarea>
                    @error('shipping_address')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="payment-options">
                    <label>Phương thức thanh toán</label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="COD" checked>
                        <span>💵 Thanh toán khi nhận hàng (COD)</span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="banking">
                        <span>🏦 Chuyển khoản ngân hàng</span>
                    </label>
                </div>

                <button type="submit" class="btn-order">Xác nhận đặt hàng</button>
            </form>
        </div>

        {{-- Tóm tắt đơn hàng --}}
        <div>
            <h3>Đơn hàng của bạn</h3>
            <div class="order-summary">
                @foreach($cartItems as $item)
                <div class="order-item">
                    <div class="order-item-left">
                        <img src="{{ product_image($item->variant->product->thumbnail_url) }}">
                        <div>
                            <p>{{ $item->variant->product->name }}</p>
                            <span>{{ $item->variant->size }} | {{ $item->variant->color }} x{{ $item->quantity }}</span>
                        </div>
                    </div>
                    <span>{{ number_format($item->variant->product->price * $item->quantity, 0, ',', '.') }}đ</span>
                </div>
                @endforeach

                <div class="order-total-row">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                </div>
                <div class="order-total-row">
                    <span>Phí vận chuyển:</span>
                    <span class="free">Miễn phí</span>
                </div>
                <hr>
                <div class="order-total-row final">
                    <span>Tổng cộng:</span>
                    <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection