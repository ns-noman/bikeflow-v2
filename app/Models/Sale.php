<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Sale extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'customer_id',
        'bike_reg_no',
        'account_id',
        'invoice_no',
        'date',
        'total_price',
        'vat_tax',
        'discount_method',
        'discount_rate',
        'discount',
        'total_payable',
        'paid_amount',
        'reference_number',
        'note',
        'payment_status',
        'status',
        'created_by_id',
        'updated_by_id',
    ];


    public function details()
    {
        return $this->hasMany(SaleDetails::class, 'sale_id');
    }

}