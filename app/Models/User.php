<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable;

    protected $guard = 'web';

    protected $table = 'users';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',  
        'user_type', 
        'phone', 
        'date_birth', 
        'city', 
        'phone2', 
        'fax', 
        'site', 
        'image', 
        'confirm_hash',
        'redirectUri',
        'activate',
        'confirm'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ]; 
    
    public function cityData()
    {
        return $this->hasOne('App\Models\Cities', 'id', 'city');
    }

    public function userType()
    {
        return $this->hasOne('App\Models\UserTypes', 'id', 'user_type');
    }

    public function teacherBoockmarks()
    { 
        return $this->belongsToMany('App\Models\User', 'teacher_boockmarks', 'id_teacher', 'id_user')->allowUser();
    }

    public function userTeacherBoockmarks()
    {
        return $this->belongsToMany('App\Models\User', 'teacher_boockmarks', 'id_user', 'id_teacher')->allowUser();
    }

    public function universityBoockmarks()
    { 
        return $this->belongsToMany('App\Models\User', 'university_bookmarks', 'id_university', 'id_user')->allowUser();
    }

    public function userUniversityBoockmarks()
    {
        return $this->belongsToMany('App\Models\User', 'university_bookmarks', 'id_user', 'id_university')->allowUser();
    }
 
    public function courseFavorite()
    { 
        return $this->belongsToMany('App\Models\Courses', 'course_favorite', 'id_user', 'id_course')->published(); 
    }

    public function connectionTeachers()
    {
        return $this->belongsToMany('App\Models\User', 'teachers_university', 'id_university', 'id_teacher')->allowUser();
    }

    public function connectionUniversities()
    {
        return $this->belongsToMany('App\Models\User', 'teachers_university', 'id_teacher', 'id_university')->with('university')->allowUser();
    }

    public function connectsUniversityRequest()
    {
        return $this->hasOne('App\Models\TeacherUniversityConnect', 'id_teacher', 'id')->fromUniversity()->orderBy('created_at', 'desc');
    }

    public function university()
    {
        return $this->hasOne('App\Models\UsersUniversity', 'id_user', 'id');
    }

    public function courses()
    {
        return $this->hasMany('App\Models\Courses', 'id_user', 'id')->orderBy('created_at', 'desc');
    } 

    public function coursesRequests()
    {
        return $this->belongsToMany('App\Models\Courses', 'course_request', 'id_user', 'id_course')
                    ->whereHas('user', function($query){
                        return $query->allowUser();
                    });
    } 
    
    public function scopeAllowUser($query)
    {
        return $query->where('activate', '1')
                     ->where('confirm', '1') 
                     ->where('data_filled','1');
    }      

    public static function getTeachers($request = false)
    {

        $user = (new User)->newQuery(); 

        if (isset($request['q'])) 
        {
            $user->where('name', 'like', '%'.$request['q'].'%');
        }

        if (isset($request['sex']) && in_array($request['sex'], ['male', 'female'])) 
        {
            $user->where('sex', $request['sex']);
        }

        if (isset($request['teacher_available']) && in_array($request['teacher_available'], ['1', '0'])) 
        {
            $user->where('is_available', $request['teacher_available']);
        }

        if (isset($request['min_price'])) 
        {
            $user->where('price_hour', '>=', toFloat($request['min_price']));
        }

        if (isset($request['max_price'])) 
        {
            $user->where('price_hour', '<=', toFloat($request['max_price']));
        } 

        if (isset($request['subjects'])) 
        {
            $subjectsId = explode(',', $request['subjects']);
            $user->whereHas('subjects', function ($query) use ($subjectsId) {
                $query->whereIn('id_subject', $subjectsId);
            });
        }

        if (isset($request['specializations'])) 
        {
            $specializationsId = explode(',', $request['specializations']);
            $user->whereHas('teacherSpecializations', function ($query) use ($specializationsId) {
                $query->whereIn('id_specialization', $specializationsId);
            });
        }

        if (isset($request['lesson_options'])) 
        {
            $lessonOptionsId = explode(',', $request['lesson_options']);
            $user->whereHas('lesson_options', function ($query) use ($lessonOptionsId) {
                $query->whereIn('id_lesson_option', $lessonOptionsId);
            });
        }

        $user->allowUser()->where('user_type',2); 

        return $user->paginate(!empty($request['per_page']) ? $request['per_page'] : 6, 
                                      ['*'], 
                                      'page', 
                                      !empty($request['page']) ? $request['page'] : 1);
    }

    public function direction()
    {
        return $this->belongsToMany('App\Models\CourseCategory', 'teacher_subjects', 'id_teacher', 'id_direction')
                    ->orderBy('page_up', 'asc')->orderBy('id', 'desc')->groupBy('id');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Models\CourseCategory', 'teacher_subjects', 'id_teacher', 'id_subject')
                    ->orderBy('page_up', 'asc')->orderBy('id', 'desc')->withPivot('id_direction');
    }

    public function teacherRequests()
    {
        return $this->belongsToMany('App\Models\User', 'teacher_request', 'id_teacher', 'id_user');
    }

    public function teacherSpecializations()
    {
        return $this->belongsToMany('App\Models\TeacherSpecializationsList', 'teacher_specializations', 'id_teacher', 'id_specialization');
    }

    public function educations()
    {
        return $this->hasMany('App\Models\UsersEducations', 'id_user', 'id')->orderBy('id', 'asc');
    }

    public function lesson_options()
    {
        return $this->belongsToMany('App\Models\LessonOptionsList', 'teacher_lesson_options', 'id_teacher', 'id_lesson_option');
    }

    public function certificates()
    {
        return $this->hasMany('App\Models\UsersCertificates', 'id_user', 'id')->orderBy('id', 'asc');
    }

    public static function getTeachersMinMaxPrice()
    {
        $min = self::allowUser()
                    ->where('price_hour', '>', '0')
                    ->where('user_type',2)
                    ->min('price_hour');

        $max = self::allowUser()
                   ->where('price_hour', '>', '0')
                   ->where('user_type',2)
                   ->max('price_hour');

        return compact('min', 'max');
    }
}
