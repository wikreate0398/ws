<?php

namespace App\Utils\Users\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Courses;  
use App\Models\CourseRequest as CourseRequestModel;
use App\Utils\Users\Requests\RequestInterface;
use App\Mail\CourseRequestMail; 
use Illuminate\Support\Facades\Mail;

class CourseRequest implements RequestInterface
{
    private $id_course  = null;

    private $id_user    = null; 

    private $courseData = [];
     
    /**
     * Create a new controller instance.
     *
     * @return void
     */ 
    public function __construct($id_course, $id_user = null)
    {
        $this->id_course = $id_course;
        $this->id_user   = $id_user; 
    }

    public function getCourse()
    {
        if (empty($this->courseData))  
        { 
            $this->courseData = Courses::getOneCourse($this->id_course, $this->id_user);
        } 
        return $this->courseData;
    }

    public function canMakeRequest()
    {  
        if ($this->id_user && $this->getCourse()) 
        { 
            if ($this->ifSelfCourse() == true) 
            {
                return 'Вы не можете записаться на этот курс';
            }

            if ($this->ifHasRequest() == true) 
            {
                return 'Вы уже записаны на этот курс';
            }

            return true;
        }

        return 'Ошибка';
    }

    public function ifSelfCourse()
    {
        if ($this->id_user == $this->getCourse()->user->id) 
        {
            return true;
        }
    }

    public function ifHasRequest()
    { 
        if (in_array($this->id_user, $this->getCourse()->userRequests->pluck('id')->toArray()) == true) 
        {
            return true;
        }
    }

    public function makeRequest()
    {
        CourseRequestModel::create([
            'id_course' => $this->id_course,
            'id_user'   => $this->id_user
        ]);
    }
    
    public function sendNotification()
    {
        Mail::to($this->getCourse()->user->email)->send(new CourseRequestMail($this->getCourse()));
    }
}
