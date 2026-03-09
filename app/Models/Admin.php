<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Role;

class Admin extends Authenticate
{
    use HasFactory;

    protected $guard = 'admin';

    protected $fillable = [
        'company_id',
        'investor_id',
        'name',
        'type',
        'mobile',
        'username',
        'email',
        'password',
        'image',
        'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'type');
    }
}