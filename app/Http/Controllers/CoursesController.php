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
use App\Models\CourseRequest;
use App\Utils\Users\Requests\CourseRequest as CourseRequestClass;
use App\Utils\Users\Requests\RequestInterface;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
 
class CoursesController extends Controller
{ 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    private function courseRequestInstance($id)
    {
        return new CourseRequestClass($id, @Auth::user()->id);
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
                            $query->whereHas('user', function($query){
                                return User::allowUser($query);
                            });
                        }])->has('coursesSubcat', '>=', '1')->where('parent_id', $id)->get();  
        }
        else
        {
            $categories = CourseCategory::whereHas('courses', function($query) use($authCheck){
                                    $query->whereHas('user', function($query){
                                        return User::allowUser($query);
                                    })->where('isHide', 0);
                                    if ($authCheck != true) 
                                    { 
                                        $query->where('available', '!=', '2');
                                    }
                              })->has('courses', '>=', '1')->get();
        } 

        $courses = Courses::getCatalog($cat, $subcat, $request->all());
        //exit(print_arr($courses->toArray()));
        $data = [
            'courses'      => $courses,
            'totalCourses' => Courses::countTotal(),
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
        $course = Courses::getOneCourse($id, Auth::check());
        $data = [
            'course'         => $course,
            'hasRequest'     => ($this->courseRequestInstance($id)->canMakeRequest() === true) ? false : true, 
            'scripts'        => [
                'js/courses.js'
            ]
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

    public function makeRequest($id)
    { 
        $courseRequest        = $this->courseRequestInstance($id);  
        $canMakeRequestStatus = $courseRequest->canMakeRequest();
        if ($canMakeRequestStatus === true) 
        {
            $courseRequest->makeRequest(); 
            //$courseRequest->sendNotification();
        }
        else
        {  
            return redirect('course/' . $id)->with('courseMsg.error', $canMakeRequestStatus);
        } 
        return redirect('course/' . $id)->with('courseMsg.success', 'Вы успешно записаны на этот курс'); 
    }
}