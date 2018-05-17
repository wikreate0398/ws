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
use App\Models\SpecializationsList;
use App\Models\LessonOptionsList;
use App\Models\UsersEducations;

use App\Models\User;
use Illuminate\Http\Request;

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
            'teachers'        => User::getTeachers($request),
            'subjects'        => SubjectsList::has('users')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'specializations' => TeacherSpecializations::has('specializations_list')->groupBy('id_specialization')->get(),
            'minMaxPrice'     => User::getTeachersMinMaxPrice(),
            'lesson_filter_options'  => TeacherLessonOptions::has('lesson_options_list')
                                                     ->groupBy('id_lesson_option')
                                                     ->get(),

            'lesson_options'          => LessonOptionsList::orderBy('page_up', 'asc')
                                                          ->orderBy('id', 'desc')
                                                          ->get(),
            'scripts' => [
                'js/filter_teachers.js'
            ]
        ];  

        //exit(print_arr($data['subjects']->toArray()));

        return view('teachers.catalog', $data);
    } 

    public function show($id)
    { 
        $data = [
            'teacher'                 => \App\Models\User::with(['cityData', 
                                                                 'specializations', 
                                                                 'certificates', 
                                                                 'lesson_options', 
                                                                 'educations', 
                                                                 'subjects'])
                                                           ->where('user_type', '2')
                                                           ->where('activate', '1')
                                                           ->where('confirm', '1')
                                                           ->findOrFail($id),  
            'lesson_options'          => LessonOptionsList::orderBy('page_up', 'asc')
                                                          ->orderBy('id', 'desc')
                                                          ->get() 
        ];   

        return view('teachers.show', $data);
    } 

    public function autocomplete(Request $request)
    {
        $query      = $request->input('search');  
        $searchData = User::where('user_type', 2)->where('name', 'like', "%$query%")->orderBy('created_at', 'desc')->get();
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