<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::withCount('products')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('collections.index', compact('collections'));
    }

    public function show($id)
    {
        $collection = Collection::with('products')->where('status', 1)->findOrFail($id);
        return view('collections.show', compact('collection'));
    }
}