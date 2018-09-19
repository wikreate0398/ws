<?php

namespace App\Http\Controllers\Users\University;

use App\Models\User;  
use App\Models\UsersUniversity; 
use App\Models\University;  
use App\Models\UniversitySpecializationsList;
use App\Models\UniversitySpecializations; 
use App\Models\Regions; 
use App\Models\UniversityFaculties;  
use App\Models\UniversityNews;    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use App\Http\Controllers\Users\ProfileController;
use App\Http\Controllers\Users\University\Faculties; 
use App\Utils\Users\University\User as UniversityUser;

class UniversityController extends ProfileController
{
    public $viewPath = 'users.profile_types.university.'; 

    protected $_user;

	function __construct()
    { 
        $this->_user = new UniversityUser;
    }

    public function showEditForm()
    {  

        $formSection = request()->segment(count(request()->segments()));

        switch ($formSection) {
            case 'profile':
                $view = 'profile';
                break;

            case 'general':
                $view = 'general';
                break;

            case 'certificates':
                $view = 'certificates';
                break;
            
            default:
                abort(404);
                break;
        }

        $user = Auth::user(); 

        $data = [
            'regions'         => Regions::where('country_id', 3159)->orderBy('name', 'asc')->get(),  
            'specializations' => UniversitySpecializationsList::where('view', '1')->orderBy('page_up','asc')->orderBy('id','desc')->get(), 
            'user'            => User::with('university')->where('id', $user->id)->first(),  
            'university'      => University::orderBy('page_up','asc')->get(),
            'university_specializations' => UniversitySpecializations::where('id_university', $user->university->id)->get(),
            'scripts' => [
                'full:https://api-maps.yandex.ru/2.1/?lang=ru_RU',
                'js/map.js'
            ]
        ];

        $data['userUniversity'] = $data['user']['university'];

        return view($this->viewPath . 'edit.' . $view, $data); 
    } 

    public function editProfile(Request $request)
    {  
        $edit = $this->_user->setUserId(Auth::user()->id)->editProfile($request->all());   
        if ($edit !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $edit]);  
        }
 
        return \App\Utils\JsonResponse::success(self::redirectAfterSave('profile', $request, Auth::user()), 'Данные успешно сохранены!'); 
    }  

    public function editGeneral(Request $request)
    { 
        $edit = $this->_user->setUserId(Auth::user()->id)->editGeneral($request->all());   
        if ($edit !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $edit]);  
        }  
 
        return \App\Utils\JsonResponse::success(self::redirectAfterSave('general', $request, Auth::user()), 'Данные успешно сохранены!'); 
    }  

    public function editCertifications(Request $request)
    { 
        $user = Auth::user();
        $data = $request->all();
        if (!empty($data['certificates'])) 
        {
            $this->_user->setUserId(Auth::user()->id)->saveCertificates($data['certificates']);
        }   
 
        $msg      = 'Данные успешно сохранены!';
        if (!$user->univ_certificates_filled) 
        { 
            $msg      = 'Ваш профиль успешно активирован';
        }

        return \App\Utils\JsonResponse::success(self::redirectAfterSave('certificates', $request, $user), $msg); 
    } 

    private static function redirectAfterSave($action, $request, $user = null)
    { 
        $redirect = ['reload' => true];
        switch ($action) {
            case 'general':  
                if (!$user->univ_certificates_filled) 
                {
                    $redirect = ['redirect' => route(userRoute('user_certificates_edit'))];
                }
                break;

            case 'profile': 
                if (!$user->univ_general_filled) 
                {
                    $redirect = ['redirect' => route(userRoute('user_general_edit'))];
                } 
                break; 

            case 'certificates':   
                if (!$user->univ_certificates_filled) 
                {
                    $redirect = ['redirect' => route(userRoute('user_profile'))]; 
                } 
                break;
            
            default:
                # code...
                break;
        } 

        if (!empty($request['redirectUri'])) 
        {
            $parseUri = parse_url($request['redirectUri']); 
            if ($parseUri['host'] == request()->server('HTTP_HOST')) 
            {
                $redirect = ['redirect' => $request['redirectUri']];
            }
        }

        return $redirect;
    }
}