<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionLectures extends Model
{

	public $timestamps = false;

	protected $table = 'section_lectures';

	protected $fillable = [
        'name',
        'id_section',
        'description',
        'duration_hourse',
        'duration_minutes',
        'video_link',
        'video_file',
        'video_type',
        'homework_letter',
        'homework_required',
        'homework_file',
        'has_homework'
    ];

    public function materials()
    {
        return $this->hasMany('App\Models\SectionLecturesMaterials', 'id_lecture', 'id');
    } 
}
