<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Support\Facades\Auth;

class BikeProfit extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'bike_sale_id',
        'investor_id',
        'profit_amount',
        'profit_share_amount',
        'profit_entry_date',
        'profit_share_last_date',
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

    public function paymenthistory()
    {
        return $this->hasMany(BikeProfitShareRecords::class, 'bike_profit_id');
    }
}
