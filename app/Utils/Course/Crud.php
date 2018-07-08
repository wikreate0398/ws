<?php

namespace App\Utils\Course;
 
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Courses; 
use App\Models\CourseSections; 
use App\Models\SectionLectures; 
use App\Models\CourseCategory;
use App\Models\CoursesCertificates; 
 
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
        'price'         => 'Стоимость' 
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
    ]; 

    private $customMessage = [ 
        'available.required' => 'Укажите доступность на сайте' 
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

        if ($err === true) 
        {
            return ['section', 'lecture'];
        }

        return true;
    } 

    public function validation(array $data, $type='general')
    { 
        if ($this->manager(Courses::whereId($this->id_course)->first())->isStarted() == true && $this->id_course != null) 
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

                if (!in_array($data['pay'], $this->payOptions)) 
                {
                    return 'Ошибка на сервере';
                }

                $errors = []; 
                if (CourseCategory::where('parent_id', $data['id_category'])->count() > 0 && empty($data['subcat_id'])) 
                {
                    $errors['subcat_id'] = ['Укажите <strong>подкатегорию</strong> курса'];
                }

                $validator = Validator::make($data, $rules); 
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
        return $id_course;
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
    } 

    public function editSettings(array $data)
    {   
        $dataUpdate = [ 
            'type'           => intval($data['type']),
            'is_open_to'     => !empty($data['hide_after_end']) ? date('Y-m-d', strtotime($data['is_open_to'])) : null,
            'is_open_from'   => !empty($data['hide_after_end']) ? date('Y-m-d', strtotime($data['is_open_from'])) : null,
            'max_nr_people'  => intval($data['max_nr_people']),
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
        $insert = [];
        foreach ($this->sections as $sectionKey => $section) 
        {  
            $id = CourseSections::create([
                'name'      => $section['name'],
                'id_course' => $this->id_course
            ])->id;

            foreach (sortValue($this->lectures[$sectionKey]) as $lectureKey => $lecture) 
            { 
                SectionLectures::insert([
                    'id_section'      => $id,
                    'name'            => $lecture['name'],
                    'description'     => $lecture['description'],
                    'duration_hourse' => toFloat($lecture['hourse']),
                    'duration_minutes' => toFloat($lecture['minutes']),
                ]);
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
