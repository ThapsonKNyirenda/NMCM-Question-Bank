<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceStoreRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', 'Services');
         //$this->authorizeResource( Service ::class, '');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Service/Index',[
            'services' => Service::whenSearch($request->input('search'), [])
                ->with('serviceCategory')
                ->paginate(8)
                ->withQueryString(),
            'filters' => $request->only(['search']) ?? []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $serviceCategory = ServiceCategory::all();

        return Inertia::render('Service/Create', [
            'servicecategories' => $serviceCategory,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(ServiceStoreRequest $request): RedirectResponse
    {
        Service::create($request->validated());
        return redirect()->route('services.index')->with('success', ' successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return Response
     */
    public function edit(Service $service)
    {
        return Inertia::render('Service/Edit', [
            'service' => $service
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return RedirectResponse
     */
    public function update(Request $request, Service $service)
    {
       $service->update($request->validated());
       return redirect()->route('.index')->with('success', ' successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}
