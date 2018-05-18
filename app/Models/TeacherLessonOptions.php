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
 
    public function lesson_options_list()
    {
    	return $this->hasOne(LessonOptionsList::class, 'id', 'id_lesson_option')
    	            ->orderBy('page_up', 'asc')
                    ->orderBy('id', 'desc');
    }

    
}
