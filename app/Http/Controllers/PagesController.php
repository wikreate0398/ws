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
    public function index()
    { 
        $data = [
            'university' => UsersUniversity::getUniversities(),
            'teachers'   => User::where('user_type', 2)->where(function($query){
                                    return User::allowUser($query);
                                })->orderBy('created_at', 'desc')->get(),
            'stats'      => [
                'institutions' => User::where('user_type', 3)->where(function($query){
                                    return User::allowUser($query);
                                })->count(),
                'teachers'     => User::where('user_type', 2)->where(function($query){
                                    return User::allowUser($query);
                                })->count(),
                'courses'      => Courses::published()->count() 
            ], 
            'courseCategories' => CourseCategory::with(['courses' => function($query){ 
                                    $query->published()->withCount('userRequests');
                                }])->has('courses', '>=', '1')->get()
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
                $content .= '<a href=""> 
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
                $content .= '<a href="/institution/'.$university['id'].'/">
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

    private function generateSearch($query, $data = [])
    {

        if (empty($query)) 
        {
            return array();
        }

        $getCourses = \App\Models\Courses::where('name', 'like', "%$query%")->get(); 
        if (count($getCourses)) 
        {
            $data['courses'] = $getCourses;
        }

        $getTeachers = User::where('user_type', 2)->where(function($query){
                                    return User::allowUser($query);
                                })->where('name', 'like', "%$query%")
                                ->orderBy('created_at', 'desc')
                                ->get(); 
        if (count($getTeachers)) 
        {
            $data['teachers'] = $getTeachers;
        }

        $getUniversity = UsersUniversity::where('full_name', 'like', "%$query%")
                                        ->whereHas('user', function($query){
                                            return User::allowUser($query);
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