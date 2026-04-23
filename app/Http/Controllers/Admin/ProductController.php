<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 1) abort(403);
    }

    public function index(Request $request)
    {
        $this->checkAdmin();

        $query = Product::with(['category', 'variants']);

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('tag')) {
            $query->where('tag', $request->tag);
        }

        $sortBy = $request->get('sort', 'id');
        $sortDir = $request->get('dir', 'desc');
        $allowedSorts = ['id', 'name', 'price'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $products = $query->paginate(10)->appends($request->query());
        $categories = Category::all();
        $tags = Product::select('tag')->distinct()->whereNotNull('tag')->pluck('tag');

        return view('admin.products.index', compact('products', 'categories', 'tags'));
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
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
            'tag'         => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $thumbnail_url = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnail_url = $request->file('thumbnail')->store('products', 'public');
        }

        $product = Product::create([
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'price'         => $request->price,
            'tag'           => $request->tag,
            'description'   => $request->description,
            'thumbnail_url' => $thumbnail_url,
        ]);

        // Upload ảnh chi tiết
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/details', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url'  => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $this->checkAdmin();
        $product    = Product::with(['variants', 'images'])->findOrFail($id);
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
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
            'tag'         => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);

        $thumbnail_url = $product->thumbnail_url;
        if ($request->hasFile('thumbnail')) {
            $thumbnail_url = $request->file('thumbnail')->store('products', 'public');
        }

        $product->update([
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'price'         => $request->price,
            'tag'           => $request->tag,
            'description'   => $request->description,
            'thumbnail_url' => $thumbnail_url,
        ]);

        // Upload thêm ảnh chi tiết mới
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/details', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url'  => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.edit', $id)->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $this->checkAdmin();
        $product = Product::with('images')->findOrFail($id);

        foreach ($product->images as $img) {
            if (Storage::disk('public')->exists($img->image_url)) {
                Storage::disk('public')->delete($img->image_url);
            }
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }

    public function destroyImage($id)
    {
        $this->checkAdmin();
        $image = ProductImage::findOrFail($id);
        $productId = $image->product_id;

        if (Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }

        $image->delete();
        return redirect()->route('admin.products.edit', $productId)->with('success', 'Xóa ảnh thành công!');
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

    public function updateVariant(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'size'           => 'required|string|max:10',
            'color'          => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $variant = \App\Models\ProductVariant::findOrFail($id);
        $variant->update([
            'size'           => $request->size,
            'color'          => $request->color,
            'stock_quantity' => $request->stock_quantity,
        ]);

        return redirect()->route('admin.products.edit', $variant->product_id)->with('success', 'Cập nhật biến thể thành công!');
    }

    public function destroyVariant($id)
    {
        $this->checkAdmin();
        \App\Models\ProductVariant::findOrFail($id)->delete();
        return back()->with('success', 'Xóa biến thể thành công!');
    }
}