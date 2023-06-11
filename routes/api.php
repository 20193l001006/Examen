<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('pacientes', 'App\Http\Controllers\PacientesApiController@index');
Route::post('pacientes', 'App\Http\Controllers\PacientesApiController@store');
Route::put('pacientes/{id}', 'App\Http\Controllers\PacientesApiController@show');
Route::put('pacientes/{id}', 'App\Http\Controllers\PacientesApiController@update');
Route::delete('pacientes/{id}', 'App\Http\Controllers\PacientesApiController@destroy');