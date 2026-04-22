@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')
@section('page-title', 'Quản lý người dùng')

@section('content')

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-users" style="color: #1976d2;"></i> Danh sách người dùng</h5>
    </div>

    {{-- Thanh tìm kiếm & lọc --}}
    <div style="padding: 12px 20px; border-bottom: 1px solid #f0f0f0; background: #fafafa;">
        <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên hoặc email..."
                   value="{{ request('keyword') }}" style="width: 260px; padding: 8px 12px;">

            <select name="role" class="form-control" style="width: 150px; padding: 8px 12px;">
                <option value="">-- Vai trò --</option>
                <option value="1" {{ request('role') === '1' ? 'selected' : '' }}>Admin</option>
                <option value="0" {{ request('role') === '0' ? 'selected' : '' }}>Khách hàng</option>
            </select>

            <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">
                <i class="fa-solid fa-magnifying-glass"></i> Tìm
            </button>

            @if(request('keyword') || request('role') !== null && request('role') !== '')
                <a href="{{ route('admin.users.index') }}" class="btn" style="background: #eee; color: #333; padding: 8px 16px;">
                    <i class="fa-solid fa-xmark"></i> Xóa lọc
                </a>
            @endif

            <span style="margin-left: auto; font-size: 13px; color: #999;">
                {{ $users->total() }} người dùng
            </span>
        </form>
    </div>

    <div class="card-body" style="padding: 0;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày đăng ký</th>
                    <th style="text-align: center;">Số đơn hàng</th>
                    <th style="text-align: right;">Tổng chi tiêu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 35px; height: 35px; background: {{ $user->role === 1 ? '#7b1fa2' : '#1976d2' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: bold; font-size: 14px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span style="font-weight: 500;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="color: #666;">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 1)
                            <span class="badge badge-danger">Admin</span>
                        @else
                            <span class="badge badge-info">Khách hàng</span>
                        @endif
                    </td>
                    <td style="font-size: 13px; color: #666;">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                    <td style="text-align: center;">
                        @if($user->orders_count > 0)
                            <span style="font-weight: 500;">{{ $user->orders_count }}</span>
                        @else
                            <span style="color: #ccc;">0</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if($user->total_spent > 0)
                            <span style="color: #28a745; font-weight: 500;">{{ number_format($user->total_spent, 0, ',', '.') }}đ</span>
                        @else
                            <span style="color: #ccc;">0đ</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #999; padding: 30px;">
                        <i class="fa-solid fa-users" style="font-size: 24px; color: #ddd; display: block; margin-bottom: 8px;"></i>
                        Không tìm thấy người dùng nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    @if($users->hasPages())
    <div style="padding: 15px 20px; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-size: 13px; color: #999;">
            Hiển thị {{ $users->firstItem() }}–{{ $users->lastItem() }} / {{ $users->total() }} người dùng
        </span>
        <div style="display: flex; gap: 4px;">
            @if($users->onFirstPage())
                <span style="padding: 6px 12px; border: 1px solid #eee; border-radius: 4px; color: #ccc; font-size: 13px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $users->previousPageUrl() }}" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            @endif

            @for($i = 1; $i <= $users->lastPage(); $i++)
                @if($i == $users->currentPage())
                    <span style="padding: 6px 12px; border: 1px solid #2c3345; border-radius: 4px; background: #2c3345; color: #fff; font-size: 13px;">{{ $i }}</span>
                @else
                    <a href="{{ $users->url($i) }}" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">{{ $i }}</a>
                @endif
            @endfor

            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #333; text-decoration: none; font-size: 13px;">
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