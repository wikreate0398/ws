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
}
