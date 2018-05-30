<?php
 
namespace App\Http\Controllers\Users\Pupil;

use App\Models\User; 
use App\Models\Regions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use App\Http\Controllers\Users\UserTypes\UserTypesInterface;
use App\Http\Controllers\ProfileController;

/**
* Регистрация обычного пользователя
*/
class PupilController extends ProfileController  
{
    private $viewPath = 'users.profile_types.user.'; 
 
    use \App\Http\Controllers\Users\Traits\PupilTrait;

	function __construct() {} 
 
 
    public function showCourse()
    { 
        return view('users.user_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'courses',
        ]); 
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

    public function showBookmarks()
    {
        return view('users.user_profile', [ 
            'user'               => Auth::user(), 
            'include'            => $this->viewPath . 'bookmarks',
        ]); 
    }  
}