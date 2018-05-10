<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;


class TeachersController extends Controller
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
            'teachers' => \App\Models\User::where('user_type', 2)->orderBy('created_at', 'desc')->get(),
        ]; 

        return view('teachers.catalog', $data);
    } 

    public function show($id)
    { 
        $data = [
            'teacher' => \App\Models\User::findOrFail($id),
        ]; 

        return view('teachers.show', $data);
    } 
}