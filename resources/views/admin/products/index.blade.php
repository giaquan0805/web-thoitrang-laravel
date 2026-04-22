@extends('admin.layouts.app')

@section('title', 'Quản lý sản phẩm')
@section('page-title', 'Quản lý sản phẩm')

@section('content')

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-box-open" style="color: #1976d2;"></i> Danh sách sản phẩm</h5>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Thêm sản phẩm</a>
    </div>

    {{-- Thanh tìm kiếm & lọc --}}
    <div style="padding: 15px 20px; border-bottom: 1px solid #f0f0f0; background: #fafafa;">
        <form action="{{ route('admin.products.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên sản phẩm..."
                   value="{{ request('keyword') }}" style="width: 250px; padding: 8px 12px;">

            <select name="category" class="form-control" style="width: 160px; padding: 8px 12px;">
                <option value="">-- Danh mục --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <select name="tag" class="form-control" style="width: 140px; padding: 8px 12px;">
                <option value="">-- Tag --</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag }}" {{ request('tag') == $tag ? 'selected' : '' }}>
                        {{ $tag }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">
                <i class="fa-solid fa-magnifying-glass"></i> Tìm
            </button>

            @if(request('keyword') || request('category') || request('tag'))
                <a href="{{ route('admin.products.index') }}" class="btn" style="background: #eee; color: #333; padding: 8px 16px;">
                    <i class="fa-solid fa-xmark"></i> Xóa lọc
                </a>
            @endif

            <span style="margin-left: auto; font-size: 13px; color: #999;">
                Tìm thấy {{ $products->total() }} sản phẩm
            </span>
        </form>
    </div>

    <div class="card-body" style="padding: 0;">
        <table>
            <thead>
                <tr>
                    <th>
                        <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'id', 'dir' => request('sort') == 'id' && request('dir') == 'desc' ? 'asc' : 'desc'])) }}"
                           style="text-decoration: none; color: #666;">
                            # {!! request('sort') == 'id' ? (request('dir') == 'asc' ? '&#9650;' : '&#9660;') : '' !!}
                        </a>
                    </th>
                    <th>Ảnh</th>
                    <th>
                        <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'name', 'dir' => request('sort') == 'name' && request('dir') == 'asc' ? 'desc' : 'asc'])) }}"
                           style="text-decoration: none; color: #666;">
                            Tên sản phẩm {!! request('sort') == 'name' ? (request('dir') == 'asc' ? '&#9650;' : '&#9660;') : '' !!}
                        </a>
                    </th>
                    <th>Danh mục</th>
                    <th>
                        <a href="{{ route('admin.products.index', array_merge(request()->query(), ['sort' => 'price', 'dir' => request('sort') == 'price' && request('dir') == 'desc' ? 'asc' : 'desc'])) }}"
                           style="text-decoration: none; color: #666;">
                            Giá {!! request('sort') == 'price' ? (request('dir') == 'asc' ? '&#9650;' : '&#9660;') : '' !!}
                        </a>
                    </th>
                    <th>Tồn kho</th>
                    <th>Tag</th>
                    <th style="text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                @php
                    $totalStock = $product->variants->sum('stock_quantity');
                @endphp
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        <img src="{{ $product->thumbnail_url && file_exists(public_path('storage/'.$product->thumbnail_url)) ? asset('storage/'.$product->thumbnail_url) : asset($product->thumbnail_url) }}"
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                    </td>
                    <td style="font-weight: 500;">{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                    <td>
                        @if($product->variants->count() == 0)
                            <span style="color: #999; font-size: 12px;">Chưa có</span>
                        @elseif($totalStock == 0)
                            <span style="color: #dc3545; font-weight: 500;">Hết hàng</span>
                        @elseif($totalStock <= 5)
                            <span style="color: #f57c00; font-weight: 500;">{{ $totalStock }} <span style="font-size: 11px; color: #999;">(sắp hết)</span></span>
                        @else
                            <span style="color: #28a745; font-weight: 500;">{{ $totalStock }}</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $tagColors = [
                                'Mới' => 'badge-info',
                                'Sale' => 'badge-danger',
                                'Bán chạy' => 'badge-success',
                                'Hot' => 'badge-warning',
                            ];
                            $badgeClass = $tagColors[$product->tag] ?? 'badge-info';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $product->tag }}</span>
                    </td>
                    <td style="text-align: center; white-space: nowrap;">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                              onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')"
                              style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #999; padding: 30px;">
                        <i class="fa-solid fa-box-open" style="font-size: 24px; color: #ddd; display: block; margin-bottom: 8px;"></i>
                        Không tìm thấy sản phẩm nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    @if($products->hasPages())
    <div style="padding: 15px 20px; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-size: 13px; color: #999;">
            Hiển thị {{ $products->firstItem() }}–{{ $products->lastItem() }} / {{ $products->total() }} sản phẩm
        </span>
        <div style="display: flex; gap: 4px;">
            {{-- Nút Previous --}}
            @if($products->onFirstPage())
                <span style="padding: 6px 12px; border: 1px solid #eee; border-radius: 4px; color: #ccc; font-size: 13px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $products->previousPageUrl() }}" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            {{-- Số trang --}}
            @for($i = 1; $i <= $products->lastPage(); $i++)
                @if($i == $products->currentPage())
                    <span style="padding: 6px 12px; border: 1px solid #2c3345; border-radius: 4px; background: #2c3345; color: #fff; font-size: 13px;">{{ $i }}</span>
                @else
                    <a href="{{ $products->url($i) }}" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">{{ $i }}</a>
                @endif
            @endfor

            {{-- Nút Next --}}
            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            @else
                <span style="padding: 6px 12px; border: 1px solid #eee; border-radius: 4px; color: #ccc; font-size: 13px;">
                    <i class="fa-solid fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection