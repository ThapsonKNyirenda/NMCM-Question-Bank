<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserPermissionRequest;
use App\Models\Permission;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserPermissionController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        Inertia::share('activeMenu','User Management');
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $user
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create(User $user): Response
    {
        return Inertia::render('UserPermission/Create',[
            'user' => $user->load('roles:id','permissions:id,uuid,name')->only(['id','uuid','name','roles','permissions']),
            'userRolePermissions' => Permission::select('name')->whereHas('roles', function($query) use($user){
                $query->whereIn('roles.id', $user->roles->pluck('id'));
            })->get(),
            'permissions' => PermissionService::getPermissionMappedToGroup()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserPermissionRequest $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function store(UpdateUserPermissionRequest $request, User $user): RedirectResponse
    {
        $user->syncPermissions(
            $request->input('permissions')
        );

        return redirect()
            ->back()
            ->with('success','Permissions successfully assigned to the user');
    }
}
