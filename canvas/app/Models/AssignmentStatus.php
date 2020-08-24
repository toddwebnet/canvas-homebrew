<?php
/**
 * User: jtodd
 * Date: 2020-08-23
 * Time: 21:18
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AssignmentStatus extends Model
{
    protected $table = 'assignment_status';
    protected $fillable = [
        'assignment_id',
        'download_date'
    ];
}
