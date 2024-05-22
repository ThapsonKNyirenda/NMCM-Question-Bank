<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Services\PermissionService;
use Illuminate\Cache\CacheManager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::updateOrCreate(
            [ 'name' => 'Super User', 'description' => 'Super user role'],
            [ 'description' => 'Super user role' ]
        );

        //Get all permissions for the system and add to the Super User role

        $permissions = Permission::pluck('id');

        $role->syncPermissions($permissions);

        app( PermissionService::class )->forgetCachedPermissions();

    }
}
