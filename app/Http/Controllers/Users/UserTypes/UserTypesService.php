<?php

namespace App\Http\Controllers\Users\UserTypes;

use App\Http\Controllers\Users\UserTypes\UserTypesInterface;
use Illuminate\Support\Facades\Auth;

/**
* 
*/
class UserTypesService
{

	private static $userTypes = [
        '1' => \App\Http\Controllers\Users\UserTypes\SimpleUser::class,
        '2' => \App\Http\Controllers\Users\UserTypes\TeacherUser::class,
        '3' => \App\Http\Controllers\Users\UserTypes\UniversityUser::class,
    ]; 
	
	function __construct() {}

	static public function init($user_type, $class, $method, $params = false)
	{  
		return self::call((new self::$userTypes[$user_type]($class)), $method, $params);
	}

	static private function call(UserTypesInterface $userTypeInterface, $method, $params = false)
	{ 
		return $userTypeInterface->$method($params);
	}
}