<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//liste des routes pour le patient
Route::resource(
    '/patient',
    PatientController::class
);
//liste des routes pour le professionnel
Route::resource(
    '/professional',
    ProfessionalController::class
);
//liste des routes pour les événemenents (rendez-vous)
Route::resource(
    '/event',
    EventController::class
);