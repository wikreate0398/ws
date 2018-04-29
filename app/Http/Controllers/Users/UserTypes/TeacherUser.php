<?php

namespace App\Http\Controllers\Users\UserTypes;

use App\Models\User; 
use App\Models\UsersEducations;
use App\Models\UsersTeachingActivities;
use App\Models\UsersWorkExperience;
use App\Models\ProgramsType;
use App\Models\GradeEducation;
use App\Models\Cities;
use App\Models\TeachActivityCategories;
use App\Models\WorkExperienceDirection;
use App\Models\CourseCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use App\Http\Controllers\Users\UserTypes\UserTypesInterface; 

/**
* Регистрация обычного пользователя
*/
class TeacherUser extends Controller implements UserTypesInterface
{
    private $viewPath = 'users.profile_types.teacher.';

    use \App\Http\Controllers\Users\Traits\TeacherTrait;

	function __construct() {} 

    public function showEditForm()
    {
        $user = Auth::user();
        return view('users.teacher_profile', [
            'cities'          => Cities::orderBy('name', 'asc')->get(),
            'grade_education' => map_tree(GradeEducation::orderBy('page_up','asc')->get()->toArray()),
            'programs_type'   => map_tree(ProgramsType::orderBy('page_up','asc')->get()->toArray()),
            'teach_activ_cat' => map_tree(TeachActivityCategories::orderBy('page_up','asc')->get()->toArray()),
            'work_experience_direction' => WorkExperienceDirection::orderBy('page_up','asc')->get(),
            'user'            => $user,
            'usersEducations' => UsersEducations::where('id_user', $user->id)->orderBy('from_year', 'desc')->get(),
            'usersTeachingActivities' => UsersTeachingActivities::where('id_user', $user->id)->orderBy('from_year', 'desc')->get(),
            'usersWorkExperience'     => UsersWorkExperience::where('id_user', $user->id)->orderBy('from_year', 'desc')->get(),
            'include'                 => $this->viewPath . 'edit',
        ]); 
    }   

    public function showCourse()
    { 
        return view('users.teacher_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'courses',
        ]); 
    }

    public function showSubscriptions()
    {
        return view('users.teacher_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'subscriptions',
        ]); 
    }

    public function showReviews()
    {
        return view('users.teacher_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'reviews',
        ]); 
    } 

    public function showDiploms()
    {
        return view('users.teacher_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'diplomas',
        ]); 
    }  

    public function showCourseForm()
    {
        return view('users.teacher_profile', [ 
            'user'       => Auth::user(), 
            'include'    => $this->viewPath . 'add_course',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
        ]); 
    } 
}