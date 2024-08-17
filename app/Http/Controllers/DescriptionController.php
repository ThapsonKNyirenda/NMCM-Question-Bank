<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Description;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Collection;

class DescriptionController extends Controller
{
    public function __construct()
    {
        //  Inertia::share('activeMenu', 'Category');
         //$this->authorizeResource( Category ::class, 'category');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // Eager load related models
        $descriptions = Description::with(['cadre', 'nursingProcess', 'diseaseArea', 'taxonomyLevel'])
                            ->paginate($request->get('per_page', 10));

    
        return inertia('Description/Index', [
            'descriptions' => $descriptions,
            'filters' => $request->only(['search', 'per_page']),
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store()
    {
        

       
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function edit()
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update()
    {
        
    }
      

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

    }
}