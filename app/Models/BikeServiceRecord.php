<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Auth;

class BikeServiceRecord extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'invoice_no',
        'bike_purchase_id',
        'customer_id',
        'account_id',
        'date',
        'total_amount',
        'reference_number',
        'note',
        'status',
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
