<?php

namespace App\Traits;

use App\Exceptions\PermissionDoesNotExist;
use App\Models\Lecturer;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\PermissionService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *Has Permissions
 */
trait HasPermissions
{
    /**
     * when deleting delete also delete the related permissions
     */
    public static function bootHasPermissions(): void
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }

            $model->permissions()->detach();
        });
    }

    /**
     * Scope the model query to certain permissions only.
     *
     * @param Builder $query
     * @param string|array|Permission|\Illuminate\Support\Collection $permissions
     *
     * @return Builder
     */
    public function scopePermission(Builder $query, $permissions):Builder
    {
        $permissions = $this->convertToPermissionModels($permissions);

        $rolesWithPermissions = array_unique(array_reduce($permissions, function ($result, $permission){
            return array_merge($result, $permission->roles->all());
        }, []));

        return $query->where(function (Builder $query) use ($permissions, $rolesWithPermissions) {
            $query->whereHas('permissions', function (Builder $subQuery) use ($permissions) {
                $subQuery->whereIn('permissions.id', \array_column($permissions, 'id'));
            });
            if (count($rolesWithPermissions) > 0) {
                $query->orWhereHas('roles', function (Builder $subQuery) use ($rolesWithPermissions) {
                    $subQuery->whereIn('roles.id', \array_column($rolesWithPermissions, 'id'));
                });
            }
        });
    }

    /**
     * @param string|array|Permission|\Illuminate\Support\Collection $permissions
     *
     * @return array
     */
    protected function convertToPermissionModels($permissions): array
    {
        if ($permissions instanceof Collection) {
            $permissions = $permissions->all();
        }

        $permissions = is_array($permissions) ? $permissions : [$permissions];

        return array_map(function ($permission) {
            if ($permission instanceof Permission) {
                return $permission;
            }

            return Permission::findByName($permission);
        }, $permissions);
    }


    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        if (is_string($permission)) {
            $permission = Permission::findByName($permission);
        }

        if (is_int($permission)){
            $permission = Permission::findById($permission);
        }

        if (! $permission instanceof Permission) {
            throw new PermissionDoesNotExist();
        }

        return $this->hasDirectPermission($permission) || $this->hasPermissionViaRole($permission);
    }


    /**
     * An alias to hasPermissionTo(), but avoids throwing an exception.
     *
     * @param string|int $permission
     * @return bool
     */
    public function checkPermissionTo($permission): bool
    {
        try {
            return $this->hasPermissionTo($permission);
        }catch (PermissionDoesNotExist $e){
            return false;
        }
    }

    /**
     * Determine if the model has any of the given permissions.
     *
     * @param array ...$permissions
     *
     * @return bool
     * @throws Exception
     */
    public function hasAnyPermission(...$permissions): bool
    {
        $permissions = collect($permissions)->flatten();

        foreach ($permissions as $permission) {
            if ($this->checkPermissionTo($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the model has all of the given permissions.
     *
     * @param array ...$permissions
     *
     * @return bool
     * @throws Exception
     */
    public function hasAllPermissions(...$permissions): bool
    {
        $permissions = collect($permissions)->flatten();

        foreach ($permissions as $permission) {
            if (! $this->hasPermissionTo($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Determine if the model has, via roles, the given permission.
     *
     * @param Permission $permission
     *
     * @return bool
     */
    protected function hasPermissionViaRole(Permission $permission): bool
    {
        return $this->hasRole($permission->roles);
    }


    /**
     * Determine if the model has the given permission.
     *
     * @param string|int|Permission $permission
     * @return bool
     *
     * @throws PermissionDoesNotExist
     */
    public function hasDirectPermission($permission): bool
    {
        if (is_string($permission)){
            $permission = Permission::findByName($permission);
        }

        if (is_int($permission)){
            $permission = Permission::findById($permission);
        }

        if (! $permission instanceof Permission) {
            throw new PermissionDoesNotExist();
        }

        return $this->permissions->contains('id', $permission->id);
    }

    /**
     * Return all the permissions the model has via roles.
     *
     * @return Collection
     */
    public function getPermissionsViaRoles():Collection
    {
        return $this->loadMissing('roles','roles.permissions')->roles->flatMap(function ($role){
            return $role->permissions;
        })->sort()->values();
    }

    /**
     * Grant the given permissions to a role
     *
     * @param ...$permissions
     *
     * @return $this
     */
    public function givePermissionTo(...$permissions)
    {
        $permissions = $this->getPermissionsIds($permissions);

        $this->permissions()->sync($permissions, false);

        if (is_a($this,'App\Models\Role::Class')){
            $this->forgetCachedPermissions();
        }

        $this->load('permissions');

        return $this;
    }


    /**
     * Remove all current permissions and set the given ones.
     *
     * @param ...$permissions
     *
     * @return Role|User
     */
    public function syncPermissions(...$permissions): User|Lecturer|Role
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }


    /**
     * Revoke the given permission.
     *
     * @param $permission
     * @return $this
     */
    public function revokePermissionTo($permission)
    {
        $this->permissions()->detach($this->getStoredPermission($permission));

        if (is_a($this, 'App\Models\Role::class')) {
            $this->forgetCachedPermissions();
        }

        $this->load('permissions');

        return $this;
    }

    public function getPermissionNames(): Collection
    {
        return $this->permissions->pluck('name');
    }


    /**
     * @param array $permissions
     * @return array
     */
    public function getPermissionsIds(array $permissions): array
    {
        return collect($permissions)
            ->flatten()
            ->map(function ($permission){
                if (empty($permission)){
                    return false;
                }
                return $this->getStoredPermission($permission);
            })
            ->filter(function ($permission){
                return $permission instanceof Permission;
            })->pluck('id')
            ->toArray();
    }


    /**
     * @param  string|array|Permission|\Illuminate\Support\Collection $permissions
     * @return \App\Contracts\Permission|Permission[]|\Illuminate\Support\Collection
     */
    protected function getStoredPermission($permissions)
    {
        if (is_numeric($permissions)){
            return Permission::findById($permissions);
        }

        if (is_string($permissions)){
            return Permission::findByName($permissions);
        }

        if (is_array($permissions)){
            return Permission::whereIn('name', $permissions)->get();
        }

        return $permissions;
    }

    /**
     * Forget the cached permissions.
     */
    public function forgetCachedPermissions()
    {
        app(PermissionService::class)->forgetCachedPermissions();
    }

    /**
     * Check if the model has All of the requested Direct permissions.
     * @param array ...$permissions
     * @return bool
     */
    public function hasAllDirectPermissions(...$permissions): bool
    {
        $permissions = collect($permissions)->flatten();

        foreach ($permissions as $permission) {
            if (! $this->hasDirectPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the model has Any of the requested Direct permissions.
     * @param array ...$permissions
     * @return bool
     */
    public function hasAnyDirectPermission(...$permissions): bool
    {
        $permissions = collect($permissions)->flatten();

        foreach ($permissions as $permission) {
            if ($this->hasDirectPermission($permission)) {
                return true;
            }
        }

        return false;
    }



}
