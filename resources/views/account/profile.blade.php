@extends('layouts.app')

@section('title', 'Tài khoản - Fashion AI')

@section('content')

<div class="container account-wrapper">
    <div class="account-grid">

        {{-- Sidebar --}}
        <div class="account-sidebar">
            <div class="account-avatar">
                <div class="account-avatar-circle">
                    <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <p>{{ Auth::user()->name }}</p>
                <small>{{ Auth::user()->email }}</small>
            </div>

            <ul class="account-menu">
                <li>
                    <a href="{{ route('account.profile') }}" class="active">
                        👤 Thông tin tài khoản
                    </a>
                </li>
                <li>
                    <a href="{{ route('account.orders') }}">
                        📦 Lịch sử đơn hàng
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">🚪 Đăng xuất</button>
                    </form>
                </li>
            </ul>
        </div>

        {{-- Nội dung chính --}}
        <div class="account-content">
            <h3>Thông tin tài khoản</h3>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('account.update') }}" method="POST">
                @csrf

                <div class="account-form-group">
                    <label>Họ tên</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" required>
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="account-form-group">
                    <label>Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" disabled>
                </div>

                <div class="account-form-group">
                    <label>Mật khẩu mới <small style="color:#999; font-weight:normal;">(để trống nếu không đổi)</small></label>
                    <input type="password" name="password">
                </div>

                <div class="account-form-group" style="margin-bottom: 25px;">
                    <label>Xác nhận mật khẩu mới</label>
                    <input type="password" name="password_confirmation">
                </div>

                <button type="submit" class="btn-save">Lưu thay đổi</button>
            </form>
        </div>

    </div>
</div>

@endsection