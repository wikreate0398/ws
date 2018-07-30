<?php

namespace App\Utils\Requests;
  
use App\Utils\Requests\RequestInterface;
use App\Mail\CourseRequestMail; 
use Illuminate\Support\Facades\Mail;
use App\Utils\Course\Course;

class CourseRequest implements RequestInterface
{
    private $id_course    = null;

    private $auth_user    = []; 
    
    private $course       = [];

    private $error        = null;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */ 
    public function __construct($course, $auth_user = null)
    { 
        $this->course    = $course;
        $this->auth_user = $auth_user; 
        $this->course_facade = new Course;
    } 

    public function canMakeRequest()
    {  
        if (@$this->auth_user->id && $this->course) 
        { 
            if ($this->ifSelfCourse() == true 
                or $this->auth_user->user_type != 1 
                or $this->course_facade->manager($this->course)->isStarted() 
                or $this->course_facade->manager($this->course)->isFinished()) 
            { 
                $this->setError('Вы не можете записаться на этот курс');
                return false;
            }

            if ($this->ifHasRequest() == true) 
            { 
                $this->setError('Вы уже записаны на этот курс');
                return false;
            } 

            if (!empty($this->course->max_nr_people) && $this->course->max_nr_people == count($this->course->userRequests)) 
            { 
                $this->setError('Запись на курс ограничена');
                return false;
            }  

            $today        = dateToTimestamp(date('Y-m-d')); 
            $is_open_from = dateToTimestamp($this->course->is_open_from);
            $is_open_to   = dateToTimestamp($this->course->is_open_to);

            if (!empty($this->course->hide_after_end))
            { 
                if ($today < $is_open_from or $today > $is_open_to) 
                { 
                    $this->setError('Курс не доступен для записи');
                    return false;
                } 
            } 
            return true;
        }
        $this->setError('Ошибка');
        return false;
    }  

    public function ifSelfCourse()
    {
        if ($this->auth_user->id == $this->course->user->id) 
        {
            return true;
        }
    }

    public function ifHasRequest()
    { 
        if (in_array(@$this->auth_user->id, @$this->course->userRequests->pluck('id')->toArray()) == true) 
        {
            return true;
        }
    }

    public function makeRequest()
    {
        \App\Models\CourseRequest::create([
            'id_course' => $this->course->id,
            'id_user'   => $this->auth_user->id
        ]);
        $this->sendNotification();
    }
    
    public function sendNotification()
    {
        Mail::to($this->course->user->email)->send(new CourseRequestMail($this->course));
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }
}
