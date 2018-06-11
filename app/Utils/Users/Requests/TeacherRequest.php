<?php

namespace App\Utils\Users\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;   
use App\Models\TeacherRequest as TeacherRequestModel;
use App\Utils\Users\Requests\RequestInterface;
use App\Mail\TeacherRequestMail; 
use Illuminate\Support\Facades\Mail;

class TeacherRequest implements RequestInterface
{

    private static $instance;

    public $id_teacher  = null;

    public $id_user     = null; 

    public $user_type   = null;

    private $teacherData = [];
     
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {} 

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    } 

    public function setIdTeacher($id_teacher)
    {
        $this->id_teacher = $id_teacher;
        return $this;
    }

    public function setIdUser($id_user = null)
    { 
        $this->id_user = $id_user;
        return $this;
    }

    public function setUserType($type = null)
    { 
        $this->user_type = $type;
        return $this;
    }
 
    public function getTeacher()
    {
        if (empty($this->teacherData))  
        { 
            $this->teacherData = User::where(function($query){
                return User::allowUser($query);
            })->findOrFail($this->id_teacher);
        } 
        return $this->teacherData;
    }

    public function canMakeRequest()
    {  
        if ($this->id_user && $this->getTeacher() && $this->user_type == 1) 
        { 
            if ($this->ifSelfUser() == true) 
            {
                return 'Вы не можете оставить заявку';
            }

            if ($this->ifHasRequest() == true) 
            {
                return 'Вы уже оставляли заявку для этого учителя';
            }

            return true;
        }

        return 'Ошибка';
    }

    public function ifSelfUser()
    {
        if ($this->id_user == $this->id_teacher) 
        {
            return true;
        }
    }

    public function ifHasRequest()
    {
        if (in_array($this->id_user, $this->getTeacher()->teacherRequests->pluck('id')->toArray()) == true) 
        {
            return true;
        }
    }

    public function makeRequest()
    {
        TeacherRequestModel::create([
          'id_teacher' => $this->id_teacher,
          'id_user'    => $this->id_user
        ]);
    }
    
    public function sendNotification()
    {
        Mail::to($this->getTeacher()->email)->send(new TeacherRequestMail($this->getTeacher()));
    }
}
