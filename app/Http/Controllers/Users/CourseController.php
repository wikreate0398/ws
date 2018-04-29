<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $niceNames = [ 
        'id_category'   => 'Основные рубрики', 
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function validation(array $data)
    { 
        $section  = sortValue(request()->input('section'));
        $lecture  = sortValue(request()->input('lecture'));  
        
        if (!empty($data['pay']) && $data['pay'] == 1) 
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
                'array'    => $section, 
                'excepts'  => [], 
                'fName'    => 'section', 
                'required' => true
            ],
            '1' => [
                'array'   => $lecture, 
                'excepts' => [], 
                'fName'   => 'lecture'
            ] 
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

    public function save(array $data)
    {

    }
}
