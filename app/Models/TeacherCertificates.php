<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCertificates extends Model
{
    protected $table = 'teacher_certificates';

    public $timestamps = false;

	protected $fillable = [ 
        'id_teacher',
        'image'
    ];
}
