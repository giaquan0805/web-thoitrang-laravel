<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Hiện trang checkout
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt hàng!');
        }

        $cartItems = Cart::with(['variant.product'])
                        ->where('user_id', Auth::id())
                        ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->variant->product->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    // Xử lý đặt hàng
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'shipping_name'    => 'required|string|max:100',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method'   => 'required|in:COD,banking',
        ], [
            'shipping_name.required'    => 'Vui lòng nhập họ tên.',
            'shipping_phone.required'   => 'Vui lòng nhập số điện thoại.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ giao hàng.',
        ]);

        $cartItems = Cart::with(['variant.product'])
                        ->where('user_id', Auth::id())
                        ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->variant->product->price * $item->quantity;
        });

        // Dùng DB transaction để đảm bảo an toàn
        DB::transaction(function () use ($request, $cartItems, $total) {
            $order = Order::create([
                'user_id'          => Auth::id(),
                'shipping_name'    => $request->shipping_name,
                'shipping_phone'   => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'total_price'      => $total,
                'payment_method'   => $request->payment_method,
                'status'           => 0,
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id'           => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity'           => $item->quantity,
                    'price'              => $item->variant->product->price,
                ]);
            }

            // Xóa giỏ hàng sau khi đặt hàng
            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('home')->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng. 🎉');
    }
}