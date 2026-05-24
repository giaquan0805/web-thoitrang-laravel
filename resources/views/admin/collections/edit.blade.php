@extends('admin.layouts.app')

@section('title', 'Sửa bộ sưu tập')
@section('page-title', 'Sửa bộ sưu tập')

@section('content')

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-pen-to-square" style="color: #f57c00;"></i> Sửa: {{ $collection->name }}</h5>
        <a href="{{ route('admin.collections.index') }}" class="btn btn-sm" style="background: #eee; color: #333;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.collections.update', $collection->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Tên bộ sưu tập</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $collection->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Loại</label>
                    <select name="type" class="form-control">
                        <option value="seasonal" {{ $collection->type === 'seasonal' ? 'selected' : '' }}>Theo mùa</option>
                        <option value="trending" {{ $collection->type === 'trending' ? 'selected' : '' }}>Xu hướng</option>
                        <option value="sale" {{ $collection->type === 'sale' ? 'selected' : '' }}>Khuyến mãi</option>
                        <option value="other" {{ $collection->type === 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $collection->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ $collection->status == 0 ? 'selected' : '' }}>Bản nháp</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Ảnh banner</label>
                    @if($collection->banner_url)
                        <div style="margin-bottom: 8px;">
                            <img src="{{ asset('storage/' . $collection->banner_url) }}" style="width: 120px; height: 70px; object-fit: cover; border-radius: 6px;">
                        </div>
                    @endif
                    <input type="file" name="banner" class="form-control" accept="image/*">
                    <p style="font-size: 12px; color: #999; margin-top: 4px;">Để trống nếu không đổi ảnh</p>
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $collection->description) }}</textarea>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <h4 style="font-size: 15px; font-weight: 600; margin-bottom: 12px;">
                    <i class="fa-solid fa-shirt" style="color: #1976d2;"></i> Chọn sản phẩm ({{ $collection->products->count() }} đã chọn)
                </h4>
                <div style="max-height: 400px; overflow-y: auto; border: 1px solid #f0f0f0; border-radius: 8px; padding: 15px;">
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                        @foreach($products as $product)
                        <label style="display: flex; align-items: center; gap: 8px; padding: 8px; border: 1px solid {{ $collection->products->contains($product->id) ? '#f59e0b' : '#f0f0f0' }}; border-radius: 8px; cursor: pointer; transition: 0.2s; font-size: 13px; {{ $collection->products->contains($product->id) ? 'background: #fffbeb;' : '' }}">
                            <input type="checkbox" name="products[]" value="{{ $product->id }}" {{ $collection->products->contains($product->id) ? 'checked' : '' }} style="accent-color: #f59e0b;">
                            @if($product->thumbnail_url)
                                <img src="{{ product_image($product->thumbnail_url) }}" style="width: 35px; height: 35px; object-fit: cover; border-radius: 4px;">
                            @endif
                            <span style="flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $product->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Cập nhật</button>
                <a href="{{ route('admin.collections.index') }}" class="btn" style="background: #eee; color: #333; margin-left: 10px;">Hủy</a>
            </div>
        </form>
    </div>
</div>

@endsection