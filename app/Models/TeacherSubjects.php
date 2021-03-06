<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubjects extends Model
{
    protected $table = 'teacher_subjects';

    public $timestamps = false;

	protected $fillable = [
        'id_subject',
        'id_teacher'
    ];
}
