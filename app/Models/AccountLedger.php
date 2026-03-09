<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class AccountLedger extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'account_id',
        'debit_amount',
        'credit_amount',
        'current_balance',
        'reference_number',
        'description',
        'transaction_date',
    ];
}
