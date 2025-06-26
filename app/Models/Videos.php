<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    //

    // app/Models/Video.php

            protected $fillable = ['title', 'thumbnail', 'video_url', 'category_id', 'subcategory_id', 'description', 'duration'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // Allow mass assignment for these fields
    

}
