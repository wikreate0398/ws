<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversityDepartment extends Model
{
    protected $table = 'university_department';

    public $timestamps = false;

	protected $fillable = [ 
        'id_university',
        'name',
        'phone'
    ];

    public function university()
    {
    	return $this->hasOne('App\Models\User', 'id', 'id_university');
    }
}
