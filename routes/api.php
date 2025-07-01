<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenderController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('tenders')->group(function () {
    Route::post('/', [TenderController::class, 'actionStore']);
    Route::get('/', [TenderController::class, 'actionList']);
    Route::get('/{id}', [TenderController::class, 'actionShow']);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
