<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::select('id','username','nama_lengkap','role','status')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success','User berhasil dibuat');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
            'status' => 'nullable|in:active,inactive',
        ]);

        $user->update([
            'role' => $request->role,
            'status' => $request->status ?? 'inactive',]);

        return back()->with('success','Data user diperbarui');
    }

    public function destroy(User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser && $user->id === $currentUser->id) {
            return back()->withErrors('Tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return back()->with('success', 'User dihapus');
    }



}
