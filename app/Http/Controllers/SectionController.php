<?php

namespace App\Http\Controllers;
use App\Models\Cadre;
use App\Models\DiseaseArea;
use Illuminate\Http\Request;

class SectionController extends Controller
{
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

}