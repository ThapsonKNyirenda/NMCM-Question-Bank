<?php

namespace App\Traits;

use App\Services\PermissionService;

trait RefreshesPermissionCache
{
    /**
     *
     */
    public static function bootRefreshesPermissionCache()
    {
        static::saved(function () {
            app(PermissionService::class)->forgetCachedPermissions();
        });

        static::deleted(function () {
            app(PermissionService::class)->forgetCachedPermissions();
        });
    }
}
