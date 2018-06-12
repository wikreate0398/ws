<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
	public $timestamps = false;

	protected $table = 'course_category';

	protected $fillable = [
        'name',
        'description',
        'url',
        'seo_title',
        'seo_description',
        'seo_keywords'
    ];

    public function courses()
    {
        return $this->hasMany('App\Models\Courses', 'id_category', 'id');
    }

    public function coursesSubcat()
    {
        return $this->hasMany('App\Models\Courses', 'id_subcat', 'id');
    }

    public function usersSubjects()
    {
        return $this->belongsToMany('App\Models\User', 'teacher_subjects', 'id_subject', 'id_teacher');
    }
}
