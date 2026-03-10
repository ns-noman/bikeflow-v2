<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class BikeService extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'bike_service_category_id',
        'name',
        'trade_price',
        'price',
        'status',
    ];
}
