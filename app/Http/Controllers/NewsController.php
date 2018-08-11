<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsCategory;

class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    public function index($cat_url = false, $category = [])
    {
        $news = News::where('view', '1')->orderBy('created_at', 'asc');
        if (!empty($cat_url)) 
        {
          $news->whereHas('category', function($query) use($cat_url){
            return $query->where('url', $cat_url);
          });

          $category = NewsCategory::where('url', $cat_url)->firstOrFail();
        }

        $data = [
          'news'       => $news->get(),
          'category'   => $category,
          'totalNews'  => News::where('view', '1')->orderBy('created_at', 'asc')->count(),
          'categories' => NewsCategory::has('news')->where('view', '1')->orderBy('page_up', 'asc')->orderBy('id', 'desc')->get()
        ];
        return view('news.catalog', $data);
    }

    public function view($url)
    {
      $data = News::where('view', '1')->where('url', $url)->firstOrFail();
      $data = [
        'data'      => $data,
        'more_news' => News::where('view', '1')
                           ->where('id', '<>', $data->id)
                           ->where('id_category', $data->id_category)
                           ->orderBy('created_at', 'asc')
                           ->get(),
      ];
      return view('news.show', $data);
    }
}
