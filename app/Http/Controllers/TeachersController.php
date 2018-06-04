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

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeachersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $data = [
            'teachers'               => User::getTeachers($request),
            'subjects'               => SubjectsList::whereHas('users', function($query){
                                            return User::allowUser($query);
                                        })->orderBy('page_up', 'asc')
                                          ->orderBy('id', 'desc')->get(),

            'specializations'        => TeacherSpecializationsList::whereHas('users', function($query){
                                            return User::allowUser($query);
                                        })->get(),

            'minMaxPrice'            => User::getTeachersMinMaxPrice(),
            'lesson_filter_options'  => LessonOptionsList::whereHas('users', function($query){
                                                            return User::allowUser($query);
                                                        })->orderBy('page_up', 'asc')
                                                          ->orderBy('id', 'desc')->get(), 

            'lesson_options'          => LessonOptionsList::orderBy('page_up', 'asc')
                                                          ->orderBy('id', 'desc')
                                                          ->get(),
            'scripts' => [
                'js/filter_teachers.js'
            ]
        ];  

        //exit(print_arr($data['lesson_filter_options']->toArray()));

        return view('teachers.catalog', $data);
    } 

    public function show($id)
    { 
        $data = [
            'teacher'                 => \App\Models\User::with(['cityData', 
                                                                 'teacherSpecializations', 
                                                                 'certificates', 
                                                                 'lesson_options', 
                                                                 'educations', 
                                                                 'subjects'])
                                                           ->where(function($query){
                                                                return User::allowUser($query);
                                                           }) 
                                                           ->findOrFail($id),  
            'lesson_options'          => LessonOptionsList::orderBy('page_up', 'asc')
                                                          ->orderBy('id', 'desc')
                                                          ->get(),

            'universities' => \App\Models\UsersUniversity::getUniversities(), 
            'boockmark'    => TeacherBoockmarks::where([['id_user', @Auth::user()->id], ['id_teacher', $id]])->first()
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
        $searchData = User::where('user_type', 2)->where(function($query){
                                return User::allowUser($query);
                            })
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
}