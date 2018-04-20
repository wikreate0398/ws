<?php

namespace App\Http\Controllers\Auth;
 
use App\Models\User; 
use App\Mail\UserMail; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Cities;
use App\Models\GradeEducation;
use App\Models\ProgramsType;
use App\Models\TeachActivityCategories;
use App\Models\WorkExperienceDirection;
use App\Models\InstitutionTypes;
use App\Models\University; 
use App\Models\UniversityFormAttitude;  
use App\Http\Controllers\Users\UserService;

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

    public $userType = 1;

    private $education = [];

    private $work_experience = [];

    private $teach_activity = []; 

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
        $cities          =  Cities::orderBy('name', 'asc')->get();
        $grade_education = map_tree(GradeEducation::orderBy('page_up','asc')->get()->toArray());
        $programs_type   = map_tree(ProgramsType::orderBy('page_up','asc')->get()->toArray());
        $teach_activ_cat = map_tree(TeachActivityCategories::orderBy('page_up','asc')->get()->toArray());
        $work_experience_direction = WorkExperienceDirection::orderBy('page_up','asc')->get();
        $inst_type       = InstitutionTypes::orderBy('page_up','asc')->get();
        $university      = University::orderBy('page_up','asc')->get();
        $univ_form_attitude = UniversityFormAttitude::orderBy('page_up','asc')->get();
   
        return view('auth.register', compact('cities', 
                                             'grade_education', 
                                             'programs_type', 
                                             'teach_activ_cat', 
                                             'work_experience_direction', 
                                             'inst_type', 
                                             'university', 
                                             'univ_form_attitude')
                    ); 
    }

    public function register(Request $request)
    { 
        $this->userType = $request->input('user_type');  

        $errors = UserService::init($this->userType)->validation($request->all());

        if ($errors !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $errors]);
        } 

        $createUser = UserService::init($this->userType)->create($request->all()); 
        if ($createUser) 
        { 
            $user = User::whereId($createUser)->first(); 
            $this->sendConfirmationEmail($user['email'], $user['confirm_hash']); 
            return \App\Utils\JsonResponse::success(['redirect' => route('finish_registration')]); 
        }  
    }
  
    public function sendConfirmationEmail($email, $hash)
    {   
        if (request()->server('SERVER_NAME') != 'ws.loc') { 
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

    public function test_mail(){
        Mail::to('fleancu.daniel@gmail.com')->send(new UserMail('asdsd'));
    }
}