<?php

namespace App\Http\Controllers\Users\University;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\CourseCategory;
use App\Models\Courses;  
use App\Utils\Users\Course;

class CourseController extends UniversityController
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

    public function showCourse()
    {   
        $user    = Auth::user();
        $courses = Courses::with('sections')->where('id_user', $user->id)->get();

        return view('users.university_profile', [ 
            'user'    => Auth::user(), 
            'courses' => $courses,
            'include' => $this->viewPath . 'courses.list',
            'scripts' => [ 
                'js/courses.js'
            ]
        ]); 
    }

    public function showCourseForm()
    { 
        return view('users.university_profile', [ 
            'user'       => Auth::user(), 
            'include'    => 'users.profile_types.teacher.courses.add',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
            'scripts' => [
                'js/courses.js'
            ]
        ]); 
    } 

    public function editCourseForm($id_course)
    {
        $user    = Auth::user();
        $course = Courses::with('sections')->where('id_user', $user->id)->findOrFail($id_course);  
        return view('users.university_profile', [ 
            'user'       => Auth::user(), 
            'include'    => 'users.profile_types.teacher.courses.edit',
            'categories' => map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()),
            'course'     => $course,
            'scripts' => [
                'js/courses.js'
            ]
        ]); 
    } 

    public function saveCourse(Request $request)
    {
        $validate = $this->_course->validation($request->all());
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 

        $idCourse = $this->_course->save($request->all(), Auth::user()->id); 

        if (!empty($this->_course->sections)) 
        {
            $this->_course->saveSections($idCourse);
        }

        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('user_profile'))], 'Курс успешно добавлен!');
    } 

    public function editCourse($idCourse, Request $request)
    {
        if (!$this->_course->hasAccessCourse($idCourse, Auth::user()->id)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $validate = $this->_course->validation($request->all());
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 

        $this->_course->deleteSectionsAndLectures($idCourse, Auth::user()->id); 
        $this->_course->edit($request->all(), $idCourse, Auth::user()->id); 
        if (!empty($this->_course->sections)) 
        {
            $this->_course->saveSections($idCourse);
        }
        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('user_profile'))], 'Курс успешно изменен!');
    }
  
    public function deleteCourse($id_course)
    {  
        if ($this->_course->hasAccessCourse($id_course, Auth::user()->id)) 
        {
            $this->_course->delete($id_course, Auth::user()->id); 
        }
        return redirect()->route(userRoute('user_profile'));
    }
}
