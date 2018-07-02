<?php

namespace App\Utils\Requests; 

interface RequestInterface
{   
	public function canMakeRequest();

	public function makeRequest();
}