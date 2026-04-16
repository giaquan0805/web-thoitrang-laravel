<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Kiểm tra quyền admin
        if (Auth::user()->role !== 1) {
            abort(403, 'Bạn không có quyền truy cập trang này!');
        }

        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalUsers     = User::count();
        $totalRevenue   = Order::where('status', 2)->sum('total_price');
        $recentOrders   = Order::with('user')->orderBy('order_date', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalRevenue',
            'recentOrders'
        ));
    }
}