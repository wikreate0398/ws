<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;
  
use App\Models\User;
use App\Models\Courses;
use App\Models\CourseCategory;

use Illuminate\Http\Request;

class CoursesController extends Controller
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
    public function index($cat = false, Request $request)
    { 

        $baseUrl = '/courses';
        if (!empty($cat)) {
            $baseUrl .= "/$cat";
        }

        $data = [
            'courses'      => Courses::getCatalog($cat, $request->all()),
            'totalCourses' => Courses::count(),
            'categories'   => CourseCategory::has('courses', '>=', '1')->get(),
            'baseUrl'      => $baseUrl,
            'scripts' => [
                'js/filter_courses.js'
            ]
        ];    

        return view('courses.catalog', $data);
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
        $searchData = Courses::whereHas('user', function($query){
            $query->where('user_type', '2')
                  ->where('activate', '1')
                  ->where('confirm', '1');
        })->where('name', 'like', "%$query%")->orderBy('created_at', 'desc')->get();

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