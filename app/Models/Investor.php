<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Investor extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'name',
        'email',
        'contact',
        'address',
        'dob',
        'nid',
        'investment_capital',
        'balance',
        'is_self',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
