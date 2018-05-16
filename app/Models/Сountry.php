<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Сountry extends Model
{
    protected $table = 'country';

    public $timestamps = false;
 

	protected $fillable = [
        'name' 
    ];
}
