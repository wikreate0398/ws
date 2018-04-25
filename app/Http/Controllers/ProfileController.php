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
use App\Http\Controllers\Users\UserService;

class ProfileController extends Controller
{ 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}  
 
    public function showCourse()
    {   
        return UserService::init(Auth::user()->user_type)->showCourse();  
    } 

    public function showEditForm()
    { 
        return UserService::init(Auth::user()->user_type)->showEditForm(); 
    }

    public function showSubscriptions()
    {
        return UserService::init(Auth::user()->user_type)->showSubscriptions();  
    }

    public function showReviews()
    {
        return UserService::init(Auth::user()->user_type)->showReviews();  
    }

    public function showBookmarks()
    {
        return UserService::init(Auth::user()->user_type)->showBookmarks();  
    }

    public function editProfile(Request $request)
    {
        $edit = UserService::init(Auth::user()->user_type)->edit($request->all(), Auth::user()->id);   
        if ($edit !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $edit]);  
        } 
        return \App\Utils\JsonResponse::success(['reload' => true], 'Данные успешно обновлены!'); 
    } 

    public function showDiploms()
    {
        return UserService::init(Auth::user()->user_type)->showDiploms();  
    } 

    public function showCourseForm()
    {
        return UserService::init(Auth::user()->user_type)->showCourseForm();  
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

        $fileName = UserService::init(Auth::user()->user_type)->uploadImage();   
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
        $validator->setAttributeNames([
            'password'         => 'Пароль',
            'repeat_password'  => 'Повторите пароль',
            'old_password'     => 'Старый Пароль'
        ]);
  
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

        return \App\Utils\JsonResponse::success(['reload' => true], 'Пароль успешно изменен!');
    }

    public function deleteUserEducation($id)
    { 
        \App\Models\UsersEducations::where('id', $id)->where('id_user', Auth::user()->id)->delete();
        return redirect()->back()->with('flash_message', 'Образование успешно удалено');
    } 

    public function deleteUserActivities($id)
    { 
        \App\Models\UsersTeachingActivities::where('id', $id)->where('id_user', Auth::user()->id)->delete();
        return redirect()->back()->with('flash_message', 'Преподовательская деятельность успешно удалена');
    } 

    public function deleteUserExperience($id)
    { 
        \App\Models\UsersWorkExperience::where('id', $id)->where('id_user', Auth::user()->id)->delete();
        return redirect()->back()->with('flash_message', 'Трудовая деятельность успешно удалена');
    } 
}