<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Supplier extends BaseModel
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
        'opening_payable',
        'opening_receivable',
        'current_balance',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}