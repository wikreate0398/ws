<?php

namespace App\Utils;
use Illuminate\Http\Request;
use \App\Models\Menu;

/**
* 
*/
class Page  
{

	function __construct() {}

	public function top()
	{
		return Menu::where('view_top', '1')->get();
	}

	public function bottom()
	{
		return Menu::where('view_bottom', '1')->get();
	}

	public function active($url)
	{ 
		(request()->segment(1) == $url) ? true : false;
	}

	public function meta($url)
	{
		return Menu::where('url', $url)->first();
	}
}