<?php

namespace App\Http\Controllers\Admin\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\Users\FastRegistration;
use App\Models\User;

class SiteUser extends Controller
{

	protected $_fastRegister;
	
	function __construct()
	{
		$this->_fastRegister = new FastRegistration;
	}

	public function fastRegister(Request $request)
    {
        $input = $request->all();  
        $this->_fastRegister->setUserType($input['user_type']);
        $this->_fastRegister->setRequestData($input); 
        if ($this->_fastRegister->validationData($input) !== true) 
        {
            return $this->_fastRegister->getError();
        } 

        $user = $this->_fastRegister->register();
        User::where('id', $user['id'])->
            update([ 
                'activate'     => '1',
                'confirm'      => '1', 
                'confirm_date' => date('Y-m-d H:i:s'),
        ]);

        return \App\Utils\JsonResponse::success(['message' => 'Пользователь успешно добавлен!']);
    }
}