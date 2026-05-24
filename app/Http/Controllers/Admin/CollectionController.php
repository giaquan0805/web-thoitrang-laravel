<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 1) abort(403);
    }

    public function index(Request $request)
    {
        $this->checkAdmin();

        $query = Collection::withCount('products');

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $collections = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        $this->checkAdmin();
        $products = Product::all();
        return view('admin.collections.create', compact('products'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'required|in:0,1',
            'type'        => 'required|string|max:50',
            'products'    => 'nullable|array',
        ]);

        $banner_url = null;
        if ($request->hasFile('banner')) {
            $banner_url = $request->file('banner')->store('collections', 'public');
        }

        $collection = Collection::create([
            'name'        => $request->name,
            'description' => $request->description,
            'banner_url'  => $banner_url,
            'status'      => $request->status,
            'type'        => $request->type,
        ]);

        if ($request->has('products')) {
            $collection->products()->sync($request->products);
        }

        return redirect()->route('admin.collections.index')->with('success', 'Tạo bộ sưu tập thành công!');
    }

    public function edit($id)
    {
        $this->checkAdmin();
        $collection = Collection::with('products')->findOrFail($id);
        $products = Product::all();
        return view('admin.collections.edit', compact('collection', 'products'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'required|in:0,1',
            'type'        => 'required|string|max:50',
            'products'    => 'nullable|array',
        ]);

        $collection = Collection::findOrFail($id);

        $banner_url = $collection->banner_url;
        if ($request->hasFile('banner')) {
            $banner_url = $request->file('banner')->store('collections', 'public');
        }

        $collection->update([
            'name'        => $request->name,
            'description' => $request->description,
            'banner_url'  => $banner_url,
            'status'      => $request->status,
            'type'        => $request->type,
        ]);

        $collection->products()->sync($request->products ?? []);

        return redirect()->route('admin.collections.edit', $id)->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $this->checkAdmin();
        $collection = Collection::findOrFail($id);
        $collection->products()->detach();
        $collection->delete();
        return redirect()->route('admin.collections.index')->with('success', 'Đã xóa bộ sưu tập!');
    }
}