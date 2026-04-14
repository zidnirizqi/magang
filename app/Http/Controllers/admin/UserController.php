<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Hanya tampilkan akun user yang sedang login
        $users = User::where('id', auth()->id())->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // Disable create functionality
        return redirect()->route('admin.user.index')->with('error', 'Adding new users is not allowed');
    }

    public function store(Request $request)
    {
        // Disable store functionality
        return redirect()->route('admin.user.index')->with('error', 'Adding new users is not allowed');
    }

    public function edit(User $user)
    {
        // Hanya bisa edit akun sendiri
        if ($user->id !== auth()->id()) {
            return redirect()->route('admin.user.index')->with('error', 'You can only edit your own account');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Hanya bisa update akun sendiri
        if ($user->id !== auth()->id()) {
            return redirect()->route('admin.user.index')->with('error', 'You can only edit your own account');
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6'
        ]);

        $data = $request->only(['name', 'email']);
        $data['role'] = 'admin'; // pastikan role tetap admin
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'Your account updated successfully');
    }

    public function destroy(User $user)
    {
        // Tidak bisa menghapus akun sendiri atau akun orang lain
        return redirect()->route('admin.user.index')->with('error', 'Account deletion is not allowed');
    }
}
