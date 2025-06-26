<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Table name (optional if table name is 'categories')
    protected $table = 'categories';

    // Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'image',
    ];
}
