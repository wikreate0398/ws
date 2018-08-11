<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
 
class NewsCategoriesController extends Controller
{

    private $method = 'admin/news/category'; 

    private $folder = 'news.category';

    private $redirectRoute = 'admin_nw_cat';

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
            'data'   => NewsCategory::orderByRaw('page_up asc, id desc')->get(),
            'table'  => (new NewsCategory)->getTable(),
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
        NewsCategory::create($input);
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', ['method' => $this->method, 'data' => NewsCategory::findOrFail($id)]);
    }

    public function update($id, Request $request)
    { 
        $data         = NewsCategory::findOrFail($id); 
        $input        = $request->all(); 
        $input['url'] = !empty($input['url']) ? str_slug($input['url'], '-') : str_slug($input['name'], '-');        
        $data->fill($input)->save(); 
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    } 
}
