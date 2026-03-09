<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class BaseModel extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('company', function ($query) {
            $user = Auth::guard('admin')->user();
            if ($user) {
                $query->where($query->getModel()->getTable() . '.company_id', $user->company_id);
            }
        });
    }
    protected static function boot()
    {
        parent::boot();

        // Auto-fill company_id on create
        static::creating(function ($model) {
            $user = Auth::guard('admin')->user();
            if ($user && empty($model->company_id)) {
                $model->company_id = $user->company_id;
            }
        });
    }
}
