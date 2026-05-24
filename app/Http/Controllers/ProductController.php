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
        $tag = $request->get('tag');

        if ($keyword || $category_slug || $tag) {
            $query = Product::with('category');

            if ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            }

            if ($category_slug) {
                $query->whereHas('category', function ($q) use ($category_slug) {
                    $q->where('slug', $category_slug);
                });
            }

            if ($tag) {
                $query->where('tag', $tag);
            }

            // Bộ lọc giá
            $price = $request->get('price');
            if ($price === 'under200') {
                $query->where('price', '<', 200000);
            } elseif ($price === '200to500') {
                $query->whereBetween('price', [200000, 500000]);
            } elseif ($price === 'above500') {
                $query->where('price', '>', 500000);
            }

            // Sắp xếp
            $sort = $request->get('sort');
            if ($sort === 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($sort === 'price_desc') {
                $query->orderBy('price', 'desc');
            } else {
                $query->latest('created_at');
            }

            $products = $query->get();
        } else {
            $products = Product::with('category')->where('tag', 'Nổi bật')->take(8)->get();

            if ($products->isEmpty()) {
                $products = Product::with('category')->latest('created_at')->take(8)->get();
            }
        }

        $newProducts = Product::with('category')->where('tag', 'Mới')->take(4)->get();

        if ($newProducts->count() < 4) {
            $moreNew = Product::with('category')
                ->whereNotIn('id', $newProducts->pluck('id'))
                ->latest('created_at')
                ->take(4 - $newProducts->count())
                ->get();
            $newProducts = $newProducts->merge($moreNew);
        }

        $hotProducts = Product::with('category')->where('tag', 'Bán chạy')->take(4)->get();
        $saleProducts = Product::with('category')->where('tag', 'Sale')->take(4)->get();
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
        $reviews = \App\Models\Review::with('user')
            ->where('product_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $avgRating = $reviews->avg('rating') ?? 0;
        $reviewCount = $reviews->count();
        return view('product.show', compact('product', 'reviews', 'avgRating', 'reviewCount'));
    }
}