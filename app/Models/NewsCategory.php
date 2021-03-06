<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_category';

    public $timestamps = false;
 

	protected $fillable = [
        'name',
        'url',
        'seo_title',
        'seo_description',
        'seo_keywords'
    ];

    public function news()
    {
        return $this->hasMany('App\Models\News', 'id_category', 'id')->orderBy('created_at', 'desc');
    }
}
