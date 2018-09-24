<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use App\Models\Regions;
use App\Models\UsersUniversity; 
use App\Models\University;  
use App\Models\UniversitySpecializationsList;
use App\Models\UniversitySpecializations;
use Illuminate\Support\Facades\DB;

use App\Utils\Users\University\User as UniversityUser;
use App\Http\Controllers\Admin\Users\SiteUser;

class UniversityUserController extends SiteUser
{

    private $method = 'admin/users/university'; 

    private $folder = 'users.university';

    private $redirectRoute = 'admin_user_university'; 
 
    public $_user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        parent::__construct();
        $this->_user = new UniversityUser;
    } 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    { 
        $data = [
            'data'   => User::with('university')->where('user_type', '3')->orderByRaw('created_at desc')->get(),   
            'table'  => (new User)->getTable(),
            'method' => $this->method
        ]; 

        return view('admin.'.$this->folder.'.list', $data);
    } 

    public function showAddForm()
    {
        return view('admin.'.$this->folder.'.add', [
            'method' => $this->method 
        ]);
    }

    public function updateUser($id, Request $request)
    {
        $data     = $request->all();
        $_methods = [
            'editProfile', 'editGeneral'
        ];

        try {
            DB::beginTransaction();
            $this->_user->setUserId($id);
            $error = [];
            foreach ($_methods as $key => $method) {
                $_edit = $this->_user->{$method}($data);
                if ($_edit !== true)
                {
                    if (!is_array($_edit))
                    {
                        $arr['nf'] = $_edit;
                        $_edit     = $arr;
                    }
                    $error = array_merge($error, $_edit);
                }
            }

            if (!empty($error))
            {
                throw new \Exception(serialize($error));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return \App\Utils\JsonResponse::error(['messages' => unserialize($e->getMessage())]);
        }
        if (!empty($data['certificates']))
        {
            $this->_user->saveCertificates($data['certificates']);
        }

        $this->allowUser($id);

        return \App\Utils\JsonResponse::success(['reload' => true], 'Данные успешно обновлены!');
    }  

    public function showeditForm($id)
    { 
        $user = User::where('id', $id)->first(); 

        $data = [
            'method'             => $this->method, 
            'user'               => $user, 
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
        $data['userUniversity'] = $user['university'];
        
        return view('admin.'.$this->folder.'.edit', $data);
    }
}
