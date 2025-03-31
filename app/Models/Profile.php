<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'profile_image',
        'name',
        'phone',
        'email',
        'street_address',
        'city',
        'state',
        'country'
    ];
}
