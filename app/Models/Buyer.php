<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Buyer extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'name',
        'contact',
        'nid',
        'dob',
        'dl_no',
        'passport_no',
        'bcn_no',
        'status',
    ];
}
