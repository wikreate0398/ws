<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'surname', 
        'patronymic', 
        'user_type', 
        'phone', 
        'date_birth', 
        'city', 
        'phone2', 
        'fax', 
        'site', 
        'image', 
        'confirm_hash',
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

    public function university()
    {
        return $this->hasOne('App\Models\UsersUniversity', 'id_user', 'id');
    }

    public static function getTeachers($request = false)
    {

        $user = (new User)->newQuery(); 

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

        if (isset($request['subject'])) 
        {
            $subject = $request['subject'];
            $user->whereHas('subjects', function ($query) use ($subject) {
                $query->where('name', urldecode($subject));
            });
        }

        if (isset($request['specializations'])) 
        {
            $specializationsId = explode(',', $request['specializations']);
            $user->whereHas('specializations', function ($query) use ($specializationsId) {
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

        $user->where('user_type', '2')
             ->where('activate', '1')
             ->where('confirm', '1')
             ->orderBy('created_at', 'desc');

        return $user->paginate(!empty($request['per_page']) ? $request['per_page'] : 6, 
                                      ['*'], 
                                      'page', 
                                      !empty($request['page']) ? $request['page'] : 1);
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Models\SubjectsList', 'teacher_subjects', 'id_teacher', 'id_subject')->orderBy('page_up', 'asc')->orderBy('id', 'desc');
    }

    public function specializations()
    {
        return $this->belongsToMany('App\Models\SpecializationsList', 'teacher_specializations', 'id_teacher', 'id_specialization');
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
        return $this->hasMany('App\Models\TeacherCertificates', 'id_teacher', 'id')->orderBy('id', 'asc');
    }

    public static function getTeachersMinMaxPrice()
    {
        $min = self::where('user_type', '2')
                   ->where('activate', '1')
                   ->where('confirm', '1')
                   ->where('price_hour', '>', '0')
                   ->min('price_hour');

        $max = self::where('user_type', '2')
                   ->where('activate', '1')
                   ->where('confirm', '1')
                   ->where('price_hour', '>', '0')
                   ->max('price_hour');

        return compact('min', 'max');
    }
}
