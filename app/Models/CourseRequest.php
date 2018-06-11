<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRequest extends Model
{
	public $timestamps = true;

	protected $table = 'course_request';

	protected $fillable = [
        'id_course',
        'id_user' 
    ];
}
