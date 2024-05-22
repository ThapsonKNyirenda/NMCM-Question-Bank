<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', 'Teams');
         $this->authorizeResource( Team ::class, 'team');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Team/Index',[
            'teams' => Team::select('uuid', 'email_alias', 'team_leader_id', 'name')
                ->with(['users:id,name,email', 'teamLeader:id,name'])
                ->whenSearch($request->input('search'))
                ->paginate($request->per_page)
                ->withQueryString(),
            'filters' => $request->only(['search', 'per_page']) ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Team/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeamStoreRequest $request
     * @return RedirectResponse
     */
    public function store(TeamStoreRequest $request): RedirectResponse
    {
        $team = Team::create($request->validated());
        $team->users()->attach([$request->team_leader_id]);

        return redirect()->route('teams.index')->with('success', 'Team successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Team $team
     *
     * @return Response
     */
    public function edit(Team $team): Response
    {
        return Inertia::render('Team/Edit', [
            'team' => $team->load('teamLeader:id,uuid')
                ->only('uuid','id', 'name', 'team_leader_id', 'email_alias', 'description','teamLeader')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TeamUpdateRequest $request
     * @param Team $team
     * @return RedirectResponse
     */
    public function update(TeamUpdateRequest $request, Team $team): RedirectResponse
    {
       $team->update($request->validated());

       return redirect()
           ->route('teams.index')
           ->with('success', 'Team successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team): RedirectResponse
    {
        $team->delete();

        return redirect()->back()->with('success', 'Category successfully deleted');
    }
}
