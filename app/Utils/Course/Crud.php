<?php

namespace App\Utils\Course;
 
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Courses; 
use App\Models\CourseSections; 
use App\Models\SectionLectures; 
use App\Models\CourseCategory;
use App\Models\CoursesCertificates; 
use App\Models\CourseTeachers; 
use App\Models\SectionLecturesMaterials; 
use App\Models\LectureUserHomework;  
  
class Crud extends Course
{ 
    protected $_course_facade = null;

    private $niceNames = [ 
        'id_category'   => 'Категория', 
        'name'          => 'Название курса',
        'description'   => 'Краткое описание курса',
        'text'          => 'Подробное описание курса',
        'pay'           => 'Тип (платный/бесплатный)', 
        'date_from'     => 'Длительность курса от',
        'date_to'       => 'Длительность курса до',
        'is_open_from'  => 'Запись курса открыта от',
        'is_open_to'    => 'Запись курса открыта до',
        'type'          => 'Тип',
        'available'     => 'Доступность на сайте',
        'price'         => 'Стоимость',
        'max_nr_people' => 'Кол-во людей'
    ];

    private $rules = [
        'name'         => 'required',
        'description'  => 'required|max:200',
        'text'         => 'max:2000',  
        'id_category'  => 'required',
        'pay'          => 'required', 
        'date_from'    => 'required',
        'date_to'      => 'required',
        'type'         => 'required',
        'available'    => 'required', 
        'lecture_video.*' => 'mimes:mp4' 
    ]; 

    private $customMessage = [ 
        'available.required' => 'Укажите доступность на сайте',
        'teachers.required'  => 'Выберите преподавателей',
        'max_nr_people.required' => 'Необходимо указать кол-в людей если желаете скрыть курс по окончанию набора'
    ];

    private $payOptions = ['1','2'];

    private $availableOptions = ['1','2'];

    private $types = ['1','2', '3'];

    public $sections = [];

    public $lectures = [];

    public $id_course = null;

    public $user      = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($id_course = null, $authUser) 
    {
        parent::__construct();
        $this->user      = $authUser;
        $this->id_course = $id_course;
    } 

