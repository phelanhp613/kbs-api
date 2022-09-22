<?php

use App\Http\Controllers\JobCandidateController;
use Illuminate\Support\Facades\Route;

Route::post('/job-candidate', [JobCandidateController::class, 'create']);
Route::group(['prefix' => 'job-candidate', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/search', [JobCandidateController::class, 'list']);
});
