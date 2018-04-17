<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Menu;

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
    public function index()
    {
        $data = [
            'menu'   => Menu::all(),
            'table'  => (new Menu)->getTable(),
            'method' => $this->method
        ]; 

        return view('admin.menu.list', $data);
    }

    public function sortable(Request $request)
    {
        exit(print_arr($request->all()));
    }
}
