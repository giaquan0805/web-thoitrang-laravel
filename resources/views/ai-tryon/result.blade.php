@extends('layouts.app')

@section('title', 'Kết quả thử đồ AI - ' . $product->name)

@section('content')

<div class="container" style="padding: 40px 15px; max-width: 950px;">

    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-size: 26px; margin-bottom: 8px;">
            <i class="fa-solid fa-circle-check" style="color: #28a745;"></i> Kết quả thử đồ AI
        </h2>
        <p style="color: #999; font-size: 14px;">AI đã ghép sản phẩm lên ảnh của bạn</p>
    </div>

    {{-- Kết quả --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 30px;">

        {{-- Ảnh gốc --}}
        <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; overflow: hidden;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0; text-align: center; font-size: 13px; color: #999;">
                <i class="fa-solid fa-user"></i> Ảnh của bạn
            </div>
            <div style="padding: 15px;">
                <img src="{{ $userImageUrl }}" alt="Ảnh người dùng"
                     style="width: 100%; border-radius: 8px; object-fit: cover;">
            </div>
        </div>

        {{-- Ảnh kết quả AI --}}
        <div style="background: #fff; border: 2px solid #f59e0b; border-radius: 12px; overflow: hidden;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0; text-align: center; font-size: 13px; color: #f59e0b; font-weight: 600;">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Kết quả AI
            </div>
            <div style="padding: 15px;">
                <img src="{{ $resultImageUrl }}" alt="Kết quả AI"
                     style="width: 100%; border-radius: 8px; object-fit: cover;">
            </div>
        </div>

        {{-- Ảnh sản phẩm --}}
        <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; overflow: hidden;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0; text-align: center; font-size: 13px; color: #999;">
                <i class="fa-solid fa-shirt"></i> Sản phẩm
            </div>
            <div style="padding: 15px;">
                <img src="{{ product_image($product->thumbnail_url) }}" alt="{{ $product->name }}"
                     style="width: 100%; border-radius: 8px; object-fit: cover;">
            </div>
        </div>

    </div>

    {{-- Thông tin sản phẩm --}}
    <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; padding: 20px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="font-size: 18px; margin-bottom: 4px;">{{ $product->name }}</h3>
            <p style="color: #f59e0b; font-weight: 700; font-size: 18px;">{{ number_format($product->price, 0, ',', '.') }}đ</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('product.show', $product->id) }}"
               style="padding: 10px 24px; background: #f59e0b; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 500; font-size: 14px; transition: 0.3s;">
                <i class="fa-solid fa-bag-shopping"></i> Mua ngay
            </a>
            <a href="{{ route('ai.tryon', $product->id) }}"
               style="padding: 10px 24px; background: #fff; color: #333; border: 1.5px solid #e5e5e5; border-radius: 8px; text-decoration: none; font-size: 14px; transition: 0.3s;">
                <i class="fa-solid fa-arrows-rotate"></i> Thử lại
            </a>
        </div>
    </div>

    {{-- Quay lại --}}
    <div style="text-align: center;">
        <a href="{{ route('product.show', $product->id) }}" style="color: #999; font-size: 14px; text-decoration: none;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại sản phẩm
        </a>
    </div>

</div>

@endsection