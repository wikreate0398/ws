<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursesCertificates extends Model
{
    protected $table = 'courses_certificates';

    public $timestamps = false;

	protected $fillable = [ 
        'id_course',
        'image'
    ];

    public function course()
    {
        return $this->hasOne('App\Models\Courses', 'id', 'id_course'); 
    }
}
