<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
 
class AjaxController extends Controller
{ 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}
  
    public function depthSort(Request $request)
    { 
        $arr   = $request->input('arr'); 
        $table =  $_POST['table'];  
        foreach ($arr as $key => $value) 
        { 
           $data[] = $value; 
           $this->sort($data, 0, $table);  
        }

        return \App\Utils\JsonResponse::success(['message' => trans('admin.ajax_true')]); 
    }

    private function sort($arr, $parent = 0, $table)
    {
        $i     = 1;
        foreach ($arr as $item) 
        {
            DB::table($table)->where('id', $item['id'])
                              ->update(['parent_id' => $parent, 'page_up' => $i]);

            if (!empty($item['children'])) 
            { 
                $this->sort($item['children'], $item['id'], $table);
            }  
            $i++;
        }   
    }

    public function viewElement(Request $request)
    {
        $id    = $request->input('id');
        $table = $request->input('table'); 
        $row   = $request->has('row') ? $request->input('row') : 'view'; 
        
        $query = DB::table($table)->where('id', $id)->first();  
        DB::table($table)->where('id', $id)
                         ->update(["{$row}" => !empty($query->$row) ? '0' : '1']); 
        return \App\Utils\JsonResponse::success(['message' => trans('admin.ajax_true')]);  
    }     

    public function deleteElement(Request $request)
    {
        $id    = $request->input('id');
        $table = $request->input('table'); 
        DB::table($table)->where('id', $id)->delete();  
        return \App\Utils\JsonResponse::success(['message' => trans('admin.delete_true')]);
    }
}
