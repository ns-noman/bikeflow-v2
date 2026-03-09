<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
class ExpenseCategory extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'cat_name',
        'status'
    ];
}
