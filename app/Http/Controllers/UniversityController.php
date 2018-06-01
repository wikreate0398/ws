<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\User;
use \App\Models\UsersUniversity;
use \App\Models\UniversitySpecializationsList;

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

        $data = [
            'universities'       => UsersUniversity::getUniversities($request),
            'filter' => [
                'specializationList' => UniversitySpecializationsList::whereHas('users', function($query){ 
                                            return $query->whereHas('user', function($query){
                                                return User::allowUniversityUser($query);
                                            });
                                        })->orderBy('page_up', 'asc')
                                          ->orderBy('id', 'desc')->get(),
                'minMaxPrice'        => UsersUniversity::getFilterMinMaxPrice(),
            ],
            'scripts' => [
                'js/filter_university.js'
            ]
        ]; 

        //exit(print_arr($data['filter']['specializationList']));
 
        return view('university.catalog', $data);
    }

    public function view($id)
    {
        $university = UsersUniversity::with([
            'user', 
        ])->whereHas('user', function($query){
            return User::allowUniversityUser($query);
        })->where('id', $id)->get()->first();
        
        if (empty($university)) abort('404'); 

        $data = [
            'data' => $university 
        ];  

        return view('university.show', $data);
    }

    public function autocomplete(Request $request)
    {
        $query      = urldecode($request->input('search'));  
        $searchData = UsersUniversity::whereHas('user', function($query){
                                            return User::allowUniversityUser($query);
                                        })
                                        ->where('full_name', 'like', "%$query%")
                                        ->orderBy('id_user', 'asc')->get();

        if (empty($searchData)) die();
        
        $content    = '';
        if (@count($searchData)) 
        {
            foreach ($searchData as $university) 
            {
                $content .= '<a href="/universities/'.$university['id'].'/"> 
                                <i class="fa fa-angle-right" aria-hidden="true"></i>' . $university['full_name'] .  '
                            </a>';
            }
            $content .= '</div>';
        } 

        return \App\Utils\JsonResponse::success(['content' => $content]);
    }
}