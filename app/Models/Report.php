<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_user_id',
        'reported_photo_id',
        'reason',
        'status',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_user_id');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'reported_photo_id');
    }
}
