<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;

class AuthorController extends Controller
{
    public function show(User $user)
    {
        // postingan milik author (published saja)
        $posts = Post::with('categories')
            ->where('author_id', $user->id)
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('author.profile', compact('user', 'posts'));
    }
}
