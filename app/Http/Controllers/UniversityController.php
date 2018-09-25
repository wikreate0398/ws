<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

use \App\Models\User;
use \App\Models\UsersUniversity;
use \App\Models\UniversitySpecializationsList;
use \App\Models\UniversityBookmarks;

class UniversityController extends Controller
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

        $userUniversityBoockmarks = [];
        if (Auth::check()) 
        {
            $userUniversityBoockmarks = Auth::user()->userUniversityBoockmarks->pluck('id')->toArray();
        }

        $data = [
            'universities'       => UsersUniversity::getUniversities($request),
            'filter' => [
                'specializationList' => UniversitySpecializationsList::whereHas('users', function($query){ 
                                            return $query->whereHas('user', function($query){
                                                return User::allowUser();
                                            });
                                        })->orderBy('page_up', 'asc')
                                          ->orderBy('id', 'desc')->get(),
                'minMaxPrice'        => UsersUniversity::getFilterMinMaxPrice(),
            ],
            'userUniversityBoockmarks'  => $userUniversityBoockmarks,
            'scripts' => [
                'js/filter_university.js',
                'js/university.js'
            ]
        ];
 
        return view('university.catalog', $data);
    }

    public function view($id)
    {
        $university = UsersUniversity::with([
            'user', 
            'user.courses' => function($query){
                                return $query->published();
                            }, 
            'news' => function($query){
                return $query->where('view','1');
            }
        ])->whereHas('user', function($query){
            return User::allowUser();
        })->where('id', $id)->get()->first();
        
        if (empty($university)) abort('404'); 

        $bookmark = [];
        if (Auth::check()) 
        {
            $bookmark = @in_array($university->user->id, @Auth::user()->userUniversityBoockmarks->pluck('id')->toArray())  ? true : false;
        } 

        $data = [
            'university' => $university, 
            'bookmark'   => $bookmark,
            'scripts' => [
                'full:https://api-maps.yandex.ru/2.1/?lang=ru_RU',
                'js/university.js',
                'js/courses.js'
            ]
        ];

        (new \App\Utils\CounterViews)->counter($university->user->id, 'university');

        return view('university.show', $data);
    }

    public function autocomplete(Request $request)
    {
        $query      = urldecode($request->input('search'));  
        $searchData = UsersUniversity::whereHas('user', function($query){
                                            return User::allowUser();
                                        })
                                        ->where('full_name', 'like', "%$query%")
                                        ->orderBy('id_user', 'asc')->get();

        if (empty($searchData)) die();
        
        $content    = '';
        if (@count($searchData)) 
        {
            foreach ($searchData as $university) 
            {
                $content .= '<a href="/university/'.$university['id'].'/"> 
                                <i class="fa fa-angle-right" aria-hidden="true"></i>' . $university['full_name'] .  '
                            </a>';
            }
            $content .= '</div>';
        } 

        return \App\Utils\JsonResponse::success(['content' => $content]);
    }

    public function setBoockmark(Request $request)
    {
        $id_university = $request->input('id');
        $check = UniversityBookmarks::where('id_user', Auth::user()->id)
                                     ->where('id_university', $id_university)->count();

        if ($check != false) {
            UniversityBookmarks::where([['id_user', Auth::user()->id], ['id_university', $id_university]])->delete();
            $status = 0;
        }else{
            UniversityBookmarks::insert(['id_user' => Auth::user()->id, 'id_university' => $id_university]);
            $status = 1;
        }

        return \App\Utils\JsonResponse::success(['status' => $status]);
    }
}