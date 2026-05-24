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
                <div style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                    @php
                        $colorMap = [
                            'đen' => '#222222',
                            'den' => '#222222',
                            'trắng' => '#ffffff',
                            'trang' => '#ffffff',
                            'đỏ' => '#e74c3c',
                            'do' => '#e74c3c',
                            'xanh' => '#2196F3',
                            'xanh dương' => '#2196F3',
                            'xanh navy' => '#1a237e',
                            'xanh lá' => '#4CAF50',
                            'xanh rêu' => '#556B2F',
                            'vàng' => '#FFC107',
                            'vang' => '#FFC107',
                            'cam' => '#FF9800',
                            'hồng' => '#E91E63',
                            'hong' => '#E91E63',
                            'tím' => '#9C27B0',
                            'tim' => '#9C27B0',
                            'nâu' => '#795548',
                            'nau' => '#795548',
                            'xám' => '#9E9E9E',
                            'xam' => '#9E9E9E',
                            'be' => '#F5F5DC',
                            'kem' => '#FFFDD0',
                            'ghi' => '#808080',
                        ];
                    @endphp
                    @foreach($product->variants->unique('color') as $index => $variant)
                        @php
                            $colorCode = $colorMap[mb_strtolower($variant->color)] ?? '#ccc';
                            $isWhite = in_array(mb_strtolower($variant->color), ['trắng', 'trang', 'kem', 'be']);
                        @endphp
                        <button class="color-btn {{ $index === 0 ? 'active' : '' }}"
                                onclick="selectColor(this, '{{ $variant->color }}')"
                                data-color="{{ $variant->color }}"
                                title="{{ $variant->color }}"
                                style="width: 36px; height: 36px; border-radius: 50%; background: {{ $colorCode }}; border: 2px solid {{ $isWhite ? '#ddd' : 'transparent' }}; cursor: pointer; padding: 0; position: relative; transition: 0.2s;">
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
            <div style="display: flex; gap: 12px; margin-bottom: 20px; align-items: stretch;">
                <form action="{{ route('cart.add') }}" method="POST" style="flex: 1;">
                    @csrf
                    <input type="hidden" name="product_variant_id" id="selected_variant"
                           value="{{ $product->variants->first()->id ?? '' }}">
                    <input type="hidden" name="quantity" id="selected_qty" value="1">
                    <button type="submit" id="btn-add-cart"
                            style="width: 100%; height: 100%; padding: 14px; background: #222; color: #fff; border: none; border-radius: 50px; font-size: 15px; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        <i class="fa-solid fa-bag-shopping"></i> Thêm vào giỏ
                    </button>
                </form>

                <a href="{{ route('ai.tryon', $product->id) }}" class="btn-tryon-ai"
                   style="padding: 14px 28px; background: linear-gradient(135deg, #667eea, #764ba2); color: #fff; border: none; border-radius: 50px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 8px; text-decoration: none; white-space: nowrap;">
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

