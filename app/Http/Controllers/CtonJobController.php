<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CtonJobController extends Controller
{
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
    public function index() {}

    public function updateNewUsers() { 
        \App\Models\User::where('new', '1')->update(['new'=>'0']);
    }
}
