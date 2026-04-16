@extends('layouts.app')

@section('title', 'Đăng nhập - Fashion AI')

@section('content')

<div class="auth-box">

    <h2>Đăng Nhập</h2>

    @if(session('error'))
        <div class="auth-alert-error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="auth-alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="auth-form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-form-group" style="margin-bottom: 20px;">
            <label>Mật khẩu</label>
            <input type="password" name="password" required>
            @error('password')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="auth-btn">Đăng nhập</button>
    </form>

    <p class="auth-footer">
        Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
    </p>

</div>

@endsection