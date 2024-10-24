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
        $sections = Section::where('paper_code', $paper_code)
            ->with('diseaseArea') // Eager load the related disease area
            ->get();

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

            // Add each section with its label, disease_area_name, and questions as an object
            $result[] = [
                'paper_code' => $paper_code,
                'section_label' => $section->section_label,
                'disease_area_name' => $section->diseaseArea->name, // Fetch the disease area name
                'question_ids' => $questionIds->unique()->values(), // Ensure unique question IDs
            ];
        }

        // Return the structured result
        return response()->json($result);
    }



    public function viewPaper(Request $request)
    {

        $paperCode = $request->input('paperCode');

        // The code below won't execute if dd is used
        return Inertia::render('Section/Paper', [
            'paperCode' => $paperCode,
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
            'selectedQuestions' => 'required|array',
            'selectedDescriptions' => 'required|array',
        ]);

        // Step 1: Store the section data in the 'sections' table
        $section = Section::create([
            'cadre_id' => $validatedData['cadre_id'],
            'disease_area_id' => $validatedData['disease_area_id'],
            'section_label' => $validatedData['section_label'],
            'paper_code' => $validatedData['paper_code'],
            'number_of_questions' => $validatedData['number_of_questions'],
            'selected_descriptions' => implode(',', $validatedData['selectedDescriptions']),
            'selected_questions' => implode(',', $validatedData['selectedQuestions']),
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


    public function destroy($id)
    {
        try {
            $section = Section::findOrFail($id);
            $section->delete();

            return response()->json([
                'success' => true,
                'message' => 'Section deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete Section'
            ]);
        }
    }

    public function edit($id)
    {
        // Find the section by ID
        $section = Section::findOrFail($id);

        // Retrieve related data
        $cadres = Cadre::pluck('name', 'id');
        $diseaseAreas = DiseaseArea::pluck('name', 'id');

        // Return the inertia view with the section data and related options
        return inertia('Section/Edit', [
            'section' => $section,
            'cadres' => $cadres, 
            'diseaseAreas' => $diseaseAreas, 
        ]);
    }


}