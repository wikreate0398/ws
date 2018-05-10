<?php

namespace App\Http\Controllers\Users\UserTypes;

use App\Models\User; 
use App\Models\Cities;
use App\Models\UsersUniversity;
use App\Models\UniversityFormAttitude; 
use App\Models\InstitutionTypes;
use App\Models\University; 
use App\Models\ProgramsType;
use App\Models\TeachActivityCategories;
use App\Models\CourseCategory;
use App\Models\Courses;

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
class UniversityUser extends Controller implements UserTypesInterface
{ 

    private $viewPath = 'users.profile_types.university.';

	use \App\Http\Controllers\Users\Traits\UniversityTrait;

	function __construct() {} 

    public function showCourse()
    {
        $user    = Auth::user();
        $courses = Courses::with('sections')->where('id_user', $user->id)->get();

        return view('users.teacher_profile', [ 
            'user'    => Auth::user(), 
            'courses' => $courses,
            'include' => $this->viewPath . 'courses',
        ]); 
    }

    public function showCourseForm()
    {
        return view('users.teacher_profile', [ 
            'user'       => Auth::user(), 
            'include'    => 'users.profile_types.teacher.add_course',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
        ]); 
    } 

    public function editCourseForm($id_course)
    {
        $user    = Auth::user();
        $courses = Courses::with('sections')->where('id_user', $user->id)->orderBy('created_at', 'desc')->findOrFail($id_course); 

        return view('users.teacher_profile', [ 
            'user'       => Auth::user(), 
            'include'    => 'users.profile_types.teacher.edit_course',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
            'course'     => $courses
        ]); 
    }

    public function showEditForm()
    {  
        $user = Auth::user();
        $id   = $user->id;

        $data = [
            'cities'             => Cities::orderBy('name', 'asc')->get(), 
            'programs_type'      => map_tree(ProgramsType::orderBy('page_up','asc')->get()->toArray()),
            'teach_activ_cat'    => map_tree(TeachActivityCategories::orderBy('page_up','asc')->get()->toArray()), 
            'user'               => User::with('university')->where('id', $id)->first(), 
            'inst_type'          => InstitutionTypes::orderBy('page_up','asc')->get(),
            'university'         => University::orderBy('page_up','asc')->get(),
            'univ_form_attitude' => UniversityFormAttitude::orderBy('page_up','asc')->get(),
            'include'            => $this->viewPath . 'edit',
        ];

        $data['userUniversity'] = $data['user']['university'];

         //exit(print_arr($data['user']));
        return view('users.university_profile', $data); 
    } 
}