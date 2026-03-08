<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeAttribute extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'brand_id',
        'model_id',
        'color_id',
        'manufacture_year',
    ];
}
