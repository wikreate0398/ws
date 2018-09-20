<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherReviews extends Model
{
	public $timestamps = true;

	protected $table = 'teacher_reviews';

	protected $fillable = [
        'id_teacher',
        'id_user',
        'rating',
        'review' 
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }

    public function teacher()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_teacher');
    }
}
