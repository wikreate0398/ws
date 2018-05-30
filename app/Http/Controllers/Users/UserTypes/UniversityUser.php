<?php

namespace App\Http\Controllers\Users\UserTypes;

use App\Models\User;  
use App\Models\UsersUniversity;
 
use App\Models\University; 
 
use App\Models\UniversitySpecializationsList;
use App\Models\UniversitySpecializations;
use App\Models\CourseCategory;
use App\Models\Courses;
use App\Models\Regions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail; 

use App\Http\Controllers\ProfileController;

/**
* Регистрация обычного пользователя
*/
class UniversityUser extends ProfileController
{
    private $viewPath = 'users.profile_types.university.';

	use \App\Http\Controllers\Users\Traits\UniversityTrait;

	function __construct() {} 

    private function redirectIfDataNoFilled()
    {
        if (Auth::user()->user_type == 3 && Auth::user()->data_filled == 0) 
        {
            if (request()->ajax()) {
                return response()->json(['error' => 'page not available'], 404);
            }  
            return redirect()->route('user_edit');
        }

        return true;
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

        return view('users.university_profile', [ 
            'user'    => Auth::user(), 
            'courses' => $courses,
            'include' => $this->viewPath . 'courses',
        ]); 
    }

    public function showNews()
    {
        $checkIfDataNoFilled = $this->redirectIfDataNoFilled();
        if ($checkIfDataNoFilled !== true) 
        {
            return $checkIfDataNoFilled;
        } 

        exit('news');
    }

    public function showFaculties()
    { 
        $checkIfDataNoFilled = $this->redirectIfDataNoFilled();
        if ($checkIfDataNoFilled !== true) 
        {
            return $checkIfDataNoFilled;
        }  

        return view('users.university_profile', [ 
            'user'      => Auth::user(),  
            'faculties' => [],
            'include'   => $this->viewPath . 'faculties',
        ]); 
    } 

    showFacultyForm

    public function showCourseForm()
    {

        $checkIfDataNoFilled = $this->redirectIfDataNoFilled();
        if ($checkIfDataNoFilled !== true) 
        {
            return $checkIfDataNoFilled;
        } 
        
        return view('users.university_profile', [ 
            'user'       => Auth::user(), 
            'include'    => 'users.profile_types.teacher.add_course',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
        ]); 
    } 

    public function editCourseForm($id_course)
    {
        $user    = Auth::user();
        $courses = Courses::with('sections')->where('id_user', $user->id)->orderBy('created_at', 'desc')->findOrFail($id_course); 
        
        return view('users.university_profile', [ 
            'user'       => Auth::user(), 
            'include'    => 'users.profile_types.teacher.edit_course',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
            'course'     => $courses
        ]); 
    }

    public function showEditForm()
    {  
        $user = Auth::user(); 

        $data = [
            'regions'         => Regions::where('country_id', 3159)->orderBy('name', 'asc')->get(),  
            'specializations' => UniversitySpecializationsList::where('view', '1')->orderBy('page_up','asc')->orderBy('id','desc')->get(), 
            'user'            => User::with('university')->where('id', $user->id)->first(),  
            'university'      => University::orderBy('page_up','asc')->get(),
            'university_specializations' => UniversitySpecializations::where('id_university', $user->id)->get(),   
        ];

        $data['userUniversity'] = $data['user']['university'];

         //exit(print_arr($data['user']));
        return view($this->viewPath . 'edit', $data); 
    } 
}