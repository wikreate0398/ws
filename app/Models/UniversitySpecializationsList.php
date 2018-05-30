<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversitySpecializationsList extends Model
{
    protected $table = 'university_specializations_list';

    public $timestamps = false;

	protected $fillable = [ 
        'name' 
    ]; 

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'university_specializations', 'id_specialization', 'id_teacher');
    }
}
