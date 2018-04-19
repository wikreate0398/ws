<?php
 
namespace App\Http\Controllers\Users\UserTypes;

use App\Models\User; 
use App\Models\Cities;

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
class SimpleUser extends Controller implements UserTypesInterface
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

    private $viewPath = 'users.profile_types.user.';

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

        User::create([ 
            'name'         => $data['name'],
            'surname'      => $data['surname'],
            'patronymic'   => $data['patronymic'],
            'date_birth'   => date('Y-m-d', strtotime($data['date_birth'])),
            'user_type'    => $this->_evokeClass->userType,
            'phone'        => $data['phone'],
            'email'        => $data['email'], 
            'city'         => $data['city'],
            'phone'        => $data['phone'],
            'phone2'       => $data['phone2'],
            'fax'          => $data['fax'],
            'site'         => $data['site'],
            'image'        => $this->_evokeClass->saveImage(),
            'confirm_hash' => $confirm_hash, 
            'password'     => bcrypt($data['password']),
        ]); 

        $this->_evokeClass->sendConfirmationEmail($data['email'], $confirm_hash); 
        return true;
	}

    public function showCourse()
    { 
        return view('users.user_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'courses',
        ]); 
    }

    public function showEditForm()
    { 
        return view('users.user_profile', [
            'cities'  => Cities::orderBy('name', 'asc')->get(),  
            'user'    => Auth::user(), 
            'include' => $this->viewPath . 'edit'
        ]); 
    } 

    public function showSubscriptions()
    {
        return view('users.user_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'subscriptions',
        ]); 
    }

    public function showReviews()
    {
        return view('users.user_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'reviews',
        ]); 
    }  

    public function showBookmarks()
    {
        return view('users.user_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'bookmarks',
        ]); 
    }  

    public function editProfile(array $data)
    {   
        $user_id = Auth::user()->id; 

        foreach (['email', 'password', 'password_confirmation'] as $key => $value) 
        { 
            unset($this->rules[$value]);
        }  

        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        if ($validator->fails()) {
            return \App\Utils\JsonResponse::error(['messages' => $validator->errors()->toArray()]); 
        }

        $checkEmail = User::whereEmail($data['email'])->where('id', '!=', $user_id)->get();
        if (count($checkEmail) > 0) {
            return \App\Utils\JsonResponse::error(['messages' => 'Пользователь с таким имейлом уже существует!']); 
        } 

        User::where('id', $user_id)->
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

        if (request()->hasFile('image')) {
            $file     = request()->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/uploads/users/', $fileName);   
            User::where('id', $user_id)->
              update([ 
                'image' => $fileName 
            ]); 
        }

        return \App\Utils\JsonResponse::success(['reload' => true], 'Данные успешно обновлены!'); 
    } 
}