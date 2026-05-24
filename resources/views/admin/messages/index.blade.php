@extends('admin.layouts.app')

@section('title', 'Quản lý tin nhắn')
@section('page-title', 'Quản lý tin nhắn')

@section('content')

<div class="card">
    <div class="card-header">
        <h5><i class="fa-solid fa-envelope" style="color: #1976d2;"></i> Tin nhắn ({{ $totalCount }}) — <span style="color: #dc3545;">{{ $unreadCount }} chưa đọc</span></h5>
    </div>
    <div class="card-body">

        {{-- Tab lọc --}}
        <div style="display: flex; gap: 10px; margin-bottom: 20px;">
            <a href="{{ route('admin.messages.index') }}" style="padding: 6px 16px; border-radius: 20px; font-size: 13px; text-decoration: none; {{ !request('status') ? 'background: #222; color: #fff;' : 'background: #f0f0f0; color: #555;' }}">
                Tất cả
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'unread']) }}" style="padding: 6px 16px; border-radius: 20px; font-size: 13px; text-decoration: none; {{ request('status') === 'unread' ? 'background: #dc3545; color: #fff;' : 'background: #f0f0f0; color: #555;' }}">
                Chưa đọc
            </a>
            <a href="{{ route('admin.messages.index', ['status' => 'replied']) }}" style="padding: 6px 16px; border-radius: 20px; font-size: 13px; text-decoration: none; {{ request('status') === 'replied' ? 'background: #28a745; color: #fff;' : 'background: #f0f0f0; color: #555;' }}">
                Đã trả lời
            </a>
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
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Người gửi</th>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Chủ đề</th>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Ngày gửi</th>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Trạng thái</th>
                    <th style="text-align:left; padding: 10px; background:#f5f5f5;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                <tr style="{{ !$msg->is_read ? 'background: #fffbeb;' : '' }}">
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ $msg->id }}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <strong style="{{ !$msg->is_read ? 'font-weight: 700;' : 'font-weight: 400;' }}">{{ $msg->name }}</strong>
                        <br><span style="color: #999; font-size: 12px;">{{ $msg->email }}</span>
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-size: 13px;">{{ $msg->subject ?? '(Không có)' }}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-size: 13px; color: #666;">{{ $msg->created_at->format('d/m/Y H:i') }}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        @if($msg->admin_reply)
                            <span style="padding: 3px 10px; border-radius: 12px; font-size: 11px; background: #d4edda; color: #155724;">Đã trả lời</span>
                        @elseif($msg->is_read)
                            <span style="padding: 3px 10px; border-radius: 12px; font-size: 11px; background: #e2e3e5; color: #383d41;">Đã đọc</span>
                        @else
                            <span style="padding: 3px 10px; border-radius: 12px; font-size: 11px; background: #f8d7da; color: #721c24;">Chưa đọc</span>
                        @endif
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">
                        <a href="{{ route('admin.messages.show', $msg->id) }}" class="btn btn-sm btn-primary">Xem</a>
                        <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Xóa tin nhắn này?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="padding: 30px; text-align: center; color: #999;">Chưa có tin nhắn nào.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 15px;">{{ $messages->appends(request()->query())->links() }}</div>
    </div>
</div>

@endsection