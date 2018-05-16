<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Regions;
 
class LocationController extends Controller
{

    private $method = 'admin/location'; 

    private $folder = 'location';

    private $redirectRoute = 'admin_location';

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
    public function show(Request $request)
    {
        $request = $request->all();

        $regions = (new Regions)->newQuery();
        if (!empty($request['query'])) 
        {
            $regions->where('name', 'like', '%'.urldecode($request['query']).'%');
        }
        $regions->where('country_id', 3159)->orderByRaw('name asc');
        $regions = $regions->paginate(!empty($request['per_page']) ? $request['per_page'] : 30, 
                                      ['*'], 
                                      'page', 
                                      !empty($request['page']) ? $request['page'] : 1);
        $data = [
            'data'   => $regions,
            'table'  => (new Regions)->getTable(),
            'method' => $this->method
        ]; 
  
        return view('admin.'.$this->folder.'.regions', $data);
    } 
 
    public function showCities($id, Request $request)
    {
        $request = $request->all();

        $cities = (new Cities)->newQuery();
        if (!empty($request['query'])) 
        {
            $cities->where('name', 'like', '%'.urldecode($request['query']).'%');
        }
        $cities->where('region_id', $id)->orderByRaw('name asc');
        $cities = $cities->paginate(!empty($request['per_page']) ? $request['per_page'] : 30, 
                                      ['*'], 
                                      'page', 
                                      !empty($request['page']) ? $request['page'] : 1);
        $data = [
            'data'   => $cities,
            'table'  => (new Cities)->getTable(),
            'method' => $this->method . '/' . $id . '/cities/',
            'crumbs' => '<li>
                           <a href="javascript:;" style="text-decoration:none; cursor:pointer;">Города</a>
                        </li>'
        ]; 
  
        return view('admin.'.$this->folder.'.cities', $data);
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
