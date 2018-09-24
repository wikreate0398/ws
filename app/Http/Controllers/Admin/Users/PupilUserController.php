<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Regions;
use App\Utils\Users\Pupil\User as PupilUser;
use App\Http\Controllers\Admin\Users\SiteUser;
 
class PupilUserController extends SiteUser
{

    private $method = 'admin/users/pupil'; 

    private $folder = 'users.user';

    private $redirectRoute = 'admin_user_pupil';  

    public $_user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        parent::__construct();
        $this->_user = new PupilUser;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    { 
        $data = [
            'data'   => User::where('user_type', '1')->orderByRaw('created_at desc')->get(),
            'table'  => (new User)->getTable(),
            'method' => $this->method
        ]; 

        return view('admin.'.$this->folder.'.list', $data);
    } 

    public function showAddForm()
    {
        return view('admin.'.$this->folder.'.add', [
            'method' => $this->method, 
        ]);
    }

    private function validateInputs(array $data)
    { 
        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        return $validator;
    }

    public function updateUser($id, Request $request)
    {
        $edit = $this->_user->edit($request->all(), $id);
        if ($edit !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $edit]);  
        }
        $this->allowUser($id);
        return \App\Utils\JsonResponse::success(['reload' => true], 'Данные успешно обновлены!'); 
    }
 
    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', [
            'method'  => $this->method, 
            'user'    => User::findOrFail($id),
            'regions' => Regions::where('country_id', 3159)->orderBy('name', 'asc')->get(),
        ]);
    }  
}
