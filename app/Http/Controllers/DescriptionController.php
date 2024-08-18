<?php

namespace App\Http\Controllers;

use App\Http\Requests\DescriptionStoreRequest;
use App\Models\Description;
use App\Models\Cadre;
use App\Models\NursingProcess;
use App\Models\TaxonomyLevel;
use App\Models\DiseaseArea;
use App\Models\Question;
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
    public function create(Request $request)
{
    $cadres = Cadre::pluck('name', 'id');
    $nursingProcesses = NursingProcess::pluck('name', 'id');
    $diseaseAreas = DiseaseArea::pluck('name', 'id');
    $taxonomyLevels = TaxonomyLevel::pluck('name', 'id');
    
    $questions = Question::where('description_id', $request->description_id)->get();

    return inertia('Description/Create', [
        'cadres' => $cadres,
        'nursingProcesses' => $nursingProcesses,
        'diseaseAreas' => $diseaseAreas,
        'taxonomyLevels' => $taxonomyLevels,
        'questions' => $questions,
        'description_id' => $request->description_id, // Pass the description_id
    ]);
}

    




    /**
     * Store a newly created resource in storage.
     *
     * @param DescriptionStoreRequest $request
     * @return RedirectResponse
     */
    public function store(DescriptionStoreRequest $request): RedirectResponse
{
    $description = Description::create([
        'cadre_id' => $request->input('cadre'),
        'nursing_process_id' => $request->input('nursing_process'),
        'disease_area_id' => $request->input('disease_area'),
        'taxonomy_level_id' => $request->input('taxonomy'),
        'syllabus' => $request->input('syllabus'),
        'description' => $request->input('question_description'),
    ]);

    return redirect()->route('descriptions.create', ['description_id' => $description->id])
                     ->with('success', 'Question description added successfully. You can now add questions.');
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