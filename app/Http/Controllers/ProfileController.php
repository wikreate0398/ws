<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;

use App\Models\User;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Users\UserTypes\UserTypesService;
 

class ProfileController extends Controller
{
    private $userTypes = [
        '1' => \App\Http\Controllers\Users\UserTypes\SimpleUser::class,
        '2' => \App\Http\Controllers\Users\UserTypes\TeacherUser::class,
        '3' => \App\Http\Controllers\Users\UserTypes\UniversityUser::class,
    ]; 

    public $niceNames = [
        'password'         => 'Пароль',
        'repeat_password'  => 'Повторите пароль',
        'image'            => 'Фото' 
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {  
        //$this->middleware('guest')->except('logout');
    } 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function userProfile()
    { 
        return \App\Http\Controllers\Users\UserTypes\UserTypesService::init(Auth::user()->user_type, $this, 'showProfile');  
    } 

    public function editProfile(Request $request)
    {
        return \App\Http\Controllers\Users\UserTypes\UserTypesService::init(Auth::user()->user_type, $this, 'editProfile', $request->all());  
    } 
  
    public function updatePassword()
    { 
        $validator = Validator::make(request()->all(), [
            'old_password'          => 'required',
            'password'              => 'required|string|min:6|confirmed|',
            'password_confirmation' => 'required',
        ]);
        $validator->setAttributeNames($this->niceNames);
  
        if ($validator->fails()) 
        {
            $errors = $validator->errors()->toArray(); 
        } 

        if(Hash::check(request()->input('old_password'), Auth::user()->password) == false) {
            $errors[]['password'] = 'Старый пароль не верный';
        }
  
        if (!empty($errors)) 
        {
            return \App\Json\JsonResponse::error(['messages' => $errors]);
        }

        $obj_user           = User::find(Auth::user()->id);
        $obj_user->password = Hash::make(request()->input('password'));
        $obj_user->save(); 

        return \App\Json\JsonResponse::success(['redirect' => '/user/profile'], 'Пароль успешно изменен!');
    }

    public function deleteUserEducation($id)
    { 
        \App\Models\UsersEducations::where('id', $id)->where('id_user', Auth::user()->id)->delete();
        return redirect(route('user_profile'))->with('flas_message', 'Образование успешно удалено');
    } 

    public function deleteUserActivities($id)
    { 
        \App\Models\UsersTeachingActivities::where('id', $id)->where('id_user', Auth::user()->id)->delete();
        return redirect(route('user_profile'))->with('flas_message', 'Преподовательская деятельность успешно удалена');
    } 

    public function deleteUserExperience($id)
    { 
        \App\Models\UsersWorkExperience::where('id', $id)->where('id_user', Auth::user()->id)->delete();
        return redirect(route('user_profile'))->with('flas_message', 'Трудовая деятельность успешно удалена');
    } 
}