<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'id',
        'student_id',
        'name',
        'code',
        'uuid',
        'start_at',
        'calendar'
    ];
}
