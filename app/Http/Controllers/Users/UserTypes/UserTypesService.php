<?php

namespace App\Http\Controllers\Users\UserTypes;

use App\Http\Controllers\Users\UserTypes\UserTypesInterface;

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

	static public function init($userType, $class, $method, $params = false)
	{  
		return self::call((new self::$userTypes[$userType]($class)), $method, $params);
	}

	static private function call(UserTypesInterface $userTypeInterface, $method, $params = false)
	{ 
		return $userTypeInterface->$method($params);
	}
}