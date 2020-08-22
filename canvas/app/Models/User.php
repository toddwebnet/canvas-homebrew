<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'family_id',
        'name',
        'email',
        'email_verified_at',
        'password'
    ];
}
