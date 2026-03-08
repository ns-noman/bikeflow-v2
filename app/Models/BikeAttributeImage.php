<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeAttributeImage extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'attribute_id',
        'image',
        'caption',
        'is_thumbnail',
    ];
}
