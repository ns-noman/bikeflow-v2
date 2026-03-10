<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class CustomerLedger extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'customer_id',
        'sale_id',
        'payment_id',
        'account_id',
        'particular',
        'date',
        'debit_amount',
        'credit_amount',
        'current_balance',
        'reference_number',
        'note',
        'created_by_id',
        'updated_by_id',
    ];
}
