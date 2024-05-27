<?php

namespace App\Http\Controllers;

use App\Enums\PermissionGroup;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response;

class PermissionController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        Inertia::share('activeMenu','User Management');
        $this->authorizeResource(Permission::class, 'permission');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Permission/Index',[
            'permissions' => Permission::select('id','uuid', 'name','description','permission_group')
                ->with('roles:uuid,name')
                ->search($request->input('search'))
                ->filterByPermissionGroup($request->input('permission_group'))
                ->filterByRole($request->input('role_id'))
                ->orderBy('name', 'desc')
                ->paginate($request->per_page)
                ->withQueryString(),
            'roles' => Role::all('id','name'),
            'permissionGroups' => PermissionGroup::array(),
            'filters' => $request->only(['search','permission_group','role_id','per_page']) ?? [],
        ]);
    }

    public function create(Request $request): Response{
        return Inertia::render('Permission/Create');
    }
}