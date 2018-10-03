<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionLecturesMaterials extends Model
{
	public $timestamps = false;

	protected $table = 'section_lectures_materials';

	protected $fillable = [
        'id_lecture',
        'material'
    ];
}
