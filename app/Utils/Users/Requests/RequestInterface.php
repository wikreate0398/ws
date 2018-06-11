<?php

namespace App\Utils\Users\Requests; 

interface RequestInterface
{   
	public function canMakeRequest();

	public function makeRequest();
}