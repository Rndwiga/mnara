<?php

namespace Tyondo\Mnara\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Caffeinated\Shinobi\Traits\ShinobiTrait;

class User extends Authenticatable
{
    use Notifiable;
    use ShinobiTrait;
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
        'name', 'email', 'password',
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
     * The roles that have the permissions.
     */
    public function roles()
    {
        return $this->belongsToMany('Tyondo\Mnara\Models\Role');
        //return $this->belongsToMany('App\Role');
    }
}
