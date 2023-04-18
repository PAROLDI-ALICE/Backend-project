<?php

use App\Http\Controllers\LoginController;
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
    '/patients',
    PatientController::class
);
//liste des routes pour le professionnel
Route::resource(
    '/professionals',
    ProfessionalController::class
);
//Filtre pour afficher selon les besoins
Route::get("/filter/skills/{skill}", [ProfessionalController::class, 'filterSkills']);

//liste des routes pour les événemenents (rendez-vous)
Route::resource(
    '/events',
    EventController::class
);
//route pour s'authentifier 
Route::post('/login', [LoginController::class, 'login']);
//route pour se déconnecter
Route::post('/logout', [LoginController::class, 'logout']);