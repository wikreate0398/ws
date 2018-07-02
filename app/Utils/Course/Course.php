<?php

namespace App\Utils\Course; 
use Illuminate\Support\Facades\Auth;  
use App\Utils\Requests\RequestInterface;
use App\Utils\Requests\CourseRequest;

/**
* 
*/
class Course
{ 

	public function __construct() {}

	public function manager($course)
	{
		return new State($course);
	}

	public function request($course, $authUser = null)
	{
		$authUser = $authUser ? $authUser : @Auth::user();
		return new CourseRequest($course, $authUser);
	}

	public function crud($id_course = null, $authUser = null)
	{
		$authUser = $authUser ? $authUser : @Auth::user();
		return new Crud($id_course, $authUser);
	}

	public function generatePrice($course)
	{
		if (!empty($course['discount_percent'])) 
		{
			return $course['price'] - (($course['discount_percent']/100)*$course['price']);
		}
		elseif (!empty($course['discount_price'])) 
		{
			return $course['price'] - $course['discount_price'];
		}
		else
		{
			return $course['price'];
		}
	}
}