@extends('admin.layouts.app')

@section('title', 'Sửa sản phẩm')
@section('page-title', 'Sửa sản phẩm')

@section('content')

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-pen-to-square" style="color: #f57c00;"></i> Sửa sản phẩm: {{ $product->name }}</h5>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm" style="background: #eee; color: #333;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
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
                        <option value="Nổi bật" {{ old('tag', $product->tag) == 'Nổi bật' ? 'selected' : '' }}>Nổi bật</option>
                        <option value="Bán chạy" {{ old('tag', $product->tag) == 'Bán chạy' ? 'selected' : '' }}>Bán chạy</option>
                        <option value="Sale" {{ old('tag', $product->tag) == 'Sale' ? 'selected' : '' }}>Sale</option>
                    </select>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label><i class="fa-regular fa-image" style="color: #1976d2;"></i> Ảnh chính</label>
                    @if($product->thumbnail_url)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ product_image($product->thumbnail_url) }}"
                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px;">
                        <p style="font-size: 12px; color: #666; margin-top: 5px;">Ảnh hiện tại</p>
                    </div>
                    @endif
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    <p style="font-size: 12px; color: #999; margin-top: 5px;">Để trống nếu không muốn đổi ảnh</p>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label><i class="fa-solid fa-images" style="color: #7b1fa2;"></i> Thêm ảnh chi tiết</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    <p style="font-size: 12px; color: #999; margin-top: 5px;">Chọn nhiều ảnh để thêm (giữ Ctrl + click). Ảnh cũ vẫn được giữ lại.</p>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Mô tả sản phẩm</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div style="margin-top: 15px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk"></i> Cập nhật
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn" style="background: #eee; color: #333; margin-left: 10px;">Hủy</a>
            </div>
        </form>

        {{-- Ảnh chi tiết hiện có (TÁCH RA NGOÀI form cập nhật) --}}
        @if($product->images->count() > 0)
        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee;">
            <h4 style="margin-bottom: 15px;"><i class="fa-solid fa-images" style="color: #7b1fa2;"></i> Ảnh chi tiết hiện có ({{ $product->images->count() }} ảnh)</h4>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                @foreach($product->images as $img)
                <div style="position: relative; width: 100px; height: 100px;">
                    <img src="{{ asset('storage/' . $img->image_url) }}"
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px; border: 1px solid #eee;">
                    <form action="{{ route('admin.product-images.destroy', $img->id) }}" method="POST"
                          onsubmit="return confirm('Xóa ảnh này?')"
                          style="position: absolute; top: -6px; right: -6px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width: 22px; height: 22px; border-radius: 50%; background: #dc3545; color: #fff; border: 2px solid #fff; font-size: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 0;">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Quản lý biến thể --}}
        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee;">
            <h4 style="margin-bottom: 15px;"><i class="fa-solid fa-layer-group" style="color: #1976d2;"></i> Biến thể sản phẩm (Size & Màu)</h4>

            @if($product->variants->count() > 0)
            <table style="width:100%; margin-bottom: 20px; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align:left; padding: 8px; background:#f5f5f5; width: 25%;">Size</th>
                        <th style="text-align:left; padding: 8px; background:#f5f5f5; width: 25%;">Màu</th>
                        <th style="text-align:left; padding: 8px; background:#f5f5f5; width: 25%;">Tồn kho</th>
                        <th style="text-align:center; padding: 8px; background:#f5f5f5; width: 25%;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->variants as $variant)
                    <tr>
                        <form action="{{ route('admin.variants.update', $variant->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <td style="padding: 8px; border-bottom: 1px solid #eee;">
                                <input type="text" name="size" value="{{ $variant->size }}" class="form-control" style="padding: 6px 10px; font-size: 13px;">
                            </td>
                            <td style="padding: 8px; border-bottom: 1px solid #eee;">
                                <input type="text" name="color" value="{{ $variant->color }}" class="form-control" style="padding: 6px 10px; font-size: 13px;">
                            </td>
                            <td style="padding: 8px; border-bottom: 1px solid #eee;">
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    <input type="number" name="stock_quantity" value="{{ $variant->stock_quantity }}" class="form-control" min="0" style="padding: 6px 10px; font-size: 13px; width: 80px;">
                                    @if($variant->stock_quantity == 0)
                                        <span style="color: #dc3545; font-size: 11px; white-space: nowrap;">Hết hàng</span>
                                    @elseif($variant->stock_quantity <= 5)
                                        <span style="color: #f57c00; font-size: 11px; white-space: nowrap;">Sắp hết</span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 8px; border-bottom: 1px solid #eee; text-align: center; white-space: nowrap;">
                                <button type="submit" class="btn btn-sm btn-success" title="Lưu">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Xóa"
                                        onclick="if(confirm('Xóa biến thể này?')) document.getElementById('delete-variant-{{ $variant->id }}').submit();">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </td>
                        </form>
                    </tr>
                    <form id="delete-variant-{{ $variant->id }}" action="{{ route('admin.variants.destroy', $variant->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="color: #999; margin-bottom: 15px;">Chưa có biến thể nào.</p>
            @endif

            <h5 style="margin-bottom: 10px;"><i class="fa-solid fa-plus" style="color: #28a745;"></i> Thêm biến thể mới</h5>
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