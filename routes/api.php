<?php

use App\Http\Controllers\TenderController;
use Illuminate\Support\Facades\Route;

Route::prefix('tenders')->group(function () {
    Route::post('/', [TenderController::class, 'actionStore']);
    Route::get('/', [TenderController::class, 'actionList']);
    Route::get('/{id}', [TenderController::class, 'actionShow']);
});