{{-- Section Đánh giá sản phẩm --}}
<div class="container" style="padding: 0 15px 50px;">
    <div style="border-top: 1px solid #f0f0f0; padding-top: 40px;">

        {{-- Header đánh giá --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">

            {{-- Tổng quan --}}
            <div style="background: #fafafa; border-radius: 12px; padding: 25px; text-align: center;">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 15px;">Đánh giá sản phẩm</h3>
                <div style="font-size: 48px; font-weight: 700; color: #f59e0b; margin-bottom: 8px;">{{ number_format($avgRating, 1) }}</div>
                <div style="margin-bottom: 8px;">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star" style="font-size: 18px; color: {{ $i <= round($avgRating) ? '#f59e0b' : '#ddd' }};"></i>
                    @endfor
                </div>
                <p style="color: #999; font-size: 14px;">Dựa trên {{ $reviewCount }} đánh giá</p>
            </div>

            {{-- Phân bố sao --}}
            <div style="background: #fafafa; border-radius: 12px; padding: 25px;">
                <h4 style="font-size: 15px; font-weight: 600; margin-bottom: 15px;">Phân bố đánh giá</h4>
                @for($star = 5; $star >= 1; $star--)
                    @php
                        $starCount = $reviews->where('rating', $star)->count();
                        $percent = $reviewCount > 0 ? round($starCount / $reviewCount * 100) : 0;
                    @endphp
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <span style="font-size: 13px; color: #666; min-width: 45px;">{{ $star }} <i class="fa-solid fa-star" style="font-size: 11px; color: #f59e0b;"></i></span>
                        <div style="flex: 1; height: 8px; background: #eee; border-radius: 4px; overflow: hidden;">
                            <div style="width: {{ $percent }}%; height: 100%; background: #f59e0b; border-radius: 4px;"></div>
                        </div>
                        <span style="font-size: 12px; color: #999; min-width: 35px;">{{ $percent }}%</span>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Form viết đánh giá --}}
        @auth
            @php
                $hasReviewed = $reviews->where('user_id', Auth::id())->count() > 0;
            @endphp
            @if(!$hasReviewed)
            <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 15px;">
                    <i class="fa-solid fa-pen" style="color: #f59e0b;"></i> Viết đánh giá
                </h4>

                @if(session('success'))
                    <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 10px 14px; border-radius: 8px; margin-bottom: 15px; font-size: 13px;">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 10px 14px; border-radius: 8px; margin-bottom: 15px; font-size: 13px;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('review.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div style="margin-bottom: 15px;">
                        <label style="font-size: 14px; font-weight: 500; color: #555; display: block; margin-bottom: 8px;">Chọn số sao:</label>
                        <div class="star-rating" style="display: flex; gap: 4px;">
                            @for($i = 1; $i <= 5; $i++)
                                <label style="cursor: pointer;">
                                    <input type="radio" name="rating" value="{{ $i }}" style="display: none;" {{ $i == 5 ? 'checked' : '' }}>
                                    <i class="fa-solid fa-star star-input" data-value="{{ $i }}" style="font-size: 24px; color: {{ $i <= 5 ? '#f59e0b' : '#ddd' }}; transition: 0.2s;"></i>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="font-size: 14px; font-weight: 500; color: #555; display: block; margin-bottom: 8px;">Nhận xét:</label>
                        <textarea name="comment" rows="3" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..."
                                  style="width: 100%; padding: 12px; border: 1.5px solid #e5e5e5; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit; background: #fafafa;"></textarea>
                    </div>

                    <button type="submit" style="padding: 10px 28px; background: #f59e0b; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.3s;">
                        <i class="fa-solid fa-paper-plane"></i> Gửi đánh giá
                    </button>
                </form>
            </div>
            @else
            <div style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 12px; padding: 15px 20px; margin-bottom: 30px; font-size: 14px; color: #92400e;">
                <i class="fa-solid fa-circle-check" style="color: #f59e0b;"></i> Bạn đã đánh giá sản phẩm này.
            </div>
            @endif
        @else
            <div style="background: #f5f5f5; border-radius: 12px; padding: 20px; margin-bottom: 30px; text-align: center;">
                <p style="color: #666; font-size: 14px; margin-bottom: 10px;">Đăng nhập để viết đánh giá</p>
                <a href="{{ route('login') }}" style="display: inline-block; padding: 8px 24px; background: #222; color: #fff; border-radius: 8px; text-decoration: none; font-size: 14px;">Đăng nhập</a>
            </div>
        @endauth

        {{-- Danh sách đánh giá --}}
        <div>
            <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 15px;">{{ $reviewCount }} đánh giá</h4>

            @forelse($reviews as $review)
            <div style="border-bottom: 1px solid #f0f0f0; padding: 18px 0;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #f59e0b; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 14px;">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <span style="font-weight: 600; font-size: 14px; color: #333;">{{ $review->user->name }}</span>
                            <span style="color: #bbb; font-size: 12px; margin-left: 8px;">{{ $review->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div>
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star" style="font-size: 12px; color: {{ $i <= $review->rating ? '#f59e0b' : '#ddd' }};"></i>
                        @endfor
                    </div>
                </div>
                @if($review->comment)
                    <p style="color: #555; font-size: 14px; line-height: 1.6; margin-left: 46px;">{{ $review->comment }}</p>
                @endif
            </div>
            @empty
            <div style="text-align: center; padding: 30px 0; color: #999;">
                <i class="fa-regular fa-comment" style="font-size: 30px; margin-bottom: 10px; display: block; color: #ddd;"></i>
                <p>Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá!</p>
            </div>
            @endforelse
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

// Star rating interactive
document.querySelectorAll('.star-input').forEach(star => {
    star.addEventListener('click', function() {
        const value = this.dataset.value;
        document.querySelectorAll('.star-input').forEach((s, index) => {
            s.style.color = index < value ? '#f59e0b' : '#ddd';
        });
    });
    star.addEventListener('mouseenter', function() {
        const value = this.dataset.value;
        document.querySelectorAll('.star-input').forEach((s, index) => {
            s.style.color = index < value ? '#f59e0b' : '#ddd';
        });
    });
});
document.querySelector('.star-rating')?.addEventListener('mouseleave', function() {
    const checked = document.querySelector('input[name="rating"]:checked');
    const value = checked ? checked.value : 5;
    document.querySelectorAll('.star-input').forEach((s, index) => {
        s.style.color = index < value ? '#f59e0b' : '#ddd';
    });
});
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
    width: 36px; height: 36px; border-radius: 50%;
    cursor: pointer; padding: 0; position: relative;
    transition: 0.2s; outline: none;
}
.color-btn:hover { transform: scale(1.1); }
.color-btn.active {
    box-shadow: 0 0 0 3px #fff, 0 0 0 5px #f59e0b;
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

.btn-tryon-ai:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

@media (max-width: 768px) {
    .container > div:first-child { grid-template-columns: 1fr !important; }
}
</style>
@endpush