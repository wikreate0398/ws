<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;

use App\Models\User;

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