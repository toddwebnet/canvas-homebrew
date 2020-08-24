<?php
/**
 * User: jtodd
 * Date: 2020-08-23
 * Time: 21:11
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'assignment_id',
        'course_id',
        'student_id',
        'name',
        'due_at'
    ];
}
