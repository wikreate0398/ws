<?php

namespace App\Http\Controllers\Users\Traits;

use Illuminate\Support\Facades\Validator;
use App\Models\User; 

trait PupilTrait
{
	private $niceNames = [
		'password'         => 'Пароль',
        'repeat_password'  => 'Повторите пароль',
        'image'            => 'Фото' 
	];

	private $rules = [
        'name'                  => 'required',
        'surname'               =>  'required',
        'patronymic'            => 'required', 
        'date_birth'            => 'required',
        'phone'                 => 'required', 
        'image'                 => 'file|mimes:jpeg,jpg,png',
        'email'                 => 'required|string|email|unique:users',
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required',
	];

	public function validation(array $data)
	{ 
        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
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
        return User::create([ 
            'name'         => $data['name'],
            'surname'      => $data['surname'],
            'patronymic'   => $data['patronymic'],
            'date_birth'   => date('Y-m-d', strtotime($data['date_birth'])),
            'user_type'    => '1',
            'phone'        => $data['phone'],
            'email'        => $data['email'], 
            'city'         => $data['city'],
            'phone'        => $data['phone'], 
            'site'         => $data['site'],
            'image'        => $this->uploadImage(),
            'confirm_hash' => $confirm_hash, 
            'password'     => bcrypt($data['password']),
        ])->id; 
	}

	public function edit(array $data, $id_user)
    {   
        foreach (['email', 'password', 'password_confirmation'] as $key => $value) 
        { 
            unset($this->rules[$value]);
        }  

        $validate = $this->validation($data);
        if ($validate != true) 
        {
            return $validate;
        }

        $checkEmail = User::whereEmail($data['email'])->where('id', '!=', $id_user)->get();
        if (count($checkEmail) > 0) 
        {
            return 'Пользователь с таким имейлом уже существует!'; 
        } 

        User::where('id', $id_user)->
          	update([ 
                'name'         => $data['name'],
                'surname'      => $data['surname'],
                'patronymic'   => $data['patronymic'],
                'date_birth'   => date('Y-m-d', strtotime($data['date_birth'])), 
                'phone'        => $data['phone'],
                'email'        => $data['email'], 
                'city'         => !empty($data['city']) ? $data['city'] : '',
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
            	User::where('id', $id_user)->
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