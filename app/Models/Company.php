<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'title',
        'meta_keywords',
        'meta_description',
        'logo',
        'favicon',
        'phone1',
        'phone2',
        'email',
        'address',
        'web_link',
        'facebook_link',
        'x_link',
        'linkedin_link',
        'youtube_link',
        'map_embed',
    ];
}
