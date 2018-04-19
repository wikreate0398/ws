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
 
    public function showCourse()
    { 
        return UserTypesService::init(Auth::user()->user_type, $this, 'showCourse');  
    } 

    public function showEditForm()
    { 
        return UserTypesService::init(Auth::user()->user_type, $this, 'showEditForm');  
    }

    public function showSubscriptions()
    {
        return UserTypesService::init(Auth::user()->user_type, $this, 'showSubscriptions'); 
    }

    public function showReviews()
    {
        return UserTypesService::init(Auth::user()->user_type, $this, 'showReviews'); 
    }

    public function showBookmarks()
    {
        return UserTypesService::init(Auth::user()->user_type, $this, 'showBookmarks'); 
    }

    public function editProfile(Request $request)
    {
        return UserTypesService::init(Auth::user()->user_type, $this, 'editProfile', $request->all());  
    } 

    public function showDiploms()
    {
        return UserTypesService::init(Auth::user()->user_type, $this, 'showDiploms');  
    } 

    public function updateImage(Request $request)
    {
        if ($request->hasFile('image') == false) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Изображение не выбрано']); 
        }

        $validator = Validator::make($request->all(), [
            'image' => 'file|mimes:jpeg,jpg,png|max:200000' 
        ]);
        $validator->setAttributeNames(['image' => 'Изображение']);  

        if ($validator->fails()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validator->errors()->toArray()]); 
        } 

        $file     = request()->file('image');
        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/uploads/users/', $fileName);   
        User::where('id', Auth::user()->id)->
          update([ 
            'image' => $fileName 
        ]); 

        return \App\Utils\JsonResponse::success(['reload' => true], 'Изображение успешно изменено!');
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
            return \App\Utils\JsonResponse::error(['messages' => $errors]);
        }

        $obj_user           = User::find(Auth::user()->id);
        $obj_user->password = Hash::make(request()->input('password'));
        $obj_user->save(); 

        return \App\Utils\JsonResponse::success(['redirect' => route('user_profile')], 'Пароль успешно изменен!');
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