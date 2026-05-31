<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'kategori_post', 'kategori_id', 'post_id');
    }

}
