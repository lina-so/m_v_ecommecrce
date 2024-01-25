<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProfileController;

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

Route::get('/', function () {
    return view('auth.register-as');
})->name('register-as');

// Auth::routes(['verify' => true]);

// Route::get('user/profile',[ProfileController::class,'index'])->middleware(['auth','verified']);
Route::get('user/profile',[ProfileController::class,'index'])->middleware(['auth:web','verified']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


