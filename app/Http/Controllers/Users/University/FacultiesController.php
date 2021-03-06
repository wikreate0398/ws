<?php

namespace App\Http\Controllers\Users\University;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\UniversityFaculties;   
use App\Models\UniversityFacultiesSubjects;     
use App\Utils\Users\University\Faculties;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseCategory;

class FacultiesController extends UniversityController
{
    protected $_faculties;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->middleware('data_filled');
        $this->_faculties = new Faculties;
    } 

    public function showFaculties()
    {  
        $faculties = UniversityFaculties::getProfileFaculties(Auth::user()->university->id, request()->all(), $this->_faculties->formLearningOptipons); 

        return view('users.university_profile', [ 
            'user'      => Auth::user(),  
            'faculties' => $faculties,
            'durationLearning' => UniversityFaculties::select('duration_learning')
                                                     ->where('id_university', Auth::user()->university->id)
                                                     ->groupBy('duration_learning')
                                                     ->orderBy('duration_learning', 'asc')
                                                     ->get(),
            'include'   => $this->viewPath . '.faculties.list',
        ]); 
    }  

    public function showFacultyForm()
    {   
        $categories = map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()); 
        return view('users.university_profile', [ 
            'user'          => Auth::user(), 
            'include'       => $this->viewPath . '.faculties.add', 
            'categories'              => $categories, 
            'scripts'       => [
                'js/university.js'
            ]
        ]); 
    } 

    public function editFacultyForm($id_faculty)
    {
        $user = Auth::user(); 
        $categories = map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray()); 
        return view('users.university_profile', [ 
            'user'          => Auth::user(), 
            'include'       => $this->viewPath . '.faculties.edit', 
            'faculty'       => UniversityFaculties::where('id_university', $user->university->id)->findOrFail($id_faculty),
            'categories'              => $categories, 
            'scripts'       => [
                'js/university.js'
            ]
        ]); 
    }

    public function saveFaculty(Request $request)
    {
        $validate = $this->_faculties->validation($request->all());
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 

        $idFaculty = $this->_faculties->save($request->all(), Auth::user()->university->id); 
  
        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('user_faculties'))], 'Факультет успешно добавлен!');
    }

    public function editFaculty($idFaculty, Request $request)
    { 
        if (!$this->_faculties->hasAccessFaculty($idFaculty, Auth::user()->university->id)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $validate = $this->_faculties->validation($request->all());
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        }   
        $this->_faculties->edit($request->all(), $idFaculty, Auth::user()->university->id);  
        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('user_faculties'))], 'Факультет успешно изменен!');
    }

    public function deleteFaculty($id_faculty)
    {  
        if ($this->_faculties->hasAccessFaculty($id_faculty, Auth::user()->university->id)) 
        {
            $this->_faculties->delete($id_faculty); 
        }
        return redirect()->route(userRoute('user_faculties'));
    } 
}
