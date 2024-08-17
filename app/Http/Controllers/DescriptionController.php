<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
    public function index(Request $request): Response
    {
        return Inertia::render('Description/Index',[
            'categories' => Category::whenSearch($request->input('search'))
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
    public function create(): Response
    {
        return Inertia::render('Description/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return redirect()->route('categories.index')->with('success', 'Category successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function edit(Category $category): Response
    {
        return Inertia::render('Category/Edit', [
            'category' => $category->only('uuid', 'name', 'description')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
       $category->update($request->validated());
       return redirect()->route('categories.index')->with('success', 'Category successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->back()->with('success', 'Category successfully deleted');
    }
}