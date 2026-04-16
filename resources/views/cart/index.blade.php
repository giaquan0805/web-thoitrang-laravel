@extends('layouts.app')

@section('title', 'Giỏ hàng - Fashion AI')

@section('content')

<div class="container cart-wrapper">
    <h2>Giỏ hàng của bạn</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <div class="cart-empty">
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('home') }}">Tiếp tục mua sắm</a>
        </div>
    @else
        <div class="cart-grid">

            {{-- Danh sách sản phẩm --}}
            <div>
                @foreach($cartItems as $item)
                <div class="cart-item">

                    <img src="{{ product_image($item->variant->product->thumbnail_url) }}"
                         alt="{{ $item->variant->product->name }}">

                    <div class="cart-item-info">
                        <h3>{{ $item->variant->product->name }}</h3>
                        <p>Size: {{ $item->variant->size }} | Màu: {{ $item->variant->color }}</p>
                        <p class="cart-item-price">{{ number_format($item->variant->product->price, 0, ',', '.') }}đ</p>
                    </div>

                    <div class="cart-qty">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $item->id }}">
                            <button type="submit" name="action" value="decrease">-</button>
                            <span>{{ $item->quantity }}</span>
                            <button type="submit" name="action" value="increase">+</button>
                        </form>
                    </div>

                    <div class="cart-item-total">
                        <p>{{ number_format($item->variant->product->price * $item->quantity, 0, ',', '.') }}đ</p>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cart_id" value="{{ $item->id }}">
                            <button type="submit" class="btn-remove">Xóa</button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>

            {{-- Tổng tiền --}}
            <div class="cart-summary">
                <h3>Tóm tắt đơn hàng</h3>

                <div class="cart-summary-row">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                </div>

                <div class="cart-summary-row">
                    <span>Phí vận chuyển:</span>
                    <span class="free">Miễn phí</span>
                </div>

                <hr style="margin-bottom: 20px;">

                <div class="cart-summary-row total">
                    <span>Tổng cộng:</span>
                    <span>{{ number_format($total, 0, ',', '.') }}đ</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn-checkout">Tiến hành đặt hàng</a>
                <a href="{{ route('home') }}" class="btn-continue">Tiếp tục mua sắm</a>
            </div>

        </div>
    @endif
</div>

@endsection