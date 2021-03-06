<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers\Users;

use App\Models\User;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;  
use App\Utils\Course\Course;

class ProfileController extends Controller
{ 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {

    }   

    public function editProfile(Request $request)
    { 
        $edit = $this->_user->edit($request->all(), Auth::user()->id);   
        if ($edit !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $edit]);  
        } 
        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('user_profile'))], 'Данные успешно обновлены!'); 
    } 

    public function deleteCertificate(Request $request)
    {
        $id = $request->input('id');
        \App\Models\UsersCertificates::whereId($id)->where('id_user', Auth::user()->id)->delete();
    }  

    public function deleteCourseCertificate(Request $request, Course $course)
    {   
        $id = $request->input('id'); 
        $crudFactory = $course->crud($id, Auth::user()); 
        if ($crudFactory->hasAccessCertificate($id)) 
        {  
            \App\Models\CoursesCertificates::whereId($id)->delete();
        }
    }

    public function deleteCourseSection(Request $request, Course $course)
    { 
        $course->setUserId(Auth::user()->id);
        $id_section = intval($request->input('id_section'));  
        if ($course->hasAccessSection($id_section)) 
        {
            $course->deleteSection($id_section);
            return \App\Utils\JsonResponse::success();
        } 
    }

    public function deleteCourseSectionLecture(Request $request, Course $course)
    { 
        $id_lecture = intval($request->input('id_lecture'));  
        $course->setUserId(Auth::user()->id); 
        if ($course->hasAccessLecture($id_lecture)) 
        {
            $course->deleteLecture($id_lecture);
            return \App\Utils\JsonResponse::success(); 
        } 
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

        $avatarbase64    = $request->input('avatar');
        $avatarImageName = '';
        if (!empty($avatarbase64)) 
        {
            $avatarImageName = 'user-' . Auth::user()->id . '-' . md5(microtime()) . '.png';
            $avatarImagePath = public_path() . '/uploads/users/' . $avatarImageName;  
            uploadBase64($avatarbase64, $avatarImagePath); 
        }

        User::where('id', Auth::user()->id)->
          update([ 
            'image'  => $fileName ,
            'avatar' => $avatarImageName
        ]); 

        return \App\Utils\JsonResponse::success(); // ['reload' => true], 'Изображение успешно изменено!'
    }

    public function loadCourseSubcats(Request $request)
    { 
        $id        = $request->input('id'); 
        $id_subcat = @$request->input('id_subcat'); 

        if (empty($id)) die();
        $subcats = \App\Models\CourseCategory::where('parent_id', intval($id))->get();
 
        $content = '';
        if (count($subcats) > 0) 
        { 
            $content .= '<select name="subcat_id"  class="form-control">
                         <option value="">Выбрать</option>';
            foreach ($subcats as $item)
            {
                $selected = ($id_subcat == $item['id']) ? 'selected' : '';
                $content .= '<option '.$selected.' value="'.$item['id'].'">'.$item['name'].'</option>';
            }
            $content .= '</select>';
        }
        echo $content;
    }  

    public function changeStatus(Request $request)
    {
        $status = $request->input('status'); 
        $obj_user               = User::find(Auth::user()->id);
        $obj_user->is_available = ($status == 'true') ? '1' : '0'; 
        $obj_user->save();  
        return \App\Utils\JsonResponse::success();
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

    public function deleteDepartment($id)
    {
        \App\Models\UniversityDepartment::where('id', $id)->where('id_university', Auth::user()->id)->delete();
        return redirect()->back()->with('flash_message', 'Отдел успешно удален');
    }

    public function deleteUploadMaterial(Request $request)
    {
        $id        = $request->input('id');
        $materials = \App\Models\SectionLecturesMaterials::whereId($id)->first();
        if ($materials) 
        {
            \File::delete('uploads/courses/materials/' . $materials['material']);
        } 
        $materials->delete();
    }
}