@extends('layouts.app')

@section('title', 'Liên hệ - Fashion AI')

@section('content')

<div class="container" style="padding: 40px 15px 60px; max-width: 800px;">

    <div style="text-align: center; margin-bottom: 35px;">
        <h2 style="font-size: 26px; font-weight: 700; margin-bottom: 8px;">Liên hệ với chúng tôi</h2>
        <p style="color: #999; font-size: 14px;">Bạn có câu hỏi hoặc cần hỗ trợ? Hãy gửi tin nhắn cho chúng tôi!</p>
    </div>

    @if(session('success'))
        <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">

        {{-- Form liên hệ --}}
        <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; padding: 30px;">
            <h3 style="font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-paper-plane" style="color: #f59e0b;"></i> Gửi tin nhắn
            </h3>

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 6px; font-weight: 500; font-size: 14px; color: #555;">Họ tên</label>
                    <div style="position: relative;">
                        <i class="fa-regular fa-user" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb;"></i>
                        <input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : old('name') }}" required
                               style="width: 100%; padding: 11px 12px 11px 38px; border: 1.5px solid #e5e5e5; border-radius: 8px; font-size: 14px; background: #fafafa;">
                    </div>
                    @error('name')<span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 6px; font-weight: 500; font-size: 14px; color: #555;">Email</label>
                    <div style="position: relative;">
                        <i class="fa-regular fa-envelope" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb;"></i>
                        <input type="email" name="email" value="{{ Auth::check() ? Auth::user()->email : old('email') }}" required
                               style="width: 100%; padding: 11px 12px 11px 38px; border: 1.5px solid #e5e5e5; border-radius: 8px; font-size: 14px; background: #fafafa;">
                    </div>
                    @error('email')<span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 6px; font-weight: 500; font-size: 14px; color: #555;">Chủ đề</label>
                    <div style="position: relative;">
                        <i class="fa-solid fa-tag" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #bbb; font-size: 13px;"></i>
                        <input type="text" name="subject" value="{{ old('subject') }}" placeholder="VD: Hỏi về sản phẩm, đơn hàng,..."
                               style="width: 100%; padding: 11px 12px 11px 38px; border: 1.5px solid #e5e5e5; border-radius: 8px; font-size: 14px; background: #fafafa;">
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 6px; font-weight: 500; font-size: 14px; color: #555;">Nội dung</label>
                    <textarea name="content" rows="5" required placeholder="Nhập nội dung tin nhắn..."
                              style="width: 100%; padding: 12px; border: 1.5px solid #e5e5e5; border-radius: 8px; font-size: 14px; background: #fafafa; resize: vertical; font-family: inherit;">{{ old('content') }}</textarea>
                    @error('content')<span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <button type="submit" style="width: 100%; padding: 13px; background: #222; color: #fff; border: none; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-paper-plane"></i> Gửi tin nhắn
                </button>
            </form>
        </div>

        {{-- Thông tin liên hệ --}}
        <div>
            <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; padding: 30px; margin-bottom: 20px;">
                <h3 style="font-size: 18px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-location-dot" style="color: #f59e0b;"></i> Thông tin liên hệ
                </h3>

                <div style="margin-bottom: 18px; display: flex; gap: 12px; align-items: start;">
                    <div style="width: 38px; height: 38px; border-radius: 8px; background: #fffbeb; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-location-dot" style="color: #f59e0b; font-size: 14px;"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; color: #333; margin-bottom: 3px;">Địa chỉ</h4>
                        <p style="color: #666; font-size: 13px;">TP. Hồ Chí Minh, Việt Nam</p>
                    </div>
                </div>

                <div style="margin-bottom: 18px; display: flex; gap: 12px; align-items: start;">
                    <div style="width: 38px; height: 38px; border-radius: 8px; background: #fffbeb; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-solid fa-phone" style="color: #f59e0b; font-size: 14px;"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; color: #333; margin-bottom: 3px;">Điện thoại</h4>
                        <p style="color: #666; font-size: 13px;">0383 880 857</p>
                    </div>
                </div>

                <div style="margin-bottom: 18px; display: flex; gap: 12px; align-items: start;">
                    <div style="width: 38px; height: 38px; border-radius: 8px; background: #fffbeb; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-regular fa-envelope" style="color: #f59e0b; font-size: 14px;"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; color: #333; margin-bottom: 3px;">Email</h4>
                        <p style="color: #666; font-size: 13px;">contact@fashionai.com</p>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; align-items: start;">
                    <div style="width: 38px; height: 38px; border-radius: 8px; background: #fffbeb; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fa-regular fa-clock" style="color: #f59e0b; font-size: 14px;"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 14px; font-weight: 600; color: #333; margin-bottom: 3px;">Giờ làm việc</h4>
                        <p style="color: #666; font-size: 13px;">8:00 - 22:00 (Thứ 2 - Chủ nhật)</p>
                    </div>
                </div>
            </div>

            <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; padding: 20px; text-align: center;">
                <p style="color: #666; font-size: 14px; margin-bottom: 12px;">Hoặc liên hệ qua mạng xã hội</p>
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #555; text-decoration: none; transition: 0.2s; font-size: 16px;">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" style="width: 40px; height: 40px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #555; text-decoration: none; transition: 0.2s; font-size: 16px;">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://zalo.me/0383880857" target="_blank" style="width: 40px; height: 40px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #555; text-decoration: none; transition: 0.2s; font-size: 16px;">
                        <i class="fa-solid fa-comment-dots"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection