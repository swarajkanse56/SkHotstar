<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    // Table name (optional if it follows Laravel convention 'subcategories')
    protected $table = 'subcategories';

    // Fields allowed for mass assignment
    protected $fillable = [
        'name',
        'category_id',
        'image',
        'status',
    ];

    // Cast 'status' to boolean automatically
    protected $casts = [
        'status' => 'boolean',
    ];

    // Relationship: SubCategory belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);



    }

    
}
