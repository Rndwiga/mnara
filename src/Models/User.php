<?php

namespace Tyondo\Mnara\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tyondo\Mnara\Traits\MnaraTrait;

class User extends Authenticatable
{
    use Notifiable;
    use MnaraTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that are used to log user activities.
     *
     * @var array
     */
    protected static $logAttributes = ['name', 'email','password'];

}
