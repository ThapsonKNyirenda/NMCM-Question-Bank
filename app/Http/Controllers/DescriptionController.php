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
         Inertia::share('activeMenu', 'Questions');
         //$this->authorizeResource( Category ::class, 'category');
    }

    public function getDescriptionsByDiseaseArea($diseaseAreaId)
{
    $descriptions = Description::where('disease_area_id', $diseaseAreaId)->pluck('description', 'id');
    return response()->json($descriptions);
}


    public function updateStatus(Request $request)
    {
        // Validate the request data
        $request->validate([
            'ids' => 'required|array',
            'status' => 'required|string'
        ]);

        // Retrieve the selected descriptions and update their status
        Description::whereIn('id', $request->ids)->update(['status' => $request->status]);

        // Return a success response
        // return response()->json(['message' => 'Status updated successfully']);

        return redirect()->route('descriptions.index')->with('success', 'Successfully Submitted the questions');
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
        $descriptions = Description::where('status', 'saved')
        ->with(['diseaseArea'])
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
    
    $diseaseAreas = DiseaseArea::pluck('name', 'id');

    
    $questions = Question::where('description_id', $request->description_id)->get();

    return inertia('Description/Create', [ 
        'diseaseAreas' => $diseaseAreas,
        'questions' => $questions,
        'description_id' => $request->description_id, // Pass the description_id
    ]);
}

    
public function edit($id)
{
    $description = Description::findOrFail($id);
    $diseaseAreas = DiseaseArea::pluck('name', 'id');
    $questions = Question::where('description_id', $id)->get();
    
    
    return Inertia::render('Description/Edit', [
        'description' => $description,
        'diseaseAreas' => $diseaseAreas,
        'description_id' => $id,
        'questions' => $questions,
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
        // 'cadre_id' => $request->input('cadre'),
        'disease_area_id' => $request->input('disease_area'),
        'description' => $request->input('question_description'),
        'status'=>'saved',
    ]);

        return redirect()->route('descriptions.create', ['description_id' => $description->id])
                        ->with('success', 'Question Scenario added successfully. You can now add questions.');
}

    
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the description by ID
        $description = Description::find($id);

        // Check if the description exists
        if (!$description) {
            return response()->json(['error' => 'Description not found'], 404);
        }

        // Return the description data
        return response()->json($description);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Description $description
     * @return Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'disease_area' => 'required',
            'question_description' => 'required|string',
        ]);
    
        $description = Description::findOrFail($id);
        $description->update([
            'disease_area_id' => $request->disease_area,
            'description' => $request->question_description,
        ]);
    
        return redirect()->route('descriptions.edit', ['description' => $id])
                     ->with('success', 'Question scenario updated successfully');
    }
      

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $description = Description::findOrFail($id);
            $description->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Description deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete description'
            ]);
        }
    }
}