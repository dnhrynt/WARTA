<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kategoriAktif = $request->get('kategori');
        $search = $request->get('search');

        // navbar kategori
        $categories = Kategori::orderBy('nama_kategori')->get();

        // ===== POST UTAMA =====
        $postsQuery = Post::with(['categories', 'author', 'likes'])
            ->where('status', 'published');

        if ($kategoriAktif) {
            $postsQuery->whereHas('categories', function ($q) use ($kategoriAktif) {
                $q->where('kategori.id', $kategoriAktif);
            });
        }

        if ($search) {
            $postsQuery->where('judul', 'like', "%{$search}%");
        }

        $posts = $postsQuery
            ->orderByDesc('published_at')
            ->paginate(6)
            ->withQueryString();

        // ⭐ PALING BANYAK DISUKAI
        $mostLikedPosts = Post::with(['author'])
            ->withCount('likes')
            ->where('status', 'published')
            ->orderByDesc('likes_count')
            ->limit(4)
            ->get();

        // ===== POPULER =====
        $popularPosts = Post::where('status', 'published')
            ->orderByRaw('(views + shared) DESC')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'categories',
            'posts',
            'popularPosts',
            'mostLikedPosts',
            'kategoriAktif',
            'search'
        ));
    }
}
