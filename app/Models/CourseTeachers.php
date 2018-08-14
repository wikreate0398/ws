<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTeachers extends Model
{
	public $timestamps = false;

	protected $table = 'course_teachers';

	protected $fillable = [
        'id_course',
        'id_teacher' 
    ];
}
