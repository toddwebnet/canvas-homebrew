<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $fillable = [
        'family_id',
        'first_name',
        'last_name',
        'school',
        'grade'
    ];
}
