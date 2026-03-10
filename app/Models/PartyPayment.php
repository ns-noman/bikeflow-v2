<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;


class PartyPayment extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'party_id',
        'account_id',
        'loan_id',
        'payment_type',
        'date',
        'amount',
        'reference_number',
        'note',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
