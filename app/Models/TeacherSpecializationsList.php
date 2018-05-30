<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSpecializationsList extends Model
{
    protected $table = 'teacher_specializations_list';

    public $timestamps = false;

	protected $fillable = [ 
        'name' 
    ]; 

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'teacher_specializations', 'id_specialization', 'id_teacher');
    }
}
