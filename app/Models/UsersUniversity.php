<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersUniversity extends Model
{
 	public $timestamps = false;
 	
    protected $table = 'users_university';

    public function user()
    {
    	return $this->hasOne('App\Models\User', 'id', 'id_user')->where('activate', '1');
    }

    public function institutionType()
    {
    	return $this->hasOne('App\Models\InstitutionTypes', 'id', 'institution_type');
    }

    public function parentInstitution()
    {
    	return $this->hasOne('App\Models\University', 'id', 'parent_institution');
    }

    public function formAttitude()
    {
    	return $this->hasOne('App\Models\UniversityFormAttitude', 'id', 'form_attitude');
    }

    public function programType()
    {
    	return $this->hasOne('App\Models\ProgramsType', 'id', 'program_type');
    }

    public function city()
    {
		return $this->hasOne('App\Models\Cities', 'id', 'city');
    }    

    public function teachActivity()
    {
		return $this->hasOne('App\Models\TeachActivityCategories', 'id', 'id_category');
    }   
}
