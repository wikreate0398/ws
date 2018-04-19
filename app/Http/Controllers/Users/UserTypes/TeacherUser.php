<?php

namespace App\Http\Controllers\Users\UserTypes;

use App\Models\User; 
use App\Models\UsersEducations;
use App\Models\UsersTeachingActivities;
use App\Models\UsersWorkExperience;
use App\Models\ProgramsType;
use App\Models\GradeEducation;
use App\Models\Cities;
use App\Models\TeachActivityCategories;
use App\Models\WorkExperienceDirection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use App\Http\Controllers\Users\UserTypes\UserTypesInterface; 

/**
* Регистрация обычного пользователя
*/
class TeacherUser extends Controller implements UserTypesInterface
{

    protected $_evokeClass;

    private $_id_user;

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

    private $viewPath = 'users.profile_types.teacher.';

	function __construct($evokeClass)
	{
		$this->_evokeClass = $evokeClass;
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
	public function validateRegistration(array $data)
	{ 
        $education       = sortValue(request()->input('education'));
        $teach_activity  = sortValue(request()->input('teach_activity')); 
        $work_experience = sortValue(request()->input('work_experience'));
 
        $validateMultiArr = validateArray([
            '0' => ['array' => $education, 'excepts' => ['description', 'department'], 'fName' => 'education', 'required' => true],
            '1' => ['array' => $teach_activity, 'excepts' => ['description'], 'fName' => 'teach_activity'],
            '2' => ['array' => $work_experience, 'excepts' => ['description', 'responsibility'], 'fName' => 'work_experience'] 
        ]);

        if ($validateMultiArr['status'] == false) 
        {
            \App\Utils\JsonResponse::error(['messages' => [$validateMultiArr['field'] => ['Заполните все обязательные поля!']]]);
        }

        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
		return $validator;
	}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
	public function createUser(array $data)
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
            'user_type'  => $this->_evokeClass->userType,
            'phone'      => $data['phone'],
            'email'      => $data['email'], 
            'city'       => !empty($data['city']) ? $data['city'] : '',
            'phone'      => $data['phone'],
            'phone2'     => !empty($data['phone2']) ? $data['phone2'] : '',
            'fax'        => !empty($data['fax']) ? $data['fax'] : '',
            'site'       => !empty($data['site']) ? $data['site'] : '',
            'image'      => $this->_evokeClass->saveImage(),
            'confirm_hash' => $confirm_hash, 
            'password'     => bcrypt($data['password']),
        ]);  

        $this->_id_user = $createUser->id;

        $this->saveEducations();
        $this->saveTeachingActivities();
        $this->saveWorkExperience(); 

        $this->_evokeClass->sendConfirmationEmail($data['email'], $confirm_hash);  
        return true;
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
                'department'       => ifNull($item['department']),
                'notes'            => ifNull($item['notes']),
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
                    'description'      => ifNull($item['description']),
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
                    'description'      => ifNull($item['description']),
                    'direction'        => $item['direction'],
                    'responsibility'   => ifNull($item['responsibility']), 
                ];
            } 
            UsersWorkExperience::insert($insert); 
        }
    }

    public function showEditForm()
    {
        $user = Auth::user();
        return view('users.teacher_profile', [
            'cities'          => Cities::orderBy('name', 'asc')->get(),
            'grade_education' => map_tree(GradeEducation::orderBy('page_up','asc')->get()->toArray()),
            'programs_type'   => map_tree(ProgramsType::orderBy('page_up','asc')->get()->toArray()),
            'teach_activ_cat' => map_tree(TeachActivityCategories::orderBy('page_up','asc')->get()->toArray()),
            'work_experience_direction' => WorkExperienceDirection::orderBy('page_up','asc')->get(),
            'user'            => $user,
            'usersEducations' => UsersEducations::where('id_user', $user->id)->orderBy('from_year', 'desc')->get(),
            'usersTeachingActivities' => UsersTeachingActivities::where('id_user', $user->id)->orderBy('from_year', 'desc')->get(),
            'usersWorkExperience'     => UsersWorkExperience::where('id_user', $user->id)->orderBy('from_year', 'desc')->get(),
            'include'                 => $this->viewPath . 'edit',
        ]); 
    } 
 
    private function validateEditProfile(array $data)
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
                'excepts'  => ['description', 'department'], 
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
            return ['status' => false, 'messages' => [$validateMultiArr['field'] => ['Заполните все обязательные поля!']]];
        }
  
        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        return $validator;
    }

    public function editProfile(array $data)
    { 
        $this->_id_user = Auth::user()->id; 

        foreach (['email', 'password', 'password_confirmation'] as $key => $value) 
        { 
            unset($this->rules[$value]);
        }   

        $validator = $this->validateEditProfile($data);

        if (!is_object($validator) && !empty($validator['messages'])) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validator['messages']]); 
        }
        elseif ($validator->fails()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validator->errors()->toArray()]); 
        }        

        $checkEmail = User::whereEmail($data['email'])->where('id', '!=', $this->_id_user)->get();
        if (count($checkEmail) > 0) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Пользователь с таким имейлом уже существует!']); 
        } 

        User::where('id', $this->_id_user)
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
            $file     = request()->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/uploads/users/', $fileName);   
            User::where('id', $this->_id_user)->
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

                    UsersEducations::where('id', $item['id'])->where('id_user', $this->_id_user)->update($update);
                }
            }   
        }

        if (empty($this->edit_teach_activity) && empty($this->teach_activity)) 
        {
            UsersTeachingActivities::where('id_user', $this->_id_user)->delete();
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

                UsersTeachingActivities::where('id', $item['id'])->where('id_user', $this->_id_user)->update($update);
            }  
        }

        if (empty($this->edit_work_experience) && empty($this->work_experience)) 
        {
            UsersWorkExperience::where('id_user', $this->_id_user)->where('id_user', $this->_id_user)->delete();
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

                UsersWorkExperience::where('id', $item['id'])->where('id_user', $this->_id_user)->update($update);
            }  
        }

        return \App\Utils\JsonResponse::success(['reload' => true], 'Данные успешно обновлены!'); 
    }

    public function showCourse()
    { 
        return view('users.teacher_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'courses',
        ]); 
    }

    public function showSubscriptions()
    {
        return view('users.teacher_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'subscriptions',
        ]); 
    }

    public function showReviews()
    {
        return view('users.teacher_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'reviews',
        ]); 
    } 

    public function showDiploms()
    {
        return view('users.teacher_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'diplomas',
        ]); 
    }  
}