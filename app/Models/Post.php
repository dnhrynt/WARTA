<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'author_id',
        'status',
        'views',
        'shared',
        'published_at',
        'rejected_at',
        'rejection_reason',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'rejected_at'  => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Kategori::class, 'kategori_post', 'post_id', 'kategori_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    public function isLikedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->likes()
            ->where('user_id', $user->id)
            ->exists();
    }

}
