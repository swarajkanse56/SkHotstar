<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{      protected $fillable = ['name', 'video_id','thumbnail'];

    //
   public function video()
    {
        return $this->belongsTo(Videos::class, 'video_id');
    }

}
