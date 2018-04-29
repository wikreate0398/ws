<?php

namespace App\Http\Controllers\Users\Traits;

use Illuminate\Support\Facades\Validator;

use App\Models\User; 
use App\Models\UsersEducations;
use App\Models\UsersTeachingActivities;
use App\Models\UsersWorkExperience;

trait TeacherTrait
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
        'form_attitude'      => 'Форма отношения'
    ];

    private $rules = [
        'name'                  =>   'required',
        'surname'               =>   'required',
        'patronymic'            => 'required', 
        'date_birth'            =>   'required',
        'phone'                 => 'required', 
        'image'                 => 'file|mimes:jpeg,jpg,png',
        'email'                 => 'required|string|email|unique:users',
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required',
    ]; 

    private $education = [];

    private $edit_education = [];

    private $work_experience = [];

    private $edit_work_experience = [];

    private $teach_activity = [];

    private $edit_teach_activity = [];

    private $_id_user;

    public function validation(array $data)
    { 
        $education       = sortValue(request()->input('education'));
        $teach_activity  = sortValue(request()->input('teach_activity')); 
        $work_experience = sortValue(request()->input('work_experience'));
 
        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        if ($validator->fails()) 
        {
            return $validator->errors()->toArray();
        }

        $validateMultiArr = validateArray([
            '0' => [
                'array'    => $education, 
                'excepts'  => ['notes', 'department'], 
                'fName'    => 'education', 
                'required' => true
            ],
            '1' => [
                'array'   => $teach_activity, 
                'excepts' => ['description'], 
                'fName'   => 'teach_activity'
            ],
            '2' => [
                'array'   => $work_experience, 
                'excepts' => ['description', 'responsibility'], 
                'fName'   => 'work_experience'
            ] 
        ]); 

        if ($validateMultiArr['status'] == false) 
        { 
            return [$validateMultiArr['field'] => ['Заполните все обязательные поля!']]; 
        }

        return true;
    }

    public function create(array $data)
    {
        $this->education       = sortValue(request()->input('education'));
        $this->teach_activity  = sortValue(request()->input('teach_activity')); 
        $this->work_experience = sortValue(request()->input('work_experience'));

        $confirm_hash = md5(microtime());
 
        $createUser = User::create([ 
            'name' => $data['name'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'date_birth' => date('Y-m-d', strtotime($data['date_birth'])),
            'user_type'  => '2',
            'phone'      => $data['phone'],
            'email'      => $data['email'], 
            'city'       => !empty($data['city']) ? $data['city'] : '',
            'phone'      => $data['phone'],
            'phone2'     => !empty($data['phone2']) ? $data['phone2'] : '',
            'fax'        => !empty($data['fax']) ? $data['fax'] : '',
            'site'       => !empty($data['site']) ? $data['site'] : '',
            'image'      => $this->uploadImage(),
            'confirm_hash' => $confirm_hash, 
            'password'     => bcrypt($data['password']),
        ]);  

        $this->_id_user = $createUser->id; 
        $this->saveEducations();
        $this->saveTeachingActivities();
        $this->saveWorkExperience();  
        return $this->_id_user;
    }

    private function saveEducations()
    {
        $insert = [];
        foreach ($this->education as $key => $item) { 
            $insert[] = [
                'id_user'          => $this->_id_user,
                'from_year'        => $item['from'],
                'to_year'          => $item['to'],
                'institution_name' => $item['institution'],
                'department'       => $item['department'],
                'notes'            => $item['notes'],
                'specialty'        => $item['specialty'],
                'grade'            => $item['grade'], 
            ];
        } 
        UsersEducations::insert($insert);
    }

    private function saveTeachingActivities()
    {
        if (!empty($this->teach_activity)) 
        { 
            $insert = [];
            foreach ($this->teach_activity as $key => $item) 
            { 
                $insert[] = [
                    'id_user'          => $this->_id_user,
                    'from_year'        => $item['from'],
                    'to_year'          => $item['to'],
                    'institution_name' => $item['institution'],
                    'position'         => $item['position'],
                    'description'      => $item['description'],
                    'id_category'      => $item['id_category'],
                    'program_type'     => $item['program_type'], 
                ];
            } 
            UsersTeachingActivities::insert($insert);
        } 
    }

    private function saveWorkExperience()
    { 
        if (!empty($this->work_experience)) 
        { 
            $insert = [];
            foreach ($this->work_experience as $key => $item) 
            { 
                $insert[] = [
                    'id_user'          => $this->_id_user,
                    'from_year'        => $item['from'],
                    'to_year'          => $item['to'],
                    'institution_name' => $item['institution'],
                    'position'         => $item['position'],
                    'description'      => $item['description'],
                    'direction'        => $item['direction'],
                    'responsibility'   => $item['responsibility'], 
                ];
            } 
            UsersWorkExperience::insert($insert); 
        }
    }

    private function validateEdit(array $data)
    {   
        $this->education       = sortValue(request()->input('education'));
        $this->teach_activity  = sortValue(request()->input('teach_activity')); 
        $this->work_experience = sortValue(request()->input('work_experience'));
        $this->edit_education       = sortValue(request()->input('edit_education'));
        $this->edit_teach_activity  = sortValue(request()->input('edit_teach_activity')); 
        $this->edit_work_experience = sortValue(request()->input('edit_work_experience'));
 
        $validateMultiArr = validateArray([
            '0' => [
                'array'    => $this->education, 
                'excepts'  => ['notes', 'department'], 
                'fName'    => 'education', 
                'required' => empty($this->edit_education) ? true : false
            ],

            '1' => [
                'array'   => $this->teach_activity, 
                'excepts' => ['description'], 
                'fName'   => 'teach_activity'
            ],

            '2' => [
                'array'   => $this->work_experience, 
                'excepts' => ['description', 'responsibility'], 
                'fName'   => 'work_experience'
            ],

            '3' => [
                'array'    => $this->edit_education, 
                'excepts'  => ['notes', 'department'], 
                'fName'    => 'edit_education', 
                'required' => empty($this->education) ? true : false
            ],

            '4' => [
                'array'   => $this->edit_teach_activity, 
                'excepts' => ['description'], 
                'fName'   => 'edit_teach_activity'
            ],

            '5' => [
                'array'   => $this->edit_work_experience, 
                'excepts' => ['description', 'responsibility'], 
                'fName'   => 'edit_work_experience'
            ]
        ]);

        if ($validateMultiArr['status'] == false) 
        {
            return [$validateMultiArr['field'] => ['Заполните все обязательные поля!']];
        }
  
        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        if ($validator->fails()) 
        {
            return $validator->errors()->toArray();
        }
        return true;
    }

    public function edit(array $data, $id_user)
    {  

        $this->_id_user = $id_user; 
        
        foreach (['email', 'password', 'password_confirmation'] as $key => $value) 
        { 
            unset($this->rules[$value]);
        }   

        $errors = $this->validateEdit($data); 

        if ($errors !== true) 
        {
            return $errors; 
        }      

        $checkEmail = User::whereEmail($data['email'])->where('id', '!=', $id_user)->get();
        if (count($checkEmail) > 0) 
        {
            return 'Пользователь с таким имейлом уже существует!'; 
        } 

        User::where('id', $id_user)
            ->update([ 
            'name'       => $data['name'],
            'surname'    => $data['surname'],
            'patronymic' => $data['patronymic'],
            'date_birth' => date('Y-m-d', strtotime($data['date_birth'])), 
            'phone'      => $data['phone'],
            'email'      => $data['email'], 
            'city'       => !empty($data['city']) ? $data['city'] : '',
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

        if (!empty($this->education)) {
            $this->saveEducations();
        }
         
        $this->saveTeachingActivities();
        $this->saveWorkExperience(); 

        if (!empty($this->edit_education)) 
        {
            foreach ($this->edit_education as $key => $item) 
            { 
                if (!empty($item['id'])) 
                { 
                    $update = [  
                        'from_year'        => $item['from'],
                        'to_year'          => $item['to'],
                        'institution_name' => $item['institution'],
                        'department'       => ifNull($item['department']),
                        'notes'            => ifNull($item['notes']),
                        'specialty'        => $item['specialty'],
                        'grade'            => $item['grade'], 
                    ];  

                    UsersEducations::where('id', $item['id'])->where('id_user', $id_user)->update($update);
                }
            }   
        }

        if (empty($this->edit_teach_activity) && empty($this->teach_activity)) 
        {
            UsersTeachingActivities::where('id_user', $id_user)->delete();
        }
        elseif(!empty($this->edit_teach_activity))
        { 
            foreach ($this->edit_teach_activity as $key => $item) 
            { 
                if (!empty($item['id'] )) 
                { 
                    $update = [ 
                        'from_year'        => $item['from'],
                        'to_year'          => $item['to'],
                        'institution_name' => $item['institution'],
                        'position'         => $item['position'],
                        'description'      => ifNull($item['description']),
                        'id_category'      => $item['id_category'],
                        'program_type'     => $item['program_type']  
                    ];  
                }

                UsersTeachingActivities::where('id', $item['id'])->where('id_user', $id_user)->update($update);
            }  
        }

        if (empty($this->edit_work_experience) && empty($this->work_experience)) 
        {
            UsersWorkExperience::where('id_user', $id_user)->where('id_user', $id_user)->delete();
        }
        elseif (!empty($this->edit_work_experience)) 
        { 
            foreach ($this->edit_work_experience as $key => $item) 
            { 
                if (!empty($item['id'])) 
                {
                    $update = [ 
                        'from_year'        => $item['from'],
                        'to_year'          => $item['to'],
                        'institution_name' => $item['institution'],
                        'position'         => $item['position'],
                        'description'      => ifNull($item['description']),
                        'direction'        => $item['direction'],
                        'responsibility'   => ifNull($item['responsibility']), 
                    ];
                }

                UsersWorkExperience::where('id', $item['id'])->where('id_user', $id_user)->update($update);
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