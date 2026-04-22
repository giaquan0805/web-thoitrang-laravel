@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)
@section('page-title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px;">

    {{-- Chi tiết sản phẩm --}}
    <div>
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <h5><i class="fa-solid fa-box-open" style="color: #1976d2;"></i> Sản phẩm trong đơn</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm" style="background: #eee; color: #333;">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại
                </a>
            </div>
            <div class="card-body" style="padding: 0;">
                <table>
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Size/Màu</th>
                            <th>SL</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $detail)
                        <tr>
                            <td>
                                <img src="{{ product_image($detail->variant->product->thumbnail_url) }}"
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                            </td>
                            <td style="font-weight: 500;">{{ $detail->variant->product->name }}</td>
                            <td>
                                <span style="background: #f0f0f0; padding: 2px 8px; border-radius: 4px; font-size: 12px;">
                                    {{ $detail->variant->size }} / {{ $detail->variant->color }}
                                </span>
                            </td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                            <td style="font-weight: 500;">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Thông tin giao hàng --}}
        <div class="card">
            <div class="card-header">
                <h5><i class="fa-solid fa-truck" style="color: #388e3c;"></i> Thông tin giao hàng</h5>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 10px 0; color: #666; width: 150px;">Người nhận:</td>
                        <td style="padding: 10px 0; font-weight: 500;">{{ $order->shipping_name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #666;">Số điện thoại:</td>
                        <td style="padding: 10px 0;">{{ $order->shipping_phone }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #666;">Địa chỉ:</td>
                        <td style="padding: 10px 0;">{{ $order->shipping_address }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #666;">Thanh toán:</td>
                        <td style="padding: 10px 0;">
                            <span style="background: #f0f0f0; padding: 3px 8px; border-radius: 4px; font-size: 13px;">
                                {{ $order->payment_method }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #666;">Ngày đặt:</td>
                        <td style="padding: 10px 0;">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; color: #666;">Khách hàng:</td>
                        <td style="padding: 10px 0;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 28px; height: 28px; border-radius: 50%; background: #e3f2fd; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #1976d2; font-size: 12px;">
                                    {{ strtoupper(substr($order->user->name ?? 'N', 0, 1)) }}
                                </div>
                                {{ $order->user->name }} ({{ $order->user->email }})
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Tổng tiền + Cập nhật trạng thái --}}
    <div>
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <h5><i class="fa-solid fa-coins" style="color: #f57c00;"></i> Tổng tiền</h5>
            </div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                    <span style="color: #666;">Tạm tính:</span>
                    <span>{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px;">
                    <span style="color: #666;">Phí vận chuyển:</span>
                    <span style="color: #28a745;">Miễn phí</span>
                </div>
                <hr style="border: none; border-top: 1px solid #eee;">
                <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 20px; margin-top: 15px; color: #1976d2;">
                    <span>Tổng cộng:</span>
                    <span>{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                </div>
            </div>
        </div>

        {{-- Cập nhật trạng thái --}}
        <div class="card">
            <div class="card-header">
                <h5><i class="fa-solid fa-arrows-rotate" style="color: #7b1fa2;"></i> Cập nhật trạng thái</h5>
            </div>
            <div class="card-body">
                @php
                    $badges = ['badge-warning', 'badge-info', 'badge-success', 'badge-danger'];
                    $labels = ['Chờ xác nhận', 'Đang giao', 'Hoàn thành', 'Đã hủy'];
                @endphp
                <p style="margin-bottom: 15px;">
                    Trạng thái hiện tại:
                    <span class="badge {{ $badges[$order->status] }}">
                        {{ $labels[$order->status] }}
                    </span>
                </p>

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Chuyển sang trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đang giao</option>
                            <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Cập nhật
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection