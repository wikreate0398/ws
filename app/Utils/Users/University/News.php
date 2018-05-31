<?php

namespace App\Utils\Users\University;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\UniversityNews;      
 
class News 
{
    private $niceNames = [  
        'name'              => 'Название курса',
        'description'       => 'Описание новости', 
        'type'              => 'Тип новости', 
    ];

    private $rules = [
        'name'              => 'required|max:80',
        'description'       => 'required|max:200', 
        'type'              => 'required', 
    ];  

    public $typeOptipons = ['news', 'event'];

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

        if (!in_array($data['type'], $this->typeOptipons)) 
        {
            return 'Ошибка на сервере!';
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
            'name'          => $data['name'],
            'description'   => $data['description'],
            'type'          => $data['type'],
            'view'          => !empty($data['view']) ? 1 : 0,  
            'id_university' => $id_university
        ]; 

        $add = UniversityNews::create($createArray);    
        return $add->id;
    } 

    public function edit(array $data, $id_news, $id_university)
    { 
        $editArray = [ 
            'name'          => $data['name'],
            'description'   => $data['description'],
            'type'          => $data['type'],
            'view'          => !empty($data['view']) ? 1 : 0
        ]; 
        
        UniversityNews::where('id', $id_news)
        ->where('id_university', $id_university)
        ->update($editArray);  
    } 

    public function hasAccessNews($id_news, $id_university)
    {
        return UniversityNews::where('id', $id_news)->where('id_university', $id_university)->count();
    } 

    public function delete($id_news)
    {
        UniversityNews::whereId($id_news)->delete();
    } 
}
