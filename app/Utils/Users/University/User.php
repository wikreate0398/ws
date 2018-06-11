<?php

namespace App\Utils\Users\University;

use Illuminate\Support\Facades\Validator;
use App\Models\User as ModelUser; 
use App\Models\UsersUniversity;
use App\Models\UniversitySpecializations;
use App\Models\UsersCertificates;
use Illuminate\Support\Facades\Hash;

class User 
{
	private $niceNames = [
        'name'                     => 'Название вуза',
        'description'              => 'Коротко о вузе',
        'year_of_foundation'       => 'Дата основания',   
        'region'                   => 'Область',
        'address'                  => 'Адрес', 
        'phone'                    => 'Телефон',
        'email'                    => 'Имейл',
        'city'                     => 'Город', 
        'status'                   => 'Тип Вуза', 
        'price'                    => 'Средняя стоимость обучения',
        'qty_budget'               => 'Кол-во мест на бюджетной основе',
        'budget_points_admission'  => 'Бюджетная основа',
        'payable_points_admission' => 'Платная основа',
        'password'                 => 'Пароль',
        'repeat_password'          => 'Повторите пароль', 
        'specializations'          => 'Ваша Специализация' 
    ];

    private $editRules = [ 
        'name'                  => 'required', 
        'description'           => 'required|max:800', 
        'year_of_foundation'    => 'required', 
        'region'                => 'required',
        'city'                  => 'required',  
        'address'               => 'required', 
        'phone'                 => 'required',  
        'email'                 => 'required|email',
        'price'                 => 'required',
        'qty_budget'            => 'required|integer|min:1',
        'budget_points_admission'  => 'required|min:1',
        'payable_points_admission' => 'required|min:1', 
        'status'                   => 'required|integer',    
        'specializations'          => 'required'
    ];

    private $addRules = [
        'email'                 => 'required|string|email|unique:users',
        'name'                  => 'required', 
        'phone'                 => 'required', 
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required' 
    ]; 

    public function validation(array $data, $rules)
    { 

        if (!empty($data['secondary_inst'])) {
            $rules['parent_institution'] = 'required|integer';
            $rules['form_attitude']      = 'required|integer';
        }

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

        $createUser = ModelUser::create([   
            'user_type'    => 3,
            'phone'        => $data['phone'],
            'email'        => $data['email'],    
            'confirm_hash' => $confirm_hash, 
            'password'     => bcrypt($data['password']),
        ]); 

        $id_user = $createUser->id; 

        UsersUniversity::insert([
            'id_user'   => $id_user, 
            'full_name' => $data['name'],
             
        ]); 
        return $id_user;
    }

    public function edit(array $data, $id_user)
    {   
        $validator = Validator::make($data, $this->editRules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        if ($validator->fails()) 
        {
            return $validator->errors()->toArray(); 
        }

        $checkEmail = ModelUser::whereEmail($data['email'])->where('id', '!=', $id_user)->get();
        if (count($checkEmail) > 0) 
        {
            return 'Пользователь с таким имейлом уже существует!';  
        } 

        ModelUser::where('id', $id_user)->update([    
            'about'      => $data['description'],
            'address'    => $data['address'],
            'city'       => $data['city'], 
            'region'     => $data['region'],
            'phone'      => $data['phone'],
            'phone2'     => !empty($data['phone2']) ? $data['phone2'] : '', 
            'site'       => !empty($data['site']) ? $data['site'] : '',
            'email'      => $data['email'],
            'data_filled' => 1 
        ]);  

        UsersUniversity::where('id_user', $id_user)->update([   
            'status'                   => $data['status'],
            'full_name'                => $data['name'], 
            'price'                    => toFloat($data['price']),
            'qty_budget'               => $data['qty_budget'],
            'budget_points_admission'  => $data['budget_points_admission'],
            'payable_points_admission' => $data['payable_points_admission'],
            'year_of_foundation'       => date('Y-m-d', strtotime($data['year_of_foundation'])), 
            'has_hostel'               => !empty($data['has_hostel']) ? 1 : 0,
            'has_military_department'  => !empty($data['has_military_department']) ? 1 : 0,
            'distance_learning'        => !empty($data['distance_learning']) ? 1 : 0 
        ]);

        $id_university = UsersUniversity::where('id_user', $id_user)->first()->id;
  
        UniversitySpecializations::where('id_university', $id_university)->delete();
        if (!empty($data['specializations'])) 
        { 
            $insert          = [];
            foreach ($data['specializations'] as $id_specialization => $value) 
            {
                $insert[] = [
                    'id_university'     => $id_university,
                    'id_specialization' => $id_specialization
                ];
            }
            UniversitySpecializations::insert($insert);
        }

        if (!empty($data['certificates'])) 
        {
            $this->saveCertificates($data['certificates'], $id_user);
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

    public function saveCertificates($certificates, $id_user)
    {
        $insert = [];
        foreach ($certificates as $key => $value) 
        {
            $fileName = md5(microtime()) . '.png';
            uploadBase64($value, public_path() . "/uploads/users/certificates/$fileName");
            $insert[] = [
                'id_user' => $id_user,
                'image'      => $fileName
            ];
        } 
        UsersCertificates::insert($insert);
    } 
}