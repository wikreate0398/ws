<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountViews extends Model
{
    protected $table = 'count_views';

    public $timestamps = false;

	protected $fillable = [ 
        'type',
        'id_item',
        'count'
    ]; 
}
