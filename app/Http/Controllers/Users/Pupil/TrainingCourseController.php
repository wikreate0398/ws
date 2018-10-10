<?php
 
namespace App\Http\Controllers\Users\Pupil;

use App\Models\User;  
use App\Models\Courses; 

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
  
use App\Utils\Users\Pupil\User as PupilUser;
  
class TrainingCourseController extends PupilController  
{  
	function __construct() 
    { 
        parent::__construct();
        $this->_user = new PupilUser;
    }
    
    public function training($id)
    {  
        $user    = Auth::user();
        $id_user = $user->id;
        $data = [ 
            'user'    => $user,  
            'course'  => Courses::whereHas('userRequests', function($query) use ($id_user){
                           return $query->where('id_user', @$id_user);
                        })->whereHas('user', function($query){
                            return $query->allowUser();
                        })->findOrFail($id),
            'scripts' => [ 
                'full:https://vjs.zencdn.net/ie8/ie8-version/videojs-ie8.min.js',
                'full:https://vjs.zencdn.net/7.2.3/video.js'
            ],

            'styles' => [ 
                'full:https://vjs.zencdn.net/7.2.3/video-js.css' 
            ],

            'include' => $this->viewPath . 'training.index',  
        ]; 
        return view('users.user_profile', $data); 
    }  

    public function download($file, Request $request)
    {
        $filename = basename(base64_decode($file));
        $fullPath = public_path(). "/uploads/courses/" . base64_decode($file);

        if (\File::exists($fullPath) == false) 
        {
            abort('404');
        } 

        $headers = array(
          'Content-Type: ' . \File::mimeType($fullPath),
        ); 


        return \Response::download($fullPath, $filename, $headers);
    }
}