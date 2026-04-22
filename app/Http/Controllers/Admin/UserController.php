<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 1) abort(403);
    }

    public function index(Request $request)
    {
        $this->checkAdmin();

        $query = User::withCount('orders')
            ->withSum(['orders as total_spent' => function ($q) {
                $q->where('status', '!=', 3); // Không tính đơn đã hủy
            }], 'total_price');

        // Tìm kiếm
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                  ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }

        // Lọc theo vai trò
        if ($request->filled('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());

        return view('admin.users.index', compact('users'));
    }
}