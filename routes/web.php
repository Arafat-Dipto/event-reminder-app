<?php

use App\Http\Controllers\EventController;
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

Route::get('/', function () {
    return view('welcome');
});
// Route::apiResource('events', EventController::class);
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/event/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::get('/events/show/{id}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/{id}', [EventController::class, 'update'])->name('events.update');
Route::get('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
Route::post('event/list/import', [EventController::class, 'import'])->name('events.import');
