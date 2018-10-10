<?php

namespace App\Http\Controllers\Users\Pupil;

use App\Models\User;  
use App\Models\Courses; 
use App\Models\LectureUserHomework;  
use App\Models\SectionLectures;   
    
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  
use Illuminate\Support\Facades\Auth;
use App\Utils\Course\Course;
use App\Models\CourseReviews;

use App\Mail\Course\Homework\NotifyTeacher;  
use App\Mail\Course\MessageTeacher;  
use Illuminate\Support\Facades\Mail;

use App\Utils\Users\Pupil\User as PupilUser;
  
class TrainingCourseController extends PupilController  
{  
	function __construct() 
    { 
        parent::__construct();
        $this->_user = new PupilUser;
        $this->_course = new Course;
    }
    
    public function training($id)
    {  
        $user    = Auth::user();
        $id_user = $user->id;
        $data = [ 
            'user'    => $user,  
            'course'  => Courses::with(['sections.lectures.userHomework' => function($query) use ($id_user){
                                    return $query->where('id_user', @$id_user);
                                }]) 
                                ->whereHas('userRequests', function($query) use ($id_user){
                                   return $query->where('id_user', @$id_user);
                                })->allowUser()->findOrFail($id),
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

    public function makeHomework(Request $request)
    {
        if (empty($request->id_course) or empty($request->id_lecture) or empty($request->message)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Заполните все обязательные поля!']);
        } 

        $validator = Validator::make($request->all(), [ 
            'file'    => 'mimes:doc,docx,pdf,rtf,zip|max:2000',
        ], [
            'file.mimes'     => 'Файл не правильного формата', 
            'file.max'       => 'Загрузите файл размером не более 2мб' 
        ]);

        if ($validator->fails()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validator->errors()->toArray()]); 
        } 

        $id_user = Auth::user()->id; 
        $course  = Courses::whereHas('userRequests', function($query) use ($id_user){
                   return $query->where('id_user', @$id_user);
                })->allowUser()->whereId($request->id_course)->first(); 

        if (empty($course)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $hmFile = null;
        if ($request->hasFile('file'))
        {
            $file      = $request->file('file'); 
            $fileName  = $file->getClientOriginalName() . "_" . date('d_m_Y_H_i_s')  . "." . $file->getClientOriginalExtension();
            $hmFile    = $fileName;
            $file->move(public_path() . '/uploads/courses/homework/', $fileName); 
        }

        LectureUserHomework::where('id_lecture', $request->id_lecture)->where('id_user', $id_user)->delete();
        LectureUserHomework::create([
            'id_lecture' => $request->id_lecture,
            'id_user'    => $id_user,
            'message'    => $request->message,
            'file'       => $hmFile
        ]); 

        $lecture = SectionLectures::whereId($request->id_lecture)->first();
        Mail::to($this->getTrainingTeacherEmails($course, true))->send(new NotifyTeacher($course, $lecture));

        return \App\Utils\JsonResponse::success([
            'redirect' => route(userRoute('course_training'), ['id' => $request->id_course]
        )], 'Ваше домашнее задание было успешно отправленно преподавателю');  
    }

    public function writeMessage(Request $request)
    {
        if (empty($request->id_course) or empty($request->id_teacher) or empty($request->message)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Заполните все обязательные поля!']);
        } 

        $validator = Validator::make($request->all(), [ 
            'file'    => 'mimes:doc,docx,pdf,rtf,zip|max:2000',
        ], [
            'file.mimes'     => 'Файл не правильного формата', 
            'file.max'       => 'Загрузите файл размером не более 2мб' 
        ]);

        if ($validator->fails()) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validator->errors()->toArray()]); 
        } 

        $id_user = Auth::user()->id; 
        $course  = Courses::whereHas('userRequests', function($query) use ($id_user){
                   return $query->where('id_user', @$id_user);
                })->allowUser()->whereId($request->id_course)->first(); 

        if (empty($course)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $msgFile = null;
        if ($request->hasFile('file'))
        {
            $file      = $request->file('file'); 
            $fileName  = $file->getClientOriginalName() . "_" . date('d_m_Y_H_i_s')  . "." . $file->getClientOriginalExtension();
            $msgFile    = $fileName;
            $file->move(public_path() . '/uploads/courses/message/', $fileName); 
        }

        Mail::to($this->getTrainingTeacherEmails($course, true))->send(new MessageTeacher($course, Auth::user(), $msgFile));

        return \App\Utils\JsonResponse::success([
            'redirect' => route(userRoute('course_training'), ['id' => $request->id_course]
        )], 'Ваше сообщение было успешно отправленно преподавателю');  
    }

    public function review($id, Request $request, Course $courseFacade)
    {
        $id_user = Auth::user()->id; 
        $course  = Courses::whereHas('userRequests', function($query) use ($id_user){
                   return $query->where('id_user', @$id_user);
                })->allowUser()->whereId($id)->first(); 

        if ($courseFacade->manager($course)->ifHasUserReview($id_user)) 
        {
            return;
        } 

        if (!$request->input('message')) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Заполните поле с комментарием']); 
        }

        CourseReviews::create([
            'id_course' => $id,
            'id_user'   => $id_user,
            'review'    => $request->input('message'),
            'rating'    => floatval($request->input('rating'))
        ]);

        return \App\Utils\JsonResponse::success(['reload' => true], 'Отзыв успешно добавлен и ожидает проверки модератора'); 
    }

    private function getTrainingTeacherEmails($course, $implode = true)
    {
        $emails = [$course->user->email];
        if ($course->user->user_type==3) 
        {
            if ($course->teachers->count()) 
            {
                $emails = $course->teachers->pluck('email')->toArray();
            }
        } 
        return !empty($implode) ? implode(',', $emails) : $emails;
    }
}