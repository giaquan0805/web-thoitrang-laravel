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

    public function index()
    {
        $this->checkAdmin();
        $orders = Order::with('user')->orderBy('order_date', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
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