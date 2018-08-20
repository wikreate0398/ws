<?php
 
namespace App\Http\Controllers\Users\Pupil;

use App\Models\User; 
use App\Models\Regions;
use App\Models\CourseFavorite;
use App\Models\TeacherBoockmarks;
use \App\Models\UniversityBookmarks;

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

    public function showFavorites()
    {        
        $user       = Auth::user();
        $courses    = CourseFavorite::where('id_user', $user->id)
                                    ->with('course')
                                    ->whereHas('course', function($query){
                                        $query->published();
                                    })
                                    ->get();
         
        $teachers   = @User::whereId($user->id)->with('userTeacherBoockmarks')->whereHas('userTeacherBoockmarks', function($query){
            return $query->allowUser();
        })->first()->userTeacherBoockmarks;

        $university = @User::whereId($user->id)->with('userUniversityBoockmarks')->whereHas('userUniversityBoockmarks', function($query){
            return $query->allowUser();
        })->first()->userUniversityBoockmarks;
   
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
            'user'       => $user, 
            'include'    => $this->viewPath . 'favorites.list',
            'page'       => $this->viewPath . 'favorites.' . $page,
            'university' => $university,
            'teachers'   => $teachers,
            'courses'    => $courses
        ];

        return view('users.user_profile', $data); 
    }  

    public function destroyFavorites($id)
    {
        $type = request()->type;
        if (!in_array($type, ['course', 'teacher', 'university'])) 
        {
            abort(404);
        }

        $models = [
            'course' => CourseFavorite::class,
            'teacher' => TeacherBoockmarks::class,
            'university' => UniversityBookmarks::class
        ];

        $fields = [
            'course' => 'id_course',
            'teacher' => 'id_teacher',
            'university' => 'id_university'
        ];

        $models[$type]::where('id_user', Auth::user()->id)->where("{$fields[$type]}", $id)->delete();
        return redirect()->back()->with('flash_message', 'Закладка успешно удалена');
    }
}