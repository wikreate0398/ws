<?php

namespace App\Http\Controllers\Users\University;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
use App\Models\User; 
use App\Models\TeacherUniversityConnect; 
// use App\Models\UniversityTeacherConnect;  
use App\Models\TeachersUniversity; 
use App\Mail\Connections\Teacher\NotifyRequest;
use App\Mail\Connections\Teacher\ConfirmRequest; 
use App\Mail\Connections\Teacher\DeclineRequest;
use App\Mail\Connections\Teacher\DestroyRequest; 
use Illuminate\Support\Facades\Mail;
   
class TeachersConnectionController extends UniversityController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user   = Auth::user(); 
        $userId = $user->id;
        $data   = [ 
            'user'                => $user,    
            'requestFromTeachers' => TeacherUniversityConnect::with('teacher')
                                                             ->fromTeacher()
                                                             ->where('decline', '0')
                                                             ->where('id_university', $userId)
                                                             ->orderBy('id', 'desc')
                                                             ->get(),

            'requestForTeachers' => User::with('connectsUniversityRequest')
                                         ->allowUser()
                                         ->with(['connectsUniversityRequest' => function($query) use($userId){
                                            return $query->where('id_university', $userId);
                                         }]) 
                                         ->withCount('connectsUniversityRequest')
                                         ->has('connectsUniversityRequest')
                                         ->orderBy('id', 'asc')
                                         ->get(), 

            'include'     => $this->viewPath . 'teachers.list', 
            'scripts' => [ 
                'js/university.js'
            ]
        ]; 
  
        $p = request()->input('p') ? request()->input('p') : 'confirmed_records';

        switch ($p) {
            case 'confirmed_records':
                $data['teacherPage'] = $this->viewPath . 'teachers.confirmed';
                break;

            case 'requests_for_confirmed':
                $data['teacherPage'] = $this->viewPath . 'teachers.requests_for_confirmed';  
                break;

            case 'requests_for_teachers':
                $data['teacherPage'] = $this->viewPath . 'teachers.requests_for_teachers';  
                break;
            
            default:
                
                break;
        }  

        //exit(print_arr($data['request']->toArray())); 
        
        return view('users.university_profile', $data); 
    }

    public function confirm($id_request)
    {    
        $get = TeacherUniversityConnect::with('teacher')
                                       ->fromTeacher()
                                       ->whereId($id_request)
                                       ->where('decline', '0')
                                       ->where('id_university', Auth::user()->id)
                                       ->first();
        if (!count($get)) 
        {
            abort('404');
        }

        TeachersUniversity::create([
            'id_teacher'    => $get['id_teacher'],
            'id_university' => Auth::user()->id
        ]);

        TeacherUniversityConnect::whereId($id_request)->delete();
        Mail::to($get->teacher->email)->send(new ConfirmRequest);   

        return redirect(route(userRoute('user_teachers')) . '?p=confirmed_records')->with('flash_message', 'Заявка успешно подтверждена');
    }

    public function autocomplete(Request $request)
    { 
        $searchStr  = urldecode($request->input('search'));
        $userId     = Auth::user()->id;  
        $searchData = User::allowUser()
                          ->with('connectionUniversities')
                          ->where('name', 'like', "%$searchStr%")
                          ->orWhere('email', 'like', "%$searchStr%")
                          ->where('user_type', '2')
                          ->orderBy('id', 'asc')
                          ->get();  
 
        if (empty($searchData)) die();
         
        $content    = ''; 
        if (@count($searchData)) 
        {
            foreach ($searchData as $item) 
            {
                if (!array_key_exists($userId, key_to_id($item['connectionUniversities']))) { 
                    $content .= view('users.profile_types.university.teachers.item', ['item' => $item]);
                }  
            } 
        }  
        return \App\Utils\JsonResponse::success(['content' => $content]);
    } 

    public function request($id_teacher)
    {  
        $checkRequest = TeacherUniversityConnect::where('id_teacher', $id_teacher)
                                                ->where('id_university', Auth::user()->id)
                                                ->first();

        if (!empty($checkRequest) && $checkRequest['decline'] == 0) 
        {
            $message = 'Вы уже оставляли заявку этому учителю';
            if ($checkRequest['from'] == 2) 
            {
                $message = 'Учитель уже отправила вам запрос.';
            }
            return redirect()->back()->with('error_flash_message', $message);
        }

        if (TeachersUniversity::where('id_teacher', $id_teacher)->where('id_university', Auth::user()->id)->count()) 
        {
            return redirect()->back()->with('error_flash_message', 'У вас уже существует привязка к этому учебному заведению'); 
        }

        TeacherUniversityConnect::whereId($checkRequest['id'])->delete();

        TeacherUniversityConnect::create([
            'id_teacher'    => $id_teacher,
            'id_university' => Auth::user()->id,
            'from'          => 3 
        ]);

        $teacher = User::whereId($id_teacher)->first(); 
        Mail::to($teacher->email)->send(new NotifyRequest); 

        return redirect()->back()->with('flash_message', 'Ваша заявка успешно отправлена. Мы отправим вам уведомления после ее рассмотрения.');
    } 

    public function decline($id_request)
    {  
        $update = TeacherUniversityConnect::whereId($id_request)->where('id_university', Auth::user()->id)->update(['decline' => 1]); 
        if (empty($update)) 
        {
            abort('404');
        }

        $teacher = User::whereId(TeacherUniversityConnect::whereId($id_request)->first()->id_teacher)->first(); 
        Mail::to($teacher->email)->send(new DeclineRequest); 

        return redirect()->back()->with('flash_message', 'Заявка успешно откланена'); 
    }

    public function destroyRequest($id_request)
    { 
        $delete = TeacherUniversityConnect::whereId($id_request)->where('id_university', Auth::user()->id)->delete(); 
        if (empty($delete)) 
        {
            abort('404');
        } 
        return redirect()->back()->with('flash_message', 'Заявка успешно отменена');
    }

    public function destroy($id_teacher)
    { 
        if (!TeachersUniversity::where('id_teacher', $id_teacher)->where('id_university', Auth::user()->id)->count()) 
        {
            abort('404');
        } 
        TeachersUniversity::where('id_teacher', $id_teacher)->where('id_university', Auth::user()->id)->delete();

        $teacher = User::whereId($id_teacher)->first(); 
        Mail::to($teacher->email)->send(new DestroyRequest); 

        return redirect()->back()->with('flash_message', 'Заявка успешно удалено!');
    }
}
