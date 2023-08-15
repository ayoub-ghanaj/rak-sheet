<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HomeController;

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
// Route::middleware(['cors'])->group(function () {
Route::post('/app/students', [UserController::class, 'saveList'])
    ->name('staff.studentAdd');


Route::get('/result', [SearchController::class, 'search']);
// Route::get('/app/send', [UserController::class, 'sendshow'])
//     ->name('staff.home');



Route::get('/app/add', [UserController::class, 'addshow'])
    ->name('staff.add');

Route::get('/search', [UserController::class, 'lookup'])
    ->name('staff.lookup');

Route::get('/app/list/class_stats', [UserController::class, 'list_class_stats'])
    ->name('staff.class');

Route::get('/app/list/class', [UserController::class, 'list_class'])
    ->name('staff.class');

Route::get('/app/list', [UserController::class, 'list'])
    ->name('staff.list');

// Route::get('/app/account', [UserController::class, 'account'])
//     ->name('staff.account');

Route::get('/app/home', [UserController::class, 'index'])
    ->name('staff.home');
Route::get('/home', [UserController::class, 'index'])
    ->name('staff.home');
Route::get('/', [UserController::class, 'index'])
    ->name('staff.home');
Route::get('app/', [UserController::class, 'index'])
    ->name('staff.home');
    // ->middleware('auth:');

Route::get('app/login', [UserController::class, 'login'])
    ->name('staff.login');

Route::post('/app/delete_all', [UserController::class, 'dropdb'])
    ->name('staff.db_delete');

Route::post('app/login', [UserController::class, 'handleLogin'])
    ->name('staff.handleLogin');

Route::get('app/logout', [UserController::class, 'logout'])
    ->name('staff.logout');

Route::get('app/register', [UserController::class, 'create'])
    ->name('staff.register');

Route::post('app/register', [UserController::class, 'make'])
    ->name('staff.handlRegister');


Route::get('/app/subjects', [UserController::class, 'low_subs'])->name('low_subjects.index');
Route::get('/app/subjects/{id}/edit', [UserController::class, 'low_subs_ed_index'])->name('low_subjects.edit');
Route::put('/app/subjects/{id}', [UserController::class, 'low_subs_update'])->name('low_subjects.update');
Route::delete('/app/subjects/{id}', [UserController::class, 'low_subs_destroy'])->name('low_subjects.destroy');
Route::get('/app/subjects/add', [UserController::class, 'low_subs_ad_index'])->name('low_subjects.create');
Route::post('/app/subjects/create', [UserController::class, 'low_subs_add'])->name('low_subjects.create_put');
// Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/home', [HomeController::class, 'index'])->name('home');



