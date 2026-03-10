<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class BikeServiceRecordDetails extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'bike_service_record_id',
        'service_id',
        'quantity',
        'price',
    ];
}
