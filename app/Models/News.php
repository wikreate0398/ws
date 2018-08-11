<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    public $timestamps = true;

	protected $fillable = [
        'name',
        'url',
        'id_category',
        'description',
        'text',
        'image',
        'seo_title',
        'seo_description',
        'seo_keywords'
    ];

    public function category()
    {
        return $this->hasOne('App\Models\NewsCategory', 'id', 'id_category');
    }
}
