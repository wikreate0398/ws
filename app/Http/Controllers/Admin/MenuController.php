<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;

 
class MenuController extends Controller
{

    private $method = 'admin/menu'; 

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
            'menu'   => Menu::orderByRaw('page_up asc, id desc')->get(),
            'table'  => (new Menu)->getTable(),
            'method' => $this->method
        ]; 

        return view('admin.menu.list', $data);
    } 

    public function showAddForm()
    {
        return view('admin.menu.add', ['method' => $this->method]);
    }

    public function create(Request $request)
    {
        $input        = $request->all(); 
        $input['url'] = !empty($input['url']) ? str_slug($input['url'], '-') : str_slug($input['name'], '-'); 
        Menu::create($input);
        return \App\Utils\JsonResponse::success(['redirect' => route('admin_menu')], trans('admin.save')); 
    }

    public function showeditForm($id)
    { 
        return view('admin.menu.edit', ['method' => $this->method, 'data' => Menu::findOrFail($id)]);
    }

    public function update($id, Request $request)
    { 
        $data         = Menu::findOrFail($id); 
        $input        = $request->all(); 
        if ($data['page_type'] != 'home') 
        {
            $input['url'] = !empty($input['url']) ? str_slug($input['url'], '-') : str_slug($input['name'], '-'); 
        } 

        $data->fill($input)->save(); 
        return \App\Utils\JsonResponse::success(['redirect' => route('admin_menu')], trans('admin.save')); 
    } 
}
