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

    private function validateInputs(array $data)
    { 
        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        return $validator;
    }

    public function createUser(Request $request)
    {
        $data     = $request->all();  
        $validate = $this->validation($data, $this->addRules);
        if ($validate !== true) 
        {  
            return \App\Utils\JsonResponse::error(['messages' => $validate]); 
        } 

        $create = $this->_user->create($data);
 
        User::where('id', $create)->
            update([ 
                'activate'     => '1',
                'confirm'      => '1', 
                'confirm_date' => date('Y-m-d H:i:s'),
        ]);

        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    public function updateUser($id, Request $request)
    {
        $edit = $this->_user->edit($request->all(), $id);   
        if ($edit !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $edit]);  
        } 
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
        ];
        $data['userUniversity'] = $user['university'];
        
        return view('admin.'.$this->folder.'.edit', $data);
    }  
}
