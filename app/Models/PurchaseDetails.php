<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class PurchaseDetails extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'purchase_id',
        'item_id',
        'quantity',
        'unit_price',
    ];
    
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id')->with('unit');
    }
}
