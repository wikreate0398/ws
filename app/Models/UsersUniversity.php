<?php

namespace App\Models;

use function foo\func;
use Illuminate\Database\Eloquent\Model;

class UsersUniversity extends Model
{
 	public $timestamps = false;
 	
    protected $table = 'users_university';

    public function user()
    {
    	return $this->hasOne('App\Models\User', 'id', 'id_user')->where('activate', '1');
    }
 
    public function city()
    {
		return $this->hasOne('App\Models\Cities', 'id', 'city');
    }     

    public function faculties()
    {
        return $this->hasMany('App\Models\UniversityFaculties', 'id_university', 'id')->orderBy('created_at', 'desc');
    }

    public function news()
    {
        return $this->hasMany('App\Models\UniversityNews', 'id_university', 'id')->orderBy('created_at', 'desc');
    }

    public function scopeAllow($query)
    {
        return $query->whereHas('user', function($query){
            return User::allowUser();
        });
    }

    public function connects()
    {
        return $this->hasOne('App\Models\TeacherUniversityConnect', 'id_university', 'id_user')->fromTeacher()->orderBy('created_at', 'desc');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\UniversityReviews', 'id_university', 'id_user')->orderBy('created_at', 'desc');
    } 
 
    public static function getUniversities($request = false)
    {
        $university = (new UsersUniversity)->newQuery();

        $university->select('users_university.*');

        if (isset($request['has_military_department']) && in_array($request['has_military_department'], ['1','0'])) 
        {
            $university->where('has_military_department', $request['has_military_department']);
        }

        if (isset($request['has_hostel']) && in_array($request['has_hostel'], ['1','0'])) 
        {
            $university->where('has_hostel', $request['has_hostel']);
        }

        if (isset($request['distance_learning']) && in_array($request['distance_learning'], ['1','0'])) 
        { 
            $university->where('distance_learning', $request['distance_learning']);
        }

        if (isset($request['status']) && in_array($request['status'], ['1','2'])) 
        { 
            $university->where('status', $request['status']);
        } 

        if (isset($request['min_price'])) 
        {
            $university->where('price', '>=', toFloat($request['min_price']));
        }

        if (isset($request['max_price'])) 
        {
            $university->where('price', '<=', toFloat($request['max_price']));
        }

        if (isset($request['specializations'])) 
        {
            $specializationsId = explode(',', $request['specializations']);
            $university->whereHas('specializations', function ($query) use ($specializationsId) {
                $query->whereIn('id_specialization', $specializationsId);
            });
        }

        $university->with('user')->whereHas('user', function($query){
                                return $query->allowUser();
                            });

        $university->with(['user.courses' => function($query){
                                return $query->published();
                            }]);

        
        if (request()->reviewSort) 
        {
            $university->orderByReview();
        } 

        if (request()->placesSort) 
        {
            $university->orderByPlaces();
        }

        switch (@$request['tab']){
            case "popular": 
                    $university->orderByViews();
                    $university->orderByReview(); 
                break;

            case "featured":
                $university->whereHas('user', function($query){
                    $query->where('featured', '1');
                });
                break;

            case "budget":
                $university->where('qty_budget', '>', '0');
                break;

            case "online_training":
                $university->where('distance_learning', '1');
                break;

            default:
                break;
        }

        $university->orderUniv();

        $university->groupBy('users_university.id');

        return $university->paginate(!empty($request['per_page']) ? $request['per_page'] : 6, 
                                      ['*'], 
                                      'page', 
                                      !empty($request['page']) ? $request['page'] : 1);
    }

    public function scopeOrderUniv($query)
    {
        $query->orderBy('id_user', 'asc');
    }

    public function scopeOrderByReview($query)
    {
        $query->withCount('reviews');

        if (request()->reviewSort == 'asc') 
        {
            return $query->orderBy('reviews_count', 'asc');
        }
        elseif (request()->reviewSort == 'desc') 
        {
            return $query->orderBy('reviews_count', 'desc');
        }  
    }

    public function scopeOrderByPlaces($query)
    {
        if (request()->placesSort == 'desc') 
        { 
            return $query->orderBy('qty_budget', 'desc');
        }
        elseif (request()->placesSort == 'asc') 
        {
            return $query->orderBy('qty_budget', 'asc');
        } 
    }

    public function scopeOrderByViews($query)
    {
        return $query->leftJoin('count_views', function($leftJoin){
            $leftJoin->on('count_views.id_item', '=', 'users_university.id_user')
                     ->where('type', 'university');
        })->orderBy('count_views.count', 'desc');
    }

    public function specializations()
    {
        return $this->belongsToMany('App\Models\UniversitySpecializationsList', 'university_specializations', 'id_university', 'id_specialization');
    }

    public static function getFilterMinMaxPrice()
    {
        $min = self::where('price', '>', '0')->whereHas('user', function($query){
                                return $query->allowUser();
                            })
                    ->min('price');

        $max = self::where('price', '>', '0')->whereHas('user', function($query){
                                return $query->allowUser();
                            })
                   ->max('price');

        return compact('min', 'max');
    }
}
