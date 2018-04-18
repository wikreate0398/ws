<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	public $timestamps = false;

	protected $table = 'menu';

	protected $fillable = [
        'name',
        'text',
        'url',
        'seo_title',
        'seo_description',
        'seo_keywords'
    ];
}
