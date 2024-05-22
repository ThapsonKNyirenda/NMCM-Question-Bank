<?php

namespace App\Http\Middleware;

use App\Services\PermissionService;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        $userPermissions = collect([]);

        if($user){
            $roleNames = $user->roles->pluck('name');
            $userPermissions = app(PermissionService::class)->getUserPermissions($roleNames, $user->id);
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? $user->only('uuid','name','email','photo','photo_url', 'signature') : [],
                'roles' => $roleNames ?? [],
                'permissions' => $userPermissions,
                'can' => [
                    'view_user_management_tab' => $userPermissions->intersect(get_user_management_permissions())->count() > 0,
                    'view_customer_management_tab' => $userPermissions->intersect(get_customer_management_permissions())->count() > 0
                ],
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
                'info' => fn () => $request->session()->get('info')
            ]
        ];
    }
}
