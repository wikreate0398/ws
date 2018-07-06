<?php

namespace App\Utils\Users;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator; 
use App\Models\User; 

/**
* Fast User Registartion
*/
class FastRegistration  
{

	public $userType = null;

	public $requestData = [];

	private $error;

	function __construct() {}  

	public function setUserType($userType)
	{
		$this->userType = $userType;
	}

	public function setRequestData($data)
	{
		$this->requestData = $data;
	}

	public function getError()
	{
		return \App\Utils\JsonResponse::error(['messages' => $this->error]); 
	}

	public function validationData()
	{
		$rules = [
            'email'                 => 'required|string|email|unique:users',
            'name'                  => 'required', 
            'phone'                 => 'required', 
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required' 
        ];

        $validator = Validator::make($this->requestData, $rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames([
            'password'         => 'Пароль',
            'repeat_password'  => 'Повторите пароль',   
            'phone'            => 'Телефон',
            'name'             => 'Имя'
        ]); 
        if ($validator->fails()) 
        {
        	$this->error = $validator->errors()->toArray(); 
        	return false;
        }

        return true;
	}

	public function register()
	{
		$confirm_hash = md5(microtime()); 
        $id_user = User::create([ 
            'name'         => $this->requestData['name'], 
            'user_type'    => $this->userType,
            'phone'        => $this->requestData['phone'],
            'email'        => $this->requestData['email'],    
            'confirm_hash' => $confirm_hash, 
            'password'     => bcrypt($this->requestData['password']),
            'redirectUri'  => $this->requestData['redirectUri']
        ])->id; 

        if ($this->userType == 3) 
        {
            \App\Models\UsersUniversity::insert([
                'id_user'   => $id_user, 
                'full_name' => $this->requestData['name'], 
            ]); 

            User::where('id', $id_user)->
            update([ 
                'name' => '' 
            ]); 
        } 

        return User::whereId($id_user)->first();
	}
}