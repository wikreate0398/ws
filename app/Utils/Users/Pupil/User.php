<?php

namespace App\Utils\Users\Pupil;

use Illuminate\Support\Facades\Validator;
use App\Models\User as ModelUser; 
use Illuminate\Support\Facades\Hash;

class User
{
	public $niceNames = [ 
        'name'             => 'Имя',
        'sex'              => 'Пол', 
        'date_birth'       => 'День рождения',
        'address'          => 'Адрес',
        'phone'            => 'Телефон',          
        'region'           => 'Область',
        'city'             => 'Город', 
        'email'            => 'E-mail',
        'password'         => 'Пароль',
        'repeat_password'  => 'Повторите пароль', 
        'old_password'     => 'Старый Пароль'
	];

	public $addRules = [
        'email'                 => 'required|string|email|unique:users',
        'name'                  => 'required', 
        'phone'                 => 'required', 
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required'
	];

    public $editRules = [ 
        'name'       => 'required', 
        'date_birth' => 'required',
        'sex'        => 'required', 
        'region'     => 'required',
        'city'       => 'required',
        'phone'      => 'required', 
        'address'    => 'required', 
        'email'      => 'required|string|email|unique:users',
        'image'      => 'file|mimes:jpeg,jpg,png|max:200000'
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
                'address'      => $data['address'],
                'email'        => $data['email'], 
                'city'         => $data['city'],
                'region'       => $data['region'],
                'phone'        => $data['phone'], 
                'sex'          => $data['sex'],
                'data_filled'  => 1
      	]);

        $image = $this->uploadImage();
        if($image){
            ModelUser::where('id', $id_user)->
            update([
                'image'  => $image ,
                'avatar' => $image
            ]);
        }

        if (!empty($data['old_password'])) 
        {

            $validator = Validator::make($data, [
                'old_password'          => 'required',
                'password'              => 'required|string|min:6|confirmed|',
                'password_confirmation' => 'required',
            ]);
            $validator->setAttributeNames([
                'password'         => 'Пароль',
                'repeat_password'  => 'Повторите пароль',
                'old_password'     => 'Старый Пароль'
            ]);
            $errors=false;
            if ($validator->fails()) 
            {
                $errors = $validator->errors()->toArray(); 
            } 

            $obj_user = ModelUser::find($id_user);

            if(Hash::check($data['old_password'], $obj_user->password) == false) {
                $errors[]['password'] = 'Старый пароль не верный';
            } 

            if (!empty($errors)) 
            {   
                return $errors;
            } 
 
            $obj_user->password = Hash::make($data['password']);
            $obj_user->save(); 
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