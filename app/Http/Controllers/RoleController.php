<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\PermissionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{

    public function __construct()
    {
        Inertia::share('activeMenu','User Management');
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Role/Index', [
            'roles' => Role::noneSuperUser()
                ->whenSearchRequest($request, ['name', 'description'])
                ->select('id', 'uuid','name','description')
                ->withCount('permissions')
                ->paginate($request->per_page)
                ->withQueryString(),
            'filters' => $request->only('search', 'per_page') ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Role/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $role = Role::create($request->validated());

        return redirect()
            ->route('roles.permissions.create', ['role'=>$role])
            ->with('success','Role successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return Response
     */
    public function show(Role $role)
    {
        return Inertia::render('Role/Show',[
            'permissions' => PermissionService::getPermissionMappedToGroup(),
            'role'=> $role->load('permissions:id,name')->only('id','name', 'permissions')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     *
     * @return Response
     */
    public function edit(Role $role): Response
    {
        return Inertia::render('Role/Edit', [
            'role'=>$role->only('uuid', 'name','description')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     *
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return redirect()->route('roles.index')->with('success','Role details successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
