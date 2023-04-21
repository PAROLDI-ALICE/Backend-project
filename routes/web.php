<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("message", [MessageController::class, 'formMessageGoogle']);
Route::post("message", [MessageController::class, 'sendMessageGoogle'])->name('send.message.google');

//test message confirmation patient Axel
Route::post('/send-message', [MessageController::class, 'sendMessagePatient'])->name('sendMessage');
Route::get('send-mail', [MessageController::class, 'se']);