<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_id',
        'student_id',
        'name',
        'code',
        'uuid',
        'calendar'
    ];
}
