<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserCreated;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{

    public function __construct(private UserService $userService)
    {
        Inertia::share('activeMenu','User Management');
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('User/Index',[
            'users' => User::select('id','name','email','uuid', 'status', 'photo', 'last_login_at')
                ->whenSearch($request->input('search'), ['name','email', 'status'])
                ->whereStatus($request->input('status'))
                ->filterByRole($request->input('role_id'))
                ->with('roles:uuid,name')
                ->orderBy('name','asc')
                ->paginate($request->per_page)
                ->withQueryString(),
            'roles' => Role::select('id','name')->get(),
            'filters' => $request->only(['search','status','role_id','per_page']) ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('User/Create', [
            'roles' => Role::all('id','name')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = $this->userService->createUser($request);
        $user->syncRoles( $request->input('roles'));

        if ($request->send_notification){
            $user->notify( new UserCreated($user, $request->password) );
        }

        return redirect()->route('users.index')->with('success', 'User successfully created');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user): Response
    {
        return Inertia::render('User/Edit',[
            'user' => $user->load('roles:id')->only(['name','email', 'uuid', 'status','photo','photo_url','roles']),
            'roles' => Role::all('id','name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->userService->updateUser($request, $user);
        $user->syncRoles( $request->input('roles'));
        return redirect()->route('users.index')->with('success', 'User details successfully updated');
    }

}
