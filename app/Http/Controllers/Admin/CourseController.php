<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseCategory;

 
class CourseController extends Controller
{

    private $method = 'admin/course/category'; 

    private $folder = 'course';

    private $redirectRoute = 'admin_course_category';

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
            'data'   => CourseCategory::orderByRaw('page_up asc, id desc')->get(),
            'table'  => (new CourseCategory)->getTable(),
            'method' => $this->method
        ]; 

        return view('admin.'.$this->folder.'.list', $data);
    } 

    public function showAddForm()
    {
        return view('admin.'.$this->folder.'.add', ['method' => $this->method]);
    }

    public function create(Request $request)
    {
        $input        = $request->all(); 
        $input['url'] = !empty($input['url']) ? str_slug($input['url'], '-') : str_slug($input['name'], '-'); 
        CourseCategory::create($input);
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', ['method' => $this->method, 'data' => CourseCategory::findOrFail($id)]);
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
