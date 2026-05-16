@extends('layouts.app')

@section('title', $product->name . ' - Fashion AI')

@section('content')

<div class="container" style="padding: 30px 15px 50px;">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">

        {{-- Cột trái: Ảnh sản phẩm --}}
        <div>
            <div style="background: #f9f9f9; border-radius: 12px; overflow: hidden; margin-bottom: 12px;">
                <img id="main-img" src="{{ product_image($product->thumbnail_url) }}"
                     alt="{{ $product->name }}"
                     style="width: 100%; height: 500px; object-fit: contain; display: block;">
            </div>

            <div style="display: flex; gap: 8px; overflow-x: auto;">
                @if($product->thumbnail_url)
                    <img src="{{ product_image($product->thumbnail_url) }}"
                         class="thumb-img thumb-active"
                         onclick="changeMainImage(this, '{{ product_image($product->thumbnail_url) }}')">
                @endif

                @foreach($product->images as $img)
                    <img src="{{ product_image($img->image_url) }}"
                         class="thumb-img"
                         onclick="changeMainImage(this, '{{ product_image($img->image_url) }}')">
                @endforeach
            </div>
        </div>

        {{-- Cột phải: Thông tin sản phẩm --}}
        <div>
            <span style="display: inline-block; padding: 4px 12px; border-radius: 4px; font-size: 12px; font-weight: 600; color: #fff; background: #f59e0b; margin-bottom: 12px;">{{ $product->tag }}</span>

            <h1 style="font-size: 26px; font-weight: 700; color: #222; margin-bottom: 10px; line-height: 1.3;">{{ $product->name }}</h1>

            <p style="font-size: 24px; font-weight: 700; color: #e74c3c; margin-bottom: 15px;">{{ number_format($product->price, 0, ',', '.') }}đ</p>

            <p style="color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f0;">
                {{ $product->description }}
            </p>

            {{-- Chọn Màu sắc --}}
            <div style="margin-bottom: 20px;">
                <label style="font-weight: 600; font-size: 14px; color: #333; display: block; margin-bottom: 8px;">
                    Màu sắc: <span id="selected-color-text" style="font-weight: 400; color: #666;"></span>
                </label>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    @foreach($product->variants->unique('color') as $index => $variant)
                        <button class="color-btn {{ $index === 0 ? 'active' : '' }}"
                                onclick="selectColor(this, '{{ $variant->color }}')"
                                data-color="{{ $variant->color }}">
                            {{ $variant->color }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Chọn Size --}}
            <div style="margin-bottom: 20px;">
                <label style="font-weight: 600; font-size: 14px; color: #333; display: block; margin-bottom: 8px;">
                    Chọn Size: <span id="stock-info" style="font-weight: 400; font-size: 13px; color: #999;"></span>
                </label>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    @foreach($product->variants->unique('size') as $variant)
                        <button class="size-btn"
                                onclick="selectSize(this, '{{ $variant->size }}')"
                                data-size="{{ $variant->size }}">
                            {{ $variant->size }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Số lượng --}}
            <div style="margin-bottom: 25px;">
                <label style="font-weight: 600; font-size: 14px; color: #333; display: block; margin-bottom: 8px;">Số lượng:</label>
                <div style="display: flex; align-items: center; gap: 0;">
                    <button onclick="changeQty(-1)" style="width: 38px; height: 38px; border: 1.5px solid #ddd; border-radius: 6px 0 0 6px; background: #fff; cursor: pointer; font-size: 16px; color: #555;">-</button>
                    <span id="qty" style="width: 50px; height: 38px; border-top: 1.5px solid #ddd; border-bottom: 1.5px solid #ddd; display: flex; align-items: center; justify-content: center; font-weight: 500;">1</span>
                    <button onclick="changeQty(1)" style="width: 38px; height: 38px; border: 1.5px solid #ddd; border-radius: 0 6px 6px 0; background: #fff; cursor: pointer; font-size: 16px; color: #555;">+</button>
                </div>
            </div>

            {{-- Nút hành động --}}
            <div style="display: flex; gap: 12px; margin-bottom: 20px;">
                <form action="{{ route('cart.add') }}" method="POST" style="flex: 1;">
                    @csrf
                    <input type="hidden" name="product_variant_id" id="selected_variant"
                           value="{{ $product->variants->first()->id ?? '' }}">
                    <input type="hidden" name="quantity" id="selected_qty" value="1">
                    <button type="submit" id="btn-add-cart"
                            style="width: 100%; padding: 14px; background: #222; color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fa-solid fa-bag-shopping"></i> Thêm vào giỏ
                    </button>
                </form>

                <a href="{{ route('ai.tryon', $product->id) }}"
                   style="padding: 14px 24px; background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 8px; text-decoration: none; white-space: nowrap;">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Thử đồ AI
                </a>
            </div>

            {{-- Cam kết --}}
            <div style="background: #fafafa; border-radius: 10px; padding: 16px 20px; display: flex; gap: 20px; font-size: 13px; color: #666;">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-truck-fast" style="color: #f59e0b;"></i> Miễn phí ship từ 500k
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-rotate-left" style="color: #f59e0b;"></i> Đổi trả 60 ngày
                </div>
                <div style="display: flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-shield" style="color: #f59e0b;"></i> Chính hãng 100%
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
const variants = @json($product->variants);

