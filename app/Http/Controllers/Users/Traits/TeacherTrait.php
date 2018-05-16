<?php

namespace App\Http\Controllers\Users\Traits;

use Illuminate\Support\Facades\Validator;

use App\Models\User; 
use App\Models\UsersEducations;
use App\Models\UsersTeachingActivities;
use App\Models\UsersWorkExperience;

use App\Models\TeacherSubjects;
use App\Models\TeacherSpecializations;
use App\Models\TeacherLessonOptions;
use App\Models\TeacherCertificates;

use Illuminate\Support\Facades\Hash;

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
        'form_attitude'      => 'Форма отношения',
        'sex'                => 'Пол',
        'address'            => 'Адрес',
        'teacher_subjects'   => 'Предметы',
        'specializations'    => 'Специализация',
        'lesson_options'     => 'проведения занятий' 
    ];

    private $rules = [
        'name'                  => 'required', 
        'date_birth'            => 'required',
        'phone'                 => 'required',
        'sex'                   => 'required',
        'address'               => 'required',
        'image'                 => 'image|mimes:jpeg,jpg,png',
        'email'                 => 'required|string|email|unique:users',
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required',
        'teacher_subjects'      => 'required',
        'specializations'       => 'required',
        'lesson_options'        => 'required'
    ]; 

    private $education = []; 

    private $_id_user;
 
    public function validation(array $data)
    { 
        $education       = sortValue(request()->input('education'));
 
        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        if ($validator->fails()) 
        {
            return $validator->errors()->toArray();
        }

        $validateMultiArr = validateArray([
            '0' => [
                'array'    => $education, 
                'excepts'  => [], 
                'fName'    => 'education', 
                'required' => true
            ],
            // '1' => [
            //     'array'   => $teach_activity, 
            //     'excepts' => ['description'], 
            //     'fName'   => 'teach_activity'
            // ],
            // '2' => [
            //     'array'   => $work_experience, 
            //     'excepts' => ['description', 'responsibility'], 
            //     'fName'   => 'work_experience'
            // ] 
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
            // 'surname' => $data['surname'],
            // 'patronymic' => $data['patronymic'],
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
        return $this->_id_user;
    }

    private function saveEducations()
    {
        $insert = [];
        foreach ($this->education as $key => $item) { 
            $insert[] = [
                'id_user'          => $this->_id_user, 
                'institution_name' => $item['institution'], 
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
 
        $validateMultiArr = validateArray([
            '0' => [
                'array'    => $this->education, 
                'excepts'  => [], 
                'fName'    => 'education', 
                'required' => true
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
            'date_birth' => date('Y-m-d', strtotime($data['date_birth'])), 
            'phone'      => $data['phone'],
            'email'      => $data['email'], 
            'city'       => $data['city'],
            'region'     => $data['region'],
            'phone'      => $data['phone'],
            'about'      => $data['about'],
            'sex'        => $data['sex'],
            'address'    => $data['address'],
            'experience_from' => date('Y-m-d', strtotime($data['experience_from'])),
            'price_hour'      => toFloat($data['price_hour'])
        ]);  

        if (request()->hasFile('image')) { 
            $fileName = $this->uploadImage();   
            User::where('id', $id_user)->
              update([ 
                'image' => $fileName 
            ]); 
        } 

        TeacherSubjects::where('id_teacher', $id_user)->delete();
        if (!empty($data['teacher_subjects'])) 
        { 
            foreach ($data['teacher_subjects'] as $key => $id_subject) 
            {
                $insert[] = [
                    'id_teacher' => $id_user,
                    'id_subject' => $id_subject
                ];
            }
            TeacherSubjects::insert($insert);
        }

        TeacherSpecializations::where('id_teacher', $id_user)->delete();
        if (!empty($data['specializations'])) 
        { 
            $insert          = [];
            foreach ($data['specializations'] as $id_specialization => $value) 
            {
                $insert[] = [
                    'id_teacher'        => $id_user,
                    'id_specialization' => $id_specialization
                ];
            }
            TeacherSpecializations::insert($insert);
        }

        TeacherLessonOptions::where('id_teacher', $id_user)->delete();
        if (!empty($data['lesson_options'])) 
        { 
            $insert         = [];
            foreach ($data['lesson_options'] as $id_lesson_option => $value) 
            {
                $insert[] = [
                    'id_teacher'       => $id_user,
                    'id_lesson_option' => $id_lesson_option
                ];
            } 
            TeacherLessonOptions::insert($insert);
        }

        UsersEducations::where('id_user', $id_user)->delete();
        $this->saveEducations(); 

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

            $obj_user = User::find($id_user);

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
                'id_teacher' => $id_user,
                'image'      => $fileName
            ];
        } 
        TeacherCertificates::insert($insert);
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