<?php

namespace App\Http\Controllers\Users\Teacher;

use App\Models\User;  
use App\Models\TeacherSubjects;
use App\Models\TeacherSpecializations;
use App\Models\TeacherSpecializationsList;
 
use App\Models\TeacherLessonOptions;
use App\Models\TeacherCertificates;
use App\Models\SubjectsList; 
use App\Models\GradeEducation;
use App\Models\Regions;
  
use App\Models\CourseCategory;
use App\Models\Courses;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\UserMail;
use App\Http\Controllers\Users\ProfileController;
use App\Utils\Users\Teacher\User as TeacherUser;

class TeacherController extends ProfileController 
{
    public $viewPath = 'users.profile_types.teacher.'; 

    protected $_user;

	function __construct() 
    {
        $this->middleware('data_filled', ['only' => ['showSubscriptions', 'showReviews', 'showDiploms']]);
        $this->_user = new TeacherUser;
    }  

    public function showGeneralForm()
    {
        $user       = Auth::user(); 
        $categories = map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray());

        $data = [ 
            'user'                    => $user, 
            'regions'                 => Regions::where('country_id', 3159)->orderBy('name', 'asc')->get(),
            'grade_education'         => map_tree(GradeEducation::orderBy('page_up','asc')->get()->toArray()),   
            'scripts'                 => [
                // 'js/tinymce/tinymce.min.js',
                'js/teachers.js'
            ]
        ]; 
        return view($this->viewPath . 'edit.general', $data); 
    }  

    public function showTutorDataForm()
    {
        $user       = Auth::user(); 
        $categories = map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()); 
        $data = [    
            'user'                    => $user, 
            'degree_experience'       => DB::table('degree_experience')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),

            'specializations_list'    => TeacherSpecializationsList::where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'lesson_options_list'     => DB::table('lesson_options_list')->where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'subjects_list'           => SubjectsList::where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(), 
            'teacher_specializations' => TeacherSpecializations::where('id_teacher', $user->id)->get(),  
            'teacher_lesson_options'  => TeacherLessonOptions::where('id_teacher', $user->id)->get(),
            'categories'              => $categories, 
            'scripts'                 => [ 
                'js/teachers.js'
            ]
        ]; 
        return view($this->viewPath . 'edit.tutor', $data); 
    }    

    public function showCertificatesForm()
    {
        $user       = Auth::user(); 
        $categories = map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray());

        $data = [    
            'scripts'                 => [ 
                'js/teachers.js'
            ],
            'user'                    => $user, 
        ]; 
        return view($this->viewPath . 'edit.certificates', $data); 
    }  

    public function editGeneral(Request $request)
    { 
        $data = $request->all();
        $edit = $this->_user->setUserId(Auth::user()->id)->editGeneral($data);   
        if ($edit !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $edit]);  
        } 
        $this->_user->updateIfProfileFilled();
        return \App\Utils\JsonResponse::success(self::redirectAfterSave($data), 'Данные успешно обновлены!'); 
    }  

    public function editTutor(Request $request)
    { 
        $data = $request->all();
        $edit = $this->_user->setUserId(Auth::user()->id)->editTutor($data);   
        if ($edit !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $edit]);  
        } 
        $this->_user->updateIfProfileFilled();
        return \App\Utils\JsonResponse::success(self::redirectAfterSave($data), 'Данные успешно обновлены!'); 
    } 

    public function editCertifications(Request $request)
    { 
        $data = $request->all();
        if (!empty($data['certificates'])) 
        {
            $this->_user->setUserId(Auth::user()->id)->saveCertificates($data['certificates']);
        }  
        $this->_user->updateIfProfileFilled();
        return \App\Utils\JsonResponse::success(self::redirectAfterSave($data), 'Данные успешно обновлены!'); 
    }   

    private static function redirectAfterSave($request)
    { 
        $redirect = ['reload' => true]; 
        if (!empty($request['redirectUri'])) 
        {
            $parseUri = parse_url($request['redirectUri']); 
            if ($parseUri['host'] == request()->server('HTTP_HOST')) 
            {
                $redirect = ['redirect' => $request['redirectUri']];
            }
        }

        return $redirect;
    }

    public function showSubscriptions()
    {   
        return view($this->viewPath . 'subscriptions', [ 
            'user'               => Auth::user(),  
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
}