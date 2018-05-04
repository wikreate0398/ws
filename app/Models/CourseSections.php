<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSections extends Model
{
	public $timestamps = false;
	
    protected $table = 'course_sections';

	protected $fillable = [
        'name',
        'id_course'
    ];

    public function lectures()
    {
    	return $this->hasMany('App\Models\SectionLectures', 'id_section', 'id');
    }
}
