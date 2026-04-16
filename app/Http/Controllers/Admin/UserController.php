<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->role !== 1) abort(403);
    }

    public function index()
    {
        $this->checkAdmin();
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }
}