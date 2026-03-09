<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
class InvestorLedger extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'investor_id',
        'account_id',
        'particular',
        'debit_amount',
        'credit_amount',
        'current_balance',
        'reference_number',
        'transaction_date',
        'created_by_id',
        'updated_by_id',
    ];
}
