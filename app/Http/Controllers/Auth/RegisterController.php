<?php

namespace App\Http\Controllers\Auth;
 
use App\Models\User; 
use App\Mail\UserMail; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home'; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    { 
        return view('auth.register'); 
    } 

    public function register(Request $request)
    {
        $input             = $request->all();
        $fastRegisterClass = new \App\Utils\Users\FastRegistration; 
        $fastRegisterClass->setUserType($input['user_type']);
        $fastRegisterClass->setRequestData($input); 
        if ($fastRegisterClass->validationData($input) !== true) 
        {
            return $fastRegisterClass->getError();
        } 

        $user = $fastRegisterClass->register();

        $this->sendConfirmationEmail($user['email'], $user['confirm_hash']); 
        return \App\Utils\JsonResponse::success(['redirect' => route('finish_registration')]);
    }
  
    public function sendConfirmationEmail($email, $hash)
    {   
        if (request()->server('SERVER_NAME') != 'ws.loc') 
        { 
            Mail::to($email)->send(new UserMail($hash)); 
        }
        request()->session()->put('reg', 'На вашу почту было отравленно письмо с ссылкой для подтверждения регистрации.');  
    }

    public function finish_registration(Request $request)
    {  
        if ($request->session()->has('reg')) 
        { 
            $messgae = request()->session()->get('reg') ;
            $request->session()->forget('reg'); 
            return view('auth.finish_registration', compact('messgae'));
        } 
        
        return redirect('/'); 
    }

    public function confirmation($confirmation_hash)
    {
        $user = User::where('confirm_hash', $confirmation_hash)->get()->first();  
  
        if (empty($user->activate)) {
            User::where('id', $user->id)
                  ->update(['activate' => 1, 'confirm_date' => date('Y-m-d H:i:s'), 'confirm' => 1]);
        }

        return view('auth.confirmation', compact('user')); 
    } 
}