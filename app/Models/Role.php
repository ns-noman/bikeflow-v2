<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Role extends BaseModel
{
    use HasFactory;
    protected $fillable = 
    [
        'company_id',
        'created_by',
        'role'
    ];
    
    
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
