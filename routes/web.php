<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/todo', [TodoController::class, 'index']);
Route::get('/todo/{id}', [TodoController::class, 'getByStatus']);

Route::put('/appendTodo', [TodoController::class, 'put']);
Route::post('/', [TodoController::class, 'post']);
Route::delete('/', [TodoController::class, 'delete']);
