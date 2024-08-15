<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', [UserController::class, 'login'])->name('user.login');
Route::get('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/createUser', [UserController::class, 'createUser'])->name('user.createUser');
Route::post('/loginUser', [UserController::class, 'loginUser'])->name('user.loginUser');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::middleware('auth')->group(function () {
    Route::get('/',[SubscriptionController::class, 'index'])->name('index');
    Route::post('/createSubscription',[SubscriptionController::class, 'createSubscription'])->name('createSubscription');
});


