<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversityReviews extends Model
{
	public $timestamps = true;

	protected $table = 'university_reviews';

	protected $fillable = [
        'id_university',
        'id_user',
        'rating',
        'review' 
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }

    public function university()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_university');
    }
}
