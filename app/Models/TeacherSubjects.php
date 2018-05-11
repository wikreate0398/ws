<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubjects extends Model
{
    protected $table = 'teacher_subjects';

    public $timestamps = false;

	protected $fillable = [
        'name',
        'id_teacher'
    ];
}
