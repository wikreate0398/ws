<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniversityBookmarks extends Model
{
    protected $table = 'university_bookmarks';

    public $timestamps = false;

	protected $fillable = [ 
        'id_university',
        'id_user'
    ];

    public function university()
    {
    	return $this->hasOne('App\Models\User', 'id', 'id_university');
    }
}
