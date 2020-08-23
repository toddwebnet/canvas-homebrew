<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'id',
        'family_id',
        'name',
        'school',
        'grade'
    ];
    public function courses(){
        return $this->hasMany(Course::class);
    }
}
