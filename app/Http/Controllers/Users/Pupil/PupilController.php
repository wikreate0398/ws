<?php
 
namespace App\Http\Controllers\Users\Pupil;

use App\Models\User; 
use App\Models\Regions; 

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
 
use App\Http\Controllers\Users\ProfileController;
use App\Utils\Users\Pupil\User as PupilUser;
 
 
class PupilController extends ProfileController  
{
    private $viewPath = 'users.profile_types.user.';  

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

    public function showSubscriptions()
    {
        return view('users.user_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'subscriptions',
        ]); 
    }

    public function showReviews()
    {
        return view('users.user_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'reviews',
        ]); 
    }    
}