let selectedColor = '{{ $product->variants->first()->color ?? '' }}';
let selectedSize = '';
let qty = 1;

document.getElementById('selected-color-text').innerText = selectedColor;

function selectColor(btn, color) {
    document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    selectedColor = color;
    document.getElementById('selected-color-text').innerText = color;
    selectedSize = '';
    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    updateSizeAvailability();
    updateVariant();
}

function selectSize(btn, size) {
    if (btn.classList.contains('disabled')) return;
    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    selectedSize = size;
    updateVariant();
}

function updateSizeAvailability() {
    document.querySelectorAll('.size-btn').forEach(btn => {
        const size = btn.dataset.size;
        const variant = variants.find(v => v.color === selectedColor && v.size === size);
        btn.classList.remove('disabled');
        if (!variant || variant.stock_quantity <= 0) {
            btn.classList.add('disabled');
        }
    });
}

function updateVariant() {
    const variant = variants.find(v => v.color === selectedColor && v.size === selectedSize);
    const stockInfo = document.getElementById('stock-info');
    const btnAdd = document.getElementById('btn-add-cart');

    if (variant) {
        document.getElementById('selected_variant').value = variant.id;
        if (variant.stock_quantity > 0 && variant.stock_quantity <= 5) {
            stockInfo.innerHTML = '<span style="color: #f59e0b;">Chỉ còn ' + variant.stock_quantity + ' sản phẩm</span>';
        } else if (variant.stock_quantity > 5) {
            stockInfo.innerHTML = '<span style="color: #28a745;">Còn hàng</span>';
        } else {
            stockInfo.innerHTML = '<span style="color: #dc3545;">Hết hàng</span>';
        }
        btnAdd.disabled = variant.stock_quantity <= 0;
    } else {
        stockInfo.innerText = '';
    }
}

function changeQty(delta) {
    qty = Math.max(1, qty + delta);
    document.getElementById('qty').innerText = qty;
    document.getElementById('selected_qty').value = qty;
}

function changeMainImage(thumb, imageUrl) {
    document.getElementById('main-img').src = imageUrl;
    document.querySelectorAll('.thumb-img').forEach(img => img.classList.remove('thumb-active'));
    thumb.classList.add('thumb-active');
}

updateSizeAvailability();
</script>
@endpush

@push('styles')
<style>
.thumb-img {
    width: 70px; height: 70px; object-fit: cover;
    border-radius: 8px; border: 2px solid transparent;
    cursor: pointer; opacity: 0.6; transition: 0.2s;
}
.thumb-img:hover { opacity: 1; }
.thumb-img.thumb-active { border-color: #f59e0b; opacity: 1; }

.color-btn {
    padding: 8px 18px; border: 1.5px solid #ddd;
    border-radius: 8px; background: #fff;
    cursor: pointer; font-size: 13px; font-weight: 500;
    transition: 0.2s; color: #333;
}
.color-btn:hover { border-color: #f59e0b; }
.color-btn.active {
    border-color: #f59e0b; background: #fffbeb;
    color: #d97706; font-weight: 600;
}

.size-btn {
    padding: 8px 16px; border: 1.5px solid #ddd;
    border-radius: 8px; background: #fff;
    cursor: pointer; font-size: 13px; font-weight: 500;
    transition: 0.2s; color: #333; min-width: 44px;
}
.size-btn:hover { border-color: #f59e0b; }
.size-btn.active {
    border-color: #f59e0b; background: #f59e0b; color: #fff;
}
.size-btn.disabled {
    opacity: 0.3; cursor: not-allowed;
    text-decoration: line-through; pointer-events: none;
}

#btn-add-cart:hover { background: #444; transform: translateY(-1px); }
#btn-add-cart:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

@media (max-width: 768px) {
    .container > div:first-child { grid-template-columns: 1fr !important; }
}
</style>
@endpush