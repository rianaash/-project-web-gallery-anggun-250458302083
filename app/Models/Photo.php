<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Photo extends Model
{
    use HasFactory;

    // kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'category_id',
        'image_url',
        'title',
        'caption',
    ];

    // relasi

    // 1. Foto ini diupload oleh siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 2. Foto ini Kategori apa?
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // 3. Foto ini punya banyak Komentar
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest(); 
    }

    // 4. Foto ini punya banyak Like
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 5. Foto ini punya banyak Bookmark
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }



    // Cek apakah user yang login sudah like foto ini?
    public function isLikedByAuthUser()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->likes()->where('user_id', Auth::id())->exists();
    }

    // Cek apakah user yang login sudah BOOKMARK foto ini?
    public function isBookmarked()
    {
        if (!Auth::check()) {
            return false;
        }
        // Cek di tabel bookmarks apakah user ini menyimpan foto ini
        return $this->bookmarks()->where('user_id', Auth::id())->exists();
    }
}