<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class NavbarController extends Controller
{
    public static function menu(): array
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return [];
        }

        $menus = [
            'admin' => [
                ['label' => 'Beranda','route' => 'dashboard',],
                ['label' => 'Manajemen User','route' => 'admin.users.index',],
                ['label' => 'Kategori','route' => 'kategori.index',],
                ['label' => 'Verifikasi','route' => 'admin.posts.index',],
                ['label' => 'Postingan Saya','route' => 'posts.mine',],
                ['label' => 'Buat Postingan','route' => 'posts.create',],
            ],
            'user' => [
                ['label' => 'Beranda','route' => 'dashboard',],
                ['label' => 'Postingan Saya','route' => 'posts.mine',],
                ['label' => 'Buat Postingan','route' => 'posts.create',],
            ],
        ];

        return $menus[$user->role] ?? [];
    }
}
