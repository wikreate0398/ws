<?

namespace App\Utils\Classes;
use App\Models\Courses;

use App\Utils\Users\Requests\RequestInterface;
use App\Utils\Users\Requests\CourseRequest as CourseRequestClass;

/**
* 
*/
class CourseFacade
{   
    private $id = null;

    private $storage = null; 

    protected $_request; 

    private function courseRequest($id_user)
    {
        $this->_request = new CourseRequestClass($this->id, $id_user);
    }

    public function storage($storage)
    {
        $this->storage = $storage;
        $this->id      = @$storage->id; 
    }

    public function isFinished()
    {  
        if (dateToTimestamp($this->storage->date_to) < dateToTimestamp(date('Y-m-d'))) 
        {
            return true;
        }
    }

    public function isNotStarted()
    {
        if (dateToTimestamp($this->storage->date_from) > dateToTimestamp(date('Y-m-d'))) 
        {
            return true;
        }
    }

    public function isStarted()
    {
        if (dateToTimestamp($this->storage->date_from) <= dateToTimestamp(date('Y-m-d')) && !$this->isFinished()) 
        {
            return true;
        }
    }
}