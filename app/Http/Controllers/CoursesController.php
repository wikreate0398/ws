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
    public function index($cat = false, $subcat = false, Request $request)
    {  
        $baseUrl = '/courses';
        if (!empty($cat)) {
            $baseUrl .= "/cat/$cat";
        }

        $currentCat = CourseCategory::where('url', $cat)->first();

        $categories = [];
        $subcatFlag = false;
        if (!empty($cat)) 
        {  
            if ($currentCat->parent_id!='0') 
            {
                $id     = $currentCat->parent_id;
                $subcat = $currentCat->url;
                $subcatFlag = true;
            }
            else
            {
                $id = $currentCat->id;
                $subcatFlag = true;
            } 
            $categories =  CourseCategory::with(['coursesSubcat' => function($query){ 
                            $query->whereHas('user', function($query){
                                return User::allowUser($query);
                            });
                        }])->has('coursesSubcat', '>=', '1')->where('parent_id', $id)->get();  
        }
        else
        {
            $categories = CourseCategory::with(['courses' => function($query){
                                    $query->whereHas('user', function($query){
                                        return User::allowUser($query);
                                    });
                              }])->has('courses', '>=', '1')->get();
        } 
         
        $data = [
            'courses'      => Courses::getCatalog($cat, $subcat, $request->all()),
            'totalCourses' => Courses::whereHas('user', function($query){
                                        return User::allowUser($query);
                                    })->count(),
            'subcatFlag'   => $subcatFlag,
            'categories'   => $categories,
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
          'course' => Courses::with('sections')->where('id', $id)->whereHas('user', function($query){
                          return User::allowUser($query);
                      })->findOrFail($id) 
        ];   

        return view('courses.show', $data);
    } 

    public function autocomplete(Request $request)
    { 
        $query      = urldecode($request->input('search'));  
        $searchData = Courses::whereHas('user', function($query){
            return User::allowUser($query);
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