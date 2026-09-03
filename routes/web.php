<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodosController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Route::post('/user', [UserController::class, 'store']);

// Route::get('/todo', [TodosController::class, 'index']);
// Route::post('/todo', [TodosController::class, 'store']);
// Route::put('/todo/{id}', [TodosController::class, 'update']);
// Route::delete('/todo/{id}', [TodosController::class, 'destroy']);
