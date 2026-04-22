@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm')
@section('page-title', 'Thêm sản phẩm mới')

@section('content')

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-plus" style="color: #28a745;"></i> Thêm sản phẩm mới</h5>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm" style="background: #eee; color: #333;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
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
                        <option value="Nổi bật" {{ old('tag') == 'Nổi bật' ? 'selected' : '' }}>Nổi bật</option>
                        <option value="Bán chạy" {{ old('tag') == 'Bán chạy' ? 'selected' : '' }}>Bán chạy</option>
                        <option value="Sale" {{ old('tag') == 'Sale' ? 'selected' : '' }}>Sale</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label><i class="fa-regular fa-image" style="color: #1976d2;"></i> Ảnh thumbnail (ảnh chính)</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    @error('thumbnail')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label><i class="fa-solid fa-images" style="color: #7b1fa2;"></i> Ảnh chi tiết (chọn nhiều ảnh)</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    @error('images.*')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                    <p style="font-size: 12px; color: #999; margin-top: 5px;">Có thể chọn nhiều ảnh cùng lúc (giữ Ctrl + click). Ảnh sẽ hiển thị trong trang chi tiết sản phẩm.</p>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Mô tả sản phẩm</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>
            </div>

            <div style="margin-top: 10px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu sản phẩm
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn" style="background: #eee; color: #333; margin-left: 10px;">Hủy</a>
            </div>
        </form>
    </div>
</div>

@endsection