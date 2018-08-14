<?php

namespace App\Http\Controllers\Users\University;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\CourseCategory;
use App\Models\Courses;   
use App\Utils\Course\Course;

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

    public function showCourse(Request $request)
    {   
        $user    = Auth::user();
        $userId  = $user->id;
        $courses = Courses::with('sections')
                          ->filterProfile()
                          ->where('id_user', $user->id);
  
        return view('users.university_profile', [ 
            'user'       => Auth::user(), 
            'courses'    => $courses->get(),
            'categories' => CourseCategory::whereHas('courses', function($query) use($userId){
                                return $query->where('id_user', $userId);
                            })->get(),
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

    public function loadFilterCategories(Request $request)
    { 
        $teacherId   = $request->input('id');
        $selectedCat = $request->input('category');
        $get = CourseCategory::whereHas('courses.teachers', function($query) use($teacherId){
                                return $query->where('id_teacher', $teacherId);
                            })->get();
        
        if (empty($get)) {
            die();
        }

        $options = '<option value="0">Категория</option>';
        foreach ($get as $category) 
        {
            $selected = (@$selectedCat == $category['id']) ? 'selected' : '';
            $options .= '<option '.$selected.' value="'.$category['id'].'">'.$category['name'].'</option> ';
        }
        echo $options;
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
                abort(404);
                break;
        } 

        $user    = Auth::user();
        $course = Courses::with('sections')->where('id_user', $user->id)->findOrFail($id_course); 

        if (!$this->_course->manager($course)->canManage() && !in_array($formSection, ['сertificates', 'participants'])) 
        { 
            return redirect()->route(userRoute('course_participants'), ['id' => $id_course]);
        }
 
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
        $crudFactory = $this->_course->crud(null, Auth::user());  
        $validate = $crudFactory->validation($request->all(), 'general');
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        }  
        $idCourse = $crudFactory->save($request->all());  
        if (!empty($crudFactory->sections)) 
        {
            $crudFactory->saveSections($idCourse);
        } 

        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('edit_course_settings'), ['id' => $idCourse])], '');
    }

    public function saveCertificates($id, Request $request)
    { 
        $course      = Courses::whereId($id)->first();
        $crudFactory = $this->_course->crud($id, Auth::user()); 
        if (!$crudFactory->hasAccessCourse()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $certificates = $request->input('certificates');
        if (!empty($certificates)) 
        {
            $crudFactory->saveCertificates($certificates);
        }
        else
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Вы не добавили новые сертификаты']);
        } 
 
        $message  = 'Сертификаты успешно сохранены!';
        if (!$course->сertificates_filled) 
        { 
            $message  = 'Ваш курс успешно добавлен и размещен в каталоге';
        } 

        return \App\Utils\JsonResponse::success(self::redirectAfterSave('certificates', $request->all(), $course), $message);
    } 

    public function editCourseGeneral($idCourse, Request $request)
    {  
        $crudFactory = $this->_course->crud($idCourse, Auth::user());
        if (!$crudFactory->hasAccessCourse()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $validate = $crudFactory->validation($request->all(), 'general');
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 

        $crudFactory->editGeneral($request->all());  
        $crudFactory->updateCourseHide($request->all());
        
        return \App\Utils\JsonResponse::success(self::redirectAfterSave('general', $request->all()), 'Данные успешно сохранены!');
    }  

    public function editCourseSettings($idCourse, Request $request)
    {  
        $course      = Courses::whereId($idCourse)->first();
        $crudFactory = $this->_course->crud($idCourse, Auth::user());  
        if (!$crudFactory->hasAccessCourse()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $validate = $crudFactory->validation($request->all(), 'settings');
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 

        $crudFactory->editSettings($request->all());  
 
        return \App\Utils\JsonResponse::success(self::redirectAfterSave('settings', $request->all(), $course), 'Данные успешно сохранены!');
    } 

    public function editCourseProgram($idCourse, Request $request)
    {  
        $course      = Courses::whereId($idCourse)->first();
        $crudFactory = $this->_course->crud($idCourse, Auth::user());
        if (!$crudFactory->hasAccessCourse()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $validate = $crudFactory->validation($request->all(), 'program');
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 
        
        $crudFactory->deleteSectionsAndLectures(); 
        if (!empty($crudFactory->sections)) 
        { 
            $crudFactory->saveSections(); 
            Courses::where('id', $crudFactory->id_course)
                    ->where('id_user', $crudFactory->user->id)
                    ->update(['program_filled' => 1]); 
        } 
 
        return \App\Utils\JsonResponse::success(self::redirectAfterSave('program', $request->all(), $course), 'Данные успешно сохранены!');
    } 
  
    public function deleteCourse($id_course)
    {  
        $crudFactory = $this->_course->crud($id_course, Auth::user());
        if ($crudFactory->hasAccessCourse($id_course, Auth::user()->id) &&
            $this->_course->manager(Courses::whereId($id_course)->first())->canManage() == true) 
        {
            $crudFactory->delete($id_course, Auth::user()->id); 
        }
        return redirect()->route(userRoute('user_profile'));
    }

    private static function redirectAfterSave($action, $request, $course = null)
    { 
        $redirect = ['reload' => true];
        switch ($action) {
            case 'general':  
                break;

            case 'settings': 
                if (!$course->settings_filled) 
                { 
                    $redirect = ['redirect' => route(userRoute('edit_course_program'), ['id' => $course->id])];
                }   
                break;

            case 'program': 
                if (!$course->program_filled) 
                {
                    $redirect = ['redirect' => route(userRoute('edit_course_сertificates'), ['id' => $course->id])];
                }  
                break;

            case 'certificates':   
                if (!$course->сertificates_filled) 
                {
                    $redirect = ['redirect' => route(userRoute('user_profile'))];
                }   
                break;
            
            default:
                # code...
                break;
        }

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
}
