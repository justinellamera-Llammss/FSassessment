<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\TodoController;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Route::get('/todo', [TodoController::class, 'index']);
Route::get('/todo/{status}', [TodoController::class, 'getByStatus']);

Route::put('/todo/', [TodoController::class, 'put']);
Route::post('/todo/', [TodoController::class, 'post']);
Route::delete('/todo/', [TodoController::class, 'delete']);
