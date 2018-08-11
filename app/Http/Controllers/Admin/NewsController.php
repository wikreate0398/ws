<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use App\Models\News;
 
class NewsController extends Controller
{
    private $method = 'admin/news/articles'; 

    private $folder = 'news.articles';

    private $redirectRoute = 'admin_news';

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
            'data'   => NewsCategory::has('news')->with('news')->get(), 
            'table'  => (new News)->getTable(),
            'method' => $this->method
        ]; 

        //exit(print_arr($data['data']->toArray()));
        return view('admin.'.$this->folder.'.list', $data);
    } 

    public function showAddForm()
    {
        return view('admin.'.$this->folder.'.add', [
            'method' => $this->method,
            'table'      => (new News)->getTable(),
            'categories' => NewsCategory::orderByRaw('page_up asc, id desc')->get()
        ]);
    }

    public function create(Request $request)
    {
        if (empty($request->input('data.id_category')))
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Укажите категорию']); 
        }
        $input        = $request['data']; 
        $input['url'] = !empty($input['url']) ? str_slug($input['url'], '-') : str_slug($input['name'], '-');
        $id           = News::create($input)->id;

        if ($request->hasFile('image') != false) 
        { 
            $this->uploadFile($request->file('image'), $id); 
        }  
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    private function uploadFile($file, $id)
    { 
        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
        $file->move(public_path() . '/uploads/news/', $fileName);  
        News::whereId($id)->update(['image' => $fileName]);
    }

    public function showeditForm($id)
    { 
        return view('admin.'.$this->folder.'.edit', [
            'method'     => $this->method, 
            'data'       => News::findOrFail($id),
            'table'      => (new News)->getTable(),
            'categories' => NewsCategory::orderByRaw('page_up asc, id desc')->get()
        ]);
    }

    public function update($id, Request $request)
    { 
        if (empty($request->input('data.id_category')))
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Укажите категорию']); 
        }

        $data         = News::findOrFail($id); 
        $input        = $request['data']; 
        $input['url'] = !empty($input['url']) ? str_slug($input['url'], '-') : str_slug($input['name'], '-');      
        $data->fill($input)->save(); 

        if ($request->hasFile('image') != false) 
        { 
            $this->uploadFile($request->file('image'), $id); 
        } 
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    } 
}
