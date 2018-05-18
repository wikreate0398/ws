<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonOptionsList extends Model
{
    protected $table = 'lesson_options_list';

    public $timestamps = false;

	protected $fillable = [ 
        'name' 
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'teacher_lesson_options', 'id_lesson_option', 'id_teacher');
    }
}
