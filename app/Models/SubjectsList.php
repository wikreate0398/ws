<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectsList extends Model
{
    protected $table = 'subjects';

    public $timestamps = false;

	protected $fillable = [ 
        'name' 
    ]; 

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'teacher_subjects', 'id_subject', 'id_teacher');
    }
}
