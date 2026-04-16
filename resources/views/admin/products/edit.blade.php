@extends('admin.layouts.app')

@section('title', 'Sửa sản phẩm')
@section('page-title', 'Sửa sản phẩm')

@section('content')

<div class="card">
    <div class="card-header">
        <h5>✏️ Sửa sản phẩm: {{ $product->name }}</h5>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm" style="background: #eee; color: #333;">← Quay lại</a>
    </div>
    <div class="card-body">

        {{-- Form cập nhật sản phẩm --}}
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    @error('name')<span style="color:red;font-size:12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Giá (đồng)</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required min="0">
                </div>

                <div class="form-group">
                    <label>Tag</label>
                    <select name="tag" class="form-control">
                        <option value="Mới" {{ old('tag', $product->tag) == 'Mới' ? 'selected' : '' }}>Mới</option>
                        <option value="Bán chạy" {{ old('tag', $product->tag) == 'Bán chạy' ? 'selected' : '' }}>Bán chạy</option>
                        <option value="Sale" {{ old('tag', $product->tag) == 'Sale' ? 'selected' : '' }}>Sale</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Ảnh thumbnail</label>
                    @if($product->thumbnail_url)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ product_image($product->thumbnail_url) }}"
                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                        <p style="font-size: 12px; color: #666; margin-top: 5px;">Ảnh hiện tại</p>
                    </div>
                    @endif
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    <p style="font-size: 12px; color: #999; margin-top: 5px;">Để trống nếu không muốn đổi ảnh</p>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>URL ảnh AI (ai_clean_image_url)</label>
                    <input type="text" name="ai_clean_image_url" class="form-control"
                        value="{{ old('ai_clean_image_url', $product->ai_clean_image_url) }}">
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Mô tả sản phẩm</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div style="margin-top: 15px;">
                <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
                <a href="{{ route('admin.products.index') }}" class="btn" style="background: #eee; color: #333; margin-left: 10px;">Hủy</a>
            </div>
        </form>

        {{-- Quản lý biến thể (form riêng biệt) --}}
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <h4 style="margin-bottom: 15px;">📦 Biến thể sản phẩm (Size & Màu)</h4>

            {{-- Danh sách biến thể hiện có --}}
            @if($product->variants->count() > 0)
            <table style="width:100%; margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th style="text-align:left; padding: 8px; background:#f5f5f5;">Size</th>
                        <th style="text-align:left; padding: 8px; background:#f5f5f5;">Màu</th>
                        <th style="text-align:left; padding: 8px; background:#f5f5f5;">Tồn kho</th>
                        <th style="text-align:left; padding: 8px; background:#f5f5f5;">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->variants as $variant)
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $variant->size }}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $variant->color }}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">{{ $variant->stock_quantity }}</td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">
                            <form action="{{ route('admin.variants.destroy', $variant->id) }}" method="POST"
                                onsubmit="return confirm('Xóa biến thể này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="color: #999; margin-bottom: 15px;">Chưa có biến thể nào.</p>
            @endif

            {{-- Form thêm biến thể mới --}}
            <h5 style="margin-bottom: 10px;">➕ Thêm biến thể mới</h5>
            <form action="{{ route('admin.variants.store', $product->id) }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; align-items: end;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Size</label>
                        <input type="text" name="size" class="form-control" placeholder="S, M, L, XL, 29...">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Màu sắc</label>
                        <input type="text" name="color" class="form-control" placeholder="Đen, Trắng, Xanh...">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Tồn kho</label>
                        <input type="number" name="stock_quantity" class="form-control" value="10" min="0">
                    </div>
                    <button type="submit" class="btn btn-success">+ Thêm</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection