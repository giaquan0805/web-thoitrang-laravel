@extends('admin.layouts.app')

@section('title', 'Quản lý đánh giá')
@section('page-title', 'Quản lý đánh giá')

@section('content')

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-star" style="color: #f59e0b;"></i> Đánh giá ({{ $totalCount }}) — Trung bình: {{ number_format($avgRating, 1) }} <i class="fa-solid fa-star" style="color: #f59e0b; font-size: 13px;"></i></h5>
    </div>
    <div class="card-body">

        {{-- Tab lọc theo sao --}}
        <div style="display: flex; gap: 10px; margin-bottom: 20px;">
            <a href="{{ route('admin.reviews.index') }}" style="padding: 6px 16px; border-radius: 20px; font-size: 13px; text-decoration: none; {{ !request('rating') ? 'background: #222; color: #fff;' : 'background: #f0f0f0; color: #555;' }}">
                Tất cả
            </a>
            @for($i = 5; $i >= 1; $i--)
            <a href="{{ route('admin.reviews.index', ['rating' => $i]) }}" style="padding: 6px 16px; border-radius: 20px; font-size: 13px; text-decoration: none; {{ request('rating') == $i ? 'background: #f59e0b; color: #fff;' : 'background: #f0f0f0; color: #555;' }}">
                {{ $i }} <i class="fa-solid fa-star" style="font-size: 10px;"></i>
            </a>
            @endfor
        </div>

        @if(session('success'))
            <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 10px 14px; border-radius: 8px; margin-bottom: 15px; font-size: 13px;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">#</th>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Khách hàng</th>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Sản phẩm</th>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Đánh giá</th>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Nhận xét</th>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Ngày</th>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Xóa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $review->id }}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>{{ $review->user->name ?? 'Ẩn danh' }}</strong>
                        <br><span style="color: #999; font-size: 12px;">{{ $review->user->email ?? '' }}</span>
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <a href="{{ route('product.show', $review->product_id) }}" target="_blank" style="color: #1976d2; text-decoration: none; font-size: 13px;">
                            {{ $review->product->name ?? 'N/A' }}
                        </a>
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; white-space: nowrap;">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star" style="font-size: 12px; color: {{ $i <= $review->rating ? '#f59e0b' : '#ddd' }};"></i>
                        @endfor
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-size: 13px; color: #555; max-width: 250px;">
                        {{ \Illuminate\Support\Str::limit($review->comment, 80) ?? '(Không có nhận xét)' }}
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-size: 13px; color: #666;">{{ $review->created_at->format('d/m/Y') }}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Xóa đánh giá này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="padding: 30px; text-align: center; color: #999;">Chưa có đánh giá nào.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 15px;">{{ $reviews->appends(request()->query())->links() }}</div>
    </div>
</div>

@endsection