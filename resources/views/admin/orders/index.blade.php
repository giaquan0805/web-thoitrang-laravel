@extends('admin.layouts.app')

@section('title', 'Quản lý đơn hàng')
@section('page-title', 'Quản lý đơn hàng')

@section('content')

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-bag-shopping" style="color: #7b1fa2;"></i> Danh sách đơn hàng</h5>
    </div>

    {{-- Tab lọc theo trạng thái --}}
    <div style="padding: 0 20px; border-bottom: 1px solid #f0f0f0; display: flex; gap: 0;">
        @php
            $currentStatus = request('status');
            $tabs = [
                '' => ['label' => 'Tất cả', 'count' => $statusCounts['all'], 'color' => '#333'],
                '0' => ['label' => 'Chờ xác nhận', 'count' => $statusCounts['pending'], 'color' => '#856404'],
                '1' => ['label' => 'Đang giao', 'count' => $statusCounts['shipping'], 'color' => '#004085'],
                '2' => ['label' => 'Hoàn thành', 'count' => $statusCounts['completed'], 'color' => '#155724'],
                '3' => ['label' => 'Đã hủy', 'count' => $statusCounts['cancelled'], 'color' => '#721c24'],
            ];
        @endphp
        @foreach($tabs as $value => $tab)
            @php $isActive = (string)$currentStatus === (string)$value; @endphp
            <a href="{{ route('admin.orders.index', array_merge(request()->except('status', 'page'), $value !== '' ? ['status' => $value] : [])) }}"
               style="padding: 12px 18px; text-decoration: none; font-size: 13px; font-weight: 500;
                      color: {{ $isActive ? $tab['color'] : '#999' }};
                      border-bottom: 2px solid {{ $isActive ? $tab['color'] : 'transparent' }};">
                {{ $tab['label'] }}
                <span style="background: {{ $isActive ? $tab['color'] : '#eee' }}; color: {{ $isActive ? '#fff' : '#999' }};
                             padding: 1px 7px; border-radius: 10px; font-size: 11px; margin-left: 4px;">
                    {{ $tab['count'] }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- Thanh tìm kiếm --}}
    <div style="padding: 12px 20px; border-bottom: 1px solid #f0f0f0; background: #fafafa;">
        <form action="{{ route('admin.orders.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
            @if(request('status') !== null && request('status') !== '')
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên khách hàng hoặc SĐT..."
                   value="{{ request('keyword') }}" style="width: 300px; padding: 8px 12px;">
            <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">
                <i class="fa-solid fa-magnifying-glass"></i> Tìm
            </button>
            @if(request('keyword'))
                <a href="{{ route('admin.orders.index', request('status') !== null ? ['status' => request('status')] : []) }}"
                   class="btn" style="background: #eee; color: #333; padding: 8px 16px;">
                    <i class="fa-solid fa-xmark"></i> Xóa tìm
                </a>
            @endif
            <span style="margin-left: auto; font-size: 13px; color: #999;">
                {{ $orders->total() }} đơn hàng
            </span>
        </form>
    </div>

    <div class="card-body" style="padding: 0;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th style="text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php
                    $badges = ['badge-warning', 'badge-info', 'badge-success', 'badge-danger'];
                    $labels = ['Chờ xác nhận', 'Đang giao', 'Hoàn thành', 'Đã hủy'];
                @endphp
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #e3f2fd; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #1976d2; font-size: 13px;">
                                {{ strtoupper(substr($order->user->name ?? 'N', 0, 1)) }}
                            </div>
                            <span>{{ $order->user->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td>{{ $order->shipping_phone }}</td>
                    <td style="font-weight: 500;">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                    <td>
                        <span style="background: #f0f0f0; padding: 3px 8px; border-radius: 4px; font-size: 12px;">
                            {{ $order->payment_method }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $badges[$order->status] }}">
                            {{ $labels[$order->status] }}
                        </span>
                    </td>
                    <td style="font-size: 13px; color: #666;">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-warning">Chi tiết</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #999; padding: 30px;">
                        <i class="fa-solid fa-bag-shopping" style="font-size: 24px; color: #ddd; display: block; margin-bottom: 8px;"></i>
                        Không tìm thấy đơn hàng nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    @if($orders->hasPages())
    <div style="padding: 15px 20px; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-size: 13px; color: #999;">
            Hiển thị {{ $orders->firstItem() }}–{{ $orders->lastItem() }} / {{ $orders->total() }} đơn hàng
        </span>
        <div style="display: flex; gap: 4px;">
            @if($orders->onFirstPage())
                <span style="padding: 6px 12px; border: 1px solid #eee; border-radius: 4px; color: #ccc; font-size: 13px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $orders->previousPageUrl() }}" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            @for($i = 1; $i <= $orders->lastPage(); $i++)
                @if($i == $orders->currentPage())
                    <span style="padding: 6px 12px; border: 1px solid #2c3345; border-radius: 4px; background: #2c3345; color: #fff; font-size: 13px;">{{ $i }}</span>
                @else
                    <a href="{{ $orders->url($i) }}" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">{{ $i }}</a>
                @endif
            @endfor

            @if($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">
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