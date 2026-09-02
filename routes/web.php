<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodosController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/todo', [TodosController::class, 'index']);
Route::post('/user', [TodosController::class, 'storeUser']);
