<?php

namespace App\Http\Controllers\Admin\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\Users\FastRegistration;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

        $user = $this->_fastRegister->register();
        User::where('id', $user['id'])->
            update([ 
                'activate'     => '1',
                'confirm'      => '1', 
                'confirm_date' => date('Y-m-d H:i:s'),
        ]);

        return \App\Utils\JsonResponse::success(['message' => 'Пользователь успешно добавлен!']);
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
}