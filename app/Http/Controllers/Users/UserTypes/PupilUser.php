<?php
 
namespace App\Http\Controllers\Users\UserTypes;

use App\Models\User; 
use App\Models\Cities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use App\Http\Controllers\Users\UserTypes\UserTypesInterface;

/**
* Регистрация обычного пользователя
*/
class PupilUser extends Controller implements UserTypesInterface
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
            'cities'  => Cities::orderBy('name', 'asc')->get(),  
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