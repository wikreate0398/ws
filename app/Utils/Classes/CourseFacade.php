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

    public function _requestInstance($authUserId = null)
    {
        $authUserId = $authUserId ? $authUserId : @Auth::user()->id;
        if ($this->_request != null) 
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
}