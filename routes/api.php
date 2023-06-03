<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\formations;
use App\Http\Controllers\connect_user;




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

Route::middleware(['cors'])->group(function () {  
    Route::post('/registeruser' , [authController::class , 'register']);
    Route::post('/connect_user' , [connect_user::class , 'connectMyUsers']);
    Route::post('/getformations' , [formations::class , 'getFormations']);
    Route::post('/insertFormation' , [formations::class , 'insertFormation']);
    Route::post('/getevaluation' , [formations::class , 'getEvaluation']);
    Route::post('/getprof' , [connect_user::class , 'getProf']);
    Route::post('/deleteprof' , [connect_user::class , 'deleteProf']);
    Route::post('/getusers' , [connect_user::class , 'getUsers']);
    Route::post('/deleteusers' , [connect_user::class , 'deleteUsers']);
    Route::post('/confirmprof' , [connect_user::class , 'confirmProf']);
    Route::post('/insertuser' , [connect_user::class , 'insertUser']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

