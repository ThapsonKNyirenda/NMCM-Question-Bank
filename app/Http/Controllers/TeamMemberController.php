<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamMemberStoreRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeamMemberController extends Controller
{

    public function __construct()
    {
        Inertia::share('activeMenu', 'Teams');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Team $team): Response
    {
        return Inertia::render('TeamMembers/Index',[
            'team' => $team->only('uuid', 'name'),
            'users' => User::select('id','uuid', 'name', 'email', 'photo', 'status')
                ->whereRelation('teams', 'name', $team->name)
                ->where( function (Builder $query) use ($request){
                    $query->whenSearchRequest($request);
                })->paginate(
                    $request->per_page
                ),
            'filters' => $request->only('search') ?? []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamMemberStoreRequest $request, Team $team): RedirectResponse
    {
        $team->users()->syncWithoutDetaching($request->users);

        return redirect()->back()->with('success', 'Successfully assigned member(s) to team');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team, User $user): RedirectResponse
    {
        $team->users()->detach([$user->id]);

        return redirect()->back()->with('success', 'Successfully removes a member from the team');
    }
}
