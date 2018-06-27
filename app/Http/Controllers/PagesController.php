<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UsersUniversity;
use App\Models\Courses;
use App\Models\CourseCategory; 
use Illuminate\Http\Request;
use App\Utils\Classes\CourseFacade;

class PagesController extends Controller
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
    public function index(CourseFacade $courseFacade)
    { 
        $data = [
            'university' => UsersUniversity::getUniversities(),
            'teachers'   => User::allowUser()->where('user_type', 2)->orderBy('created_at', 'desc')->get(),
            'stats'      => [
                'institutions' => User::allowUser()->where('user_type', 3)->count(),
                'teachers'     => User::allowUser()->where('user_type', 2)->count(),
                'courses'      => Courses::published()->count() 
            ], 
            'courseFacadeInstance' => $courseFacade, 
            'courseCategories' => CourseCategory::with(['courses' => function($query){ 
                                    $query->published()->withCount('userRequests');
                                }])->where('parent_id','0')->has('courses', '>=', '1')->get(),
            'scripts' => [ 
                'js/courses.js'
            ]
        ];  

        return view('home', $data);
    }
 

    public function autocomplete(Request $request)
    {
        $query      = urldecode($request->input('search'));   
        $searchData = $this->generateSearch($query);
        if (empty($searchData)) die();
        
        $content    = '';    
        if (@count($searchData['courses'])) 
        {
            $content .= '<div> <label>Курсы</label>';
            foreach ($searchData['courses'] as $course) 
            {
                $content .= '<a href="/course/'.$course['id'].'/"> 
                                <i class="fa fa-angle-right" aria-hidden="true"></i>' . $course['name'] .  '
                            </a>';
            }
            $content .= '</div>';
        } 
        
        if (@count($searchData['teachers'])) 
        {
            $content .= '<div> <label>Учителя</label>';
            foreach ($searchData['teachers'] as $teacher) 
            {
                $content .= '<a href="/teacher/'.$teacher['id'].'/"> 
                                <i class="fa fa-angle-right" aria-hidden="true"></i>' . $teacher['name'] .  '
                            </a>';
            }
            $content .= '</div>';
        } 
           
        if (@count($searchData['university'])) 
        {
            $content .= '<div> <label>Учебные заведения</label>';
            foreach ($searchData['university'] as $university)
            {
                $content .= '<a href="/university/'.$university['id'].'/">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>  ' . $university['full_name'] .  '
                            </a>';
            }
            $content .= '</div>';
        }

        return \App\Utils\JsonResponse::success(['content' => $content]);
    }

    public function search(Request $request)
    {
        $query      = urldecode($request->input('q'));  
        $searchData = $this->generateSearch($query);
        return view('pages.search', ['data' => $searchData]);
    }

    private function generateSearch($searchStr, $data = [])
    {

        if (empty($searchStr)) 
        {
            return array();
        }

        $getCourses = \App\Models\Courses::published()
                                         ->where('name', 'like', "%$searchStr%")
                                         ->orWhereHas('category', function($query) use ($searchStr){ 
                                            $query->where('name', 'like', "%$searchStr%");
                                         })->orWhereHas('subCategory', function($query) use ($searchStr){ 
                                            $query->where('name', 'like', "%$searchStr%");
                                         })->OrderByCourses()
                                           ->get(); 

        if (count($getCourses)) 
        {
            $data['courses'] = $getCourses;
        }

        $getTeachers = User::allowUser()
                           ->where('user_type', 2)
                           ->where('name', 'like', "%$searchStr%")
                           ->orWhereHas('direction', function($query) use ($searchStr){
                                $query->where('name', 'like', $searchStr.'%'); 
                            })
                           ->orWhereHas('subjects', function($query) use ($searchStr){
                                $query->where('name', 'like', "%$searchStr%"); 
                            })
                           ->orderBy('created_at', 'desc')
                           ->get(); 

        if (count($getTeachers)) 
        {
            $data['teachers'] = $getTeachers;
        }

        $getUniversity = UsersUniversity::where('full_name', 'like', "%$searchStr%")
                                        ->whereHas('user', function($query){
                                            return User::allowUser();
                                        })
                                        ->orderBy('created_at', 'desc')
                                        ->get();  
        if (count($getUniversity)) 
        {
            $data['university'] = $getUniversity;
        }

        return $data;
    }

    public function termsOfUse()
    {
        return view('pages.terms');
    } 

    public function underConstruction()
    {
        return view('pages.under_construction');
    } 

    public function contacts()
    {
        return view('pages.contacts');
    }     

    public function about()
    {
        return view('pages.about');
    }     
}