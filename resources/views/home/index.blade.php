@extends('layouts.app')

@section('title', 'Trang chủ - Fashion AI')

@section('content')

    @if($keyword)
        <div class="container" style="margin-top: 20px;">
            <h2>Kết quả tìm kiếm cho: "{{ $keyword }}"</h2>
            <p>Tìm thấy {{ count($products) }} sản phẩm.</p>
        </div>
    @endif

    {{-- 1. Hero Banner --}}
    @if($category_slug)
        @php
            $bannerImages = [
                'nam' => 'banner_nam.jpg',
                'nu' => 'banner_nu.jpg',
                'tre-em' => 'banner_tre_em.jpg',
            ];
            $bannerImg = $bannerImages[$category_slug] ?? 'hero-banner.jpg';
        @endphp
        <section style="width: 100%; overflow: hidden;">
            <img src="{{ asset('images/banners/' . $bannerImg) }}" alt=""
                 style="width: 100%; display: block;">
        </section>
    @else
        <section class="hero-banner">
            <div class="container">
                <h1>Khám Phá Phong Cách Mới</h1>
                <p>Trải nghiệm công nghệ AI thử đồ ngay tại nhà!</p>
                <a href="#products" class="btn-hero">Khám phá ngay <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </section>
    @endif

    {{-- 2. Danh mục nổi bật (chỉ hiện ở trang chủ) --}}
    @if(!$category_slug && !$keyword)
    <section class="container" style="padding: 50px 15px;">
        <h2 class="section-title">Danh Mục Nổi Bật</h2>
        <div style="display: grid; grid-template-columns: repeat({{ $categories->count() }}, 1fr); gap: 20px; margin-top: 30px;">
            @foreach($categories as $cat)
            <a href="{{ route('home', ['cat' => $cat->slug]) }}"
               style="display: block; text-decoration: none; color: #333;">
                <div style="background: #f5f5f5; border-radius: 12px; overflow: hidden; transition: all 0.3s; position: relative;">
                    @if($cat->banner_url)
                        <div style="position: relative; height: 200px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $cat->banner_url) }}" alt="{{ $cat->name }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); padding: 20px 15px 15px;">
                                <h3 style="font-size: 18px; color: #fff; margin-bottom: 3px;">{{ $cat->name }}</h3>
                                <p style="font-size: 13px; color: rgba(255,255,255,0.8);">{{ $cat->products_count }} sản phẩm</p>
                            </div>
                        </div>
                    @else
                        <div style="padding: 30px 20px; text-align: center;">
                            <div style="font-size: 48px; margin-bottom: 10px;">
                                <i class="fa-solid {{ $cat->slug === 'nam' ? 'fa-person' : ($cat->slug === 'nu' ? 'fa-person-dress' : 'fa-child') }}" style="color: #d4a574;"></i>
                            </div>
                            <h3 style="font-size: 18px; margin-bottom: 5px;">{{ $cat->name }}</h3>
                            <p style="font-size: 13px; color: #999;">{{ $cat->products_count }} sản phẩm</p>
                        </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- 3. Sản phẩm nổi bật / Danh mục --}}
    @if($category_slug)
    {{-- Layout 2 cột: Bộ lọc + Sản phẩm --}}
    <section id="products" style="padding: 30px 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="font-size: 22px; font-weight: 700;">{{ $products->first()->category->name ?? 'Danh mục' }}</h2>
            <span style="color: #999; font-size: 14px;">{{ count($products) }} sản phẩm</span>
        </div>

        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 25px;">

            {{-- Bộ lọc bên trái --}}
            <div style="position: sticky; top: 80px; align-self: start;">
                <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; padding: 20px;">
                    <h3 style="font-size: 17px; font-weight: 600; margin-bottom: 15px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-filter" style="font-size: 14px; color: #f59e0b;"></i> Bộ lọc
                    </h3>

                    {{-- Danh mục --}}
                    <div style="margin-bottom: 20px;">
                        <h4 style="font-size: 15px; font-weight: 600; color: #333; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #f0f0f0;">Danh mục</h4>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach($categories as $cat)
                            <li style="margin-bottom: 6px;">
                                <a href="{{ route('home', ['cat' => $cat->slug]) }}"
                                   style="display: flex; align-items: center; gap: 8px; padding: 7px 10px; border-radius: 6px; text-decoration: none; font-size: 14px; transition: 0.2s;
                                   {{ $category_slug === $cat->slug ? 'background: #fffbeb; color: #d97706; font-weight: 600;' : 'color: #555;' }}">
                                    <i class="fa-solid fa-chevron-right" style="font-size: 10px; {{ $category_slug === $cat->slug ? 'color: #f59e0b;' : 'color: #ccc;' }}"></i>
                                    {{ $cat->name }}
                                    <span style="margin-left: auto; font-size: 12px; color: #bbb;">{{ $cat->products_count }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Khoảng giá --}}
                    <div style="margin-bottom: 20px;">
                        <h4 style="font-size: 15px; font-weight: 600; color: #333; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #f0f0f0;">Khoảng giá</h4>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 6px;">
                                <a href="{{ route('home', ['cat' => $category_slug, 'price' => 'under200']) }}"
                                   style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; border-radius: 6px; text-decoration: none; font-size: 14px; color: #555; transition: 0.2s;
                                   {{ request('price') === 'under200' ? 'background: #fffbeb; color: #d97706; font-weight: 600;' : '' }}">
                                    <span style="width: 18px; height: 18px; border-radius: 50%; border: 2px solid {{ request('price') === 'under200' ? '#f59e0b' : '#ccc' }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        @if(request('price') === 'under200')
                                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #f59e0b;"></span>
                                        @endif
                                    </span>
                                    Dưới 200.000đ
                                </a>
                            </li>
                            <li style="margin-bottom: 6px;">
                                <a href="{{ route('home', ['cat' => $category_slug, 'price' => '200to500']) }}"
                                   style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; border-radius: 6px; text-decoration: none; font-size: 14px; color: #555; transition: 0.2s;
                                   {{ request('price') === '200to500' ? 'background: #fffbeb; color: #d97706; font-weight: 600;' : '' }}">
                                    <span style="width: 18px; height: 18px; border-radius: 50%; border: 2px solid {{ request('price') === '200to500' ? '#f59e0b' : '#ccc' }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        @if(request('price') === '200to500')
                                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #f59e0b;"></span>
                                        @endif
                                    </span>
                                    200.000đ - 500.000đ
                                </a>
                            </li>
                            <li style="margin-bottom: 6px;">
                                <a href="{{ route('home', ['cat' => $category_slug, 'price' => 'above500']) }}"
                                   style="display: flex; align-items: center; gap: 10px; padding: 7px 10px; border-radius: 6px; text-decoration: none; font-size: 14px; color: #555; transition: 0.2s;
                                   {{ request('price') === 'above500' ? 'background: #fffbeb; color: #d97706; font-weight: 600;' : '' }}">
                                    <span style="width: 18px; height: 18px; border-radius: 50%; border: 2px solid {{ request('price') === 'above500' ? '#f59e0b' : '#ccc' }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        @if(request('price') === 'above500')
                                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #f59e0b;"></span>
                                        @endif
                                    </span>
                                    Trên 500.000đ
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- Sắp xếp --}}
                    <div style="margin-bottom: 10px;">
                        <h4 style="font-size: 15px; font-weight: 600; color: #333; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #f0f0f0;">Sắp xếp</h4>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 6px;">
                                <a href="{{ route('home', ['cat' => $category_slug, 'sort' => 'price_asc']) }}"
                                   style="display: flex; align-items: center; gap: 8px; padding: 7px 10px; border-radius: 6px; text-decoration: none; font-size: 14px; color: #555; transition: 0.2s;
                                   {{ request('sort') === 'price_asc' ? 'background: #fffbeb; color: #d97706; font-weight: 600;' : '' }}">
                                    <i class="fa-solid fa-arrow-up-short-wide" style="font-size: 12px; color: #bbb;"></i> Giá thấp → cao
                                </a>
                            </li>
                            <li style="margin-bottom: 6px;">
                                <a href="{{ route('home', ['cat' => $category_slug, 'sort' => 'price_desc']) }}"
                                   style="display: flex; align-items: center; gap: 8px; padding: 7px 10px; border-radius: 6px; text-decoration: none; font-size: 14px; color: #555; transition: 0.2s;
                                   {{ request('sort') === 'price_desc' ? 'background: #fffbeb; color: #d97706; font-weight: 600;' : '' }}">
                                    <i class="fa-solid fa-arrow-down-wide-short" style="font-size: 12px; color: #bbb;"></i> Giá cao → thấp
                                </a>
                            </li>
                            <li style="margin-bottom: 6px;">
                                <a href="{{ route('home', ['cat' => $category_slug, 'sort' => 'newest']) }}"
                                   style="display: flex; align-items: center; gap: 8px; padding: 7px 10px; border-radius: 6px; text-decoration: none; font-size: 14px; color: #555; transition: 0.2s;
                                   {{ request('sort') === 'newest' ? 'background: #fffbeb; color: #d97706; font-weight: 600;' : '' }}">
                                    <i class="fa-solid fa-clock" style="font-size: 12px; color: #bbb;"></i> Mới nhất
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- Nút xóa bộ lọc --}}
                    @if(request('price') || request('sort'))
                    <a href="{{ route('home', ['cat' => $category_slug]) }}"
                       style="display: block; text-align: center; padding: 8px; border: 1px solid #eee; border-radius: 8px; text-decoration: none; font-size: 13px; color: #999; margin-top: 10px; transition: 0.2s;">
                        <i class="fa-solid fa-xmark" style="font-size: 11px;"></i> Xóa bộ lọc
                    </a>
                    @endif
                </div>
            </div>

            {{-- Sản phẩm bên phải --}}
            <div>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px;">
                    @forelse($products as $item)
                        <div class="product-card">
                            <span class="product-tag">{{ $item->tag }}</span>
                            <a href="{{ route('product.show', $item->id) }}">
                                <img src="{{ product_image($item->thumbnail_url) }}" alt="{{ $item->name }}">
                            </a>
                            <div class="product-info">
                                <h3 class="product-name">
                                    <a href="{{ route('product.show', $item->id) }}">{{ $item->name }}</a>
                                </h3>
                                <p class="product-price">{{ number_format($item->price, 0, ',', '.') }}đ</p>
                            </div>
                        </div>
                    @empty
                        <p style="text-align: center; grid-column: 1/-1; padding: 40px 0; color: #999;">Rất tiếc, không tìm thấy sản phẩm nào.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </section>
    @else
    {{-- Trang chủ: hiển thị bình thường --}}
    <section class="product-section container" id="products" style="padding-bottom: 20px;">
        <h2 class="section-title">Sản Phẩm Nổi Bật</h2>

        <div class="product-grid">
            @forelse($products as $item)
                <div class="product-card">
                    <span class="product-tag">{{ $item->tag }}</span>
                    <a href="{{ route('product.show', $item->id) }}">
                        <img src="{{ product_image($item->thumbnail_url) }}" alt="{{ $item->name }}">
                    </a>
                    <button class="btn-ai-tryon"><i class="fa-solid fa-wand-magic-sparkles"></i> Thử đồ AI</button>
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
    @endif

    @if(!$keyword && !$category_slug)

    {{-- 4. Banner quảng cáo giữa trang --}}
    <section style="padding: 20px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; height: 320px;">
                {{-- Banner trái --}}
                <a href="{{ route('home', ['cat' => 'nu']) }}" style="display: block; position: relative; border-radius: 12px; overflow: hidden; height: 100%;">
                    <img src="{{ asset('images/banners/promo-banner.jpg') }}" alt="Bộ sưu tập"
                         style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.1) 60%, transparent 100%);"></div>
                    <div style="position: absolute; bottom: 30px; left: 30px; z-index: 1;">
                        <p style="color: rgba(255,255,255,0.7); font-size: 12px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px;">Bộ sưu tập</p>
                        <h3 style="color: #fff; font-size: 24px; font-weight: 700; margin-bottom: 12px;">Xu hướng mùa hè 2026</h3>
                        <span style="display: inline-block; color: #fff; font-size: 13px; border: 1px solid rgba(255,255,255,0.5); padding: 6px 16px; border-radius: 20px; transition: 0.3s;">
                            Khám phá ngay <i class="fa-solid fa-arrow-right" style="font-size: 11px;"></i>
                        </span>
                    </div>
                </a>

                {{-- Banner phải --}}
                <div style="display: grid; grid-template-rows: 1fr 1fr; gap: 20px; height: 100%;">
                    <a href="{{ route('home', ['cat' => 'nam']) }}" style="display: block; position: relative; border-radius: 12px; overflow: hidden;">
                        <div style="height: 100%; background: linear-gradient(135deg, #d4a574 0%, #b8875a 100%); display: flex; align-items: center; padding: 25px 30px; position: relative;">
                            <div style="position: relative; z-index: 1;">
                                <p style="color: rgba(255,255,255,0.7); font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px;">Ưu đãi đặc biệt</p>
                                <h3 style="color: #fff; font-size: 22px; font-weight: 700; margin-bottom: 6px;">Giảm đến 30%</h3>
                                <span style="color: rgba(255,255,255,0.8); font-size: 13px;">Áo thun, Polo, Sơ mi</span>
                            </div>
                            <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; border-radius: 50%; border: 1.5px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-arrow-right" style="color: #fff; font-size: 16px;"></i>
                            </div>
                            <div style="position: absolute; right: -30px; top: -30px; width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.08);"></div>
                        </div>
                    </a>
                    <a href="#" style="display: block; position: relative; border-radius: 12px; overflow: hidden;">
                        <div style="height: 100%; background: linear-gradient(135deg, #2c3345 0%, #1a1f2e 100%); display: flex; align-items: center; padding: 25px 30px; position: relative;">
                            <div style="position: relative; z-index: 1;">
                                <p style="color: rgba(255,255,255,0.5); font-size: 11px; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 5px;">Công nghệ mới</p>
                                <h3 style="color: #fff; font-size: 22px; font-weight: 700; margin-bottom: 6px;">AI Thử Đồ</h3>
                                <span style="color: rgba(255,255,255,0.6); font-size: 13px;">Trải nghiệm miễn phí</span>
                            </div>
                            <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); width: 50px; height: 50px; border-radius: 50%; border: 1.5px solid rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-wand-magic-sparkles" style="color: rgba(255,255,255,0.5); font-size: 16px;"></i>
                            </div>
                            <div style="position: absolute; right: -30px; bottom: -30px; width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.04);"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. Sản phẩm mới nhất --}}
    <section class="product-section container" style="padding: 30px 15px;">
        <h2 class="section-title">Sản Phẩm Mới Nhất</h2>
        <div class="product-grid">
            @foreach($newProducts as $item)
                <div class="product-card">
                    <span class="product-tag">{{ $item->tag }}</span>
                    <a href="{{ route('product.show', $item->id) }}">
                        <img src="{{ product_image($item->thumbnail_url) }}" alt="{{ $item->name }}">
                    </a>
                    <button class="btn-ai-tryon"><i class="fa-solid fa-wand-magic-sparkles"></i> Thử đồ AI</button>
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

    {{-- Banner Sale --}}
    <section style="padding: 20px 0 0;">
        <div class="container">
            <a href="#" style="display: block; border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('images/banners/banner_sale.jpg') }}" alt="Sale"
                     style="width: 100%; display: block; border-radius: 12px;">
            </a>
        </div>
    </section>

    {{-- 6. Sản phẩm Sale --}}
    @if($saleProducts->count() > 0)
    <section class="product-section container" style="padding: 30px 15px;">
        <h2 class="section-title"><i class="fa-solid fa-percent" style="color: #dc3545;"></i> Đang Giảm Giá</h2>
        <div class="product-grid">
            @foreach($saleProducts as $item)
                <div class="product-card">
                    <span class="product-tag" style="background: #dc3545;">{{ $item->tag }}</span>
                    <a href="{{ route('product.show', $item->id) }}">
                        <img src="{{ product_image($item->thumbnail_url) }}" alt="{{ $item->name }}">
                    </a>
                    <button class="btn-ai-tryon"><i class="fa-solid fa-wand-magic-sparkles"></i> Thử đồ AI</button>
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

    {{-- Banner cam kết --}}
    <section style="padding: 35px 15px; margin: 10px 0;">
        <div class="container">
            <div style="background: #63b1bc; border-radius: 12px; padding: 24px 20px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; text-align: center;">
                <div style="display: flex; align-items: center; gap: 14px; justify-content: center;">
                    <div style="width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-truck-fast" style="font-size: 16px; color: #fff;"></i>
                    </div>
                    <div style="text-align: left;">
                        <h4 style="font-size: 13px; color: #fff; margin-bottom: 2px; font-weight: 600;">Miễn phí vận chuyển</h4>
                        <p style="color: rgba(255,255,255,0.7); font-size: 12px;">Đơn từ 500.000đ</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; justify-content: center;">
                    <div style="width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-rotate-left" style="font-size: 16px; color: #fff;"></i>
                    </div>
                    <div style="text-align: left;">
                        <h4 style="font-size: 13px; color: #fff; margin-bottom: 2px; font-weight: 600;">Đổi trả dễ dàng</h4>
                        <p style="color: rgba(255,255,255,0.7); font-size: 12px;">Trong vòng 60 ngày</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; justify-content: center;">
                    <div style="width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-wand-magic-sparkles" style="font-size: 16px; color: #fff;"></i>
                    </div>
                    <div style="text-align: left;">
                        <h4 style="font-size: 13px; color: #fff; margin-bottom: 2px; font-weight: 600;">AI Thử Đồ</h4>
                        <p style="color: rgba(255,255,255,0.7); font-size: 12px;">Công nghệ tiên tiến</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 14px; justify-content: center;">
                    <div style="width: 45px; height: 45px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-shield" style="font-size: 16px; color: #fff;"></i>
                    </div>
                    <div style="text-align: left;">
                        <h4 style="font-size: 13px; color: #fff; margin-bottom: 2px; font-weight: 600;">Chất lượng đảm bảo</h4>
                        <p style="color: rgba(255,255,255,0.7); font-size: 12px;">100% chính hãng</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 7. Sản phẩm bán chạy --}}
    @if($hotProducts->count() > 0)
    <section class="product-section container" style="padding: 30px 15px;">
        <h2 class="section-title"><i class="fa-solid fa-fire" style="color: #e74c3c;"></i> Sản Phẩm Bán Chạy</h2>
        <div class="product-grid">
            @foreach($hotProducts as $item)
                <div class="product-card">
                    <span class="product-tag">{{ $item->tag }}</span>
                    <a href="{{ route('product.show', $item->id) }}">
                        <img src="{{ product_image($item->thumbnail_url) }}" alt="{{ $item->name }}">
                    </a>
                    <button class="btn-ai-tryon"><i class="fa-solid fa-wand-magic-sparkles"></i> Thử đồ AI</button>
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

    {{-- 8. Đã chuyển cam kết lên trên --}}

    @endif

@endsection