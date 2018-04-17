<?php

namespace App\Json;
use Illuminate\Http\Request; 
/**
* 
*/
class JsonResponse  
{
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
		if (!empty($flashMessage)) 
		{ 
			request()->session()->flash('flas_message', $flashMessage);
		} 
 
		return response()->json(['msg' => $bool] + $array); 
	}
}