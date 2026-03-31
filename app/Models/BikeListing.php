<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeListing extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'bike_attribute_id',
        'used_bike_id',
        'price',
        'discount_price',
        'negotiable',
        'stock_quantity',
        'condition',
        'mileage',
        'ownership_count',
        'fitness_valid_until',
        'tax_valid_until',
        'insurance_valid_until',
        'use_default_image',
        'is_online_posted',
        'status',
        'approved_by_id'
    ];
}
