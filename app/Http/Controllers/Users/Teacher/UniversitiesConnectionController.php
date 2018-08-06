<?php

namespace App\Http\Controllers\Users\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \App\Models\UsersUniversity;
use \App\Models\TeacherUniversityConnect;
// use App\Models\UniversityTeacherConnect;  
use App\Models\User; 
use App\Models\TeachersUniversity; 

use App\Mail\Connections\University\NotifyRequest;
use App\Mail\Connections\University\ConfirmRequest; 
use App\Mail\Connections\University\DeclineRequest;
use App\Mail\Connections\University\DestroyRequest; 
use Illuminate\Support\Facades\Mail;

class UniversitiesConnectionController extends TeacherController
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
            'user'    => $user,   
            'include' => $this->viewPath . 'universities.list',
            'data'    => UsersUniversity::allow()
                                        ->with('connects')  
                                        ->whereHas('connects', function($query) use($userId){
                                            return $query->where('id_teacher', $userId);
                                        })
                                        ->withCount('connects')
                                        ->orderBy('id_user', 'asc')
                                        ->get(), 

            'requests' => TeacherUniversityConnect::with('university')
                                                  ->fromUniversity()
                                                  ->where('decline', '0')
                                                  ->where('id_teacher', $userId)
                                                  ->orderBy('id', 'desc')
                                                  ->get(), 
        ]; 

        //exit(print_arr($data['requests']->toArray()));
        return view('users.teacher_profile', $data); 
    }

    public function connect()
    {
        $user   = Auth::user(); 
        $userId = $user->id;
        $data = [ 
            'user'    => $user, 
            'data'    => UsersUniversity::allow()
                                     ->with(['connects' => function($query) use($userId){
                                        return $query->where('id_teacher', $userId);
                                     }]) 
                                     ->has('connects')   
                                     ->orderBy('id_user', 'asc')
                                     ->get(),   
            'include' => $this->viewPath . 'universities.connect',
            'scripts' => [ 
                'js/teachers.js'
            ]
        ];   

        return view('users.teacher_profile',  $data); 
    }

    public function autocomplete(Request $request)
    { 
        $searchStr = urldecode($request->input('search')); 
        $userId    = Auth::user()->id; 

        $searchData = UsersUniversity::allow()    
                                     ->whereHas('user', function($query) use($searchStr){
                                        return $query->Where('email', 'like', "%$searchStr%");
                                     }) 
                                     ->orWhere('full_name', 'like', "%$searchStr%") 
                                     ->orderBy('id_user', 'asc')
                                     ->get();   

        if (empty($searchData)) die();
         
        $content    = ''; 
        if (@count($searchData)) 
        {
            foreach ($searchData as $item) 
            { 
                if (!array_key_exists($userId, key_to_id($item['user']['connectionTeachers']))) { 
                    $content .= view('users.profile_types.teacher.universities.item', ['item' => $item]);
                } 
            } 
        } 

        return \App\Utils\JsonResponse::success(['content' => $content]);
    } 
 
    public function request($id_university, Request $request)
    {
        if (empty($request->input('letter')) or $request->input('teaching')==null) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Заполните все обязательные поля']);
        }

        $checkRequest = TeacherUniversityConnect::where('id_teacher', Auth::user()->id)->where('id_university', $id_university)->first(); 

        if (!empty($checkRequest) && $checkRequest['decline'] == 0) 
        {
            $message = 'Вы уже оставляли заявку этому учебному заведению';
            if ($checkRequest['from'] == 3) 
            {
                $message = 'Данное Учебное заведение уже отправила вам запрос.';
            }
            return \App\Utils\JsonResponse::error(['messages' => $message]);
        }

        if (TeachersUniversity::where('id_teacher', Auth::user()->id)->where('id_university', $id_university)->count()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'У вас уже существует привязка к этому учебному заведению']);
        }
 
        TeacherUniversityConnect::whereId($checkRequest['id'])->delete();

        $fileNames = [];
        if (!empty($request->file('files'))) 
        {  
            foreach($request->file('files') as $key => $file) 
            {
                $n = $key+1;
                $fileName =  "scan0".$n."_".date('d-m-Y_h-i-s')."." . $file->getClientOriginalExtension();
                $fileNames[] = $fileName;
                $file->move(public_path() . '/uploads/users/teacher_connects/', $fileName);
            }
        } 
 
        TeacherUniversityConnect::create([
            'id_teacher'    => Auth::user()->id,
            'id_university' => $id_university,
            'letter'        => $request->input('letter'),
            'teaching'      => intval($request->input('teaching')),
            'attach'        => implode(',', $fileNames),
            'from'          => 2
        ]);

        $university = User::whereId($id_university)->first(); 
        Mail::to($university->email)->send(new NotifyRequest); 

        return \App\Utils\JsonResponse::success(['reload' => true], 'Ваша заявка успешно отправлена. Мы отправим вам уведомления после ее рассмотрения.'); 
    } 

    public function confirm($id_request)
    {    
        $get = TeacherUniversityConnect::fromUniversity()
                                       ->with('university')
                                       ->whereId($id_request)
                                       ->where('decline', '0')
                                       ->where('id_teacher', Auth::user()->id)
                                       ->first();
        if (!count($get)) 
        {
            abort('404');
        }

        TeachersUniversity::create([
            'id_teacher'    => Auth::user()->id,
            'id_university' => $get['id_university']
        ]);

        TeacherUniversityConnect::whereId($id_request)->delete();
        Mail::to($get->university->email)->send(new ConfirmRequest);   

        return redirect()->back()->with('flash_message', 'Заявка успешно подтверждена');
    }

    public function decline($id_request)
    {
        $update = TeacherUniversityConnect::whereId($id_request)->where('id_teacher', Auth::user()->id)->update(['decline' => 1]); 
        if (empty($update)) 
        {
            abort('404');
        }   

        $teacher = User::whereId(TeacherUniversityConnect::whereId($id_request)->first()->id_university)->first(); 
        Mail::to($teacher->email)->send(new DeclineRequest); 

        return redirect()->back()->with('flash_message', 'Заявка успешно откланена'); 
    }

    public function destroyRequest($id_request)
    { 
        $delete = TeacherUniversityConnect::whereId($id_request)->where('id_teacher', Auth::user()->id)->delete(); 
        if (empty($delete)) 
        {
            abort('404');
        } 
        return redirect()->back()->with('flash_message', 'Заявка успешно отменена');
    }

    public function destroy($id_university)
    {
        if (!TeachersUniversity::where('id_teacher', Auth::user()->id)->where('id_university', $id_university)->count()) 
        {
            abort('404');
        } 
        TeachersUniversity::where('id_teacher', Auth::user()->id)->where('id_university', $id_university)->delete(); 
        $university = User::whereId($id_university)->first(); 
        Mail::to($university->email)->send(new DestroyRequest);  
        return redirect()->route(userRoute('user_universities'))->with('flash_message', 'Заявка успешно удалена!');
    }
}
