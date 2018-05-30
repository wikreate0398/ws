<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversityFacultiesSubjects extends Model
{
    protected $table = 'university_faculties_subjects';

    public $timestamps = false;

	protected $fillable = [
        'id_subject',
        'id_faculty'
    ];
}
