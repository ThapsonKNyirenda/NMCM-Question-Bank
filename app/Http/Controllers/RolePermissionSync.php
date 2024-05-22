<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolePermissionRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;

class RolePermissionSync extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param RolePermissionRequest $request
     * @param Role $role
     *
     * @return RedirectResponse
     */
    public function __invoke(RolePermissionRequest $request, Role $role): RedirectResponse
    {
        $role->syncPermissions( $request->input('permissions') );


        return redirect()
            ->back()
            ->with('success','permission(s) successfully assigned to the role');
    }
}
