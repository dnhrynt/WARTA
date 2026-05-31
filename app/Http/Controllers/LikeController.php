<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like / unlike post
     */
    public function toggle(Post $post)
    {
        $user = Auth::user();

        // Cek apakah sudah like
        $like = Like::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($like) {
            // UNLIKE
            $like->delete();
            $status = 'unliked';
        } else {
            // LIKE
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
            $status = 'liked';
        }

        return response()->json([
            'status' => $status,
            'total_likes' => $post->likes()->count(),
        ]);
    }

    /**
     * List semua like (admin / debugging)
     */
    public function index()
    {
        $likes = Like::with(['user', 'post'])
            ->latest()
            ->paginate(20);

        return view('admin.likes.index', compact('likes'));
    }

    /**
     * Hapus like (admin)
     */
    public function destroy(Like $like)
    {
        $like->delete();

        return back()->with('success', 'Like berhasil dihapus');
    }
}
