<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 1) abort(403);
    }

    public function index(Request $request)
    {
        $this->checkAdmin();

        $query = Message::orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', 0);
            } elseif ($request->status === 'read') {
                $query->where('is_read', 1);
            } elseif ($request->status === 'replied') {
                $query->whereNotNull('admin_reply');
            }
        }

        $messages = $query->paginate(10);
        $unreadCount = Message::where('is_read', 0)->count();
        $totalCount = Message::count();

        return view('admin.messages.index', compact('messages', 'unreadCount', 'totalCount'));
    }

    public function show($id)
    {
        $this->checkAdmin();
        $message = Message::findOrFail($id);

        // Đánh dấu đã đọc
        if (!$message->is_read) {
            $message->update(['is_read' => 1]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function reply(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'admin_reply' => 'required|string|max:2000',
        ]);

        $message = Message::findOrFail($id);
        $message->update([
            'admin_reply' => $request->admin_reply,
            'replied_at'  => now(),
        ]);

        return redirect()->route('admin.messages.show', $id)->with('success', 'Đã phản hồi tin nhắn!');
    }

    public function destroy($id)
    {
        $this->checkAdmin();
        Message::findOrFail($id)->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Đã xóa tin nhắn!');
    }
}