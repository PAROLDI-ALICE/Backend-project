<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\StripeController;

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
Route::resource('/patients', PatientController::class);

//routes pour l'admin
Route::post('/admin', [AdminController::class, 'createAdmin']);

//liste des routes pour le professionnel
Route::resource('/professionals', ProfessionalController::class);
//Filtre pour afficher selon les besoins
Route::get("/filter/skills/{skill}", [ProfessionalController::class, 'filterSkills']);
//filtre pour afficher selon la ville
Route::get("/filter/city/{city}", [ProfessionalController::class, 'filterCity']);
//liste des routes pour les événemenents (rendez-vous)
Route::resource('/events', EventController::class);
/*
LOGIN/LOGOUT
*/
//routes pour s'authentifier 
Route::post('/login', [LoginController::class, 'login'])->name('login');
//route pour se déconnecter
Route::post('/logout', [LoginController::class, 'logout']);

/*
Réinitialisation du mdp
*/
//route POST pour demande de réinitialisation du password -> envoi de l'email
Route::post('/forgot', [PasswordController::class, 'forgotPassword'])->middleware('guest')->name('password.forgot');
//route GET pour le FORM de reset du password -> génération d'un nouveau mot de passe par le user 
Route::get('/reset/{token}', [PasswordController::class, 'resetPassword'])->middleware('guest')->name('password.reset');
//mise à jour du mdp dans la BDD
Route::post('/update', [PasswordController::class, 'updatePassword'])->middleware('guest')->name('password.update');
//mise à jour mdp réussie => on renvoie une vue

/*
STRIPE
*/
Route::post('/stripe', [StripeController::class, 'handleStripe'])->name('paiement.stripe');
