<?php

namespace App\Http\Controllers\Users\University;

use App\Models\User;  
use App\Models\UsersUniversity;
 
use App\Models\University; 
 
use App\Models\UniversitySpecializationsList;
use App\Models\UniversitySpecializations;
use App\Models\CourseCategory;
use App\Models\Courses;
use App\Models\Regions;
use App\Models\SubjectsList;
use App\Models\UniversityFaculties;   

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail; 

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Users\University\Faculties;

/**
* Регистрация обычного пользователя
*/
class UniversityController extends ProfileController
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
        $courses = Courses::with('sections')->where('id_user', $user->id)->findOrFail($id_course); 
        
        return view('users.university_profile', [ 
            'user'       => Auth::user(), 
            'include'    => 'users.profile_types.teacher.edit_course',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
            'course'     => $courses
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

        $faculties = UniversityFaculties::where('id_university', Auth::user()->university->id)
                                        ->orderBy('created_at', 'desc')
                                        ->get(); 
 
        return view('users.university_profile', [ 
            'user'      => Auth::user(),  
            'faculties' => $faculties,
            'include'   => $this->viewPath . '.faculties.list',
        ]); 
    }  

    public function showFacultyForm()
    { 
        $checkIfDataNoFilled = $this->redirectIfDataNoFilled();
        if ($checkIfDataNoFilled !== true) 
        {
            return $checkIfDataNoFilled;
        } 
        
        return view('users.university_profile', [ 
            'user'          => Auth::user(), 
            'include'       => $this->viewPath . '.faculties.add',
            'subjects_list' => SubjectsList::where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(), 
        ]); 
    }

    public function editFacultyForm($id_faculty)
    {
        $user    = Auth::user();
        $faculty = UniversityFaculties::where('id_university', Auth::user()->university->id)->findOrFail($id_faculty); 

        
        return view('users.university_profile', [ 
            'user'          => Auth::user(), 
            'include'       => $this->viewPath . '.faculties.edit',
            'subjects_list' => SubjectsList::where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(), 
            'faculty'       => $faculty
        ]); 
    }

    public function saveFaculty(Request $request, Faculties $faculty)
    {
        $validate = $faculty->validation($request->all());
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 

        $idFaculty = $faculty->save($request->all(), Auth::user()->university->id); 
  
        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('user_faculties'))], 'Факультет успешно добавлен!');
    }

    public function editFaculty($idFaculty, Request $request, Faculties $faculty)
    { 
        if (!$faculty->hasAccessFaculty($idFaculty, Auth::user()->university->id)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $validate = $faculty->validation($request->all());
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        }   
        $faculty->edit($request->all(), $idFaculty, Auth::user()->university->id);  
        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('user_faculties'))], 'Факультет успешно изменен!');
    }

    public function deleteFaculty($id_faculty, Faculties $faculty)
    {  
        if ($faculty->hasAccessFaculty($id_faculty, Auth::user()->university->id)) 
        {
            $faculty->delete($id_faculty); 
        }
        return redirect()->route(userRoute('user_faculties'));
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