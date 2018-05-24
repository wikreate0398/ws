<?php

namespace App\Http\Controllers\Users\Traits;

use Illuminate\Support\Facades\Validator;
use App\Models\User; 
use App\Models\UsersUniversity;

trait UniversityTrait
{
	private $niceNames = [
        'password'           => 'Пароль',
        'repeat_password'    => 'Повторите пароль',
        'image'              => 'Фото',
        'institution_type'   => 'Тип',
        'status'             => 'Статус',
        'program_type'       => 'Типы программ',
        'id_category'        => 'Основные рубрики',
        'parent_institution' => 'Родительское ВУЗ',
        'form_attitude'      => 'Форма отношения',
        'region'                => 'Область',
        'city'                  => 'Город', 
    ];

    private $editRules = [ 
        'phone'                 => 'required', 
        'image'                 => 'file|mimes:jpeg,jpg,png',
        'email'                 => 'required|string|email|unique:users',
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required',
        'institution_type'      => 'required|integer',
        'status'                => 'required|integer|',
        'full_name'             => 'required',
        'short_name'            => 'required',
        'description'           => 'required', 
        'year_of_foundation'    => 'required',
        'license_nr'            => 'required',
        'license_nr_from'       => 'required',
        'accreditation_nr'      => 'required',
        'accreditation_nr_from' => 'required',
        'program_type'          => 'required|integer|',
        'id_category'           => 'required|integer|',
        'description'           => 'max:800',
        'region'                => 'required',
        'city'                  => 'required',  
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

        $createUser = User::create([   
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
        foreach (['email', 'password', 'password_confirmation'] as $key => $value) 
        { 
            unset($this->editRules[$value]);
        }  

        if (!empty($data['secondary_inst'])) {
            $this->editRules['parent_institution'] = 'required|integer';
            $this->editRules['form_attitude']      = 'required|integer';
        }

        $validator = Validator::make($data, $this->editRules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        if ($validator->fails()) 
        {
            return $validator->errors()->toArray(); 
        }

        $checkEmail = User::whereEmail($data['email'])->where('id', '!=', $id_user)->get();
        if (count($checkEmail) > 0) 
        {
            return 'Пользователь с таким имейлом уже существует!';  
        } 

        User::where('id', $id_user)->update([   
            'phone'      => $data['phone'],
            'email'      => $data['email'], 
            'city'       => $data['city'],
            'region'     => $data['region'],
            'phone'      => $data['phone'],
            'phone2'     => !empty($data['phone2']) ? $data['phone2'] : '',
            'fax'        => !empty($data['fax']) ? $data['fax'] : '',
            'site'       => !empty($data['site']) ? $data['site'] : '' 
        ]); 

        if (request()->hasFile('image')) {
            $fileName = $this->uploadImage();    
            User::where('id', $id_user)->
              update([ 
                'image' => $fileName 
            ]); 
        }

        UsersUniversity::where('id_user', $id_user)->update([  
            'institution_type'        => $data['institution_type'],
            'status'                  => $data['status'],
            'full_name'               => $data['full_name'],
            'short_name'              => $data['short_name'],
            'other_names'             => ifNull($data['other_names']),
            'secondary_inst'          => !empty($data['secondary_inst']) ? 1 : 0,
            'parent_institution'      => !empty($data['secondary_inst']) ? ifNull($data['parent_institution']) : 0,
            'form_attitude'           => !empty($data['secondary_inst']) ? ifNull($data['form_attitude']) : 0, 
            'year_of_foundation'      => $data['year_of_foundation'],
            'has_hostel'              => !empty($data['has_hostel']) ? 1 : 0,
            'has_military_department' => !empty($data['has_military_department']) ? 1 : 0,
            'license_nr'              => $data['license_nr'],
            'license_nr_from'         => date('Y-m-d', strtotime($data['license_nr_from'])),  
            'accreditation_nr'        => $data['accreditation_nr'],
            'accreditation_nr_from'   => date('Y-m-d', strtotime($data['accreditation_nr_from'])),
            'description'             => ifNull($data['description']),
            'program_type'            => $data['program_type'],
            'id_category'             => $data['id_category'],
        ]);

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