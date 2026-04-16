@extends('layouts.app')

@section('title', 'Đăng ký - Fashion AI')

@section('content')

<div class="auth-box">

    <h2>Đăng Ký</h2>

    @if(session('error'))
        <div class="auth-alert-error">{{ session('error') }}</div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="auth-form-group">
            <label>Họ tên</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-form-group">
            <label>Mật khẩu</label>
            <input type="password" name="password" required>
            @error('password')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-form-group" style="margin-bottom: 20px;">
            <label>Xác nhận mật khẩu</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="auth-btn">Đăng ký</button>
    </form>

    <p class="auth-footer">
        Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a>
    </p>

</div>

@endsection