<?php

namespace App\Utils\Users\Teacher;

use Illuminate\Support\Facades\Validator;

use App\Models\User as ModelUser; 
use App\Models\UsersEducations;
use App\Models\UsersTeachingActivities;
use App\Models\UsersWorkExperience;

use App\Models\TeacherSubjects;
use App\Models\TeacherSpecializations;
use App\Models\TeacherLessonOptions;
use App\Models\UsersCertificates;

use Illuminate\Support\Facades\Hash;

class User
{ 
    private $niceNames = [
        'name'                  => 'Имя', 
        'about'                 => 'Коротко о вас', 
        'date_birth'            => 'Дата рождения',  
        'sex'                   => 'Ваш пол', 
        'region'                => 'Область', 
        'city'                  => 'Город', 
        'address'               => 'Адрес', 
        'phone'                 => 'Телефон',  
        'email'                 => 'E-mail', 
        'grade_experience'      => 'Степень вашего опыта',  
        'experience_from'       => 'Опыт работы учителя',
        'price_hour'            => 'Средняя стоимость часа' 
    ]; 

    private $editRules = [
        'name'                  => 'required|max:80|min:5', 
        'about'                 => 'required|min:200|max:1200', 
        'date_birth'            => 'required',  
        'sex'                   => 'required', 
        'region'                => 'required', 
        'city'                  => 'required', 
        'address'               => 'required', 
        'phone'                 => 'required',  
        'email'                 => 'required|email', 
        'grade_experience'      => 'required',  
        'experience_from'       => 'required',
        'price_hour'            => 'required',
        'teacher_subjects'      => 'required',  
        'specializations'       => 'required', 
        'lesson_options'        => 'required',   
    ]; 

    private $addRules = [
        'email'                 => 'required|string|email|unique:users',
        'name'                  => 'required', 
        'phone'                 => 'required', 
        'password'              => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required' 
    ]; 

    private $customMessage = [
        'unique'                   => 'Пользователь уже Существует.',
        'specializations.required' => 'Укажите вашу Специализацию',
        'lesson_options.required'  => 'Укажите варианты проведения занятий',
        'teacher_subjects.required' => 'Укажите Направления и предметы' 
    ];

    private $education = []; 

    private $_id_user;
 
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
        $this->education = sortValue(request()->input('education'));  
        $confirm_hash    = md5(microtime());
 
        $createUser = ModelUser::create([ 
            'name'         => $data['name'], 
            'user_type'    => 2,
            'phone'        => $data['phone'],
            'email'        => $data['email'],    
            'confirm_hash' => $confirm_hash, 
            'password'     => bcrypt($data['password']),
        ]);  
  
        return $createUser->id;
    }

    private function saveEducations($id_user)
    {
        UsersEducations::where('id_user', $id_user)->delete();
        $insert = [];
        foreach ($this->education as $key => $item) 
        { 
            if (arrayNoEmpty($item)) 
            { 
                $insert[] = [
                    'id_user'          => $id_user, 
                    'institution_name' => $item['institution'], 
                    'grade'            => $item['grade'], 
                ];
            }
        } 

        if (!empty($insert)) 
        {
            UsersEducations::insert($insert);
        } 
    } 

    private function validateEdit(array $data)
    {    
        $error = '';

        if (preg_match('/^[a-zA-Z\p{Cyrillic}\s\-]+$/u', $data['name']) == false) 
        {

            $error['name'][] = ['Поле <strong>ФИО</strong> должно содержать только буквы.']; 
        }

        if (count(explode(' ', $data['name'])) < 2) 
        {
            $error['name'][] = ['Укажите полное ФИО']; 
        }

        if (!empty($error)) 
        {
            return $error;
        }  

        $validator = Validator::make($data, $this->editRules, $this->customMessage); 
        $validator->setAttributeNames($this->niceNames);  
        if ($validator->fails()) 
        {
            return $validator->errors()->toArray();
        }

        $this->education = sortValue(request()->input('education')); 
 
        $validateMultiArr = validateArray([
            '0' => [
                'array'    => $this->education, 
                'excepts'  => [], 
                'fName'    => 'education', 
                'required' => false
            ] 
        ]); 

        if ($validateMultiArr['status'] == false) 
        {
            return [$validateMultiArr['field'] => ['Заполните все обязательные поля!']];
        } 
        return true;
    }

    public function edit(array $data, $id_user)
    {    
        $this->_id_user = $id_user;  

        $errors = $this->validateEdit($data); 
 
        if ($errors !== true) 
        {
            return $errors; 
        }      

        $checkEmail = ModelUser::whereEmail($data['email'])->where('id', '!=', $id_user)->get();
        if (count($checkEmail) > 0) 
        {
            return 'Пользователь с таким имейлом уже существует!'; 
        } 
  
        ModelUser::where('id', $id_user)
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
            'grade_experience' => $data['grade_experience'],
            'experience_from' => date('Y-m-d', strtotime($data['experience_from'])),
            'price_hour'      => toFloat($data['price_hour']),
            'lesson_place'    => $data['lesson_place'],
            'data_filled'     => '1'
        ]);    

        TeacherSubjects::where('id_teacher', $id_user)->delete();
        if (!empty($data['teacher_subjects'])) 
        { 
            foreach ($data['teacher_subjects'] as $id_direction => $subjects) 
            {
                 
                foreach ($subjects as $key => $id_subject) { 
                    $insert[] = [
                        'id_teacher'   => $id_user,
                        'id_direction' => $id_direction,
                        'id_subject'   => $id_subject
                    ];
                } 
            }
 
                // print_arr($insert);
                // exit();
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

        $this->saveEducations($id_user); 

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