<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Courses extends Model
{ 
	protected $table = 'courses';

	protected $fillable = [
        'id_user',
        'id_category',
        'id_subcat',
        'name',
        'description',
        'text',
        'pay',
        'is_open_from',
        'is_open_to',
        'date_from',
        'date_to',
        'hide_after_end',
        'max_nr_people',
        'type',
        'available',
        'price',
        'isHide',
        'general_filled',
        'settings_filled',
        'program_filled'
    ];

    public function category()
    {
        return $this->hasOne('App\Models\CourseCategory', 'id', 'id_category');
    } 

    public function subCategory()
    {
        return $this->hasOne('App\Models\CourseCategory', 'id', 'id_subcat');
    } 

    public function sections()
    {
        return $this->hasMany('App\Models\CourseSections', 'id_course', 'id');
    } 

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }   

    public function certificates()
    {
        return $this->hasMany('App\Models\CoursesCertificates', 'id_course', 'id')->orderBy('id', 'asc');
    }

    public function userRequests()
    {
        return $this->belongsToMany('App\Models\User', 'course_request', 'id_course', 'id_user');
    }

    public function userFavorite()
    { 
        return $this->belongsToMany('App\Models\User', 'course_favorite', 'id_course', 'id_user'); 
    }

    public static function getCatalog($cat=false, $subcat = false, $input=false)
    {
        $courses = (new Courses)->newQuery();

        if (!empty($input['q'])) 
        {
            $courses->where('name', 'like', '%'.$input['q'].'%');
        }

        if (!empty($input['pay']) && in_array($input['pay'], ['1','2'])) 
        {
            $courses->where('pay', $input['pay']);
        }

        if (!empty($subcat)) 
        {
            $courses->whereHas('subCategory', function($query) use($cat){
                $query->where('url', $cat);
            });
        }
        elseif (!empty($cat)) 
        { 
            $courses->whereHas('category', function($query) use($cat){
                $query->where('url', $cat);
            });
        } 
 
        
        return $courses->published()->with('user')->paginate(!empty($input['per_page']) ? $input['per_page'] : 6, 
                                      ['*'], 
                                      'page', 
                                      !empty($input['page']) ? $input['page'] : 1);
    }

    public function scopePublished($query)
    { 
        if (Auth::check() != true) 
        {
            $query->where('available', '!=', '2');
        } 

        return $query->where('isHide', 0)
                     ->where('general_filled', 1)
                     ->where('program_filled', 1)
                     ->where('settings_filled', 1)
                     ->where('view', 1)
                     ->whereHas('user', function($query){
                        return User::allowUser();
                    });
    }

    public function scopeOrderByCourses($query)
    {
        return $query->orderBy('date_from', 'asc');
    }

    public static function countTotal()
    {    
        return Courses::published()->count();
    }

    public static function getOneCourse($id, $authCheck = false)
    {
        return Courses::with('sections')->where('id', $id)->published()->findOrFail($id);
    }
}
