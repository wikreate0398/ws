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

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Users\University\Faculties;

/**
* Регистрация обычного пользователя
*/
class UniversityController extends ProfileController
{
    public $viewPath = 'users.profile_types.university.';

	use \App\Http\Controllers\Users\Traits\UniversityTrait;

	function __construct() {} 

    public function redirectIfDataNoFilled()
    {
        if (Auth::user()->user_type == 3 && Auth::user()->data_filled == 0) 
        {
            if (request()->ajax()) {
                return response()->json(['error' => 'page not available'], 404);
            }  
            return redirect()->route(userRoute('user_edit'));
        }
        return true;
    } 
 
    public function showEditForm()
    {  
        $user = Auth::user(); 

        $data = [
            'regions'         => Regions::where('country_id', 3159)->orderBy('name', 'asc')->get(),  
            'specializations' => UniversitySpecializationsList::where('view', '1')->orderBy('page_up','asc')->orderBy('id','desc')->get(), 
            'user'            => User::with('university')->where('id', $user->id)->first(),  
            'university'      => University::orderBy('page_up','asc')->get(),
            'university_specializations' => UniversitySpecializations::where('id_university', $user->id)->get(),   
        ];

        $data['userUniversity'] = $data['user']['university'];

        return view($this->viewPath . 'edit', $data); 
    } 
}