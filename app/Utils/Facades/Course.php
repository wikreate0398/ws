<?php

namespace App\Utils\Facades;  
use Illuminate\Support\Facades\Facade; 

/**
* 
*/
class Course extends Facade
{  
	protected static function getFacadeAccessor() { return 'course'; } 
}