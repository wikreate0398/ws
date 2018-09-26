<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        'program_filled',
        'discount_percent',
        'discount_price'
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
        return $this->belongsToMany('App\Models\User', 'course_request', 'id_course', 'id_user')->withPivot('confirm', 'trial', 'confirm_date', 'trial_date');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\Models\User', 'course_teachers', 'id_course', 'id_teacher');
    }  

    public function userFavorite()
    { 
        return $this->belongsToMany('App\Models\User', 'course_favorite', 'id_course', 'id_user'); 
    }

    public function reviews()
    {  
        return $this->hasMany('App\Models\CourseReviews', 'id_course', 'id')->orderBy('created_at', 'desc');
    } 

    public static function getCatalog($cat=false, $subcat = false, $input=false)
    {
        $courses = (new Courses)->newQuery();

        $courses->select('courses.*');

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

        switch (@$input['filter']){
            case "popular":
                $courses->leftJoin('count_views', function($leftJoin){
                            $leftJoin->on('count_views.id_item', '=', 'courses.id')
                                     ->where('count_views.type', 'course');
                        })
                        ->withCount('userRequests')
                        ->orderBy('count_views.count', 'desc')
                        ->orderBy('user_requests_count', 'desc');
                break;

            case "new":
                $courses->orderBy('id', 'desc');
                break;

            case "discount":
                $courses->where('discount_price', '>', 0)->orderByCourses();
                break;

            case "featured":
                $courses->where('featured', 1)->orderByCourses();
                break;

            default:
                $courses->orderByCourses();

        }

        return $courses->published()->with('user')->paginate(!empty($input['per_page']) ? $input['per_page'] : 12,
                                      ['*'], 
                                      'page', 
                                      !empty($input['page']) ? $input['page'] : 1);
    }

    public function scopeOrderByCourses($query)
    {
        return $query->orderBy('date_from');
    }

    public function counter()
    {
        return $this->hasOne('App\Models\CountViews', 'id', 'id_item')->where('type', 'course');
    }

    public function scopePublished($query)
    { 
        if (Auth::check() != true) 
        {
            $query->where('available', '!=', '2');
        }
                     
        return $query->where('general_filled', 1)
                     ->where('program_filled', 1)
                     ->where('settings_filled', 1)
                     ->where('сertificates_filled', 1)
                     ->where('view', 1)
                     ->whereRaw('If(`hide_after_end`= 1, `is_open_to` >= CURDATE(), `view`=1)')
                     ->whereHas('user', function($query){
                        return User::allowUser();
                    });
    } 

    public function scopeFilterProfile($courses)
    {  
        if (isset(request()->search)) 
        {
            if (@request()->status == '0') 
            {
                $courses->finishedStatus();
            } 

            if (@request()->status == '1') 
            { 
                $courses->activeStatus();
            } 

            if (@request()->category) 
            {
                $courses->where('id_category', request()->category);
            }  

            if (@request()->searchByName) 
            {
                $searchByName = request()->searchByName;
                $courses->where('name', 'like', '%'.$searchByName.'%');
            }  

            if (@request()->teacher) 
            {
                $teacherId = request()->teacher;
                $courses->whereHas('teachers', function($query) use($teacherId){ 
                    return $query->where('id_teacher', $teacherId);
                });
            }   
        } 
    }

    public function scopeActiveStatus($query)
    {
        return $query->whereDate('date_to', '>=', date('Y-m-d'))->where('settings_filled', '1');
    }

    public function scopeFinishedStatus($query)
    {
        return $query->whereDate('date_to', '<', date('Y-m-d'))->where('settings_filled', '1');
    }

    public static function countTotal()
    {    
        return Courses::published()->count();
    }  

    public static function getOneCourse($id, $authCheck = false)
    {
        return Courses::with('sections')  
                      ->published()
                      ->findOrFail($id);
    }
}
