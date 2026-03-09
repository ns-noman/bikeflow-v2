<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Account extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'payment_method_id',
        'account_no',
        'holder_name',
        'balance',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
