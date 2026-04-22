<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->role !== 1) {
            abort(403, 'Bạn không có quyền truy cập trang này!');
        }

        // === THỐNG KÊ TỔNG QUAN ===
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalUsers     = User::count();
        $totalRevenue   = Order::where('status', 2)->sum('total_price');

        // === ĐƠN HÀNG THEO TRẠNG THÁI (cho biểu đồ tròn) ===
        $ordersByStatus = [
            'pending'   => Order::where('status', 0)->count(),
            'shipping'  => Order::where('status', 1)->count(),
            'completed' => Order::where('status', 2)->count(),
            'cancelled' => Order::where('status', 3)->count(),
        ];

        // === DOANH THU 7 NGÀY GẦN NHẤT (cho biểu đồ cột) ===
        $revenueLast7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenue = Order::where('status', 2)
                ->whereDate('order_date', $date)
                ->sum('total_price');
            $revenueLast7Days[] = [
                'date'    => $date->format('d/m'),
                'revenue' => (int) $revenue,
            ];
        }

        // === TOP 5 SẢN PHẨM BÁN CHẠY ===
        $topProducts = DB::table('order_details')
            ->join('product_variants', 'order_details.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 3) // Không tính đơn đã hủy
            ->select(
                'products.id',
                'products.name',
                'products.thumbnail_url',
                'products.price',
                DB::raw('SUM(order_details.quantity) as total_sold'),
                DB::raw('SUM(order_details.quantity * order_details.price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.thumbnail_url', 'products.price')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // === ĐƠN HÀNG GẦN ĐÂY ===
        $recentOrders = Order::with('user')->orderBy('order_date', 'desc')->take(5)->get();

        // === THỐNG KÊ SO SÁNH THÁNG TRƯỚC ===
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $ordersThisMonth = Order::where('order_date', '>=', $thisMonth)->count();
        $ordersLastMonth = Order::whereBetween('order_date', [$lastMonth, $lastMonthEnd])->count();

        $revenueThisMonth = Order::where('status', 2)->where('order_date', '>=', $thisMonth)->sum('total_price');
        $revenueLastMonth = Order::where('status', 2)->whereBetween('order_date', [$lastMonth, $lastMonthEnd])->sum('total_price');

        $usersThisMonth = User::where('created_at', '>=', $thisMonth)->count();
        $usersLastMonth = User::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        // === SẢN PHẨM THEO DANH MỤC ===
        $productsByCategory = Category::withCount('products')->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalUsers',
            'totalRevenue',
            'ordersByStatus',
            'revenueLast7Days',
            'topProducts',
            'recentOrders',
            'ordersThisMonth',
            'ordersLastMonth',
            'revenueThisMonth',
            'revenueLastMonth',
            'usersThisMonth',
            'usersLastMonth',
            'productsByCategory'
        ));
    }
}
