<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cities;
 
class PupilUserController extends Controller
{

    private $method = 'admin/users/pupil'; 

    private $folder = 'users.user';

    private $redirectRoute = 'admin_user_pupil';

    use \App\Http\Controllers\Users\Traits\PupilTrait;

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
            'data'   => User::where('user_type', '1')->orderByRaw('created_at desc')->get(),
            'table'  => (new User)->getTable(),
            'method' => $this->method
        ]; 

        return view('admin.'.$this->folder.'.list', $data);
    } 

    public function showAddForm()
    {
        return view('admin.'.$this->folder.'.add', [
            'method' => $this->method,
            'cities' => Cities::orderBy('name', 'asc')->get(), 
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

    public function saveImage()
    { 
        $fileName = '';
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/uploads/users/', $fileName);    
        } 
        return $fileName;
    }

    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', [
            'method' => $this->method, 
            'user'   => User::findOrFail($id),
            'cities' => Cities::orderBy('name', 'asc')->get()
        ]);
    }

    public function update($id, Request $request)
    { 
        $data         = CourseCategory::findOrFail($id); 
        $input        = $request->all(); 
        if ($request->has('url') )
        {
            $input['url'] = str_slug($input['url'], '-'); 
        }         
        $data->fill($input)->save(); 
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    } 
}
