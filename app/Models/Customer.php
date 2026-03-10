<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Customer extends BaseModel
{
    use HasFactory;
    
    protected $fillable = 
    [
        'company_id',
        'name',
        'email',
        'phone',
        'address',
        'organization',
        'current_balance',
        'customer_type',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
