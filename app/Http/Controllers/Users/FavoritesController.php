<?php

namespace App\Http\Controllers\Users\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\User; 
use App\Models\CourseFavorite;
use App\Models\TeacherBoockmarks;
use App\Models\UniversityBookmarks;

class FavoritesController extends TeacherController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            'include'    => 'users.favorites.list',
            'page'       => 'users.favorites.' . $page,
            'university' => $university,
            'teachers'   => $teachers,
            'courses'    => $courses
        ];

        $view = [
            '1' => 'user_profile',
            '2' => 'teacher_profile',
            '3' => 'university_profile'
        ]; 

        return view('users.' . $view[$user->user_type], $data); 
    } 
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
