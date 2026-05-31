<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostVerificationController extends Controller
{
    /**
     * Daftar postingan draft
     */
    public function index()
    {
        $posts = Post::with('author')
            ->where('status', 'draft')
            ->latest()
            ->get();

        return view('admin.posts.verification', compact('posts'));
    }

    public function show(Post $post)
    {
        // hanya draft / rejected yang bisa diverifikasi
        if ($post->status === 'published') {
            abort(404);
        }

        return view('admin.posts.show', compact('post'));
    }


    /**
     * Publish postingan
     */
    public function approve(Post $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => Carbon::now(),
            'rejected_at' => null,
            'rejection_reason' => null,
        ]);

        return redirect()-> route('admin.posts.index')->with('success', 'Postingan dipublikasikan');
    }

    /**
     * Tolak postingan
     */
    public function reject(Request $request, Post $post)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $post->update([
            'status' => 'rejected',
            'rejected_at' => Carbon::now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Postingan ditolak');
    }
}
