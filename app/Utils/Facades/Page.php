<?php

namespace App\Utils\Facades;  
use Illuminate\Support\Facades\Facade; 

/**
* 
*/
class Page extends Facade
{  
	protected static function getFacadeAccessor() { return 'page'; } 
}