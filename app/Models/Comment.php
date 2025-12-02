<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'photo_id', 
        'content',          
        'parent_comment_id'
    ];

    // RELASI
    
    // Komentar milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Komentar milik Foto
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    // Fitur Balasan: Komentar ini punya banyak balasan (Anak)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    // Fitur Balasan: Komentar ini adalah balasan dari komentar lain (Induk)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }
}