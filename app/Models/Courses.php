<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'is_open_until',
        'available',
        'price'
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

    public static function getCatalog($cat=false, $input=false)
    {
        $courses = (new Courses)->newQuery();

        if (isset($input['q'])) 
        {
            $courses->where('name', 'like', '%'.$input['q'].'%');
        }

        if (!empty($input['pay']) && in_array($input['pay'], ['1','2'])) 
        {
            $courses->where('pay', $input['pay']);
        }

        if (!empty($cat)) 
        {
            $courses->whereHas('category', function($query) use($cat){
                $query->where('url', $cat);
            });
        }

        $courses->whereHas('user', function($query){
            $query->where(function($query){
                return User::allowTeacherUser($query);
            });
        });

        return $courses->with('user')->paginate(!empty($input['per_page']) ? $input['per_page'] : 6, 
                                      ['*'], 
                                      'page', 
                                      !empty($input['page']) ? $input['page'] : 1);
    }
}
