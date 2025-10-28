<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index']);
Route::post('/create', [\App\Http\Controllers\DashboardController::class, 'create']);
Route::delete('/destroy/{id}', [\App\Http\Controllers\DashboardController::class, 'destroy']);
