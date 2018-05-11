<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherLessonOptions extends Model
{
    protected $table = 'teacher_lesson_options';

    public $timestamps = false;

	protected $fillable = [ 
        'id_teacher',
        'id_lesson_option'
    ];
}
