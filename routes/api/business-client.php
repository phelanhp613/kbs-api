<?php

use App\Http\Controllers\BusinessClientController;
use Illuminate\Support\Facades\Route;

Route::post('/business-client', [BusinessClientController::class, 'create']);
Route::group(['prefix' => 'business-client', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/search', [BusinessClientController::class, 'list']);
});
