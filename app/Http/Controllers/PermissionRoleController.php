<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response;

class PermissionRoleController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(private PermissionService $permissionService){
        View::share('activeMenu','Settings');
        $this->authorizeResource(Permission::class, 'permission');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Permission $permission
     *
     * @return Response
     */
    public function create(Request $request, Permission $permission): Response
    {
        return Inertia::render('PermissionRole/Create',[
            'permission' => $permission->load('roles:id,uuid,name')->loadCount('roles')->only(['id','uuid','name','roles','roles_count']),
            'roles' => Role::select('uuid','name')->orderBy('name','asc')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRoleRequest $request
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function store(UserRoleRequest $request, Permission $permission): RedirectResponse
    {
        $permission->syncRoles( $request->input('roles'));
        $this->permissionService->forgetCachedPermissions();

        return redirect()
            ->route('permissions.index')
            ->with('success','Roles successfully assigned to the permission');
    }

}
