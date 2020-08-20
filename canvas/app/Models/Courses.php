<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $fillable = [
        'student_id',
        'canvas_id',
        'name',
        'code',
        'uuid',
        'start_at',
        'calendar'
    ];
}
