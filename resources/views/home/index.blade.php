@extends('layouts.app')

@section('title', 'Trang chủ - Fashion AI')

@section('content')

    @if($keyword)
        <div class="container" style="margin-top: 20px;">
            <h2>Kết quả tìm kiếm cho: "{{ $keyword }}"</h2>
            <p>Tìm thấy {{ count($products) }} sản phẩm.</p>
        </div>
    @endif

    {{-- Hero Banner --}}
    <section class="hero-banner">
        <div class="container">
            <h1>Khám Phá Phong Cách Mới</h1>
            <p>Trải nghiệm công nghệ AI thử đồ ngay tại nhà!</p>
            <a href="#products" class="btn-hero">Khám phá ngay <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </section>

    {{-- Section: Danh mục nổi bật --}}
    <section class="container" style="padding: 50px 15px;">
        <h2 class="section-title">Danh Mục Nổi Bật</h2>
        <div style="display: grid; grid-template-columns: repeat({{ $categories->count() }}, 1fr); gap: 20px; margin-top: 30px;">
            @foreach($categories as $cat)
            <a href="{{ route('home', ['cat' => $cat->slug]) }}"
               style="display: block; text-align: center; text-decoration: none; color: #333;">
                <div style="background: #f5f5f5; border-radius: 12px; padding: 30px 20px; transition: all 0.3s;">
                    <div style="font-size: 48px; margin-bottom: 10px;">
                        {{ $cat->slug === 'nam' ? '👔' : ($cat->slug === 'nu' ? '👗' : '👕') }}
                    </div>
                    <h3 style="font-size: 18px; margin-bottom: 5px;">{{ $cat->name }}</h3>
                    <p style="font-size: 13px; color: #999;">{{ $cat->products_count }} sản phẩm</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    {{-- Section: Sản phẩm nổi bật --}}
    <section class="product-section container" id="products" style="padding-bottom: 20px;">
        <h2 class="section-title">
            {{ $category_slug ? 'Danh mục: ' . ($products->first()->category->name ?? 'Đang cập nhật') : 'Sản Phẩm Nổi Bật' }}
        </h2>

        <div class="product-grid">
            @forelse($products as $item)
                <div class="product-card">
                    <span class="product-tag">{{ $item->tag }}</span>
                    <a href="{{ route('product.show', $item->id) }}">
                        <img src="{{ product_image($item->thumbnail_url) }}" alt="{{ $item->name }}">
                    </a>
                    <button class="btn-ai-tryon">✨ Thử đồ AI</button>
                    <div class="product-info">
                        <h3 class="product-name">
                            <a href="{{ route('product.show', $item->id) }}">{{ $item->name }}</a>
                        </h3>
                        <p class="product-price">{{ number_format($item->price, 0, ',', '.') }}đ</p>
                    </div>
                </div>
            @empty
                <p style="text-align: center; grid-column: 1/-1;">Rất tiếc, không tìm thấy sản phẩm nào.</p>
            @endforelse
        </div>
    </section>

    {{-- Banner cam kết --}}
    <section style="background: #1a1a2e; padding: 40px 15px; margin: 30px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; text-align: center;">
                <div style="color: #fff;">
                    <div style="font-size: 36px; margin-bottom: 10px;">🚚</div>
                    <h4 style="margin-bottom: 5px;">Miễn phí vận chuyển</h4>
                    <p style="color: #aaa; font-size: 13px;">Đơn hàng từ 500.000đ</p>
                </div>
                <div style="color: #fff;">
                    <div style="font-size: 36px; margin-bottom: 10px;">🔄</div>
                    <h4 style="margin-bottom: 5px;">Đổi trả dễ dàng</h4>
                    <p style="color: #aaa; font-size: 13px;">Trong vòng 60 ngày</p>
                </div>
                <div style="color: #fff;">
                    <div style="font-size: 36px; margin-bottom: 10px;">✨</div>
                    <h4 style="margin-bottom: 5px;">AI Thử Đồ</h4>
                    <p style="color: #aaa; font-size: 13px;">Công nghệ thử đồ tiên tiến</p>
                </div>
                <div style="color: #fff;">
                    <div style="font-size: 36px; margin-bottom: 10px;">🛡️</div>
                    <h4 style="margin-bottom: 5px;">Chất lượng đảm bảo</h4>
                    <p style="color: #aaa; font-size: 13px;">100% hàng chính hãng</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Section: Sản phẩm mới nhất --}}
    @if(!$keyword && !$category_slug)
    <section class="product-section container" style="padding: 30px 15px;">
        <h2 class="section-title">Sản Phẩm Mới Nhất</h2>
        <div class="product-grid">
            @foreach($newProducts as $item)
                <div class="product-card">
                    <span class="product-tag">{{ $item->tag }}</span>
                    <a href="{{ route('product.show', $item->id) }}">
                        <img src="{{ product_image($item->thumbnail_url) }}" alt="{{ $item->name }}">
                    </a>
                    <button class="btn-ai-tryon">✨ Thử đồ AI</button>
                    <div class="product-info">
                        <h3 class="product-name">
                            <a href="{{ route('product.show', $item->id) }}">{{ $item->name }}</a>
                        </h3>
                        <p class="product-price">{{ number_format($item->price, 0, ',', '.') }}đ</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Section: Sản phẩm bán chạy --}}
    @if($hotProducts->count() > 0)
    <section class="product-section container" style="padding: 30px 15px 50px;">
        <h2 class="section-title">🔥 Sản Phẩm Bán Chạy</h2>
        <div class="product-grid">
            @foreach($hotProducts as $item)
                <div class="product-card">
                    <span class="product-tag">{{ $item->tag }}</span>
                    <a href="{{ route('product.show', $item->id) }}">
                        <img src="{{ product_image($item->thumbnail_url) }}" alt="{{ $item->name }}">
                    </a>
                    <button class="btn-ai-tryon">✨ Thử đồ AI</button>
                    <div class="product-info">
                        <h3 class="product-name">
                            <a href="{{ route('product.show', $item->id) }}">{{ $item->name }}</a>
                        </h3>
                        <p class="product-price">{{ number_format($item->price, 0, ',', '.') }}đ</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif
    @endif

@endsection