<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class BikeServiceCategory extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'name',
        'status',
    ];
}
