<?php

namespace App\Http\Controllers\Users\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\CourseCategory;
use App\Models\Courses;  
use App\Utils\Users\Course;
use App\Utils\Classes\CourseFacade;

class CourseController extends TeacherController
{

    protected $_course;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->middleware('data_filled'); 
        $this->_course = new Course;
    } 

    public function showCourse(CourseFacade $courseFacade)
    {   
        $user    = Auth::user();
        $courses = Courses::with('sections')->where('id_user', $user->id)->get();
 
        return view('users.teacher_profile', [ 
            'user'                 => $user, 
            'courseFacadeInstance' => $courseFacade, 
            'courses'              => $courses,
            'include'              => $this->viewPath . 'courses.list',
            'scripts' => [ 
                'js/courses.js'
            ]
        ]); 
    }

    public function showCourseForm()
    {  
        return view('users.teacher_profile', [ 
            'user'       => Auth::user(), 
            'include'    => $this->viewPath . 'courses.add',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
            'scripts' => [
                'js/courses.js'
            ]
        ]); 
    } 

    public function editCourseForm($id_course)
    {
        $formSection = request()->segment(count(request()->segments()));

        switch ($formSection) {
            case 'general':
                $view = 'general';
                break;
            
            case 'settings':
                $view = 'settings';
                break;

            case 'program':
                $view = 'program';
                break;

            case 'participants':
                $view = 'participants';
                break;

            case 'сertificates':
                $view = 'certificates';
                break;
            default:
                $view = 'general';
                break;
        }

        $user    = Auth::user();
        $course = Courses::with('sections')->where('id_user', $user->id)->findOrFail($id_course); 
 
        return view('users.profile_types.teacher.courses.edit.' . $view, [ 
            'user'       => Auth::user(),  
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
            'course'     => $course,
            'scripts' => [
                'js/courses.js'
            ]
        ]); 
    }
 
    public function saveCourse(Request $request)
    {
        $this->_course->setUserId(Auth::user()->id);
        $validate = $this->_course->validation($request->all(), 'general');
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 

        $idCourse = $this->_course->save($request->all()); 

        if (!empty($this->_course->sections)) 
        {
            $this->_course->saveSections($idCourse);
        }

        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('edit_course_settings'), ['id' => $idCourse])], 'Курс успешно добавлен!');
    }

    public function saveCertificates($id, Request $request)
    { 
        $this->_course->setUserId(Auth::user()->id)->setcourseId($id);
        if (!$this->_course->hasAccessCourse()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }
        $certificates = $request->input('certificates');
        if (!empty($certificates)) 
        {
            $this->_course->saveCertificates($certificates);
        }
        else
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Сертификаты не выбраны']);  
        }

        return \App\Utils\JsonResponse::success(['reload' => true], 'Сертификаты успешно сохранены!');
    } 

    public function editCourseGeneral($idCourse, Request $request)
    { 
        $this->_course->setUserId(Auth::user()->id)->setcourseId($idCourse);
        if (!$this->_course->hasAccessCourse()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $validate = $this->_course->validation($request->all(), 'general');
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 

        $this->_course->editGeneral($request->all());  
        $this->_course->updateCourseHide($request->all());

        return \App\Utils\JsonResponse::success(['reload' => true], 'Курс успешно изменен!');
    } 

    public function editCourseSettings($idCourse, Request $request)
    { 
        $this->_course->setUserId(Auth::user()->id)->setcourseId($idCourse);
        if (!$this->_course->hasAccessCourse()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $validate = $this->_course->validation($request->all(), 'settings');
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 

        $this->_course->editSettings($request->all());  
        return \App\Utils\JsonResponse::success(['reload' => true], 'Курс успешно изменен!');
    } 

    public function editCourseProgram($idCourse, Request $request)
    {  
        $this->_course->setUserId(Auth::user()->id)->setcourseId($idCourse);
        if (!$this->_course->hasAccessCourse()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $validate = $this->_course->validation($request->all(), 'program');
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 
 
        if (!empty($this->_course->sections)) 
        {
            $this->_course->deleteSectionsAndLectures();  
            $this->_course->saveSections(); 
            Courses::where('id', $this->_course->courseId)
                    ->where('id_user', $this->_course->userId)
                    ->update(['program_filled' => 1]); 
        }  

        return \App\Utils\JsonResponse::success(['reload' => true], 'Курс успешно изменен!');
    }    

    public function deleteCourse($id_course)
    {  
        $this->_course->setUserId(Auth::user()->id)->setcourseId($id_course);
        if ($this->_course->hasAccessCourse()) 
        {
            $this->_course->delete($id_course, Auth::user()->id); 
        }
        return redirect()->route(userRoute('user_profile'));
    }
}
