@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm')
@section('page-title', 'Thêm sản phẩm mới')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>➕ Thêm sản phẩm mới</h5>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm" style="background: #eee; color: #333;">← Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Giá (đồng)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price') }}" required min="0">
                    @error('price')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Tag</label>
                    <select name="tag" class="form-control">
                        <option value="Mới" {{ old('tag') == 'Mới' ? 'selected' : '' }}>Mới</option>
                        <option value="Bán chạy" {{ old('tag') == 'Bán chạy' ? 'selected' : '' }}>Bán chạy</option>
                        <option value="Sale" {{ old('tag') == 'Sale' ? 'selected' : '' }}>Sale</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Ảnh thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    @error('thumbnail')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>URL ảnh AI (ai_clean_image_url)</label>
                    <input type="text" name="ai_clean_image_url" class="form-control"
                        value="{{ old('ai_clean_image_url') }}"
                        placeholder="vd: images/products/sp-1/main.jpg">
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Mô tả sản phẩm</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>
            </div>

            <div style="margin-top: 10px;">
                <button type="submit" class="btn btn-primary">💾 Lưu sản phẩm</button>
                <a href="{{ route('admin.products.index') }}" class="btn" style="background: #eee; color: #333; margin-left: 10px;">Hủy</a>
            </div>
        </form>
    </div>
</div>

@endsection