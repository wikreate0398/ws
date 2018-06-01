<?php

namespace App\Models;

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

    public static function getUniversities($request = false)
    {
        $university = (new UsersUniversity)->newQuery();

        // exit($request['']);

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
                                return User::allowUniversityUser($query);
                            })->orderBy('id_user', 'asc');

        return $university->paginate(!empty($request['per_page']) ? $request['per_page'] : 6, 
                                      ['*'], 
                                      'page', 
                                      !empty($request['page']) ? $request['page'] : 1);
    }

    public function specializations()
    {
        return $this->belongsToMany('App\Models\UniversitySpecializationsList', 'university_specializations', 'id_university', 'id_specialization');
    }

    public static function getFilterMinMaxPrice()
    {
        $min = self::where('price', '>', '0')
                    ->min('price');

        $max = self::where('price', '>', '0')
                   ->max('price');

        return compact('min', 'max');
    }
}
