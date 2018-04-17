<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 6:18 PM
 */

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\GradeEducation;
use Illuminate\Http\Request;

class RegisterUserController extends Controller
{
    public function showView()
    {
        $cities          =  Cities::orderBy('name', 'asc')->get();
        $grade_education = map_tree(GradeEducation::orderBy('page_up','asc')->get()->toArray());
        return view('users.auth.register', compact('cities', 'grade_education'));
    }

    public function register(Request $request)
    {
        //$this->validator($request->all())->validate();

        //event(new Registered($user = $this->create($request->all())));

//        $this->guard()->login($user);
//
//        return $this->registered($request, $user)
//            ?: redirect($this->redirectPath());
    }

    private function redirectPath(){
        return '';
    }

    protected function registered(Request $request, $user)
    {
        //
    }
}