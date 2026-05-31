<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    /* ======================
       LOGIN
    ====================== */
    public function login(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Username atau password salah');
    }

    /* ======================
       LOGOUT
    ====================== */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    /* ======================
       FORGOT PASSWORD
    ====================== */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['username' => $request->username],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        return redirect()->route('password.reset.form', [
            'username' => $request->username,
            'token' => $token,
        ])->with('success', 'Silakan buat password baru');
    }

    /* ======================
       RESET PASSWORD
    ====================== */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('username', $request->username)
            ->first();

        // token tidak ditemukan / salah
        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors('Token reset tidak valid');
        }

        // token expired (60 menit)
        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')
                ->where('username', $request->username)
                ->delete();

            return back()->withErrors('Token reset sudah kadaluarsa');
        }

        User::where('username', $request->username)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')
            ->where('username', $request->username)
            ->delete();

        return redirect()
            ->route('login')
            ->with('success', 'Password berhasil direset. Silakan login kembali.');
    }
}
