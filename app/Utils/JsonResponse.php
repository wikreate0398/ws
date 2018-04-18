<?php

namespace App\Utils;
use Illuminate\Http\Request; 
/**
* 
*/
class JsonResponse  
{

	private static $flas_message = 'flash_message';

	function __construct() {} 

	static function success($array = [], $flashMessage = false)
	{  
        return self::showResponse(true, $array, $flashMessage); 
	}

	static function error($array = [], $flashMessage = false)
	{  
        return self::showResponse(false, $array, $flashMessage); 
	}

	static function showResponse($bool, $array, $flashMessage = false)
	{

		if (request()->segment('1') == 'admin') 
		{
			self::$flas_message = 'admin_flash_message';
		}

		if (!empty($flashMessage)) 
		{ 
			request()->session()->flash(self::$flas_message, $flashMessage);
		} 
 
		return response()->json(['msg' => $bool] + $array); 
	}
}