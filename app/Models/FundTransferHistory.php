<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class FundTransferHistory extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'transfer_date',
        'from_account_id',
        'to_account_id',
        'amount',
        'reference_number',
        'description',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
