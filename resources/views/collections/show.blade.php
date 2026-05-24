@extends('layouts.app')

@section('title', $collection->name . ' - Fashion AI')

@section('content')

{{-- Banner bộ sưu tập --}}
@if($collection->banner_url)
<section style="width: 100%; overflow: hidden;">
    <img src="{{ asset('storage/' . $collection->banner_url) }}" alt="{{ $collection->name }}"
         style="width: 100%; display: block;">
</section>
@endif

{{-- Sản phẩm trong bộ sưu tập --}}
<div class="container" style="padding: 40px 15px 60px;">

    @if(!$collection->banner_url)
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 8px;">{{ $collection->name }}</h1>
        @if($collection->description)
            <p style="color: #666; font-size: 14px;">{{ $collection->description }}</p>
        @endif
        <p style="color: #999; font-size: 13px; margin-top: 6px;">{{ $collection->products->count() }} sản phẩm</p>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
        @forelse($collection->products as $item)
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
            <p style="text-align: center; grid-column: 1/-1; padding: 40px 0; color: #999;">Bộ sưu tập chưa có sản phẩm nào.</p>
        @endforelse
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('collections.index') }}" style="color: #999; font-size: 14px; text-decoration: none;">
            <i class="fa-solid fa-arrow-left"></i> Xem tất cả bộ sưu tập
        </a>
    </div>
</div>

@endsection