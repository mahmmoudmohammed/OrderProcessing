<?php

use App\Http\Domains\Order\OrderController;
use App\Http\Domains\User\AuthController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| User routes
|--------------------------------------------------------------------------
|
| Authentication and resource actions.
|
*/

Route::name('user.logout')
    ->middleware(['auth:sanctum'])
    ->get('logout', [AuthController::class, 'logout'])
;

Route::name('user.')
    ->middleware('throttle:5,60')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
});
