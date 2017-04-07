<?php

namespace Tyondo\Mnara\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    use LogsActivity;
    /**
     * The attributes that are fillable via mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'special'];
    /**
     * The attributes that are used to log user activities.
     *
     * @var array
     */
    protected static $logAttributes = ['name', 'slug', 'description', 'special'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The cache tag used by the model.
     *
     * @var string
     */
    protected $tag = 'mnara.roles';

    /**
     * Roles can belong to many users.
     *
     * @return Model
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.model') ?: config('auth.providers.users.model'))->withTimestamps();
    }

    /**
     * Roles can have many permissions.
     *
     * @return Model
     */
    public function permissions()
    {
        return $this->belongsToMany('\Tyondo\Mnara\Models\Permission')->withTimestamps();
    }

    /**
     * Get permission slugs assigned to role.
     *
     * @return array
     */
    public function getPermissions()
    {
        $primaryKey = $this->primaryKey;
        $cacheKey   = 'mnara.permissions.'.$primaryKey;

        if (method_exists(app()->make('cache')->getStore(), 'tags')) {
            return app()->make('cache')->tags($this->tag)->remember($cacheKey, 60, function () {
                return $this->permissions->pluck('slug')->all();
            });
        }

        return $this->permissions->pluck('slug')->all();
    }

    /**
     * Flush the permission cache repository.
     *
     * @return void
     */
    public function flushPermissionCache()
    {
        if (method_exists(app()->make('cache')->getStore(), 'tags')) {
            app()->make('cache')->tags($this->tag)->flush();
        }
    }

    /**
     * Checks if the role has the given permission.
     *
     * @param string $permission
     *
     * @return bool
     */
    public function can($permission)
    {
        if ($this->special === 'no-access') {
            return false;
        }

        if ($this->special === 'all-access') {
            return true;
        }

        $permissions = $this->getPermissions();

        if (is_array($permission)) {
            $permissionCount   = count($permission);
            $intersection      = array_intersect($permissions, $permission);
            $intersectionCount = count($intersection);

            return ($permissionCount == $intersectionCount) ? true : false;
        } else {
            return in_array($permission, $permissions);
        }
    }

    /**
     * Check if the role has at least one of the given permissions.
     *
     * @param array $permission
     *
     * @return bool
     */
    public function canAtLeast(array $permission = [])
    {
        if ($this->special === 'no-access') {
            return false;
        }

        if ($this->special === 'all-access') {
            return true;
        }

        $permissions = $this->getPermissions();

        $intersection      = array_intersect($permissions, $permission);
        $intersectionCount = count($intersection);

        return ($intersectionCount > 0) ? true : false;
    }

    /**
     * Assigns the given permission to the role.
     *
     * @param int $permissionId
     *
     * @return bool
     */
    public function assignPermission($permissionId = null)
    {
        $permissions = $this->permissions;

        if (!$permissions->contains($permissionId)) {
            $this->flushPermissionCache();

            return $this->permissions()->attach($permissionId);
        }

        return false;
    }

    /**
     * Revokes the given permission from the role.
     *
     * @param int $permissionId
     *
     * @return bool
     */
    public function revokePermission($permissionId = '')
    {
        $this->flushPermissionCache();

        return $this->permissions()->detach($permissionId);
    }

    /**
     * Syncs the given permission(s) with the role.
     *
     * @param array $permissionIds
     *
     * @return bool
     */
    public function syncPermissions(array $permissionIds = [])
    {
        $this->flushPermissionCache();

        return $this->permissions()->sync($permissionIds);
    }

    /**
     * Revokes all permissions from the role.
     *
     * @return bool
     */
    public function revokeAllPermissions()
    {
        $this->flushPermissionCache();

        return $this->permissions()->detach();
    }
}

