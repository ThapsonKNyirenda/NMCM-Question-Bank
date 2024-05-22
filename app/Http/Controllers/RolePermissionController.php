<?php

namespace App\Http\Controllers;

use App\Enums\PermissionGroup;
use App\Http\Requests\RolePermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\PermissionService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class RolePermissionController extends Controller
{
    /**
     * {{ model }}Controller constructor.
     */
    public function __construct(private PermissionService $permissionService)
    {
        Inertia::share('activeMenu','User Management');
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Role $role
     * @return Response
     */
    public function create(Role $role): Response
    {
        $permissions = Permission::select('id','name','permission_group')->get();
        return Inertia::render('RolePermission/Create', [
            'role' => $role->load('permissions:id,name'),
            'permissionGroups' => $permissions->mapToGroups(
                function ($permission, $key){
                    return [$permission->permission_group->value => $permission];
                }
            )
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RolePermissionRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function store(RolePermissionRequest $request, Role $role): RedirectResponse
    {
        $role->syncPermissions($request->input('permissions'));

        $this->permissionService->forgetCachedPermissions();

        return redirect()->back()->with('success', "Permissions successfully assigned to the roles");
    }
}
