<?php

use Illuminate\Support\Facades\Route;


// routes/web.php
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index']);
