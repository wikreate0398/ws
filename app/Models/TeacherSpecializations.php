<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSpecializations extends Model
{
    protected $table = 'teacher_specializations';

    public $timestamps = false;

	protected $fillable = [ 
        'id_teacher',
        'id_specialization'
    ];
}
