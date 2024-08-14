<?php

use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UsersController;
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

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('login', [UsersController::class, 'login'])->name('users.login');
//Route::get('register', [UsersController::class, 'register'])->name('users.register');
//Route::post('registerUser', [UsersController::class, 'registerUser'])->name('users.registerUser');
//Route::post('loginUser', [UsersController::class, 'loginUser'])->name('users.loginUser');
//Route::middleware('auth')->group(function () {
//    Route::get('/index', [\App\Http\Controllers\PostsController::class, 'index'])->name('posts.index');
//    Route::get('/message', [\App\Http\Controllers\UsersController::class, 'message'])->name('posts.showMessage');
//    Route::get('/getMessage', [\App\Http\Controllers\UsersController::class, 'getMessage'])->name('posts.getMessage');
//    Route::post('/createMessage', [\App\Http\Controllers\UsersController::class, 'createMessage'])->name('posts.createMessage');
//});
Route::get('/',[SubscriptionController::class, 'index'])->name('index');
Route::post('/createSubscription',[SubscriptionController::class, 'createSubscription'])->name('createSubscription');