    private function validateSectionsAndLectures($data)
    {
        $err = false;
        foreach ($data['section'] as $section_field_name => $sections) 
        {
            foreach ($sections as $section_key => $section_value) 
            { 
                if (empty($section_value)) 
                {  
                    $err = true;
                } 

                foreach ($data['lecture'] as $lecture_key => $lectures) 
                { 
                    if ($lecture_key == $section_key) 
                    { 
                        foreach ($lectures as $lecture_field_name => $lecture_values) 
                        {  
                            if (!in_array($lecture_field_name, ['video_link', 'video_type', 'last_id', 'homework', 'homework_letter', 'homework_required'])) 
                            { 
                                foreach ($lecture_values as $lecture_values_key => $lecture_values_value) 
                                {
                                    if ($lecture_values_value == null) 
                                    {
                                        $err = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } 


        if ($err === true) 
        {
            return ['section', 'lecture'];
        }

        return true;
    } 

    public function validation(array $data, $type='general')
    { 
        if ($this->manager(Courses::whereId($this->id_course)->first())->canManage() == false && $this->id_course != null) 
        {
            return 'Ошибка';
        }

        $errors = []; 
        switch ($type) {
            case 'general':
                $rules = [
                    'name'         => 'required',
                    'description'  => 'required|max:200',
                    'text'         => 'max:2000',  
                    'id_category'  => 'required',
                    'pay'          => 'required', 
                ];

                if (!empty($data['pay']) && $data['pay'] == 2) 
                {
                    $rules['price'] = 'required';
                }

                if ($this->user->user_type == 3) 
                {
                    $rules['teachers'] = 'required';
                }

                if (!in_array($data['pay'], $this->payOptions)) 
                {
                    return 'Ошибка на сервере';
                }

                $errors = []; 
                if (CourseCategory::where('parent_id', $data['id_category'])->count() > 0 && empty($data['subcat_id'])) 
                {
                    $errors['subcat_id'] = ['Укажите <strong>подкатегорию</strong> курса'];
                }

                $validator = Validator::make($data, $rules, $this->customMessage); 
                $validator->setAttributeNames($this->niceNames);  
                if ($validator->fails()) 
                {
                    $errors = array_merge($errors, $validator->errors()->toArray());
                }

                break;

            case 'settings':
                $rules = [
                    'date_from'    => 'required',
                    'date_to'      => 'required',
                    'type'         => 'required',
                    'available'    => 'required',  
                ];

                if (!empty($data['hide_after_end'])) 
                {
                    $rules['is_open_from'] = 'required';
                    $rules['is_open_to'] = 'required';
                    $rules['max_nr_people'] = 'required';
                } 

                $validator = Validator::make($data, $rules, $this->customMessage); 
                $validator->setAttributeNames($this->niceNames);  
                if ($validator->fails()) 
                {
                    $errors = array_merge($errors, $validator->errors()->toArray());
                }

                if (!empty($errors)) 
                {
                    return $errors;
                } 

                if (!in_array($data['type'], $this->types) or !in_array(@$data['available'], $this->availableOptions)) 
                {
                    return 'Ошибка на сервере';
                }

                break;

            case 'program':
                $this->sections  = sortValue(request()->input('section'));
                $this->lectures  = request()->input('lecture');  

                $validateSectionsAndLectures = $this->validateSectionsAndLectures($data);

                if ($validateSectionsAndLectures !== true) 
                { 
                    $errors[] = ['Заполните все обязательные поля в разделе <strong>Программа курса</strong>!'] ;
                    $errors['multifields'] = $validateSectionsAndLectures;
                }

                $validator = Validator::make($data, [
                    'lecture_video.*.*'       => 'mimes:mp4,ogv,ogg,m4v|max:5000',
                    'lecture_materials.*.*.*' => 'mimes:doc,docx,pdf,rtf,zip|max:2000',
                    'lecture_homework.*.*'    => 'mimes:doc,docx,pdf,rtf,zip|max:2000',
                ], [
                    'lecture_video.*.mimes'     => 'Видеофайл не правильного формата',
                    'lecture_materials.*.mimes' => 'Файл материала не правильного формата',
                    'lecture_video.*.max'       => 'Загрузите видео размером не более 5мб',
                    'lecture_materials.*.max'   => 'Загрузите файлы размером не более 2мб',
                    'lecture_homework.*.max'    => 'Файл в разделе домашнего задания должен быть размером не более 2мб',
                    'lecture_homework.*.mimes'  => 'Файл в разделе домашнего задания не правильного формата',
                ]);  
                if ($validator->fails()) 
                {
                    $errors = array_merge($errors, $validator->errors()->toArray());
                }

                if (!empty($errors)) 
                {
                    return $errors;
                }  

                break;
            
            default:
                return 'Ошибка на сервере';
                break;
        } 

        if (!empty($errors)) 
        {
            return $errors;
        } 
        return true;
    } 

    public function save(array $data)
    {  
        $create = [ 
            'id_user'          => $this->user->id,
            'id_category'      => intval($data['id_category']),
            'id_subcat'        => !empty($data['subcat_id']) ? $data['subcat_id'] : 0,
            'name'             => $data['name'],
            'description'      => $data['description'],
            'text'             => $data['text'],
            'pay'              => intval($data['pay']), 
            'price'            => !empty($data['price']) ? toFloat($data['price']) : '',
            'general_filled'   => 1,
            'discount_price'   => null,
            'discount_percent' => null
        ];

        if (!empty($data['discount_price'])) 
        {
            $create['discount_price'] = toFloat($data['discount_price']);
        }
        elseif (!empty($data['discount_percent'])) 
        {
            $create['discount_percent'] = toFloat($data['discount_percent']);
        }

        $id_course = Courses::create($create)->id; 
 
        $this->id_course = $id_course;

        if (!empty($data['teachers'])) 
        {
            $this->saveCourseTeachers($data['teachers']);
        }

        return $id_course;
    } 

    public function saveCourseTeachers($teachers)
    { 
        CourseTeachers::where('id_course', $this->id_course)->delete();
        foreach ($teachers as $id_teacher => $value) 
        {
            CourseTeachers::create([
                'id_course'  => $this->id_course,
                'id_teacher' => $id_teacher
            ]);
        }
    }

    public function editGeneral(array $data)
    {   
        $dataUpdate = [ 
            'id_category'      => intval($data['id_category']),
            'id_subcat'        => !empty($data['subcat_id']) ? $data['subcat_id'] : 0,
            'name'             => $data['name'],
            'description'      => $data['description'],
            'text'             => $data['text'],
            'pay'              => intval($data['pay']), 
            'price'            => !empty($data['price']) ? toFloat($data['price']) : '',
            'isHide'           => 0,
            'general_filled'   => 1,
            'discount_price'   => null,
            'discount_percent' => null
        ]; 

        if (!empty($data['price'])) 
        { 
            if (!empty($data['discount_price'])) 
            {
                $dataUpdate['discount_price'] = toFloat($data['discount_price']);
            }
            elseif (!empty($data['discount_percent'])) 
            {
                $dataUpdate['discount_percent'] = toFloat($data['discount_percent']);
            } 
        }

        Courses::where('id', $this->id_course)
        ->where('id_user', $this->user->id)
        ->update($dataUpdate); 

        if (!empty($data['teachers'])) 
        {
            $this->saveCourseTeachers($data['teachers']);
        } 
    } 

    public function editSettings(array $data)
    {   
        $dataUpdate = [ 
            'type'           => intval($data['type']),
            'is_open_to'     => !empty($data['hide_after_end']) ? date('Y-m-d', strtotime($data['is_open_to'])) : null,
            'is_open_from'   => !empty($data['hide_after_end']) ? date('Y-m-d', strtotime($data['is_open_from'])) : null,
            'max_nr_people'  => !empty($data['max_nr_people']) ? intval($data['max_nr_people']) : null,
            'date_to'        => date('Y-m-d', strtotime($data['date_to'])),
            'date_from'      => date('Y-m-d', strtotime($data['date_from'])),
            'hide_after_end' => !empty($data['hide_after_end']) ? 1 : 0,
            'available'      => intval($data['available']),
            'isHide'         => 0,
            'settings_filled' => 1
        ];

        Courses::where('id', $this->id_course)
        ->where('id_user', $this->user->id)
        ->update($dataUpdate);  
    }  

    public function updateCourseHide()
    {
        $dataUpdate['isHide'] = 0; 
        if ($this->manager(Courses::whereId($this->id_course)->first())->ifCourseHide() == true) 
        {
            $dataUpdate['isHide'] = 1;
        }

        Courses::where('id', $this->id_course)
        ->where('id_user', $this->user->id)
        ->update($dataUpdate);  
    } 

    public function saveSections()
    {  
        $files  = @request()->file(); 
        $insert = [];
        foreach ($this->sections as $sectionKey => $section) 
        {  
            $id = CourseSections::create([
                'name'      => $section['name'],
                'date'      => !empty($section['date']) ? date('Y-m-d', strtotime($section['date'])) : NULL,  
                'id_course' => $this->id_course
            ])->id;

            foreach (sortValue($this->lectures[$sectionKey]) as $lectureKey => $lecture) 
            { 
                $videoFile = null;
                if (!empty($files['lecture_video'][$sectionKey][$lectureKey]) && $lecture['video_type'] == 'file') 
                {
                    $file     = $files['lecture_video'][$sectionKey][$lectureKey]; 
                    $fileName  = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $videoFile = $fileName;
                    $file->move(public_path() . '/uploads/courses/video/', $fileName); 
                }

                $createLecture = [
                    'id_section'       => $id,
                    'name'             => $lecture['name'],
                    'description'      => $lecture['description'],
                    'duration_hourse'  => toFloat($lecture['hourse']),
                    'duration_minutes' => toFloat($lecture['minutes']),
                    'video_link'       => ($lecture['video_type'] == 'link') ? $lecture['video_link'] : null, 
                    'video_type'       => $lecture['video_type']
                ];

                if (!empty($lecture['homework'])) 
                {
                    $homework_file = null;
                    if (!empty($files['lecture_homework'][$sectionKey][$lectureKey])) 
                    {
                        $file          = $files['lecture_homework'][$sectionKey][$lectureKey]; 
                        $fileName      = $file->getClientOriginalName() . "_" . date('d_m_Y_H_i_s')  . "." . $file->getClientOriginalExtension();
                        $homework_file = $fileName;
                        $file->move(public_path() . '/uploads/courses/homework/', $fileName); 
                    }

                    if (empty($homework_file) && !empty($lecture['old_homework_file'])) 
                    {
                        $homework_file = $lecture['old_homework_file'];
                    }

                    $createLecture = array_merge($createLecture, [
                        'has_homework'      => 1,
                        'homework_letter'   => @$lecture['homework_letter'],
                        'homework_required' => !empty($lecture['homework_required']) ? 1 : 0,
                        'homework_file'     => $homework_file
                    ]);
                }
                else
                { 
                    if (!empty($lecture['old_homework_file'])) 
                    {
                        \File::delete('uploads/courses/homework/' . $lecture['old_homework_file']);
                    }

                    $createLecture = array_merge($createLecture, [
                        'has_homework'      => 0,
                        'homework_letter'   => null,
                        'homework_required' => null,
                        'homework_file'     => null
                    ]);
                } 
 
 
                if ($lecture['video_type'] == 'file' && !empty($videoFile)) 
                {
                    $createLecture['video_file'] = $videoFile;
                }
                elseif (!empty($lecture['old_video_file']) && $lecture['video_type'] == 'file') 
                {
                    $createLecture['video_file'] = $lecture['old_video_file'];
                } 

                if ($lecture['video_type'] == 'link' && !empty($lecture['old_video_file'])) 
                {
                    \File::delete('uploads/courses/video/' . $lecture['old_video_file']);
                }

                $insertLecture = SectionLectures::create($createLecture);
                
                if (!empty($lecture['last_id'])) 
                {
                    SectionLecturesMaterials::where('id_lecture', $lecture['last_id'])->update(['id_lecture' => $insertLecture->id]);
                    LectureUserHomework::where('id_lecture', $lecture['last_id'])->update(['id_lecture' => $insertLecture->id]);
                } 
      
                if (!empty($files['lecture_materials'][$sectionKey][$lectureKey])) 
                {
                    $insertData     = [];
                    $materialsFiles = $files['lecture_materials'][$sectionKey][$lectureKey];   
                    foreach ($materialsFiles as $key => $file) 
                    { 
                        $fileName = $file->getClientOriginalName() . "_" . date('d_m_Y_H_i_s')  . "." . $file->getClientOriginalExtension();
                        $file->move(public_path() . '/uploads/courses/materials/', $fileName);
                        $insertData[] = [
                            'id_lecture' => $insertLecture->id,
                            'material'   => $fileName
                        ];
                    }  

                    SectionLecturesMaterials::insert($insertData);
                }  
            }
        }  

        return true;
    }

    public function saveCertificates($certificates)
    {
        $insert = [];
        foreach ($certificates as $key => $value) 
        {
            $fileName = md5(microtime()) . '.png';
            uploadBase64($value, public_path() . "/uploads/courses/certificates/$fileName");
            $insert[] = [
                'id_course' => $this->id_course,
                'image'     => $fileName
            ];
        }  
        CoursesCertificates::insert($insert);  
        Courses::whereId($this->id_course)->update(['сertificates_filled' => 1]);
    } 

    public function hasAccessCourse()
    {
        return Courses::where('id', $this->id_course)->where('id_user', $this->user->id)->count();
    }

    public function hasAccessCertificate($id_certificate)
    { 
        $certificate = CoursesCertificates::whereId($id_certificate)->first();   
        $this->id_course = $certificate->course->id;
        if (!empty($certificate->course->id) && $this->hasAccessCourse($certificate->course->id, $this->user->id)) 
        {
            return true;
        } 
    }

    public function hasAccessSection($id_section)
    {
        $getCourse = CourseSections::whereId($id_section)->first();
        return Courses::where('id', @$getCourse->id_course)->where('id_user', $this->user->id)->count();
    }

    public function hasAccessLecture($id_lecture)
    {
        $getLecture = SectionLectures::whereId($id_lecture)->first(); 
        $getCourse  = CourseSections::whereId(@$getLecture->id_section)->first(); 
        return Courses::where('id', @$getCourse->id_course)->where('id_user', $this->user->id)->count();
    }

    public function deleteSection($id_section)
    {
        CourseSections::whereId($id_section)->delete();
        SectionLectures::where('id_section', $id_section)->delete();
    }

    public function deleteLecture($id_lecture)
    { 
        SectionLectures::whereId($id_lecture)->delete();
    } 

    public function delete()
    {
        Courses::whereId($this->id_course)->delete();
        $this->deleteSectionsAndLectures($this->id_course, $this->user->id);
    }

    public function deleteSectionsAndLectures()
    { 
        $sectionsIds = [];
        foreach (CourseSections::where('id_course', $this->id_course)->get() as $section) 
        {
            $sectionsIds[] = $section->id;
        }  
        CourseSections::where('id_course', $this->id_course)->delete();
        SectionLectures::whereIn('id_section', $sectionsIds)->delete(); 
    }
}
