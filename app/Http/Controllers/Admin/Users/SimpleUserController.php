<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cities;
 
class SimpleUserController extends Controller
{

    private $method = 'admin/users/disciple'; 

    private $folder = 'users.user';

    private $redirectRoute = 'admin_user_disciple';

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

    public function create(Request $request)
    {
        $data   = $request->all();  
        $errors = $this->validateInputs($data); 
        if ($errors->fails()) 
        {  
            return \App\Utils\JsonResponse::error(['messages' => $errors->errors()->toArray()]); 
        } 

        User::create([ 
            'name'         => $data['name'],
            'surname'      => $data['surname'],
            'patronymic'   => $data['patronymic'],
            'date_birth'   => date('Y-m-d', strtotime($data['date_birth'])),
            'user_type'    => 1,
            'phone'        => $data['phone'],
            'email'        => $data['email'], 
            'city'         => $data['city'],
            'phone'        => $data['phone'], 
            'site'         => $data['site'],
            'image'        => $this->saveImage(),
            'activate'     => '1',
            'confirm'      => '1',
            'confirm_date' => date('Y-m-d H:i:s'),
            'password'     => bcrypt($data['password'])
        ]); 

        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    public function updatePassword($id)
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

        $user = User::findOrFail($id);

        if(Hash::check(request()->input('old_password'), $user->password) == false) {
            $errors[]['password'] = 'Старый пароль не верный';
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
