<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 1) abort(403);
    }

    public function index()
    {
        $this->checkAdmin();
        $categories = Category::withCount('products')->orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:categories,slug',
            'description' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'slug.required' => 'Vui lòng nhập slug.',
            'slug.unique'   => 'Slug này đã tồn tại.',
            'banner.image'  => 'Banner phải là file ảnh.',
            'banner.max'    => 'Banner không được vượt quá 2MB.',
        ]);

        $data = $request->only(['name', 'slug', 'description']);

        if ($request->hasFile('banner')) {
            $data['banner_url'] = $request->file('banner')->store('categories', 'public');
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $data = $request->only(['name', 'slug', 'description']);

        if ($request->hasFile('banner')) {
            // Xóa banner cũ nếu có
            if ($category->banner_url && Storage::disk('public')->exists($category->banner_url)) {
                Storage::disk('public')->delete($category->banner_url);
            }
            $data['banner_url'] = $request->file('banner')->store('categories', 'public');
        }

        // Nếu tick xóa banner
        if ($request->has('remove_banner')) {
            if ($category->banner_url && Storage::disk('public')->exists($category->banner_url)) {
                Storage::disk('public')->delete($category->banner_url);
            }
            $data['banner_url'] = null;
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $this->checkAdmin();
        $category = Category::findOrFail($id);

        // Xóa banner khi xóa danh mục
        if ($category->banner_url && Storage::disk('public')->exists($category->banner_url)) {
            Storage::disk('public')->delete($category->banner_url);
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}