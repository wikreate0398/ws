<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;


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
            'university' => \App\Models\UsersUniversity::with('user')->orderBy('full_name', 'asc')->get()
        ]; 

        return view('university.catalog', $data);
    }

    public function view($id)
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

     
}