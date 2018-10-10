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
use App\Models\CourseReviews;
 
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

         
        $authCheck = Auth::check();

        $categories = [];
        $subcatFlag = false;
        if (!empty($cat)) 
        {  
            $currentCat = CourseCategory::where('url', $cat)->first();
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

            $categories =  CourseCategory::where('parent_id', $id)->with(['coursesSubcat' => function($query){ 
                            $query->published();
                        }])->get(); 
        }
        else
        {
            $categories = CourseCategory::with(['courses' => function($query){ 
                                    $query->published();
                              }])->get();
        } 

        $courses = Courses::getCatalog($cat, $subcat, $request->all());
//exit(print_arr($courses->toArray()));
        $data = [
            'courses'           => $courses, 
            'totalCourses' => Courses::countTotal(),
            'subcatFlag'   => $subcatFlag,
            'categories'   => $categories,
            'baseUrl'      => $baseUrl,
            'scripts' => [
                'js/filter_courses.js',
                'js/courses.js'
            ],
            'filterUrl' => request()->fullUrl() . (request()->query() ? '&' : '?')
        ];    

        return view('courses.catalog', $data);
    } 

    public function show($id, $request_id_user = false)
    {     
        if (empty($request_id_user)) 
        {
            $course = Courses::getOneCourse($id, Auth::check()); 
        }
        else
        { 
            $course = Courses::whereHas('userRequests', function($query) use ($request_id_user){
                           return $query->where('id_user', $request_id_user);
                        })->whereHas('user', function($query){
                            return $query->allowUser();
                        })->findOrFail($id);
        }
          
        $data = [
            'course'         => $course,  
            'scripts'        => [
                'js/courses.js'
            ]
        ];

        (new \App\Utils\CounterViews)->counter($id, 'course');
        return view('courses.show', $data);
    }

    private static function counter($id)
    {
        $count = CountViews::where('type', 'course')->where('id_item', $id)->first();
        if ($count)
        {
            $count->count++;
            $count->save();
        }
        else
        {
            CountViews::create([
                'type'    => 'course',
                'id_item' => $id,
                'count'   => 1
            ]);
        }
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

    public function review($id, Request $request, Course $courseFacade)
    {
        $course = Courses::getOneCourse($id, Auth::check()); 

        if (!$courseFacade->manager($course)->isFinished() 
         || !$courseFacade->request($course)->ifHasRequest() 
         || $courseFacade->manager($course)->ifHasUserReview(@Auth::user()->id)) 
        {
            return;
        } 

        if (!$request->input('message')) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Заполните поле с комментарием']); 
        }

        CourseReviews::create([
            'id_course' => $id,
            'id_user'   => Auth::user()->id,
            'review'    => $request->input('message'),
            'rating'    => floatval($request->input('rating'))
        ]);

        return \App\Utils\JsonResponse::success(['reload' => true], 'Отзыв успешно добавлен и ожидает проверки модератора'); 
    }
}