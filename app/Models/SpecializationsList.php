<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecializationsList extends Model
{
    protected $table = 'specializations_list';

    public $timestamps = false;

	protected $fillable = [ 
        'name' 
    ]; 
}
