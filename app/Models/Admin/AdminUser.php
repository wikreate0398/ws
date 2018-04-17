<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
	protected $guard = 'admin';

    protected $table = 'admin_users';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
 
}
