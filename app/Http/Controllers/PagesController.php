<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;

use App\Models\User;
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
            'university' => \App\Models\UsersUniversity::with('user')->orderBy('full_name', 'asc')->get(),
            'teachers'   => User::where('user_type', 2)->orderBy('created_at', 'desc')->get(),
            'stats'      => [
                'institutions' => User::where('user_type', 3)->count(),
                'teachers'     => User::where('user_type', 2)->count(),
                'courses'      => \App\Models\Courses::count(),
            ]
        ]; 

        return view('home', $data);
    }

    public function university($id)
    {
        $university = \App\Models\UsersUniversity::with([
            'user', 
            'institutionType', 
            'parentInstitution', 
            'formAttitude',
            'programType',
            'teachActivity'
        ])->where('id', $id)->get()->first();
        
        if (empty($university)) abort('404');

        $user = \App\Models\User::with('cityData')->where('id', $university['id_user'])->first();

        $data = [
            'data' => $university, 
            'user' => $user
        ];  

        return view('university.show', $data);
    }

    public function autocomplete(Request $request)
    {
        $query      = $request->input('search'); 
        $getCourses = \App\Models\Courses::where('name', 'like', "%$query%")->get(); 
        $content    = '';    
        if (count($getCourses)) 
        {
            $content .= '<div> <label>Курсы</label>';
            foreach ($getCourses as $course) 
            {
                $content .= '<a href=""> 
                                <i class="fa fa-angle-right" aria-hidden="true"></i>' . $course['name'] .  '
                            </a>';
            }
            $content .= '</div>';
        }

        $getTeachers = User::where('user_type', 2)->where('name', 'like', "%$query%")->orderBy('created_at', 'desc')->get(); 
        
        if (count($getTeachers)) 
        {
            $content .= '<div> <label>Учителя</label>';
            foreach ($getTeachers as $teacher) 
            {
                $content .= '<a href=""> 
                                <i class="fa fa-angle-right" aria-hidden="true"></i>' . $teacher['name'] .  '
                            </a>';
            }
            $content .= '</div>';
        }

        $getUniversity = \App\Models\UsersUniversity::where('full_name', 'like', "%$query%")
                                                     ->orderBy('created_at', 'desc')
                                                     ->get(); 
           
        if (count($getUniversity)) 
        {
            $content .= '<div> <label>Учебные заведения</label>';
            foreach ($getUniversity as $university)
            {
                $content .= '<a href="/institution/'.$university['id'].'/">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>  ' . $university['full_name'] .  '
                            </a>';
            }
            $content .= '</div>';
        }

        return \App\Utils\JsonResponse::success(['content' => $content]);
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