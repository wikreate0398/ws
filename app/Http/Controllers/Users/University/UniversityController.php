<?php

namespace App\Http\Controllers\Users\University;

use App\Models\User;  
use App\Models\UsersUniversity; 
use App\Models\University;  
use App\Models\UniversitySpecializationsList;
use App\Models\UniversitySpecializations; 
use App\Models\Regions; 
use App\Models\UniversityFaculties;  
use App\Models\UniversityNews;    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use App\Http\Controllers\Users\ProfileController;
use App\Http\Controllers\Users\University\Faculties; 
use App\Utils\Users\University\User as UniversityUser;

class UniversityController extends ProfileController
{
    public $viewPath = 'users.profile_types.university.'; 

    protected $_user;

	function __construct() 
    {
        $this->_user = new UniversityUser;
    }  
 
    public function showEditForm()
    {  
        $user = Auth::user(); 

        $data = [
            'regions'         => Regions::where('country_id', 3159)->orderBy('name', 'asc')->get(),  
            'specializations' => UniversitySpecializationsList::where('view', '1')->orderBy('page_up','asc')->orderBy('id','desc')->get(), 
            'user'            => User::with('university')->where('id', $user->id)->first(),  
            'university'      => University::orderBy('page_up','asc')->get(),
            'university_specializations' => UniversitySpecializations::where('id_university', $user->university->id)->get(),   
        ];

        $data['userUniversity'] = $data['user']['university'];

        return view($this->viewPath . 'edit', $data); 
    } 
}