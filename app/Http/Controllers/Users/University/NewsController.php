<?php

namespace App\Http\Controllers\Users\University;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\UniversityNews;      
use App\Utils\Users\University\News;

class NewsController extends UniversityController
{

    protected $_news;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->_news = new News;
    } 

    public function showNews()
    { 
        $news = UniversityNews::getProfileNews(Auth::user()->university->id, request()->all());

        return view('users.university_profile', [ 
            'user'    => Auth::user(),  
            'news'    => $news, 
            'include' => $this->viewPath . '.news.list',
        ]); 
    }

    public function showNewsForm()
    {  
        return view('users.university_profile', [ 
            'user'          => Auth::user(), 
            'include'       => $this->viewPath . '.news.add' 
        ]); 
    } 

    public function editNewsForm($id_news)
    {
        $user = Auth::user();  
        return view('users.university_profile', [ 
            'user'    => Auth::user(), 
            'include' => $this->viewPath . '.news.edit', 
            'news'    => UniversityNews::where('id_university', $user->university->id)->findOrFail($id_news)
        ]); 
    }

    public function saveNews(Request $request)
    { 
        $validate = $this->_news->validation($request->all());
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        } 

        $idFaculty = $this->_news->save($request->all(), Auth::user()->university->id); 
  
        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('user_news'))], 'Новость успешно добавлен!');
    }

    public function editNews($idNews, Request $request)
    {  
        if (!$this->_news->hasAccessNews($idNews, Auth::user()->university->id)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => 'Ошибка']);
        }

        $validate = $this->_news->validation($request->all());
        if ($validate !== true) 
        {
            return \App\Utils\JsonResponse::error(['messages' => $validate]);  
        }    

        $this->_news->edit($request->all(), $idNews, Auth::user()->university->id); 

        return \App\Utils\JsonResponse::success(['redirect' => route(userRoute('user_news'))], 'Новость успешно изменен!');
    }

    public function deleteNews($id_news)
    {  
        if ($this->_news->hasAccessNews($id_news, Auth::user()->university->id)) 
        {
            $this->_news->delete($id_news); 
        }
        return redirect()->route(userRoute('user_news'));
    } 
}
