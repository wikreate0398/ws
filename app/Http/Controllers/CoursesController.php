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
use App\Models\CourseFavorite; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Utils\Course\Course;
 
class CoursesController extends Controller
{ 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {} 

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
        $authCheck = Auth::check();

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
                            $query->published();
                        }])->has('coursesSubcat', '>=', '1')->where('parent_id', $id)->get();  
        }
        else
        {
            $categories = CourseCategory::with(['courses' => function($query){ 
                                    $query->published();
                              }])->has('courses', '>=', '1')->get(); 
        } 

        $courses = Courses::getCatalog($cat, $subcat, $request->all()); 
        $data = [
            'courses'           => $courses, 
            'totalCourses' => Courses::countTotal(),
            'subcatFlag'   => $subcatFlag,
            'categories'   => $categories,
            'baseUrl'      => $baseUrl,
            'scripts' => [
                'js/filter_courses.js',
                'js/courses.js'
            ]
        ];    

        return view('courses.catalog', $data);
    } 

    public function show($id)
    {     
        $course = Courses::getOneCourse($id, Auth::check()); 

        $data = [
            'course'         => $course, 
            'scripts'        => [
                'js/courses.js'
            ]
        ]; 
 
        return view('courses.show', $data);
    } 

    public function autocomplete(Request $request)
    { 
        $searchStr  = urldecode($request->input('search'));  
        $searchData = Courses::published()
                             ->where('name', 'like', "%$searchStr%")
                             ->orWhereHas('category', function($query) use ($searchStr){ 
                                $query->where('name', 'like', "%$searchStr%");
                             })->orWhereHas('subCategory', function($query) use ($searchStr){ 
                                $query->where('name', 'like', "%$searchStr%");
                             })->orderByCourses()
                               ->get(); 
 
        if (empty($searchData)) die();
         
        $content    = ''; 
        if (@count($searchData)) 
        {
            foreach ($searchData as $course) 
            {
                $content .= '<a href="/course/'.$course['id'].'/"> 
                                <i class="fa fa-angle-right" aria-hidden="true"></i>' . $course['name'] .  '
                            </a>';
            }
            $content .= '</div>';
        } 

        return \App\Utils\JsonResponse::success(['content' => $content]);
    }

    public function makeRequest($id, Course $courseFacade)
    { 
        $course         = Courses::whereId($id)->published()->first(); 
        $requestManager = $courseFacade->request($course);
        if ($requestManager->canMakeRequest() === true) 
        {
            $requestManager->makeRequest(); 
            $requestManager->sendNotification();  
        }
        else
        {  
            return redirect('course/' . $id)->with('courseMsg.error', $requestManager->getError());
        } 
        return redirect('course/' . $id)->with('courseMsg.success', 'Вы успешно записаны на этот курс'); 
    }

    public function favorite(Request $request)
    {
        $id_course = $request->input('id');
        $check     = CourseFavorite::where('id_user', Auth::user()->id)
                                  ->where('id_course', $id_course)->count();

        if ($check != false) {
            CourseFavorite::where([['id_user', Auth::user()->id], ['id_course', $id_course]])->delete();
            $status = 0;
        }else{
            CourseFavorite::insert(['id_user' => Auth::user()->id, 'id_course' => $id_course]);
            $status = 1;
        }

        return \App\Utils\JsonResponse::success(['status' => $status]);
    }
}