<?php

namespace App\Http\Controllers\Users\UserTypes;

use App\Models\User;  
use App\Models\TeacherSubjects;
use App\Models\TeacherSpecializations;
use App\Models\TeacherLessonOptions;
use App\Models\TeacherCertificates;
use App\Models\SubjectsList;
 
use App\Models\ProgramsType;
use App\Models\GradeEducation;
use App\Models\Regions;
  
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
            'regions'         => Regions::where('country_id', 3159)->orderBy('name', 'asc')->get(),
            'grade_education' => map_tree(GradeEducation::orderBy('page_up','asc')->get()->toArray()),
            'programs_type'   => map_tree(ProgramsType::orderBy('page_up','asc')->get()->toArray()), 
            'user'            => $user, 

            'specializations_list'    => DB::table('specializations_list')->where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'lesson_options_list'     => DB::table('lesson_options_list')->where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'subjects_list'           => SubjectsList::where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(), 
            'teacher_specializations' => TeacherSpecializations::where('id_teacher', $user->id)->get(),  
            'teacher_lesson_options'  => TeacherLessonOptions::where('id_teacher', $user->id)->get(),
             
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