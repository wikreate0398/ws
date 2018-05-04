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
        'duration_minutes' 
    ];
}
