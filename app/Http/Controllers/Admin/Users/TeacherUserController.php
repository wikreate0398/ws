<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use App\Models\UsersEducations;
use App\Models\UsersTeachingActivities;
use App\Models\UsersWorkExperience;
use App\Models\ProgramsType;
use App\Models\GradeEducation;
use App\Models\Cities;
use App\Models\TeachActivityCategories;
use App\Models\WorkExperienceDirection;
 
class TeacherUserController extends Controller
{

    private $method = 'admin/users/teachers'; 

    private $folder = 'users.teacher';

    private $redirectRoute = 'admin_user_teacher';

    use \App\Http\Controllers\Users\Traits\TeacherTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = [
            'data'   => User::where('user_type', '2')->orderByRaw('created_at desc')->get(),
            'table'  => (new User)->getTable(),
            'method' => $this->method
        ]; 

        return view('admin.'.$this->folder.'.list', $data);
    } 

    public function showAddForm()
    {  
        return view('admin.'.$this->folder.'.add', [
            'method'          => $this->method,  
            'cities'          => Cities::orderBy('name', 'asc')->get(),
            'grade_education' => map_tree(GradeEducation::orderBy('page_up','asc')->get()->toArray()),
            'programs_type'   => map_tree(ProgramsType::orderBy('page_up','asc')->get()->toArray()),
            'teach_activ_cat' => map_tree(TeachActivityCategories::orderBy('page_up','asc')->get()->toArray()),
            'work_experience_direction' => WorkExperienceDirection::orderBy('page_up','asc')->get(),  
        ]);
    }

    private function validateInputs(array $data)
    { 
        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        return $validator;
    }

    public function createUser(Request $request)
    {
 
        $data     = $request->all();  
        $validate = $this->validation($data);
        if ($validate !== true) 
        {  
            return \App\Utils\JsonResponse::error(['messages' => $validate]); 
        } 

        $create = $this->create($data);
 
        User::where('id', $create)->
            update([ 
                'activate'     => '1',
                'confirm'      => '1', 
                'confirm_date' => date('Y-m-d H:i:s'),
        ]);

        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    public function updateUser($id, Request $request)
    {
        $edit = $this->edit($request->all(), $id);   
        if ($edit !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $edit]);  
        } 
        return \App\Utils\JsonResponse::success(['reload' => true], 'Данные успешно обновлены!'); 
    }

    public function updatePassword($id)
    { 
        $validator = Validator::make(request()->all(), [ 
            'password'              => 'required|string|min:6|confirmed|',
            'password_confirmation' => 'required',
        ]);
        $validator->setAttributeNames($this->niceNames);
  
        if ($validator->fails()) 
        {
            $errors = $validator->errors()->toArray(); 
        }  
  
        if (!empty($errors)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $errors]);
        }

        $obj_user           = User::find($id);
        $obj_user->password = Hash::make(request()->input('password'));
        $obj_user->save(); 

        return \App\Utils\JsonResponse::success(['reload' => true], 'Пароль успешно изменен!');  
    }
 
    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', [
            'method' => $this->method, 
            'user'   => User::findOrFail($id),
            'cities'          => Cities::orderBy('name', 'asc')->get(),
            'grade_education' => map_tree(GradeEducation::orderBy('page_up','asc')->get()->toArray()),
            'programs_type'   => map_tree(ProgramsType::orderBy('page_up','asc')->get()->toArray()),
            'teach_activ_cat' => map_tree(TeachActivityCategories::orderBy('page_up','asc')->get()->toArray()),
            'work_experience_direction' => WorkExperienceDirection::orderBy('page_up','asc')->get(), 
            'usersEducations' => UsersEducations::where('id_user', $id)->orderBy('from_year', 'desc')->get(),
            'usersTeachingActivities' => UsersTeachingActivities::where('id_user', $id)->orderBy('from_year', 'desc')->get(),
            'usersWorkExperience'     => UsersWorkExperience::where('id_user', $id)->orderBy('from_year', 'desc')->get(),
        ]);
    } 
}
