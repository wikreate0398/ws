<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/profile/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        $this->middleware('guest:web')->except('logout');
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) 
            {
                return \App\Utils\JsonResponse::error(['messages' => 'Заполните все поля!']); 
            }

            $remember = $request->has('remember') ? true : false;
   
            if (Auth::guard('web')->attempt(['email' => $request->input('email'), 
                               'password' => $request->input('password'), 
                               'activate' => 1,
                               'confirm'  => 1], $remember) == true) 
            { 
                 
                return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('user_profile'))], trans('auth.success_login'));
            }
            else 
            { 
                return self::errorLogin();
            }
        } catch (validationException $e) {
            return self::errorLogin();
        } 
    } 

    static private function errorLogin()
    {
        return \App\Utils\JsonResponse::error(['messages' => trans('auth.error_login')]);
    }
}
