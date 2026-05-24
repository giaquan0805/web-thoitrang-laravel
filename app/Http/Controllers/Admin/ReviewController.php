<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 1) abort(403);
    }

    public function index(Request $request)
    {
        $this->checkAdmin();

        $query = Review::with(['user', 'product'])->orderBy('created_at', 'desc');

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->paginate(10);
        $totalCount = Review::count();
        $avgRating = Review::avg('rating');

        return view('admin.reviews.index', compact('reviews', 'totalCount', 'avgRating'));
    }

    public function destroy($id)
    {
        $this->checkAdmin();
        Review::findOrFail($id)->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Đã xóa đánh giá!');
    }
}