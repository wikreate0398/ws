<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherRequest extends Model
{
	public $timestamps = true;

	protected $table = 'teacher_request';

	protected $fillable = [
        'id_teacher',
        'id_user' 
    ];
}
