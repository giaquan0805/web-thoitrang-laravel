@extends('layouts.app')

@section('title', 'Bộ sưu tập - Fashion AI')

@section('content')

<div class="container" style="padding: 40px 15px 60px;">

    <div style="text-align: center; margin-bottom: 40px;">
        <h2 style="font-size: 28px; font-weight: 700; margin-bottom: 8px;">Bộ Sưu Tập</h2>
        <p style="color: #999; font-size: 14px;">Khám phá các bộ sưu tập thời trang được tuyển chọn</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px;">
        @forelse($collections as $col)
        <a href="{{ route('collections.show', $col->id) }}" style="text-decoration: none; color: #333;">
            <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08); transition: all 0.3s; background: #fff;">
                <div style="height: 220px; overflow: hidden; position: relative;">
                    @if($col->banner_url)
                        <img src="{{ asset('storage/' . $col->banner_url) }}" alt="{{ $col->name }}"
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                    @else
                        <div style="height: 100%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-layer-group" style="font-size: 40px; color: rgba(255,255,255,0.5);"></i>
                        </div>
                    @endif
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.6)); padding: 20px 15px 15px;">
                        <h3 style="color: #fff; font-size: 20px; font-weight: 600;">{{ $col->name }}</h3>
                        <p style="color: rgba(255,255,255,0.8); font-size: 13px;">{{ $col->products_count }} sản phẩm</p>
                    </div>
                </div>
                @if($col->description)
                <div style="padding: 15px;">
                    <p style="color: #666; font-size: 13px; line-height: 1.5;">{{ \Illuminate\Support\Str::limit($col->description, 100) }}</p>
                </div>
                @endif
            </div>
        </a>
        @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 60px 0;">
            <i class="fa-solid fa-layer-group" style="font-size: 40px; color: #ddd; margin-bottom: 15px; display: block;"></i>
            <p style="color: #999; font-size: 16px;">Chưa có bộ sưu tập nào.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection

@push('styles')
<style>
    .container > div:last-child > a > div:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    .container > div:last-child > a > div:hover img {
        transform: scale(1.05);
    }
</style>
@endpush