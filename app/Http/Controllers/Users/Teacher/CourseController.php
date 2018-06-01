<?php

namespace App\Http\Controllers\Users\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\CourseCategory;
use App\Models\Courses;  
use App\Utils\Users\University\Course;

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

    public function deleteCourseSection(Request $request)
    { 
        $id_section = intval($request->input('id_section')); 

        if ($this->_course->hasAccessSection($id_section, Auth::user()->id)) 
        {
            $this->_course->deleteSection($id_section);
            return \App\Utils\JsonResponse::success();
        } 
    }

    public function deleteCourseSectionLecture(Request $request)
    { 
        $id_lecture = intval($request->input('id_lecture')); 

        if ($this->_course->hasAccessLecture($id_lecture, Auth::user()->id)) 
        {
            $this->_course->deleteLecture($id_lecture);
            return \App\Utils\JsonResponse::success(); 
        } 
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
