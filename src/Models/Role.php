<?php

namespace Tyondo\Mnara\Models;

use Illuminate\Database\Eloquent\Model;

use Tyondo\Mnara\Models\User;
use Tyondo\Mnara\Models\Permission;

class Role extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'special'];

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany('Tyondo\Mnara\Models\User');
        //return $this->belongsToMany('App\User');
    }
    
    /**
     * The users that belong to the role.
     */
    public function permissions()
    {
        return $this->belongsToMany('Tyondo\Mnara\Models\Permission');
        //return $this->belongsToMany('App\Permission');
    }
    
}
