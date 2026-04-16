<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 1) abort(403);
    }

    public function index()
    {
        $this->checkAdmin();
        $products = Product::with('category')->orderBy('id', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->checkAdmin();
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tag'         => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $thumbnail_url = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnail_url = $request->file('thumbnail')->store('products', 'public');
        }

        Product::create([
            'category_id'        => $request->category_id,
            'name'               => $request->name,
            'price'              => $request->price,
            'tag'                => $request->tag,
            'description'        => $request->description,
            'thumbnail_url'      => $thumbnail_url,
            'ai_clean_image_url' => $request->ai_clean_image_url,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $this->checkAdmin();
        $product    = Product::with('variants')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tag'         => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        $thumbnail_url = $product->thumbnail_url;
        if ($request->hasFile('thumbnail')) {
            $thumbnail_url = $request->file('thumbnail')->store('products', 'public');
        }

        $product->update([
            'category_id'        => $request->category_id,
            'name'               => $request->name,
            'price'              => $request->price,
            'tag'                => $request->tag,
            'description'        => $request->description,
            'thumbnail_url'      => $thumbnail_url,
            'ai_clean_image_url' => $request->ai_clean_image_url,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $this->checkAdmin();
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    public function storeVariant(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'size'           => 'required|string|max:10',
            'color'          => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        \App\Models\ProductVariant::create([
            'product_id'     => $id,
            'size'           => $request->size,
            'color'          => $request->color,
            'stock_quantity' => $request->stock_quantity,
        ]);

        return redirect()->route('admin.products.edit', $id)->with('success', 'Thêm biến thể thành công!');
    }

    public function destroyVariant($id)
    {
        $this->checkAdmin();
        \App\Models\ProductVariant::findOrFail($id)->delete();
        return back()->with('success', 'Xóa biến thể thành công!');
    }
}
