<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Daftar postingan milik user (thumbnail)
     */
    public function index()
    {
        $posts = Post::with('categories')
            ->where('author_id', Auth::id())
            ->latest()
            ->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Form buat postingan
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('posts.create', compact('kategori'));
    }

    /**
     * Simpan postingan (default draft)
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'nullable|image|max:2048',
            'kategori' => 'required|array',
        ]);

        $data = [
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . uniqid(),
            'konten' => $request->konten,
            'author_id' => Auth::id(),
            'status' => 'draft',
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request
                ->file('gambar')
                ->store('images/post', 'public');
        }

        $post = Post::create($data);
        $post->categories()->sync($request->kategori);

        return redirect()
            ->route('posts.mine')
            ->with('success', 'Postingan berhasil dibuat dan menunggu verifikasi');
    }

    /**
     * Detail postingan (halaman berita)
     */
    public function show(Post $post)
    {
        // hanya pemilik atau postingan published
        if ($post->status !== 'published' && $post->author_id !== Auth::id()) {
            abort(403);
        }

        // hitung view hanya jika published
        if ($post->status === 'published') {
            $post->increment('views');
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Form edit (selama draft / rejected)
     */
    public function edit(Post $post)
    {
        $this->authorizeOwner($post);

        $categories = Kategori::all();
        $selectedCategories = $post->categories->pluck('id')->toArray();

        return view('posts.edit', compact(
            'post',
            'categories',
            'selectedCategories'
        ));
    }


    /**
     * Update postingan
     */
    public function update(Request $request, Post $post)
    {
        $this->authorizeOwner($post);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'gambar' => 'nullable|image|max:2048',
            'kategori' => 'required|array',
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'status' => 'draft', // edit = kembali ke draft
            'rejected_at' => null,
            'rejection_reason' => null,
        ];

        if ($request->hasFile('gambar')) {
            if ($post->gambar) {
                Storage::disk('public')->delete($post->gambar);
            }

            $data['gambar'] = $request
                ->file('gambar')
                ->store('images/post', 'public');
        }

        $post->update($data);
        $post->categories()->sync($request->kategori);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Postingan diperbarui dan dikirim ulang untuk verifikasi');
    }

    /**
     * Hapus postingan
     */
    public function destroy(Post $post)
    {
        $this->authorizeOwner($post);

        if ($post->gambar) {
            Storage::disk('public')->delete($post->gambar);
        }

        $post->delete();

        return back()->with('success', 'Postingan dihapus');
    }

    /**
     * Cek kepemilikan
     */
    private function authorizeOwner(Post $post)
    {
        if ($post->author_id !== Auth::id()) {
            abort(403);
        }
    }
}
