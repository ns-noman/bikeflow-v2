<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class SaleDetails extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'sale_id',
        'item_type',
        'item_id',
        'service_id',
        'quantity',
        'unit_price',
        'purchase_price',
        'profit',
        'net_sale_price',
        'net_profit',
    ];
}
