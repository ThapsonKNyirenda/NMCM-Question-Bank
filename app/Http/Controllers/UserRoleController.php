<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserPermissionRequest;
use App\Http\Requests\UserRoleRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class UserRoleController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(private PermissionService $permissionService){
        Inertia::share('activeMenu','User Management');
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $user
     *
     * @return Response
     */
    public function create(User $user): Response
    {
        Gate::authorize('assignRoles', Role::class);

        return Inertia::render('UserRole/Create',[
            'user' => $user->load('roles:id,name')->only(['id','uuid','name','roles']),
            'roles' => Role::select('name')->orderBy('name','asc')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRoleRequest $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function store(UserRoleRequest $request, User $user): RedirectResponse
    {
        $user->syncRoles( $request->input('roles') );

        $this->permissionService->forgetCachedPermissions();

        return redirect()
            ->back()
            ->with('success','Roles successfully assigned to the user');
    }


}
