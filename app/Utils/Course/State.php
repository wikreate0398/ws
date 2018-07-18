<?

namespace App\Utils\Course; 
use Illuminate\Support\Facades\Auth;

/**
* 
*/
class State extends Course
{   
    private $id = null;

    private $course = [];  

    public function __construct($course)
    {
        parent::__construct();
        $this->id     = @$course->id; 
        $this->course = $course;
    }   
    
    public function isFinished()
    {  
        if (dateToTimestamp(@$this->course->date_to) < dateToTimestamp(date('Y-m-d')) && @$this->course->settings_filled == 1) 
        {
            return true;
        }
    }

    public function isNotStarted()
    {
        if (dateToTimestamp($this->course->date_from) > dateToTimestamp(date('Y-m-d')) && @$this->course->settings_filled == 1) 
        {
            return true;
        }
    }

    public function isStarted()
    { 
        if (dateToTimestamp(@$this->course->date_from) <= dateToTimestamp(date('Y-m-d')) 
            && !$this->isFinished() 
            && @$this->course->settings_filled == 1) 
        {
            return true;
        }
    }

    public function canManage()
    {
        if ($this->isStarted() or $this->isFinished()) 
        {
            return false;
        }
        return true;
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

    public function ifHasUserReview($id_user=null)
    {

        if (in_array($id_user, $this->course->reviews->pluck('id_user')->toArray())) 
        {
            return true;
        } 
        return false;
    }

    public function esablishDate()
    { 
        if ($this->course->hide_after_end == 1 && !$this->request($this->course)->ifHasRequest()) 
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
        elseif ($this->course->max_nr_people > 0 
                && $this->course->max_nr_people == count($this->course->userRequests) 
                && !$this->request($this->course)->ifHasRequest()) 
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