<?php

namespace App\Providers;

use App\Console\Commands\CacheReset;
use App\Models\Permission;
use App\Models\Role;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Permission as PermissionContract;
use App\Contracts\Role as RoleContract;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(PermissionService $permissionService)
    {
        $this->registerCommands();

        $this->registerModelBindings();

        $this->registerBladeDirectives();

        $permissionService->clearClassPermissions();
        $permissionService->registerPermissions();

        $this->app->singleton(PermissionService::class, function ($app) use ($permissionService) {
            return $permissionService;
        });
    }

    protected function registerCommands(): void
    {
        $this->commands([
            CacheReset::class,
        ]);
    }

    /**
     * register the service containers for permissions and role contracts/interface
     */
    protected function registerModelBindings(): void
    {
        $this->app->bind(PermissionContract::class, Permission::class);
        $this->app->bind(RoleContract::class, Role::class);
    }

    /**
     *
     */
    protected function registerBladeDirectives(): void
    {
        Blade::if('role', function($role){
            return Auth::user()->hasRole($role);
        });

        Blade::if('hasrole', function($role){
            return auth()->user()->hasRole($role);
        });

        Blade::if('hasanyrole', function($roles){
            return auth()->user()->hasAnyRole($roles);
        });

        Blade::if('hasallroles', function($roles){
            return  auth()->user()->hasAllRoles($roles);
        });

        Blade::if('unlessrole', function($role){
            return ! auth()->user()->hasRole($role);
        });

        Blade::if('hasexactroles', function($roles){
            return auth()->user()->hasExactRoles($roles);
        });

        Blade::if('issuperuser', function () {
            return auth()->user()->hasRole('Super User');
        });
    }
}
