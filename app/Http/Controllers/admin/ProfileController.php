<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // ambil user yang sedang login
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // validasi sederhana
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        return redirect()->route('admin.profile.index')->with('success', 'Profile updated successfully');
    }
}
