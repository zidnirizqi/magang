<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function edit()
    {
        // Redirect back to index since editing is not allowed
        return redirect()->route('admin.profile.index')
            ->with('info', 'Profile information is read-only and cannot be edited');
    }

    public function update(Request $request)
    {
        // Redirect back to index since updating is not allowed
        return redirect()->route('admin.profile.index')
            ->with('info', 'Profile information is read-only and cannot be edited');
    }
}
