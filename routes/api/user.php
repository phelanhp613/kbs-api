<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
    Route::post('/search', [UserController::class, 'list'])->name('user.list');
    Route::get('/', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/', [UserController::class, 'create'])->name('user.create');
    Route::delete('/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');
});
