<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceCategoryStoreRequest;
use App\Http\Requests\ServiceCategoryUpdateRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceCategoryController extends Controller
{
    public function __construct()
    {
         Inertia::share('activeMenu', 'Services');
         //$this->authorizeResource( ServiceCategory ::class, '');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Inertia::render('ServiceCategory/Index',[
            'serviceCategories' => ServiceCategory::whenSearch($request->input('search'), [])
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
        return Inertia::render('ServiceCategory/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(ServiceCategoryStoreRequest $request): RedirectResponse
    {
        ServiceCategory::create($request->validated());
        return redirect()->route('servicecategories.index')->with('success', ' successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceCategory $serviceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return Response
     */
    public function edit(ServiceCategory $servicecategory)
    {
        return Inertia::render('ServiceCategory/Edit', [
            // 'serviceCategory' => $serviceCategory,
            'serviceCategory' => $servicecategory->only('uuid', 'name', 'description')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceCategory  $serviceCategory
     * @return RedirectResponse
     */
    public function update(ServiceCategoryUpdateRequest $request, ServiceCategory $serviceCategory): RedirectResponse
    {
       $serviceCategory->update($request->validated());
       return redirect()->route('servicecategories.index')->with('success', ' successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCategory $servicecategory)
    {
        $servicecategory->delete();

        return redirect()->back()->with('success', 'Category successfully deleted');
    }
}
