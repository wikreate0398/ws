<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use App\Models\Regions; 
use App\Models\ProgramsType;
use App\Models\GradeEducation; 

use App\Models\TeacherSubjects;
use App\Models\TeacherSpecializations;
use App\Models\TeacherSpecializationsList;
use App\Models\TeacherLessonOptions;
use App\Models\SubjectsList;
use App\Models\CourseCategory;

use Illuminate\Support\Facades\DB;

use App\Utils\Users\Teacher\User as TeacherUser;
use App\Http\Controllers\Admin\Users\SiteUser;

class TeacherUserController extends SiteUser
{

    private $method = 'admin/users/teachers';

    private $folder = 'users.teacher';

    private $redirectRoute = 'admin_user_teacher';

    public $_user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_user = new TeacherUser;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = [
            'data'   => User::where('user_type', '2')->orderByRaw('created_at desc')->get(),
            'table'  => (new User)->getTable(),
            'method' => $this->method
        ];

        return view('admin.'.$this->folder.'.list', $data);
    }

    public function showAddForm()
    {
        return view('admin.'.$this->folder.'.add', [
            'method'          => $this->method
        ]);
    }

    private function validateInputs(array $data)
    {
        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']);
        $validator->setAttributeNames($this->niceNames);
        return $validator;
    }

    public function updateUser($id, Request $request)
    {
        $data     = $request->all();
        $_methods = [
            'editGeneral', 'editTutor'
        ];

        try {
            DB::beginTransaction();
            $this->_user->setUserId($id);
            $error = [];
            foreach ($_methods as $key => $method) {
                $_edit = $this->_user->{$method}($data);
                if ($_edit !== true)
                {
                    if (!is_array($_edit))
                    {
                        $arr['nf'] = $_edit;
                        $_edit = $arr;
                    }
                    $error = array_merge($error, $_edit);
                }
            }

            if (!empty($error))
            {
                 throw new \Exception(serialize($error));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return \App\Utils\JsonResponse::error(['messages' => unserialize($e->getMessage())]);
        }
        if (!empty($data['certificates']))
        {
            $this->_user->saveCertificates($data['certificates']);
        }

        $this->_user->updateIfProfileFilled();
        $this->allowUser($id);

        return \App\Utils\JsonResponse::success(['reload' => true], 'Данные успешно обновлены!');
    }

    public function showeditForm($id)
    {
        $categories = map_tree(CourseCategory::orderBy('page_up','asc')->orderBy('id','asc')->get()->toArray());
        $user = User::findOrFail($id);
        return view('admin.'.$this->folder.'.edit', [
            'method'                  => $this->method,
            'user'                    => $user,
            'regions'                 => Regions::where('country_id', 3159)->orderBy('name', 'asc')->get(),
            'grade_education'         => map_tree(GradeEducation::orderBy('page_up','asc')->get()->toArray()),
            'programs_type'           => map_tree(ProgramsType::orderBy('page_up','asc')->get()->toArray()),
            'degree_experience'       => DB::table('degree_experience')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),

            'specializations_list'    => TeacherSpecializationsList::where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'lesson_options_list'     => DB::table('lesson_options_list')->where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'subjects_list'           => SubjectsList::where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get(),
            'teacher_specializations' => TeacherSpecializations::where('id_teacher', $user->id)->get(),
            'teacher_lesson_options'  => TeacherLessonOptions::where('id_teacher', $user->id)->get(),
            'categories'              => $categories
        ]);
    }
}
