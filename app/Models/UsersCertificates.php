<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersCertificates extends Model
{
    protected $table = 'users_certificates';

    public $timestamps = false;

	protected $fillable = [ 
        'id_user',
        'image'
    ]; 
}
