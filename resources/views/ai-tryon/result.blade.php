@extends('layouts.app')

@section('title', 'Kết quả thử đồ AI')

@section('content')

<div class="container" style="padding: 40px 15px; max-width: 900px;">

    <h2 style="margin-bottom: 5px;">✨ Kết quả thử đồ AI</h2>
    <p style="color: #666; margin-bottom: 30px;">Đây là kết quả AI tạo ra cho bạn</p>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 30px;">

        {{-- Ảnh gốc --}}
        <div style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-align: center;">
            <h4 style="margin-bottom: 10px; color: #666;">📸 Ảnh của bạn</h4>
            <img src="{{ $userImageUrl }}" alt="Ảnh gốc"
                 style="width: 100%; border-radius: 8px; object-fit: cover;">
        </div>

        {{-- Ảnh sản phẩm --}}
        <div style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-align: center;">
            <h4 style="margin-bottom: 10px; color: #666;">👗 Sản phẩm</h4>
            <img src="{{ product_image($product->thumbnail_url) }}"
                 alt="{{ $product->name }}"
                 style="width: 100%; border-radius: 8px; object-fit: cover;">
        </div>

        {{-- Kết quả AI --}}
        <div style="background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-align: center;">
            <h4 style="margin-bottom: 10px; color: #666;">✨ Kết quả AI</h4>
            <img src="{{ $resultImageUrl }}" alt="Kết quả thử đồ"
                 style="width: 100%; border-radius: 8px; object-fit: cover;">
        </div>

    </div>

    {{-- Thông tin sản phẩm --}}
    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3>{{ $product->name }}</h3>
                <p style="color: #e44; font-weight: bold; font-size: 20px; margin-top: 5px;">
                    {{ number_format($product->price, 0, ',', '.') }}đ
                </p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('product.show', $product->id) }}"
                   style="padding: 12px 24px; background: #333; color: #fff; border-radius: 6px; text-decoration: none;">
                    🛒 Mua ngay
                </a>
                <a href="{{ route('ai.tryon', $product->id) }}"
                   style="padding: 12px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border-radius: 6px; text-decoration: none;">
                    🔄 Thử lại
                </a>
            </div>
        </div>
    </div>

    <div style="text-align: center;">
        <a href="{{ route('home') }}"
           style="color: #666; text-decoration: none; font-size: 14px;">
            ← Quay về trang chủ
        </a>
    </div>

</div>

@endsection