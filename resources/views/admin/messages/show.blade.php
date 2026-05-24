@extends('admin.layouts.app')

@section('title', 'Chi tiết tin nhắn')
@section('page-title', 'Chi tiết tin nhắn')

@section('content')

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-envelope-open" style="color: #1976d2;"></i> Tin nhắn #{{ $message->id }}</h5>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-sm" style="background: #eee; color: #333;">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 10px 14px; border-radius: 8px; margin-bottom: 15px; font-size: 13px;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Thông tin người gửi --}}
        <div style="background: #fafafa; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <span style="font-size: 12px; color: #999;">Người gửi</span>
                    <p style="font-weight: 600; color: #333;">{{ $message->name }}</p>
                </div>
                <div>
                    <span style="font-size: 12px; color: #999;">Email</span>
                    <p style="color: #333;">{{ $message->email }}</p>
                </div>
                <div>
                    <span style="font-size: 12px; color: #999;">Chủ đề</span>
                    <p style="color: #333;">{{ $message->subject ?? '(Không có)' }}</p>
                </div>
                <div>
                    <span style="font-size: 12px; color: #999;">Ngày gửi</span>
                    <p style="color: #333;">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Nội dung tin nhắn --}}
        <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
            <h4 style="font-size: 14px; color: #999; margin-bottom: 10px;"><i class="fa-solid fa-message"></i> Nội dung tin nhắn</h4>
            <p style="color: #333; font-size: 15px; line-height: 1.7;">{{ $message->content }}</p>
        </div>

        {{-- Phản hồi admin --}}
        @if($message->admin_reply)
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 20px; margin-bottom: 20px;">
            <h4 style="font-size: 14px; color: #155724; margin-bottom: 10px;"><i class="fa-solid fa-reply"></i> Phản hồi của Admin</h4>
            <p style="color: #333; font-size: 15px; line-height: 1.7;">{{ $message->admin_reply }}</p>
            <span style="font-size: 12px; color: #999; margin-top: 10px; display: block;">Trả lời lúc: {{ \Carbon\Carbon::parse($message->replied_at)->format('d/m/Y H:i') }}</span>
        </div>
        @endif

        {{-- Form trả lời --}}
        <div style="background: #fff; border: 1px solid #f0f0f0; border-radius: 10px; padding: 20px;">
            <h4 style="font-size: 15px; font-weight: 600; margin-bottom: 15px;">
                <i class="fa-solid fa-reply" style="color: #1976d2;"></i>
                {{ $message->admin_reply ? 'Sửa phản hồi' : 'Trả lời tin nhắn' }}
            </h4>
            <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST">
                @csrf
                <textarea name="admin_reply" rows="4" required placeholder="Nhập phản hồi..."
                          style="width: 100%; padding: 12px; border: 1.5px solid #e5e5e5; border-radius: 8px; font-size: 14px; resize: vertical; font-family: inherit; margin-bottom: 12px;">{{ $message->admin_reply }}</textarea>
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-paper-plane"></i> Gửi phản hồi
                </button>
            </form>
        </div>

    </div>
</div>

@endsection