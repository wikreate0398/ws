<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Courses; 
use App\Models\CourseSections; 
use App\Models\SectionLectures; 

class Course extends Controller
{
    private $niceNames = [ 
        'id_category'   => 'Категория и подкатегория', 
        'name'          => 'Название курса',
        'description'   => 'Краткое описание курса',
        'pay'           => 'Тип (платный/бесплатный)', 
        'is_open_until' => 'Запись курса открыта до',
        'available'     => 'Доступность на сайте',
        'price'         => 'Стоимость'
    ];

    private $rules = [
        'name'                  => 'required',
        'description'           => 'required|max:200',
        'text'                  => 'max:2000',  
        'id_category'           => 'required',
        'pay'                   => 'required', 
        'is_open_until'         => 'required',
        'available'             => 'required',  
    ]; 

    private $payOptions = ['1','2'];

    private $availableOptions = ['1','2', '3'];

    public $sections = [];

    public $lectures = [];

    public $courseId = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function validation(array $data)
    {         

        $this->sections  = sortValue(request()->input('section'));
        $this->lectures  = request()->input('lecture'); //sortValue(request()->input('lecture')); 
 
        if (!empty($data['pay']) && $data['pay'] == 2) 
        {
            $this->rules['price'] = 'required';
        }

        $validator = Validator::make($data, $this->rules, ['unique' => 'Пользователь уже Существует.']); 
        $validator->setAttributeNames($this->niceNames);  
        if ($validator->fails()) 
        {
            return $validator->errors()->toArray();
        } 

        $validateMultiArr = validateArray([
            '0' => [
                'array'    => $this->sections, 
                'excepts'  => [], 
                'fName'    => 'section', 
                'required' => true
            ],
            // '1' => [
            //     'array'   => $this->lectures, 
            //     'excepts' => [], 
            //     'fName'   => 'lecture'
            // ] 
        ]); 

        if ($validateMultiArr['status'] == false) 
        { 
            return [$validateMultiArr['field'] => ['Заполните все обязательные поля в разделе <strong>Программа курса</strong>!']]; 
        }

        if (!in_array($data['pay'], $this->payOptions) or !in_array($data['available'], $this->availableOptions)) 
        {
            return 'Ошибка на сервере';
        }

        return true;
    }

    public function save(array $data, $id_user)
    {
        return Courses::create([ 
            'id_user'       => $id_user,
            'id_category'   => intval($data['id_category']),
            'id_subcat'     => !empty($data['subcat_id']) ? $data['subcat_id'] : 0,
            'name'          => $data['name'],
            'description'   => $data['description'],
            'text'          => $data['text'],
            'pay'           => intval($data['pay']),
            'is_open_until' => date('Y-m-d', strtotime($data['is_open_until'])),
            'available'     => intval($data['available']),
            'price'         => !empty($data['price']) ? priceString($data['price']) : ''
        ])->id; 
    }

    public function edit(array $data, $id_course, $id_user)
    {
        Courses::where('id', $id_course)
        ->where('id_user', $id_user)
        ->update([ 
            'id_category'   => intval($data['id_category']),
            'id_subcat'     => !empty($data['subcat_id']) ? $data['subcat_id'] : 0,
            'name'          => $data['name'],
            'description'   => $data['description'],
            'text'          => $data['text'],
            'pay'           => intval($data['pay']),
            'is_open_until' => date('Y-m-d', strtotime($data['is_open_until'])),
            'available'     => intval($data['available']),
            'price'         => !empty($data['price']) ? priceString($data['price']) : ''
        ]); 
    }

    public function saveSections($courseId)
    {  
        $insert = [];
        foreach ($this->sections as $sectionKey => $section) 
        {  
            $id = CourseSections::create([
                'name'      => $section['name'],
                'id_course' => $courseId
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

    public function hasAccessCourse($id_course, $id_user)
    {
        return Courses::where('id', $id_course)->where('id_user', $id_user)->count();
    }

    public function hasAccessSection($id_section, $id_user)
    {
        $getCourse = CourseSections::whereId($id_section)->first();
        return Courses::where('id', @$getCourse->id_course)->where('id_user', $id_user)->count();
    }

    public function hasAccessLecture($id_lecture, $id_user)
    {
        $getLecture = SectionLectures::whereId($id_lecture)->first();
        $getCourse  = CourseSections::whereId(@$getLecture->id_section)->first();
        return Courses::where('id', @$getCourse->id_course)->where('id_user', $id_user)->count();
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

    public function delete($id_course)
    {
        Courses::whereId($id_course)->delete();
    }

    public function deleteSectionsAndLectures($id_course, $id_user)
    { 
        $sectionsIds = [];
        foreach (CourseSections::where('id_course', $id_course)->get() as $section) 
        {
            $sectionsIds[] = $section->id;
        } 
        CourseSections::where('id_course', $id_course)->delete();
        SectionLectures::whereIn('id_section', $sectionsIds)->delete();
    }
}
