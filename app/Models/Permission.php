<?php

namespace App\Models;

use App\Enums\PermissionGroup;
use App\Exceptions\PermissionAlreadyExists;
use App\Exceptions\PermissionDoesNotExist;
use App\Services\PermissionService;
use App\Traits\HasRoles;
use App\Traits\HasUuid;
use App\Traits\RefreshesPermissionCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Contracts\Permission as PermissionContract;

class Permission extends Model implements PermissionContract
{
    use HasFactory;
    use HasRoles;
    use RefreshesPermissionCache;
    use HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $fillable = [
         'uuid',
         'name',
         'permission_group',
         'description'
     ];

     protected $casts = [
         'permission_group' => PermissionGroup::class
     ];


    /**
     * Get all the permission's roles
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class,'role_permission');
    }

    /**
     * Get all the users assigned to the permission
     *
     * @return MorphToMany
     */
     public function users(): MorphToMany
     {
         return $this->morphedByMany(User::class,'usable','user_permissions');
     }

    /**
     * @param array $attributes
     *
     * @return Builder|Model
     */
    public static function create(array $attributes = [])
     {
         $permission = static::getPermission(['name' => $attributes['name']]);

         if ($permission){
             throw PermissionAlreadyExists::create($attributes['name']);
         }

         return static::query()->create($attributes);

     }

     /**
      * update permission details
      *
      * @param array $attributes
      * @return void
      */
     public function updatePermission(array $attributes = [])
     {
         $this->update($attributes);

         $this->forgetCachedPermissions();

     }

    /**
     * Find a permission by its name (and optionally guardName).
     *
     * @param string $name
     * @return mixed
     *
     * @return PermissionContract
     * @throws PermissionDoesNotExist
     *
     */
     public static function findByName(string $name): PermissionContract
     {
         $permission = static::getPermission(['name'=>$name]);

         if (! $permission){
             throw PermissionDoesNotExist::create($name);
         }

         return $permission;
     }

    /**
     * Find a permission by its id.
     *
     * @param int $id
     * @return PermissionContract
     *
     * @return PermissionContract
     * @throws PermissionDoesNotExist
     */
     public static function findById(int $id):PermissionContract {
         $permission = static::getPermission(['id'=>$id]);

         if (! $permission){
             throw PermissionDoesNotExist::withId($id);
         }

         return $permission;
     }

    /**
     * @param string $name
     *
     * @return Permission
     */
    public function findOrCreate(string $name): Permission
     {
         $permission = static::getPermission(['name'=>$name]);

         if (! $permission) {
             return static::query()->create(['name'=>$name]);
         }

         return $permission;
     }

    /**
     * Get the current cached permissions
     *
     * @param array $params
     * @param bool $onlyOne
     * @return mixed
     */
     protected static function getPermissions(array $params = [], bool $onlyOne=false): mixed
     {
         return app(PermissionService::class)->getPermissions($params, $onlyOne);
     }


    /**
     * @param array $params
     *
     * @return mixed
     */
    protected static function getPermission(array $params = []): mixed
    {
        return static::getPermissions($params, true)->first();
    }

    protected static function getUserPermission(){

    }

    /**
     * Scope the query to include only permission that match or is like the search term
     *
     * @param $query
     * @param $search
     *
     * @return mixed
     */
    public function scopeSearch($query, $search): mixed
    {
        return $query->when($search, function($q, $search){
            return $q->where('name', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
        });
    }


    /**
     * @param Builder $query
     * @param string|null $permissionGroup
     * @return void
     */
    public function scopeFilterByPermissionGroup( Builder $query, ?string $permissionGroup ){
        $query->when($permissionGroup, function($query, $permissionGroup){
            return $query->where('permission_group', $permissionGroup);
        });
    }

    public function scopeFilterByRole( Builder $query, ?int $roleId ){
        $query->when($roleId, function($query, $roleId){
            return $query->whereRelation('roles', 'roles.id', $roleId);
        });
    }


}
