<?php

namespace App\Models;

use App\Exceptions\RoleAlreadyExists;
use App\Exceptions\RoleDoesNotExist;
use App\Traits\HasPermissions;
use App\Traits\HasUuid;
use App\Traits\RefreshesPermissionCache;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;

/**
 * @method static when(bool $param, \Closure $param1)
 */
class Role extends Model implements \App\Contracts\Role
{
    use HasFactory;
    use HasPermissions;
    use RefreshesPermissionCache;
    use Searchable;
    use HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $fillable = [
         'name',
         'description'
     ];

    protected $hidden = ['pivot'];

    /**
     * Get all roles' permissions
     *
     * @return BelongsToMany
     */
     public function permissions(): BelongsToMany
     {
         return $this->belongsToMany(Permission::class,'role_permission');
     }

    /**
     * Get all users assigned to the role
     *
     * @return MorphToMany
     */
     public function users(): MorphToMany
     {
         return $this->morphedByMany(User::class,'usable','user_roles');
     }

    /**
     * Scope a query to only include non superuser roles
     *
     * @param $query
     * @return mixed
     */
    public function scopeNonSuper($query): mixed
    {
         return $query->where('name', '<>', 'Super User');
     }

    /**
     * @param array $attributes
     * @return Builder|Model
     */
    public static function create(array $attributes = []): Model|Builder
    {
        $params = ['name' => $attributes['name']];

        if (static::findByParam($params)) {
            throw RoleAlreadyExists::create($attributes['name']);
        }

        return static::query()->create($attributes);
    }

    /**
     * Find a role by its name.
     *
     * @param string $name
     * @return \App\Contracts\Role|Role
     *
     */
    public static function findByName(string $name): \App\Contracts\Role|Role
    {
        $role = static::findByParam(['name' => $name]);

        if (! $role) {
            throw RoleDoesNotExist::named($name);
        }

        return $role;
    }

    /**
     * Find a role by its id.
     *
     * @param int $id
     * @return Role
     */
    public static function findById(int $id): Role
    {
        $role = static::findByParam(['id' => $id]);

        if (! $role) {
            throw RoleDoesNotExist::withId($id);
        }

        return $role;
    }

    /**
     * Find or create role by its name .
     *
     * @param string $name
     * @return Builder|Model
     */
    public static function findOrCreate(string $name): Model|Builder
    {
        $role = static::findByParam(['name' => $name]);

        if (! $role) {
            return static::query()->create(['name' => $name]);
        }

        return $role;
    }

    /**
     * @param array $params
     * @return mixed
     */
    protected static function findByParam(array $params = []): mixed
    {
        $query = static::when(count($params) === 0, function ($q) use ($params) {
            $q->whereIn('name', $params);
        });
        foreach ($params as $key => $value) {
            $query->where($key, $value);
        }

        return $query->first();
    }

    public function scopeSuperUser($query){
        return $query->where('name', 'Super User');
    }

    public function scopeNoneSuperUser($query){
        return $query->when(Auth::user()->name !== 'Super User', fn(Builder $qry) => $qry->where('name', '<>', 'Super User') );
    }

    public function scopeSearchRoles($query, $search){
        return $query->when($search, function ($qry, $search){
            return $qry->search($search, ['name','permissions.name', 'description']);
        });
    }

}
