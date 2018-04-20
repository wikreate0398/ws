<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Users\UserTypes\UserTypesInterface;
use Illuminate\Support\Facades\Auth;

/**
* 
*/
class UserService
{
	
	private static $userTypes = [
        '1' => \App\Http\Controllers\Users\UserTypes\PupilUser::class,
        '2' => \App\Http\Controllers\Users\UserTypes\TeacherUser::class,
        '3' => \App\Http\Controllers\Users\UserTypes\UniversityUser::class,
    ]; 
	
	function __construct() {}

	static public function init($user_type)
	{  
		return self::call((new self::$userTypes[$user_type]()));
	}

	static private function call(UserTypesInterface $userTypeInterface)
	{ 
		return $userTypeInterface;
	}
}