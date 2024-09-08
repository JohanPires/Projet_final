<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ExercicesController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'getUsers']);
    Route::get('/user/{id}', [UserController::class, 'getOneUser']);
    Route::post('/user', [UserController::class, 'postUser']);
    Route::put('/user/{id}', [UserController::class, 'editUser']);
    Route::delete('/user/{id}', [UserController::class, 'deleteUser']);

    Route::get('/training', [TrainingController::class, 'index']);
    Route::get('/training/{id}', [TrainingController::class, 'show']);
    Route::post('training', [TrainingController::class, 'store']);
    Route::put('/training/{id}', [TrainingController::class, 'update']);
    Route::delete('/training/{id}', [TrainingController::class, 'destroy']);
    Route::post('/attachExercice/{id}', [TrainingController::class, 'attachExercice']);


    Route::get('/exercices', [ExercicesController::class, 'index']);
    Route::get('/exercices/{id}', [ExercicesController::class, 'show']);
    Route::post('/exercices', [ExercicesController::class, 'store']);
    Route::put('/exercices/{id}', [ExercicesController::class, 'update']);
    Route::delete('/exercices/{id}', [ExercicesController::class, 'destroy']);
});



