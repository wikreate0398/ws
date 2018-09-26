<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\CourseCategory;
use App\Models\CourseRequest;
use App\Models\Courses;  
use App\Utils\Course\Course;

use App\Mail\Course\ConfirmRequest; 
use App\Mail\Course\DeclineRequest; 
 
use Illuminate\Support\Facades\Mail;

class CourseController extends Controller
{

    protected $_course;

    private $view;

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

    private function _view()
    {
        return (Auth::user()->user_type == 2) ? 'teacher_profile' : 'university_profile';
    }

    private function _viewPath()
    {
        return (Auth::user()->user_type == 2) ? 'users.profile_types.teacher.' : 'users.profile_types.university.';
    }

    public function showCourse()
    {   
        $user    = Auth::user();
        $userId  = $user->id;
        $status  = request()->status;
        $courses = Courses::with('sections')->filterProfile()->where('id_user', $user->id)->get();
 
        return view('users.' . $this->_view(), [
            'user'          => $user,  
            'courses'       => $courses,
            'categories'    => CourseCategory::whereHas('courses', function($query) use($userId, $status){

                                if ($status == '0') 
                                {
                                    $query->finishedStatus();
                                } 

                                if ($status == '1') 
                                { 
                                    $query->activeStatus();
                                } 
                                return $query->where('id_user', $userId);
                            })->get(), 
            'include'       => $this->_viewPath() . 'courses.list',
            'scripts' => [ 
                'js/courses.js'
            ]
        ]); 
    }

    public function filterAutocomplete(Request $request)
    {   
        $courses = Courses::with('sections')
                          ->filterProfile()
                          ->where('id_user', Auth::user()->id)->get();
     
        if (!$courses->count()) 
        {
            die();
        } 
        $content = '';
        foreach ($courses as $course) 
        {
            $content .= '<a href="javascript:;" onclick="setAutocompleteValue(this)" data-value="'.$course['name'].'"> 
                            <i class="fa fa-angle-right" aria-hidden="true"></i>' . $course['name'] .  '
                        </a>';
        }
        $content .= '</div>';

        return \App\Utils\JsonResponse::success(['content' => $content]); 
    }

    public function showCourseForm()
    {  
        return view('users.' . $this->_view(), [
            'user'       => Auth::user(), 
            'include'    => $this->_viewPath() . 'courses.add',
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

            case 'certificates':
                $view = 'certificates';
                break;
            default:
                abort(404);
                break;
        }

        $user    = Auth::user();
        $course = Courses::with('sections')->where('id_user', $user->id)->findOrFail($id_course); 

        if (!$this->_course->manager($course)->canManage() && !in_array($formSection, ['certificates', 'participants'])) 
        { 
            if ($this->_course->manager($course)->ifAdded()) 
            {
                return redirect()->route(userRoute('course_participants'), ['id' => $id_course]);
            }
            else
            {
                return redirect()->route(userRoute('user_profile'));
            }             
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

    public function confirmParticipant($id_course, $id_user)
    {
        $data = CourseRequest::where('id_course', $id_course)
                             ->where('id_user', $id_user)
                             ->where('confirm', 0)
                             ->whereHas('user', function($query){
                                return $query->allowuser();
                             })
                             ->with(['user', 'course'])
                             ->firstOrFail();
 
        $data->confirm = 1;
        $data->confirm_date = date('Y-m-d H:i:s');
        $data->save(); 
        Mail::to($data->user->email)->send(new ConfirmRequest($data->course));  
        return redirect()->back()->with('flash_message', 'Курс успешно подтвержден!');
    }

    public function declineParticipant($id_course, $id_user)
    {
        $data = CourseRequest::where('id_course', $id_course)
                             ->where('id_user', $id_user)
                             ->where('confirm', 0)
                             ->whereHas('user', function($query){
                                return $query->allowuser();
                             })
                             ->with(['user', 'course'])
                             ->firstOrFail();
        $data->delete();
        Mail::to($data->user->email)->send(new DeclineRequest($data->course));  
        return redirect()->back()->with('flash_message', 'Запрос откланен!');
    }
}
