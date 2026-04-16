@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)
@section('page-title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px;">

    {{-- Chi tiết sản phẩm --}}
    <div>
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <h5>📦 Sản phẩm trong đơn</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm" style="background: #eee; color: #333;">← Quay lại</a>
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
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td>{{ $detail->variant->product->name }}</td>
                            <td>{{ $detail->variant->size }} / {{ $detail->variant->color }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price, 0, ',', '.') }}đ</td>
                            <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Thông tin giao hàng --}}
        <div class="card">
            <div class="card-header">
                <h5>🚚 Thông tin giao hàng</h5>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 8px 0; color: #666; width: 150px;">Người nhận:</td>
                        <td style="padding: 8px 0; font-weight: 500;">{{ $order->shipping_name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Số điện thoại:</td>
                        <td style="padding: 8px 0;">{{ $order->shipping_phone }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Địa chỉ:</td>
                        <td style="padding: 8px 0;">{{ $order->shipping_address }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Thanh toán:</td>
                        <td style="padding: 8px 0;">{{ $order->payment_method }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Ngày đặt:</td>
                        <td style="padding: 8px 0;">{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #666;">Khách hàng:</td>
                        <td style="padding: 8px 0;">{{ $order->user->name }} ({{ $order->user->email }})</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Tổng tiền + Cập nhật trạng thái --}}
    <div>
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <h5>💰 Tổng tiền</h5>
            </div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <span>Phí vận chuyển:</span>
                    <span style="color: green;">Miễn phí</span>
                </div>
                <hr>
                <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 18px; margin-top: 15px;">
                    <span>Tổng cộng:</span>
                    <span>{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                </div>
            </div>
        </div>

        {{-- Cập nhật trạng thái --}}
        <div class="card">
            <div class="card-header">
                <h5>🔄 Cập nhật trạng thái</h5>
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
                            <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>⏳ Chờ xác nhận</option>
                            <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>🚚 Đang giao</option>
                            <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>✅ Hoàn thành</option>
                            <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>❌ Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        💾 Cập nhật
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection