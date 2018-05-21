<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;

use \App\Models\User;
use \App\Models\UsersUniversity;


class InstitutionController extends Controller
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
    public function index()
    { 
        $data = [
            'university' => UsersUniversity::getUniversities()
        ]; 

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
}