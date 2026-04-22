<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $category_slug = $request->get('cat');

        // Nếu đang tìm kiếm hoặc lọc danh mục
        if ($keyword || $category_slug) {
            $query = Product::with('category');

            if ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            }

            if ($category_slug) {
                $query->whereHas('category', function ($q) use ($category_slug) {
                    $q->where('slug', $category_slug);
                });
            }

            $products = $query->latest('created_at')->take(12)->get();
        } else {
            // Sản phẩm nổi bật = tag "Nổi bật"
            $products = Product::with('category')->where('tag', 'Nổi bật')->take(8)->get();

            // Nếu chưa có sản phẩm nổi bật, lấy mới nhất
            if ($products->isEmpty()) {
                $products = Product::with('category')->latest('created_at')->take(8)->get();
            }
        }

        // Sản phẩm mới nhất = tag "Mới"
        $newProducts = Product::with('category')->where('tag', 'Mới')->take(4)->get();

        // Nếu chưa đủ, bổ sung thêm từ sản phẩm mới tạo
        if ($newProducts->count() < 4) {
            $moreNew = Product::with('category')
                ->whereNotIn('id', $newProducts->pluck('id'))
                ->latest('created_at')
                ->take(4 - $newProducts->count())
                ->get();
            $newProducts = $newProducts->merge($moreNew);
        }

        // Sản phẩm bán chạy = tag "Bán chạy"
        $hotProducts = Product::with('category')->where('tag', 'Bán chạy')->take(4)->get();

        // Sản phẩm sale
        $saleProducts = Product::with('category')->where('tag', 'Sale')->take(4)->get();

        // Danh mục
        $categories = Category::withCount('products')->get();

        return view('home.index', compact(
            'products',
            'keyword',
            'category_slug',
            'newProducts',
            'hotProducts',
            'saleProducts',
            'categories'
        ));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'images', 'variants'])->findOrFail($id);
        return view('product.show', compact('product'));
    }
}