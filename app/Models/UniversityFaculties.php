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

    public static function getProfileFaculties($universityId, $request = false, $formLearningOptipons)
    {
        $faculties = (new UniversityFaculties)->newQuery();   

        if (!empty($request['searchByName'])) 
        {
            $faculties->where('name', 'like', '%'.$request['searchByName'].'%');
        }

        if (!empty($request['type']) && in_array($request['type'], $formLearningOptipons)) 
        { 
            $faculties->where($request['type'], '1');
        }

        if (!empty($request['duration_learning'])) 
        { 
            $faculties->where('duration_learning', $request['duration_learning']);
        }

        $query = $faculties->where('id_university', $universityId)
                           ->orderBy('created_at', 'desc')
                           ->get();
        return $query;
    }
}
