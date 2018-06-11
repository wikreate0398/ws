<?php

namespace App\Utils\Users\Pupil;

use Illuminate\Support\Facades\Validator;
use App\Models\User as ModelUser; 

class User
{
	public $niceNames = [
		'password'         => 'Пароль',
        'repeat_password'  => 'Повторите пароль',
        'image'            => 'Фото',
        'old_password'     => 'Старый Пароль',
        'phone'            => 'Телефон',
        'name'             => 'Имя',
        'date_birth'       => 'День рождения',
        'region'           => 'Область',
        'city'             => 'Город', 
	];

	public $addRules = [
        'email'                 => 'required|string|email|unique:users',
        'name'                  => 'required', 
        'phone'                 => 'required', 
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required'
	];

    public $editRules = [
        'email'                 => 'required|string|email|unique:users',
        'name'                  => 'required', 
        'phone'                 => 'required', 
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required',
        'date_birth'            => 'required',
        'region'                => 'required',
        'city'                  => 'required'
    ];

	public function validation(array $data, $rules)
	{ 
        $validator = Validator::make($data, $rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames); 
        if ($validator->fails()) 
        {
            return $validator->errors()->toArray();
        }
		return true;
	}

	public function create(array $data)
	{
		$confirm_hash = md5(microtime()); 
        return ModelUser::create([ 
            'name'         => $data['name'], 
            'user_type'    => 1,
            'phone'        => $data['phone'],
            'email'        => $data['email'],    
            'confirm_hash' => $confirm_hash, 
            'password'     => bcrypt($data['password']),
        ])->id; 
	}

	public function edit(array $data, $id_user)
    {   
        foreach (['email', 'password', 'password_confirmation'] as $key => $value) 
        { 
            unset($this->editRules[$value]);
        }   

        $validate = $this->validation($data, $this->editRules);
        if ($validate !== true) 
        {
            return $validate;
        } 

        $checkEmail = ModelUser::whereEmail($data['email'])->where('id', '!=', $id_user)->get();
        if (count($checkEmail) > 0) 
        {
            return 'Пользователь с таким имейлом уже существует!'; 
        }  

        ModelUser::where('id', $id_user)->
          	update([ 
                'name'         => $data['name'],  
                'date_birth'   => date('Y-m-d', strtotime($data['date_birth'])), 
                'phone'        => $data['phone'],
                'email'        => $data['email'], 
                'city'         => $data['city'],
                'region'       => $data['region'],
                'phone'        => $data['phone'],
                'phone2'       => !empty($data['phone2']) ? $data['phone2'] : '',
                'fax'          => !empty($data['fax']) ? $data['fax'] : '',
                'site'         => !empty($data['site']) ? $data['site'] : '' 
      	]); 

        if (request()->hasFile('image')) 
        {
            $image = $this->uploadImage();
            if (!empty($image)) 
            {
            	ModelUser::where('id', $id_user)->
	              update([ 
	                'image' => $image 
	            ]); 
            }
        }
        return true; 
    } 

    public function uploadImage()
    {
    	$fileName = '';
    	if (request()->hasFile('image')) 
    	{
            $file     = request()->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/uploads/users/', $fileName);
        }
        return $fileName;
    }
}