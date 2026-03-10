<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class CustomerPayment extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'customer_id',
        'account_id',
        'sale_id',
        'date',
        'amount',
        'reference_number',
        'note',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
