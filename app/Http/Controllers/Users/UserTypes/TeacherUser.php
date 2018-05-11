<?php

namespace App\Http\Controllers\Users\UserTypes;

use App\Models\User;  
use App\Models\TeacherSubjects;
use App\Models\TeacherSpecializations;
use App\Models\TeacherLessonOptions;
use App\Models\TeacherCertificates;

use App\Models\UsersEducations;
use App\Models\UsersTeachingActivities;
use App\Models\UsersWorkExperience;
use App\Models\ProgramsType;
use App\Models\GradeEducation;
use App\Models\Cities;
use App\Models\TeachActivityCategories;
use App\Models\WorkExperienceDirection;
use App\Models\CourseCategory;
use App\Models\Courses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use App\Http\Controllers\Users\UserTypes\UserTypesInterface; 

use Illuminate\Support\Facades\DB;
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

            'specializations_list'    => DB::table('specializations_list')->where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'lesson_options_list'     => DB::table('lesson_options_list')->where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'teacher_subjects'        => TeacherSubjects::where('id_teacher', $user->id)->orderBy('id', 'asc')->get(), 
            'teacher_specializations' => TeacherSpecializations::where('id_teacher', $user->id)->get(),  
            'teacher_lesson_options'  => TeacherLessonOptions::where('id_teacher', $user->id)->get(),
            'certificates'            => TeacherCertificates::where('id_teacher', $user->id)->orderBy('id', 'asc')->get(), 
            'include'                 => $this->viewPath . 'edit',
        ]); 
    }   

    public function showCourse()
    { 
        $user    = Auth::user();
        $courses = Courses::with('sections')->where('id_user', $user->id)->get();

        return view('users.teacher_profile', [ 
            'user'               => $user, 
            'courses'            => $courses,
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

    public function editCourseForm($id_course)
    {
        $user    = Auth::user();
        $courses = Courses::with('sections')->where('id_user', $user->id)->orderBy('created_at', 'desc')->findOrFail($id_course); 

        return view('users.teacher_profile', [ 
            'user'       => Auth::user(), 
            'include'    => $this->viewPath . 'edit_course',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
            'course'     => $courses
        ]); 
    }  
}