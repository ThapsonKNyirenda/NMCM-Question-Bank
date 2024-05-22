<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use DateInterval;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use function array_key_exists;


class PermissionService
{
    /**
     * @var Repository
     */
    protected $cache;

    /**
     * @var CacheManager
     */
    protected CacheManager $cacheManager;

    /**
     * @var Collection|null
     */
    protected ?Collection $permissions;

    /**
     * @var DateInterval|int
     */
    public static $cacheExpirationTime;

    /**
     * @var string
     */
    public static string $cacheKey;

    /**
     * @var array
     */
    private array $cachedRoles = [];

    private array $alias = [];

    private array $except = [];

    private array $wildcardPermissionsIndex = [];

    /**
     * @param CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager){
        $this->cacheManager = $cacheManager;
        $this->initializeCache();
    }

    /**
     * Initialize cache
     */
    public function initializeCache(): void
    {
        self::$cacheExpirationTime = config('permission.cache.expiration_time') ?: DateInterval::createFromDateString('9 hours');

        self::$cacheKey = config('permission.cache.key');

        $this->cache = $this->getCacheStoreFromConfig();
    }

    /**
     * @return Repository
     */
    public function getCacheStoreFromConfig(): Repository
    {
        // where 'default' means to use config(cache.default)
        $cacheDriver = config('permission.cache.store', 'default');
        if ($cacheDriver === 'default'){
            return $this->cacheManager->store();
        }

        // if an undefined cache store is specified, fallback to 'array' which is Laravel's closest equiv to 'none'
        if (! array_key_exists($cacheDriver, config('cache.stores'))) {
            $cacheDriver = 'array';
        }

        return $this->cacheManager->store($cacheDriver);

    }

    /**
     * Register the permission check method on the gate.
     * We resolve the Gate fresh here, for benefit of long-running instances.
     *
     * @return bool
     */
    public function registerPermissions():bool{
        Gate::before(function (Authorizable $user, string $ability){
            if (method_exists($user, 'checkPermissionTo')) {
                return $user->checkPermissionTo($ability) ?: null;
            }
        });

        return true;
    }

    /**
     * Flush the cache
     */
    public function forgetCachedPermissions(): bool
    {
        $this->permissions = null;
        //$this->forgetWildcardPermissionIndex();

        return $this->cache->forget(self::$cacheKey);
    }

    public function forgetWildcardPermissionIndex(?Model $record = null): void
    {
        if ($record) {
            unset($this->wildcardPermissionsIndex[get_class($record)][$record->getKey()]);

            return;
        }

        $this->wildcardPermissionsIndex = [];
    }


    public function getWildcardPermissionIndex(Model $record): array
    {
        if (isset($this->wildcardPermissionsIndex[get_class($record)][$record->getKey()])) {
            return $this->wildcardPermissionsIndex[get_class($record)][$record->getKey()];
        }

        return $this->wildcardPermissionsIndex[get_class($record)][$record->getKey()]
            = app($record->getWildcardClass(), ['record' => $record])->getIndex();
    }


    /**
     * Clear class permissions.
     *
     * This is only intended to be called by the PermissionServiceProvider on boot,
     * so that long-running instances like Swoole don't keep old data in memory.
     */
    public function clearClassPermissions(): void
    {
        $this->permissions = null;
        $this->wildcardPermissionsIndex = [];
    }

    /**
     * Load permissions from cache
     *
     * This get cache and turns array into \Illuminate\Database\Eloquent\Collection
     */
    private function loadPermissions(): void
    {
        if ($this->permissions !== null){
            return;
        }

        $this->permissions = $this->cache->remember(self::$cacheKey, self::$cacheExpirationTime, function (){
            return $this->getPermissionClass()->select('id', 'uuid', 'name')
                ->with(['roles:id,name', 'users:id'])
                ->get();
        });

        if ($this->permissions->count() > 0){
            $this->cachedRoles = [];
        }
    }



    /**
     * Get the permissions based on the passed params.
     *
     * @param array $params
     * @param bool $onlyOne
     *
     * @return Collection
     */
    public function getPermissions(array $params = [], bool $onlyOne=false): Collection
    {
        $this->loadPermissions();

        $method = $onlyOne ? 'first' : 'filter';

        $permissions = $this->permissions->$method(static function($permission) use ($params) {
            foreach ($params as $attr=>$value){
                if ($permission->getAttribute($attr) != $value){
                    return false;
                }
            }

            return true;
        });

        if ($onlyOne) {
            $permissions = new Collection($permissions ? [$permissions] : []);
        }

        return $permissions;
    }

    /**
     * Get the permissions for the user
     *
     * @param Collection|\Illuminate\Support\Collection $roles
     * @param int $userId
     *
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getUserPermissions(Collection|\Illuminate\Support\Collection $roles, int $userId): Collection|\Illuminate\Support\Collection
    {
        $this->loadPermissions();

        return $this->permissions->filter( static function ($permission) use ($roles, $userId) {

            if ($permission->users->contains('id', $userId)){
                return true;
            }

            foreach ($permission->roles as $role){
                if ($roles->contains($role->name)){
                    return true;
                }
            }

            return false;
        })->pluck('name');
    }

    /**
     * Get an instance of the permission class.
     *
     * @return Permission
     */
    public function getPermissionClass(): Permission
    {
        return app(Permission::class);
    }

    /**
     * Get an instance of the role class.
     *
     * @return Role
     */
    public function getRoleClass(): Role
    {
        return app(Role::class);
    }

    /**
     * Get the instance of the Cache Store.
     *
     * @return Store
     */
    public function getCacheStore(): Store
    {
        return $this->cache->getStore();
    }

    /**
     * @return mixed
     */
    public static function getPermissionMappedToGroup(): mixed
    {
        $permissions =  Permission::select('id','uuid', 'name','permission_group')
            ->orderBy('name','asc')
            ->get();

       return $permissions->mapToGroups(function ($item, $key){
            return [$item->permission_group->value => $item ];
        });
    }


}
