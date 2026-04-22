<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 1) abort(403);
    }

    public function index(Request $request)
    {
        $this->checkAdmin();

        $query = Order::with('user');

        // Lọc theo trạng thái
        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Tìm kiếm theo tên hoặc SĐT
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('shipping_name', 'like', '%' . $keyword . '%')
                  ->orWhere('shipping_phone', 'like', '%' . $keyword . '%')
                  ->orWhereHas('user', function ($q2) use ($keyword) {
                      $q2->where('name', 'like', '%' . $keyword . '%');
                  });
            });
        }

        $orders = $query->orderBy('order_date', 'desc')->paginate(10)->appends($request->query());

        // Đếm số đơn theo trạng thái
        $statusCounts = [
            'all'       => Order::count(),
            'pending'   => Order::where('status', 0)->count(),
            'shipping'  => Order::where('status', 1)->count(),
            'completed' => Order::where('status', 2)->count(),
            'cancelled' => Order::where('status', 3)->count(),
        ];

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    public function show($id)
    {
        $this->checkAdmin();
        $order = Order::with(['user', 'details.variant.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'status' => 'required|in:0,1,2,3',
        ]);

        Order::findOrFail($id)->update(['status' => $request->status]);
        return redirect()->route('admin.orders.show', $id)->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}