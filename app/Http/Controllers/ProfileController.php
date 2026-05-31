<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan profil user (read only)
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    /**
     * Form edit profil
     */
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update profil user
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'nama_lengkap' => 'nullable|string',
            'info' => 'nullable|string',
            'foto_profile' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('username', 'nama_lengkap', 'info');

        if ($request->hasFile('foto_profile')) {

            // hapus foto lama jika ada
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }

                $data['foto_profile'] = $request
                    ->file('foto_profile')
                    ->store('images/profile', 'public');

        }

        $user->update($data);

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
