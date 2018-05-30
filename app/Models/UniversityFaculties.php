<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversityFaculties extends Model
{
    protected $table = 'university_faculties';

    public $timestamps = true;

    protected $fillable = [
    	'name',
        'duration_learning',
        'average_nr_points',
        'qty_budget', 
        'price',
        'id_university',
        'full_time_learning',
        'non_public_learning',
        'distance_learning'
    ];

    public function subjects()
    {
        return $this->belongsToMany('App\Models\SubjectsList', 'university_faculties_subjects', 'id_faculty', 'id_subject')->orderBy('page_up', 'asc')->orderBy('id', 'desc');
    }
}
