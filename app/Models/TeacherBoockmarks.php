<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherBoockmarks extends Model
{
    protected $table = 'teacher_boockmarks';

    public $timestamps = false;

	protected $fillable = [ 
        'id_teacher',
        'id_user'
    ];
}
