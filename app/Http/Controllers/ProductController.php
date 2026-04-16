<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $category_slug = $request->get('cat');

        $query = Product::with('category');

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if ($category_slug) {
            $query->whereHas('category', function ($q) use ($category_slug) {
                $q->where('slug', $category_slug);
            });
        }

        $products = $query->latest('created_at')->take(8)->get();

        // Thêm data cho các section
        $newProducts      = Product::with('category')->latest('created_at')->take(4)->get();
        $hotProducts      = Product::with('category')->where('tag', 'Bán chạy')->take(4)->get();
        $categories       = \App\Models\Category::withCount('products')->get();

        return view('home.index', compact(
            'products',
            'keyword',
            'category_slug',
            'newProducts',
            'hotProducts',
            'categories'
        ));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'images', 'variants'])->findOrFail($id);
        return view('product.show', compact('product'));
    }
}
