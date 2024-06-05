<?php

use App\Http\Controllers\API\ContactTagController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\CustomerTagController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// routes/api.php
use App\Http\Controllers\QuestionController;
Route::get('questions/count', [QuestionController::class, 'countByCadre']);



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