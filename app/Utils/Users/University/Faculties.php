<?php

namespace App\Utils\Users\University;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\UniversityFaculties;   
use App\Models\UniversityFacultiesSubjects;    
 
class Faculties 
{
    private $niceNames = [  
        'name'              => 'Название факультета',
        'duration_learning' => 'Длительность обучения',
        'average_nr_points' => 'Среднее кол-во баллов',
        'qty_budget'        => 'Кол-во бюджетных мест',
        'type'              => 'Форма обучения',
        'price'             => 'Стоимость',
        'teacher_subjects'  => 'Предметы'
    ];

    private $rules = [
        'name'              => 'required',
        'duration_learning' => 'required',
        'average_nr_points' => 'required',
        'qty_budget'        => 'required',
        'type'              => 'required',
        'price'             => 'required',
        'teacher_subjects'  => 'required',
    ];  

    public $formLearningOptipons = ['full_time_learning', 'non_public_learning', 'distance_learning'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {} 

    public function validation(array $data)
    {           
        $errors = []; 
         
        $validator = Validator::make($data, $this->rules); 
        $validator->setAttributeNames($this->niceNames);  
        if ($validator->fails()) 
        {
            $errors = array_merge($errors, $validator->errors()->toArray());
        } 

        if (!empty($errors)) 
        {
            return $errors;
        }  
 

        return true;
    }

    public function save(array $data, $id_university)
    { 
        $createArray = [ 
            'name'              => $data['name'],
            'duration_learning' => $data['duration_learning'],
            'average_nr_points' => $data['average_nr_points'],
            'qty_budget'        => $data['qty_budget'], 
            'price'             => $data['price'],
            'id_university'     => $id_university
        ];

        foreach ($data['type'] as $field => $value) 
        {
            if (in_array($field, $this->formLearningOptipons)) 
            {
                $createArray[$field] = 1;
            } 
        } 

        $add = UniversityFaculties::create($createArray);  
        $this->saveFacultySubjects($data['teacher_subjects'], $add->id); 
        return $add->id;
    }

    public function saveFacultySubjects($subjects, $id_faculty)
    { 
        UniversityFacultiesSubjects::where('id_faculty', $id_faculty)->delete();
        if (!empty($subjects)) 
        {  
            foreach ($subjects as $key => $id_subject) 
            {
                $insert[] = [
                    'id_faculty' => $id_faculty,
                    'id_subject' => $id_subject
                ];
            }
            UniversityFacultiesSubjects::insert($insert);
        } 
    }

    public function edit(array $data, $id_faculty, $id_university)
    { 
        $editArray = [ 
            'name'              => $data['name'],
            'duration_learning' => $data['duration_learning'],
            'average_nr_points' => $data['average_nr_points'],
            'qty_budget'        => $data['qty_budget'], 
            'price'             => $data['price'] 
        ];
        
        foreach ($this->formLearningOptipons as $key => $value) 
        {
            if (!empty($data['type'][$value])) 
            {
               $editArray[$value] = 1;
            }
            else
            {
                $editArray[$value] = 0;
            }
        }

        UniversityFaculties::where('id', $id_faculty)
        ->where('id_university', $id_university)
        ->update($editArray); 
        $this->saveFacultySubjects($data['teacher_subjects'], $id_faculty); 
    } 

    public function hasAccessFaculty($id_faculty, $id_university)
    {
        return UniversityFaculties::where('id', $id_faculty)->where('id_university', $id_university)->count();
    } 

    public function delete($id_faculty)
    {
        UniversityFaculties::whereId($id_faculty)->delete();
    } 
}
