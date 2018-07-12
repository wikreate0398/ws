<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User; 

class AjaxController extends Controller
{ 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}
  
    public function loadRegionCities(Request $request)
    {  
        $id        = $request->input('id');   
        $id_city   = $request->input('id_city');   
        if (empty($id)) die();
        $cities = \App\Models\Cities::where('region_id', intval($id))->get();
 
        $content = '';
        if (count($cities) > 0) 
        { 
            $content .= '<div class="form-group select_form"><select name="city" class="form-control select2">
                         <option value="">Город</option>';
            foreach ($cities as $item)
            {
                $selected = ($id_city == $item['id']) ? 'selected' : '';
                $content .= '<option '.$selected.' value="'.$item['id'].'">'.$item['name'].'</option>';
            }
            $content .= '</select> </div>';
        }
        echo $content;
    } 
}
