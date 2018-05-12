<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 4/6/2018
 * Time: 5:34 PM
 */

namespace App\Http\Controllers;

use App\Models\TeacherSubjects;
use App\Models\TeacherSpecializations;
use App\Models\TeacherLessonOptions;
use App\Models\TeacherCertificates;
use App\Models\SpecializationsList;
use App\Models\LessonOptionsList;
use App\Models\UsersEducations;

class TeachersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $data = [
            'teachers' => \App\Models\User::where('user_type', 2)->orderBy('created_at', 'desc')->get(),
        ]; 

        return view('teachers.catalog', $data);
    } 

    public function show($id)
    { 
        $data = [
            'teacher'                 => \App\Models\User::with('cityData')->findOrFail($id), 
            'teacher_subjects'        => TeacherSubjects::where('id_teacher', $id)->orderBy('id', 'asc')->get(), 
            'teacher_specializations' => TeacherSpecializations::with('specializations_list')
                                                               ->where('id_teacher', $id)  
                                                               ->get(),  

            'teacher_lesson_options'  => TeacherLessonOptions::where('id_teacher', $id)->get(),
            'lesson_options'          => LessonOptionsList::orderBy('page_up', 'asc')
                                                          ->orderBy('id', 'desc')
                                                          ->get(),
            'educations'         => UsersEducations::where('id_user', $id)->orderBy('id', 'asc')->get(),
            'certificates'            => TeacherCertificates::where('id_teacher', $id)->orderBy('id', 'asc')->get(),  
        ];  

        return view('teachers.show', $data);
    } 
}