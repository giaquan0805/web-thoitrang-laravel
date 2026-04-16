@extends('layouts.app')

@section('title', $product->name . ' - Fashion AI')

@section('content')

<div class="product-detail">

    {{-- Cột trái: Ảnh sản phẩm --}}
    <div class="product-images">
        <div class="main-image">
            <img id="main-img"
                 src="{{ product_image($product->images->first()->image_url ?? $product->thumbnail_url) }}"
                 alt="{{ $product->name }}">
        </div>

        <div class="thumbnail-list">
            @foreach($product->images as $img)
                <img src="{{ product_image($img->image_url) }}"
                     alt="{{ $product->name }}"
                     onclick="document.getElementById('main-img').src='{{ product_image($img->image_url) }}'">
            @endforeach
        </div>
    </div>

    {{-- Cột phải: Thông tin sản phẩm --}}
    <div class="product-info-detail">
        <span class="product-tag">{{ $product->tag }}</span>
        <h1>{{ $product->name }}</h1>
        <p class="detail-price">{{ number_format($product->price, 0, ',', '.') }}đ</p>
        <p class="detail-desc">{{ $product->description }}</p>

        {{-- Chọn Size --}}
        <div class="variant-section">
            <label>Chọn Size:</label>
            <div class="size-options">
                @foreach($product->variants->unique('size') as $variant)
                    <button class="size-btn"
                            onclick="selectSize(this, {{ $variant->id }})">
                        {{ $variant->size }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Màu sắc --}}
        <div class="variant-section">
            <label>Màu sắc:</label>
            <div class="color-text">
                @foreach($product->variants->unique('color') as $variant)
                    <span>{{ $variant->color }}</span>
                @endforeach
            </div>
        </div>

        {{-- Số lượng --}}
        <div class="qty-section">
            <label>Số lượng:</label>
            <div class="qty-control">
                <button onclick="changeQty(-1)">-</button>
                <span id="qty">1</span>
                <button onclick="changeQty(1)">+</button>
            </div>
        </div>

        {{-- Nút hành động --}}
        <div class="product-actions">
            <button class="btn-ai-tryon">✨ Thử đồ AI</button>
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_variant_id" id="selected_variant"
                       value="{{ $product->variants->first()->id ?? '' }}">
                <input type="hidden" name="quantity" id="selected_qty" value="1">
                <button type="submit" class="btn-add-cart">🛒 Thêm vào giỏ</button>
            </form>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
let selectedVariantId = {{ $product->variants->first()->id ?? 0 }};
let qty = 1;

function selectSize(btn, variantId) {
    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    selectedVariantId = variantId;
    document.getElementById('selected_variant').value = variantId;
}

function changeQty(delta) {
    qty = Math.max(1, qty + delta);
    document.getElementById('qty').innerText = qty;
    document.getElementById('selected_qty').value = qty;
}
</script>
@endpush