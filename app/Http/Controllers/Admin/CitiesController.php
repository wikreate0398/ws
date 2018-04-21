<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cities;

 
class CitiesController extends Controller
{

    private $method = 'admin/cities'; 

    private $folder = 'cities';

    private $redirectRoute = 'admin_cities';

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
            'data'   => Cities::orderByRaw('name asc')->get(),
            'table'  => (new Cities)->getTable(),
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
        $input = $request->all();  
        Cities::create($input);
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', ['method' => $this->method, 'data' => Cities::findOrFail($id)]);
    }

    public function update($id, Request $request)
    { 
        $data         = Cities::findOrFail($id); 
        $input        = $request->all(); 
        if ($request->has('url') )
        {
            $input['url'] = str_slug($input['url'], '-'); 
        }         
        $data->fill($input)->save(); 
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    } 
}
