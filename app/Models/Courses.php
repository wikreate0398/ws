<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{ 

	protected $table = 'courses';

	protected $fillable = [
        'id_user',
        'id_category',
        'id_subcat',
        'name',
        'description',
        'text',
        'pay',
        'is_open_until',
        'available',
        'price'
    ];

    public function courseSections()
    {
        return $this->hasMany('App\Models\CourseSections', 'id_course', 'id');
    } 
}
