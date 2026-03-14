<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Auth;

class BikePurchase extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'investor_id',
        'bike_id',
        'account_id',
        'seller_id',
        'broker_id',
        'bike_sale_id',
        'slug',
        'purchase_price',
        'servicing_cost',
        'total_cost',
        'online_sale_price',
        'online_offer_price',
        'purchase_date',
        'doc_nid',
        'doc_reg_card',
        'doc_image',
        'doc_deed',
        'doc_tax_token',
        'note',
        'reference_number',
        'is_negatiable',
        'is_online',
        'conditon',
        'selling_status',
        'purchase_status',
        'created_by_id',
        'updated_by_id',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by_id = Auth::guard('admin')->user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by_id = Auth::guard('admin')->user()->id;
        });
    }
}
