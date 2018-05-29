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

    private function redirectIfDataNoFilled()
    {
        if (Auth::user()->user_type == 2 && Auth::user()->data_filled == 0) 
        {
            if (request()->ajax()) {
                return response()->json(['error' => 'page not available'], 404);
            }  
            return redirect()->route('user_edit');
        }

        return true;
    }

    public function showEditForm()
    {
        $user = Auth::user(); 
        return view($this->viewPath . 'edit', [ 
            'regions'                 => Regions::where('country_id', 3159)->orderBy('name', 'asc')->get(),
            'grade_education'         => map_tree(GradeEducation::orderBy('page_up','asc')->get()->toArray()),
            'programs_type'           => map_tree(ProgramsType::orderBy('page_up','asc')->get()->toArray()), 
            'user'                    => $user, 
            'degree_experience'       => DB::table('degree_experience')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),

            'specializations_list'    => DB::table('specializations_list')->where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'lesson_options_list'     => DB::table('lesson_options_list')->where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'subjects_list'           => SubjectsList::where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(), 
            'teacher_specializations' => TeacherSpecializations::where('id_teacher', $user->id)->get(),  
            'teacher_lesson_options'  => TeacherLessonOptions::where('id_teacher', $user->id)->get(),
             
            //'include'                 => $this->viewPath . 'edit',

            // 'scripts'                 => [
            //     'js/tinymce/tinymce.min.js'
            // ]
        ]); 
    }   

    public function showCourse()
    { 
        $checkIfDataNoFilled = $this->redirectIfDataNoFilled();
        if ($checkIfDataNoFilled !== true) 
        {
            return $checkIfDataNoFilled;
        } 

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

        $checkIfDataNoFilled = $this->redirectIfDataNoFilled();
        if ($checkIfDataNoFilled !== true) 
        {
            return $checkIfDataNoFilled;
        }

        return view($this->viewPath . 'subscriptions', [ 
            'user'               => Auth::user(),  
        ]); 
    }

    public function showReviews()
    {

        $checkIfDataNoFilled = $this->redirectIfDataNoFilled();
        if ($checkIfDataNoFilled !== true) 
        {
            return $checkIfDataNoFilled;
        }

        return view('users.teacher_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'reviews',
        ]); 
    } 

    public function showDiploms()
    {

        $checkIfDataNoFilled = $this->redirectIfDataNoFilled();
        if ($checkIfDataNoFilled !== true) 
        {
            return $checkIfDataNoFilled;
        }

        return view('users.teacher_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'diplomas',
        ]); 
    }  

    public function showCourseForm()
    {

        $checkIfDataNoFilled = $this->redirectIfDataNoFilled();
        if ($checkIfDataNoFilled !== true) 
        {
            return $checkIfDataNoFilled;
        }

        return view('users.teacher_profile', [ 
            'user'       => Auth::user(), 
            'include'    => $this->viewPath . 'add_course',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
        ]); 
    } 

    public function editCourseForm($id_course)
    {
        $checkIfDataNoFilled = $this->redirectIfDataNoFilled();
        if ($checkIfDataNoFilled !== true) 
        {
            return $checkIfDataNoFilled;
        }

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