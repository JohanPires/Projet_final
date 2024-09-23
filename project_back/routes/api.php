<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ExercicesController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/user/picture/{id}', [UserController::class, 'storePicture']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'getUsers']);
    Route::get('/user/{id}', [UserController::class, 'getOneUser']);
    Route::put('/user/{id}', [UserController::class, 'editUser']);
    Route::delete('/user/{id}', [UserController::class, 'deleteUser']);
    Route::post('/logout', [UserController::class, 'logout']);


    Route::get('/training/{id}', [TrainingController::class, 'index']);
    Route::get('/training', [TrainingController::class, 'adminTrainings']);
    Route::get('/training/one/{id}', [TrainingController::class, 'show']);
    Route::post('/training', [TrainingController::class, 'store']);
    Route::put('/training/{id}', [TrainingController::class, 'update']);
    Route::delete('/training/{id}', [TrainingController::class, 'destroy']);
    Route::post('/attachExercice/{id}', [TrainingController::class, 'attachExercice']);


    Route::get('/exercices', [ExercicesController::class, 'index']);
    Route::get('/exercices/{id}', [ExercicesController::class, 'show']);
    Route::post('/exercices', [ExercicesController::class, 'store']);
    Route::put('/exercices/{id}', [ExercicesController::class, 'update']);
    Route::delete('/exercices/{id}', [ExercicesController::class, 'destroy']);
});
