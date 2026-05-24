@extends('admin.layouts.app')

@section('title', 'Tạo bộ sưu tập')
@section('page-title', 'Tạo bộ sưu tập')

@section('content')

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-plus" style="color: #28a745;"></i> Tạo bộ sưu tập mới</h5>
        <a href="{{ route('admin.collections.index') }}" class="btn btn-sm" style="background: #eee; color: #333;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.collections.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Tên bộ sưu tập</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="VD: Xu hướng Hè 2026">
                </div>
                <div class="form-group">
                    <label>Loại</label>
                    <select name="type" class="form-control">
                        <option value="seasonal">Theo mùa</option>
                        <option value="trending">Xu hướng</option>
                        <option value="sale">Khuyến mãi</option>
                        <option value="other">Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1">Hoạt động</option>
                        <option value="0">Bản nháp</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Ảnh banner</label>
                    <input type="file" name="banner" class="form-control" accept="image/*">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Mô tả ngắn về bộ sưu tập...">{{ old('description') }}</textarea>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <h4 style="font-size: 15px; font-weight: 600; margin-bottom: 12px;"><i class="fa-solid fa-shirt" style="color: #1976d2;"></i> Chọn sản phẩm</h4>
                <div style="max-height: 400px; overflow-y: auto; border: 1px solid #f0f0f0; border-radius: 8px; padding: 15px;">
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
                        @foreach($products as $product)
                        <label style="display: flex; align-items: center; gap: 8px; padding: 8px; border: 1px solid #f0f0f0; border-radius: 8px; cursor: pointer; transition: 0.2s; font-size: 13px;">
                            <input type="checkbox" name="products[]" value="{{ $product->id }}" style="accent-color: #f59e0b;">
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
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Tạo bộ sưu tập</button>
                <a href="{{ route('admin.collections.index') }}" class="btn" style="background: #eee; color: #333; margin-left: 10px;">Hủy</a>
            </div>
        </form>
    </div>
</div>

@endsection