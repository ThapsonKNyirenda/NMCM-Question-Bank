<?php

namespace App\Http\Controllers;
use App\Http\Requests\ChannelStoreRequest;
use App\Http\Requests\ChannelUpdateRequest;
use App\Models\Channel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ChannelController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', 'Channel');
//        $this->authorizeResource( Channel ::class, 'channel');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Channel/Index',[
            'channels' => Channel::whenSearch($request->input('search'))
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
        return Inertia::render('Channel/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(ChannelStoreRequest $request): RedirectResponse
    {
        Channel::create($request->validated());
        return redirect()->route('channels.index')->with('success', 'Channel successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Channel $channel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Channel $channel
     * @return Response
     */
    public function edit(Channel $channel):response
    {
        return Inertia::render('Channel/Edit', [
            'channel' => $channel->only('uuid', 'name', 'description')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ChannelUpdateRequest $request
     * @param Channel $channel
     * @return RedirectResponse
     */
    public function update(ChannelUpdateRequest $request, Channel $channel): RedirectResponse
    {
       $channel->update($request->validated());
       return redirect()->route('channels.index')->with('success', ' successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Channel $channel)
    // {
    //     //
    // }
    public function destroy(Channel $channel): RedirectResponse
    {
        $channel->delete();

        return redirect()->back()->with('success', 'Channel successfully deleted');
    }
}
