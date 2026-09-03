<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodosController;


Route::post('/user', [UserController::class, 'store']);


Route::get('/todo', [TodosController::class, 'index']);
Route::post('/todo', [TodosController::class, 'store']);
Route::put('/todo/{id}', [TodosController::class, 'update']);
Route::delete('/todo/{id}', [TodosController::class, 'destroy']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
