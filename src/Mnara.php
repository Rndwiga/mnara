<?php

namespace Tyondo\Mnara;

use Tyondo\Mnara\Models\Role;
use Tyondo\Mnara\Models\User;
use Tyondo\Mnara\Models\Permission;
use Caffeinated\Themes\Facades\Theme;
use Illuminate\Contracts\Auth\Guard;

class Mnara
{
    /**
     * @var Illuminate\Contracts\Auth\Guard
     */
    protected $auth;
    protected $permissionsLoaded = false;
    protected $permissions = [];
    protected $users = [];

    /**
     * Create a new UserHasPermission instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    public function routes()
    {
        require __DIR__.'/../Publishable/Routes/web.php';
    }
    public function view($name, $data = null)
    {
        if(config('mnara.use_theme') === true){
            $name_fragment = explode("::", $name);
            // package-namespace --> $name_fragment[0]
            // view location --> $name_fragment[1] ;
            if(isset($data)){
                return Theme::view($name_fragment[1], $data);
            }
            return Theme::view($name_fragment[1]);
        }
        //run this if use of theme has not been switched on
        if(isset($data)){
            return view($name, $data);
        }
        return view($name);
    }

    /**
     * Checks if user has the given permissions.
     *
     * @param mixed
     *
     * @return bool
     */

    public function can($permissions)
    {
        if ($this->auth->check()) {
            $this->loadPermissions();
            // Check if permission exist
            $exist = $this->permissions->where('slug', $permissions)->first();

            if ($exist) {
                $user = $this->getUser();
                if ($user == null || !$this->auth->user()->can($permissions)) {
                    return false;
                }

                return true;
            }
            return true;
        } else {
            $guest = Role::whereSlug('guest')->first();

            if ($guest) {
                return $guest->can($permissions);
            }
        }
        return false;
    }
    protected function loadPermissions()
    {
        if (!$this->permissionsLoaded) {
            $this->permissionsLoaded = true;

            $this->permissions = Permission::all();
        }
    }

    protected function getUser($id = null)
    {
        if (is_null($id)) {
            $id = auth()->check() ? auth()->user()->id : null;
        }

        if (is_null($id)) {
            return;
        }

        if (!isset($this->users[$id])) {
            $this->users[$id] = User::find($id);
        }

        return $this->users[$id];
    }

    /**
     * Checks if user has at least one of the given permissions.
     *
     * @param array $permissions
     *
     * @return bool
     */
    public function canAtLeast($permissions)
    {
        if ($this->auth->check()) {
            return $this->auth->user()->canAtLeast($permissions);
        } else {
            $guest = Role::whereSlug('guest')->first();

            if ($guest) {
                return $guest->canAtLeast($permissions);
            }
        }

        return false;
    }

    /**
     * Checks if user is assigned the given role.
     *
     * @param string $slug
     *
     * @return bool
     */
    public function isRole($role)
    {
        if ($this->auth->check()) {
            return $this->auth->user()->isRole($role);
        } else {
            if ($role === 'guest') {
                return true;
            }
        }

        return false;
    }
}
