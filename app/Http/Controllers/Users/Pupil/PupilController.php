<?php
 
namespace App\Http\Controllers\Users\Pupil;

use App\Models\User; 
use App\Models\Regions;
use App\Models\CourseReviews;
use App\Models\TeacherReviews;
use \App\Models\UniversityReviews;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
 
use App\Http\Controllers\Users\ProfileController;
use App\Utils\Users\Pupil\User as PupilUser;
 
 
class PupilController extends ProfileController  
{
    public $viewPath = 'users.profile_types.user.';  

	function __construct() 
    {
        $this->_user = new PupilUser;
    }
    
    public function showCourse()
    {  
        $data = [ 
            'user'          => Auth::user(),  
            'include'       => $this->viewPath . 'courses', 
            'scripts' => [
                'js/courses.js'
            ]
        ]; 
        return view('users.user_profile', $data); 
    }

    public function showEditForm()
    { 
        return view('users.user_profile', [
            'regions' => Regions::where('country_id', 3159)->orderBy('name', 'asc')->get(), 
            'user'    => Auth::user(), 
            'include' => $this->viewPath . 'edit'
        ]); 
    }

    public function showReviews()
    {
        switch (request()->p) {
            case 'courses':
                $page = 'courses';
                break;

            case 'teachers':
                $page = 'teachers';
                break;

            default:
                $page = 'university';
                break;
        }

        $data = [
            'user'    => Auth::user(),
            'include' => $this->viewPath . 'reviews',
            'page'    => 'users.profile_types.user.reviews.' . $page,
        ];

        return view('users.user_profile', $data);
    }

    public function reviewDelete($id)
    {
        $type = \request()->type;
        if ($type == 'teacher')
        {
            TeacherReviews::whereId($id)->delete();
        }
        elseif($type == 'course')
        {
            CourseReviews::whereId($id)->delete();
        }
        elseif ($type == 'university') 
        {
            UniversityReviews::whereId($id)->delete();
        }
        return redirect()->back()->with('flash_message', 'Отзыв успешно удален');
    }
}