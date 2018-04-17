<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guard = 'web';

    protected $table = 'users';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'surname', 
        'patronymic', 
        'user_type', 
        'phone', 
        'date_birth', 
        'city', 
        'phone2', 
        'fax', 
        'site', 
        'image', 
        'confirm_hash'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cityData()
    {
        return $this->hasOne('App\Models\Cities', 'id', 'city');
    }
}
