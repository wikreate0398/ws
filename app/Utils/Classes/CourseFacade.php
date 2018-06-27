<?

namespace App\Utils\Classes;
use App\Models\Courses;

use App\Utils\Users\Requests\RequestInterface;
use App\Utils\Users\Requests\CourseRequest as CourseRequestClass;
use Illuminate\Support\Facades\Auth;

/**
* 
*/
class CourseFacade
{   
    private $id = null;

    private $course = []; 

    protected $_request = null; 

    public $ids = [];

    public function _requestInstance($authUserId = null)
    { 
        $authUserId = $authUserId ? $authUserId : @Auth::user()->id;
        if ($this->_request != null && $this->id == $this->_request->getCourse()->id) 
        { 
            return $this->_request;
        }   
        $this->_request = new CourseRequestClass($this->id, $authUserId);
        return $this->_request;
    }
  
    public function setId($id)
    { 
        $this->id = $id; 
        $this->course = Courses::whereId($id)->first();
        return $this;
    }

    public function isFinished()
    {  
        if (dateToTimestamp($this->course->date_to) < dateToTimestamp(date('Y-m-d'))) 
        {
            return true;
        }
    }

    public function isNotStarted()
    {
        if (dateToTimestamp($this->course->date_from) > dateToTimestamp(date('Y-m-d'))) 
        {
            return true;
        }
    }

    public function isStarted()
    {
        if (dateToTimestamp($this->course->date_from) <= dateToTimestamp(date('Y-m-d')) && !$this->isFinished()) 
        {
            return true;
        }
    }

    public function ifCourseHide()
    { 
        $today        = dateToTimestamp(date('Y-m-d')); 
        $is_open_from = dateToTimestamp($this->course->is_open_from);
        $is_open_to   = dateToTimestamp($this->course->is_open_to);

        if ($this->course->hide_after_end == '1' && $today > $is_open_to) 
        {
            return true;
        } 
        return false;
    } 

    public function esablishDate()
    { 
        if ($this->course->hide_after_end == 1 && !$this->_requestInstance()->ifHasRequest()) 
        {
            if ($this->course->max_nr_people > count($this->course->userRequests) 
                                        && dateToTimestamp($this->course->is_open_to) > dateToTimestamp(date('Y-m-d'))) 
            {
                $status = 'идет набор до';
                $date   = date('d.m.Y', strtotime($this->course->is_open_to));
            }
            else
            {
                $status = 'Набор закончен';
                $date   = '';
            }
        }
        elseif ($this->course->max_nr_people == count($this->course->userRequests) && !$this->_requestInstance()->ifHasRequest()) 
        {
            $status = 'Набор закончен';
            $date   = '';
        }
        else
        {
            if ($this->isFinished()) 
            {
                $status = 'Завершен';
                $date   = date('d.m.Y', strtotime($this->course->date_to));
            }
            elseif($this->isNotStarted())
            {
                $status = 'Начнется';
                $date   = date('d.m.Y', strtotime($this->course->date_from));
            }
            else
            {
                $status = 'Начат с';
                $date   = date('d.m.Y', strtotime($this->course->date_from));
            }
        }

        if ($this->course->program_filled !=1) {
            $status=$date='';
        }

        return ['status' => $status, 'date' => $date];
    }
}