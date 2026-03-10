<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Party extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'name',
        'email',
        'phone',
        'address',
        'nid_number',
        'date_of_birth',
        'current_balance',
        'status',
        'created_by_id',
        'updated_by_id',
    ];
}
