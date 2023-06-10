<?php

use App\Auth\SignInController;
use App\Auth\SignOutController;
use App\Auth\SignUpController;
use App\Domain\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::post('sign-out', [SignOutController::class, 'signOut'])->name('sign-out');
    Route::apiResource('users', UserController::class);
});

Route::post('signup', [SignUpController::class, 'signUp'])->name('signup');
Route::post('sign-in', [SignInController::class, 'signIn'])->name('sign-in');
