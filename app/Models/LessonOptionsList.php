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
}
