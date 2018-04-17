<?php

namespace App\Http\Controllers\Users\UserTypes;

use App\Models\User; 
use App\Models\Cities;
use App\Models\UsersUniversity;
use App\Models\UniversityFormAttitude; 
use App\Models\InstitutionTypes;
use App\Models\University; 
use App\Models\ProgramsType;
use App\Models\TeachActivityCategories;

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
class UniversityUser extends Controller implements UserTypesInterface
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
        'description'           => 'max:800' 
	];

	protected $_evokeClass;

    private $_id_user;

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

        if (!empty(request()->input('secondary_inst'))) {
            $this->rules['parent_institution'] = 'required|integer';
            $this->rules['form_attitude']      = 'required|integer';
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
		$confirm_hash = md5(microtime());

        $createUser = User::create([  
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

        $id_user = $createUser->id;

        UsersUniversity::insert([
            'id_user'                 => $id_user,
            'institution_type'        => $data['institution_type'],
            'status'                  => $data['status'],
            'full_name'               => $data['full_name'],
            'short_name'              => $data['short_name'],
            'other_names'             => ifNull($data['other_names']),
            'secondary_inst'          => !empty($data['secondary_inst']) ? 1 : 0,
            'parent_institution'      => ifNull($data['parent_institution']),
            'form_attitude'           => ifNull($data['form_attitude']),
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

        $this->_evokeClass->sendConfirmationEmail($data['email'], $confirm_hash); 
        return true;
	}

    public function showProfile()
    {
        $user = Auth::user();
        return view('users.profile', [
            'cities'             => Cities::orderBy('name', 'asc')->get(), 
            'programs_type'      => map_tree(ProgramsType::orderBy('page_up','asc')->get()->toArray()),
            'teach_activ_cat'    => map_tree(TeachActivityCategories::orderBy('page_up','asc')->get()->toArray()), 
            'user'               => $user,
            'userUniversity'     => UsersUniversity::where('id_user', $user->id)->first(),
            'inst_type'          => InstitutionTypes::orderBy('page_up','asc')->get(),
            'university'         => University::orderBy('page_up','asc')->get(),
            'univ_form_attitude' => UniversityFormAttitude::orderBy('page_up','asc')->get(),
            'include'            => 'users.profile_types.university',
        ]); 
    }

    public function editProfile(array $data)
    {
        $this->_id_user = Auth::user()->id; 

        foreach (['email', 'password', 'password_confirmation'] as $key => $value) 
        { 
            unset($this->rules[$value]);
        }  

        if (!empty(request()->input('secondary_inst'))) {
            $this->rules['parent_institution'] = 'required|integer';
            $this->rules['form_attitude']      = 'required|integer';
        }

        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        if ($validator->fails()) {
            return \App\Utils\JsonResponse::error(['messages' => $validator->errors()->toArray()]); 
        }

        $checkEmail = User::whereEmail($data['email'])->where('id', '!=', $this->_id_user)->get();
        if (count($checkEmail) > 0) {
            return \App\Utils\JsonResponse::error(['messages' => 'Пользователь с таким имейлом уже существует!']); 
        } 

        User::where('id', $this->_id_user)->update([   
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

        UsersUniversity::where('id_user', $this->_id_user)->update([  
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

        return \App\Utils\JsonResponse::success(['reload' => true], 'Данные успешно обновлены!');
    }
}