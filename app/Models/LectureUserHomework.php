<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureUserHomework extends Model
{
	public $timestamps = true;

	protected $table = 'lecture_user_homework';

	protected $fillable = [
        'id_lecture',
        'id_user',
        'message',
        'file',
        'confirm',
        'rejected',
        'teacher_comment',
        'appraisal',
        'date_response'
    ]; 
}
