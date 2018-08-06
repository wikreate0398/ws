<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherUniversityConnect extends Model
{
    protected $table = 'teacher_university_connect';

    public $timestamps = true; 

	protected $fillable = [
        'id_teacher',
        'id_university', 
        'letter',
        'teaching',  
        'attach',
        'decline',
        'from'
    ];

    public function university()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_university');
    }

    public function teacher()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_teacher');
    }
    
    public function scopeFromTeacher($query)
    {
        return $query->where('from', 2);
    }

    public function scopeFromUniversity($query)
    {
        return $query->where('from', 3);
    }
}
