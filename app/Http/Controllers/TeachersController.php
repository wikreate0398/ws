<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;

use App\Models\SubjectsList; 
use App\Models\TeacherSpecializations;
use App\Models\TeacherLessonOptions;
use App\Models\TeacherCertificates;
use App\Models\TeacherSpecializationsList;
use App\Models\LessonOptionsList;
use App\Models\UsersEducations;
use App\Models\TeacherBoockmarks;
use App\Models\TeacherRequest;
use App\Models\UsersUniversity;
use App\Models\User;
use App\Models\CourseCategory;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

use App\Utils\Requests\TeacherRequest as TeacherRequestClass;
use App\Utils\Requests\RequestInterface;

class TeachersController extends Controller
{
    protected $_teacher_request;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
      $this->_teacher_request = TeacherRequestClass::getInstance();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 

        $userTeacherBoockmarks = [];
        if (Auth::check()) 
        {
          $userTeacherBoockmarks = @Auth::user()->userTeacherBoockmarks->pluck('id')->toArray();
        }

        $data = [
            'teachers'               => User::getTeachers($request),
            'teachersRequests'       => $this->_teacher_request,
            'subjects'               => CourseCategory::whereHas('usersSubjects', function($query){
                                            return User::allowUser();
                                        })->orderBy('page_up', 'asc')
                                          ->orderBy('id', 'desc')->get(),

            'specializations'        => TeacherSpecializationsList::whereHas('users', function($query){
                                            return $query->allowUser();
                                        })->get(),

            'userTeacherBoockmarks'  => $userTeacherBoockmarks,

            'minMaxPrice'            => User::getTeachersMinMaxPrice(),
            'lesson_filter_options'  => LessonOptionsList::whereHas('users', function($query){
                                                            return $query->allowUser();
                                                        })->orderBy('page_up', 'asc')
                                                          ->orderBy('id', 'desc')->get(), 

            'lesson_options'          => LessonOptionsList::orderBy('page_up', 'asc')
                                                          ->orderBy('id', 'desc')
                                                          ->get(),
            'scripts' => [
                'js/filter_teachers.js',
                'js/teachers.js'
            ]
        ];    



        return view('teachers.catalog', $data);
    } 
 
    public function show($id)
    { 
        $teacher = User::with(['cityData', 
                               'teacherSpecializations',  
                               'certificates', 
                               'lesson_options', 
                               'educations', 
                               'subjects'])
                         ->allowUser()
                         ->where('user_type',2)
                         ->findOrFail($id); 

        $bookmark = [];
        if (Auth::check()) 
        {
          $bookmark = @in_array($id, @Auth::user()->userTeacherBoockmarks->pluck('id')->toArray())  ? true : false;
        }
 
        $data = [
            'teacher'        => $teacher,  
            'hasRequest'     => ($this->_teacher_request->setIdTeacher($id)
                                                        ->setIdUser(@Auth::user()->id)
                                                        ->setUserType(@Auth::user()->user_type)
                                                        ->canMakeRequest() === true) ? false : true, 
            'lesson_options' => LessonOptionsList::orderBy('page_up', 'asc')
                                                          ->orderBy('id', 'desc')
                                                          ->get(),
            'universities' => UsersUniversity::getUniversities(), 
            'bookmark'     => $bookmark,
            'scripts' => [
              'js/teachers.js'
            ]
        ];     

        return view('teachers.show', $data);
    } 

    public function setBoockmark(Request $request)
    {
        $id_teacher = $request->input('id');
        $check = TeacherBoockmarks::where('id_user', Auth::user()->id)
                                  ->where('id_teacher', $id_teacher)->count();

        if ($check != false) {
            TeacherBoockmarks::where([['id_user', Auth::user()->id], ['id_teacher', $id_teacher]])->delete();
            $status = 0;
        }else{
            TeacherBoockmarks::insert(['id_user' => Auth::user()->id, 'id_teacher' => $id_teacher]);
            $status = 1;
        }

        return \App\Utils\JsonResponse::success(['status' => $status]);
    }

    public function autocomplete(Request $request)
    {
      $query      = urldecode($request->input('search'));  
      $searchData = User::where('user_type', 2)
                        ->allowUser()
                        ->where('name', 'like', "%$query%")
                        ->orderBy('created_at', 'desc')->get();

      if (empty($searchData)) die();
      
      $content    = '';
      if (@count($searchData)) 
      {
          foreach ($searchData as $teacher) 
          {
              $content .= '<a href="/teacher/'.$teacher['id'].'/"> 
                              <i class="fa fa-angle-right" aria-hidden="true"></i>' . $teacher['name'] .  '
                          </a>';
          }
          $content .= '</div>';
      } 

      return \App\Utils\JsonResponse::success(['content' => $content]);
    }

    public function makeRequest($id)
    {  
      $canMakeRequestStatus = $this->_teacher_request->setIdTeacher($id)
                                                     ->setIdUser(@Auth::user()->id)
                                                     ->setUserType(@Auth::user()->user_type)
                                                     ->canMakeRequest();
      if ($canMakeRequestStatus === true) 
      {
        $this->_teacher_request->makeRequest(); 
        $this->_teacher_request->sendNotification();
      }
      else
      {  
        return redirect('teacher/' . $id)->with('teacherMsg.error', $canMakeRequestStatus);
      }

      return redirect('teacher/' . $id)->with('teacherMsg.success', 'Вы успешно оставили свою заявку этому учителю'); 
    } 
}