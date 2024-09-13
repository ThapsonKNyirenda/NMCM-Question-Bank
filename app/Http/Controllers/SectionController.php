<?php

namespace App\Http\Controllers;
use App\Models\Cadre;
use App\Models\DiseaseArea;
use App\Models\Description;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SectionController extends Controller
{
    public function __construct()
     {
          Inertia::share('activeMenu', 'Paper Sections');
         //  $this->authorizeResource( Question ::class, '');
     }

     public function getQuestionsByPaperCode($paper_code)
     {
         // Find all sections by paper_code
         $sections = Section::where('paper_code', $paper_code)->get();
     
         if ($sections->isEmpty()) {
             return response()->json(['error' => 'No sections found'], 404);
         }
     
         // Initialize an empty array to hold the structured result
         $result = [];
     
         // Loop through the sections
         foreach ($sections as $section) {
             // Retrieve question_ids for each section
             $questionIds = DB::table('section_questions')
                             ->where('section_id', $section->id)
                             ->pluck('question_id');
     
             // Add each section with its label and questions as an object
             $result[] = [
                 'paper_code' => $paper_code,
                 'section_label' => $section->section_label,
                 'question_ids' => $questionIds->unique()->values(), // Ensure unique question IDs
             ];
         }
     
         // Return the structured result
         return response()->json($result);
     }

     
     public function viewPaper(Request $request)
     {
         // The data passed from the Inertia router will be in $request
         $sectionsData = $request->input('sectionsData');
         $paperCode = $request->input('paper_code');
     
         // You can now pass this data to the Inertia view
         return Inertia::render('Section/Paper', [
             'sectionsData' => $sectionsData,
             'paperCode' => $paperCode,
             'user' => Auth::user(),
         ]);
     }
     


     
     

    public function index(Request $request)
{
    // Eager load related models
    $sections = Section::with(['cadre', 'diseaseArea']) // Assuming relationships with cadre and diseaseArea
        ->paginate($request->get('per_page', 10));

    return inertia('Section/Index', [
        'sections' => $sections,
        'filters' => $request->only(['search', 'per_page']),
    ]);
}

    public function create()
{
    // Retrieving relationships
    $cadres = Cadre::pluck('name', 'id');
    $diseaseAreas = DiseaseArea::pluck('name', 'id');

    return inertia('Section/Create', [
        'cadres' => $cadres,
        'diseaseAreas' => $diseaseAreas,
    ]);
}

public function store(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'cadre_id' => 'required|integer',
        'disease_area_id' => 'required|integer',
        'section_label' => 'required|integer',
        'paper_code' => 'required|string',
        'number_of_questions' => 'required|integer',
        'selectedQuestions' => 'required|array', // Validate the selected questions
        'selectedDescriptions' => 'required|array', // Validate the selected descriptions
    ]);

    // Step 1: Store the section data in the 'sections' table
    $section = Section::create([
        'cadre_id' => $validatedData['cadre_id'],
        'disease_area_id' => $validatedData['disease_area_id'],
        'section_label' => $validatedData['section_label'],
        'paper_code' => $validatedData['paper_code'],
        'number_of_questions' => $validatedData['number_of_questions'],
    ]);

    // Step 2: Attach the selected questions to the section in the 'section_questions' table
    $section->questions()->attach($validatedData['selectedQuestions']); 

    // Step 3: Redirect back with a success message
    return redirect()->route('sections.index')->with('success', 'Section created and questions assigned successfully.');
}


public function getDescriptionsByDiseaseArea($diseaseAreaId)
{
    $descriptions = Description::where('disease_area_id', $diseaseAreaId)->pluck('description', 'id');
    return response()->json($descriptions);
}


}