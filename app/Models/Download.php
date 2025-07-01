<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_id',
        'file_path',
        'file_name',
        'file_size'
    ];

    protected $dates = ['downloaded_at'];

   public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function video()
{
    return $this->belongsTo(Videos::class, 'video_id'); // Explicitly use 'video_id'
}

}