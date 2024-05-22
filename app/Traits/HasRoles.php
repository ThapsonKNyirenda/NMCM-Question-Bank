<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Has Roles Trait
 */
trait HasRoles {

    use HasPermissions;

    /**
     * Get all the models' roles
     *
     * @return MorphToMany
     */
    public function roles(): MorphToMany
    {
        return $this->morphToMany(Role::class,'usable','user_roles');
    }

    /**
     * Get all the model's permissions
     *
     * @return MorphToMany
     */
    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'usable','user_permissions');
    }

    /**
     * Scope the model query to certain roles only.
     *
     * @param Builder $query
     * @param int|array|\Illuminate\Support\Collection|string|Role $roles
     * @return Builder
     */
    public function scopeRole(Builder $query, int|array|\Illuminate\Support\Collection|string|Role $roles): Builder
    {
        if ($roles instanceof Collection) {
            $roles = $roles->all();
        }

        if (! is_array($roles)) {
            $roles = [$roles];
        }

        $roles = array_map(function ($role) {
            if ($role instanceof Role) {
                return $role;
            }

            $method = is_numeric($role) ? 'findById' : 'findByName';

            return Role::{$method}($role);
        }, $roles);

        return $query->whereHas('roles', function (Builder $subQuery) use ($roles) {
            $subQuery->whereIn('roles.id', \array_column($roles, 'id'));
        });
    }

    /**
     * Assign the given role to the model.
     *
     * @param array|string|int|Role ...$roles
     *
     * @return Model
     */
    public function assignRole(...$roles): Model
    {
        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) {
                if (empty($role)) {
                    return false;
                }

                return $this->getStoredRole($role);
            })
            ->filter(function ($role) {
                return $role instanceof Role;
            })->pluck('id')->toArray();

        $this->roles()->sync($roles, false);

        $this->load('roles');

        /*if (is_a($this, 'App\Models\Role::class')) {
            $this->forgetCachedPermissions();
        }*/

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Revoke the given role from the model.
     *
     * @param int|string|Role $role
     *
     * @return Model
     */
    public function removeRole(int|string|Role $role): Model
    {
        $this->roles()->detach($this->getStoredRole($role));

        $this->load('roles');

        if (is_a($this, 'App\Models\Role::class')) {
            $this->forgetCachedPermissions();
        }

        return $this;
    }

    /**
     * Remove all current roles and set the given ones.
     *
     * @param array|Role|string|int ...$roles
     *
     * @return Model
     */
    public function syncRoles(...$roles): Model
    {
        $this->roles()->detach();

        return $this->assignRole($roles);
    }

    /**
     * Determine if the model has (one of) the given role(s).
     *
     * @param array|string|Collection|Role $roles
     * @return bool
     */
    public function hasRole(Collection|array|string|Role $roles):bool{
        if ( is_string($roles) && str_contains($roles, '|')){
            $roles = $this->convertPipeToArray($roles);
        }
        if (is_string($roles)){
            return $this->roles->contains('name', $roles);
        }

        if (is_int($roles)){
            return $this->roles->contains('id', $roles);
        }

        if ($roles instanceof Role){
            return $this->roles->contains('id', $roles->id);
        }

        if (is_array($roles)){
            foreach ($roles as $role){
                if ($this->hasRole($role)){
                    return true;
                }
            }

            return false;
        }

        return $roles->intersect($this->roles)->isNotEmpty();
    }

    /**
     * Determine if the model has any of the given role(s).
     *
     * @param string|array|Role|Collection $roles
     * @return bool
     */
    public function hasAnyRole(...$roles):bool{
       return $this->hasRole($roles);
    }

    /**
     * Determine if the model has all of the given role(s).
     *
     * @param array|\Illuminate\Support\Collection|string|Role $roles
     * @return bool
     */
    public function hasAllRoles(array|\Illuminate\Support\Collection|string|Role $roles): bool
    {
        if (is_string($roles) && str_contains($roles, '|')) {
            $roles = $this->convertPipeToArray($roles);
        }

        if (is_string($roles)) {
            return $this->roles->contains('name', $roles);
        }

        if ($roles instanceof Role) {
            return $this->roles->contains('id', $roles->id);
        }

        $roles = collect()->make($roles)->map(function ($role) {
            return $role instanceof Role ? $role->name : $role;
        });

        return $roles->intersect( $this->getRoleNames()) == $roles;
    }


    /**
     * Determine if the model has exactly all the given role(s).
     *
     * @param array|\Illuminate\Support\Collection|string|Role $roles
     * @return bool
     */
    public function hasExactRoles(array|\Illuminate\Support\Collection|string|Role $roles): bool
    {
        if (is_string($roles) && str_contains($roles, '|')) {
            $roles = $this->convertPipeToArray($roles);
        }

        if (is_string($roles)) {
            $roles = [$roles];
        }

        if ($roles instanceof Role) {
            $roles = [$roles->name];
        }

        $roles = collect()->make($roles)->map(function ($role) {
            return $role instanceof Role ? $role->name : $role;
        });

        return $this->roles->count() == $roles->count() && $this->hasAllRoles($roles);
    }


    /**
     * Return all permissions directly coupled to the model.
     */
    public function getDirectPermissions(): Collection
    {
        return $this->permissions;
    }

    /**
     * Get the array of names of all roles
     *
     * @return Collection
     */
    public function getRoleNames(): Collection
    {
        return $this->roles->pluck('name');
    }

    /**
     * @param $role
     * @return Role
     */
    protected function getStoredRole($role): Role
    {
        if (is_numeric($role)) {
            return Role::findById($role);
        }

        if (is_string($role)) {
            return Role::findByName($role);
        }

        return $role;
    }


    /**
     * @param string $pipeString
     * @return string|string[]
     */
    protected function convertPipeToArray(string  $pipeString): array|string
    {
        $pipeString = trim($pipeString);

        if (strlen($pipeString) <= 2){
            return $pipeString;
        }

        $quoteChar = substr($pipeString, 0,1);
        $endChar = substr($pipeString, -1, 1);

        if ($quoteChar !== $endChar){
            return explode('|', $pipeString);
        }
        if (! in_array($quoteChar,["'",'"'])){
            return explode('|', $pipeString);
        }

        return explode('|', trim($pipeString, $quoteChar));
    }
}
