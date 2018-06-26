<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseFavorite extends Model
{
    protected $table = 'course_favorite';

    public $timestamps = false;

	protected $fillable = [ 
        'id_course',
        'id_user'
    ];
}
