<?php
namespace App\Http\Controllers;
use App\Http\Controllers\API\ContactTagController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\CustomerTagController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Question;
use App\Http\Controllers\DescriptionController;


// routes/api.php

// Route::get('questions/descriptions', [QuestionController::class, 'descriptionsByCadre']);

// Route::post('/questions', [QuestionController1::class, 'fetchQuestions']);


Route::get('/descriptions/{id}', [DescriptionController::class, 'show']);
Route::post('/descriptions/update-status', [DescriptionController::class, 'updateStatus'])->name('descriptions.update-status');
Route::post('/unvettedquestions/update-status', [UnvettedQuestionController::class, 'updateStatus'])->name('unvettedquestions.update-status');
Route::delete('/descriptions/{id}', [DescriptionController::class, 'destroy']);
Route::get('/descriptions/disease-area/{diseaseAreaId}', [DescriptionController::class, 'getDescriptionsByDiseaseArea']);
Route::get('/questions/{descriptionId}', [QuestionController::class, 'getQuestionsByDescriptionId']);
Route::get('/api/questions/cadre/{cadreId}', [QuestionController::class, 'getQuestionsByCadre']);
Route::get('/sections/questions/{paper_code}', [SectionController::class, 'getQuestionsByPaperCode']);
Route::get('/sections/paper/{paper_code}', [SectionController::class, 'paper'])->name('sections.paper');
Route::get('/paper', [SectionController::class, 'viewPaper'])->name('sections.view-paper');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::name('api.')->middleware('auth:sanctum')->group(function (){

    Route::apiResources([
        'customer-tags' => CustomerTagController::class,
        'customers' => CustomerController::class,
        'users' => UserController::class
    ]);

    Route::get('contact-tags', ContactTagController::class)->name('contact-tags.index');

});