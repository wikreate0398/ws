<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversitySpecializations extends Model
{
    protected $table = 'university_specializations';

    public $timestamps = false;

	protected $fillable = [ 
        'id_teacher',
        'id_specialization'
    ]; 

    public function specializations_list()
    {
    	return $this->hasOne(TeacherSpecializationsList::class, 'id', 'id_specialization')
    	            ->orderBy('page_up', 'asc')
                    ->orderBy('id', 'desc');
    }
}
