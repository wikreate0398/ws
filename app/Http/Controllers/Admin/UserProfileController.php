<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
 
class UserProfileController extends Controller
{

    private $method = 'admin/user-profile'; 

    private $folder = 'user_profile';

    private $redirectRoute = 'admin_user_profile';

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
        $programs_type        = DB::table('programs_type')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get();
        $degree_experience    = DB::table('degree_experience')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get();
        $specializations_list = DB::table('specializations_list')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get();
        $subjects             = DB::table('subjects')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get();
        $lesson_options_list  = DB::table('lesson_options_list')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get();
        $data = [
            // 'menu'   => Menu::orderByRaw('page_up asc, id desc')->get(),
            // 'table'  => (new Menu)->getTable(),
            'method'               => $this->method,
            'programs_type'        => collect($programs_type)->map(function($x){ return (array) $x; })->toArray(),
            'degree_experience'    => collect($degree_experience)->map(function($x){ return (array) $x; })->toArray(),
            'specializations_list' => collect($specializations_list)->map(function($x){ return (array) $x; })->toArray(),
            'subjects'             => collect($subjects)->map(function($x){ return (array) $x; })->toArray(), 
            'lesson_options_list'  => collect($lesson_options_list)->map(function($x){ return (array) $x; })->toArray(), 
        ];    

        return view('admin.' . $this->folder . '.list', $data);
    }

    public function create(Request $request)
    { 
        $input = $request->all();   
        DB::table($input['tbname'])->insert($input['data']); 
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    }

    public function showeditForm($id, $table)
    {  
        $get  = DB::table($table)->whereId($id)->first();
        $data = json_decode(json_encode($get),true); 
        return view('admin.' . $this->folder . '.edit', ['method' => $this->method, 'table' => $table, 'data' => $data]);
    }

    public function update($id, $table, Request $request)
    { 
        $input = $request->all(); 
        DB::table($table)->whereId($id)->update($input['data']);  
        return \App\Utils\JsonResponse::success(['redirect' => route($this->redirectRoute)], trans('admin.save')); 
    } 
}
