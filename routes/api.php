<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::post('gettable', [ApiController::class, 'getTable']);
Route::post('addsheets', [ApiController::class, 'addSheets']);
Route::post('addstudents', [ApiController::class, 'addStudents']);
// Route::post('/update-sheet', [ApiController::class, 'updateSheetNames']);
