<?php

namespace App\Http\Controllers\Admin\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\Users\FastRegistration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UsersCertificates;

class SiteUser extends Controller
{

	protected $_fastRegister;
	
	function __construct()
	{
		$this->_fastRegister = new FastRegistration;
	}

	public function fastRegister(Request $request)
    {
        $input = $request->all();

        $this->_fastRegister->setUserType($input['user_type']);
        $this->_fastRegister->setRequestData($input); 
        if ($this->_fastRegister->validationData($input) !== true) 
        {
            return $this->_fastRegister->getError();
        } 

        $user    = $this->_fastRegister->register();
        $getUser = User::whereId( $user['id'])->with('userType')->first();
        $getUser->create_from_admin = 1;
        $getUser->save();

        return \App\Utils\JsonResponse::success([
            'redirect' => '/admin/users/'. $getUser->userType->admin_url .'/'. $getUser->id .'/edit'
        ], 'Пользователь успешно добавлен! Заполните обязательные поля.');
    }

    public function updatePassword($id)
    { 
        $validator = Validator::make(request()->all(), [ 
            'password'              => 'required|string|min:6|confirmed|',
            'password_confirmation' => 'required',
        ]);
        $validator->setAttributeNames($this->_user->niceNames);
  
        if ($validator->fails()) 
        {
            $errors = $validator->errors()->toArray(); 
        }  
  
        if (!empty($errors)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $errors]);
        }

        $obj_user           = User::find($id);
        $obj_user->password = Hash::make(request()->input('password'));
        $obj_user->save(); 

        return \App\Utils\JsonResponse::success(['reload' => true], 'Пароль успешно изменен!');  
    }

    public function allowUser($id)
    {
        $getUser = User::whereId($id)->first();
        if (@$getUser->create_from_admin == 1)
        {
            $getUser->activate = 1;
            if (!$getUser->confirm)
            {
                $getUser->confirm = 1;
                $getUser->confirm_date = date('Y-m-d H:i:s');
            }
            $getUser->save();
        }
    }

    public function deleteCertificate(Request $request)
    {
        $id      = $request->input('id');
        $id_user = $request->input('id_user');
        UsersCertificates::whereId($id)->where('id_user', $id_user)->delete();
    }
}