<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseReviews extends Model
{
	public $timestamps = true;

	protected $table = 'course_reviews';

	protected $fillable = [
        'id_course',
        'id_user',
        'rating',
        'review' 
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }  
}
