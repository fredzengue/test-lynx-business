<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/events', 'App\Http\Controllers\EventController@index')->name('events.index');
Route::post('/event', 'App\Http\Controllers\EventController@store');
Route::patch('/event/{id}', 'App\Http\Controllers\EventController@update');
Route::post('/event/delete/{id}', 'App\Http\Controllers\EventController@destroy');
Route::post('/events/filter', 'App\Http\Controllers\EventController@filter');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia\Inertia::render('Dashboard');
    })->name('dashboard');
});