<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = 'families';

    protected $fillable = [
        'api_key',
        'name',
        'address',
        'city',
        'state',
        'zipcode',
    ];
}
