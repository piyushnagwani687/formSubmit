<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/users/data', [UserController::class, 'fetchUsers'])->name('users.fetch_users');
    Route::resource('/users', UserController::class);
});
