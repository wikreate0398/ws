<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeachersUniversity extends Model
{
	public $timestamps = true;
	
    protected $table = 'teachers_university';

	protected $fillable = [
        'id_teacher',
        'id_university'
    ];  
}
