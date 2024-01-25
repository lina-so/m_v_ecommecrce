<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Brand\BrandController;
use App\Http\Controllers\Dashboard\Option\OptionController;
use App\Http\Controllers\Dashboard\Product\ProductController;
use App\Http\Controllers\Dashboard\Admin\AdminLoginController;
use App\Http\Controllers\Dashboard\Category\CategoryController;
use App\Http\Controllers\Dashboard\Admin\AdminRegisterController;

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



Route::group([
    'middleware'=>['admin'],
    'as' => 'dashboard.',
    'prefix' => 'admin/dashboard',
], function () {

    // Route::get('/dashboard',[DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    // Route::get('/login',[AdminLoginController::class,'login'])->name('admin.login');
    // Route::post('/login',[AdminLoginController::class,'checkLogin'])->name('admin.CheckLogin');

    // Route::get('/register',[AdminRegisterController::class,'register'])->name('admin.register');
    // Route::post('/register',[AdminRegisterController::class,'store'])->name('admin.store');

    Route::get('/categories/trash',[CategoryController::class,'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore',[CategoryController::class,'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/forceDelete',[CategoryController::class,'forceDelete'])->name('categories.forceDelete');
    Route::delete('/categories/deleteAll',[CategoryController::class,'deleteAll'])->name('categories.deleteAll');
    Route::get('/get-subcategories/{id}', [CategoryController::class, 'getSubcategories'])->name('getSubcategories');
    Route::get('/get-option-values/{optionId}', [OptionController::class, 'getOptionValues']);


    Route::get('/brands/trash',[BrandController::class,'trash'])->name('brands.trash');
    Route::put('/brands/{brand}/restore',[BrandController::class,'restore'])->name('brands.restore');
    Route::delete('/brands/{brand}/forceDelete',[BrandController::class,'forceDelete'])->name('brands.forceDelete');
    Route::delete('/brands/deleteAll',[BrandController::class,'deleteAll'])->name('brands.deleteAll');


    Route::get('/products/trash',[ProductController::class,'trash'])->name('products.trash');
    Route::put('/products/{brand}/restore',[ProductController::class,'restore'])->name('products.restore');
    Route::delete('/products/{brand}/forceDelete',[ProductController::class,'forceDelete'])->name('products.forceDelete');
    Route::delete('/products/deleteAll',[ProductController::class,'deleteAll'])->name('products.deleteAll');

    Route::get('/options/trash',[OptionController::class,'trash'])->name('options.trash');
    Route::put('/options/{option}/restore',[OptionController::class,'restore'])->name('options.restore');
    Route::delete('/options/{option}/forceDelete',[OptionController::class,'forceDelete'])->name('options.forceDelete');
    Route::delete('/options/deleteAll',[OptionController::class,'deleteAll'])->name('options.deleteAll');

    Route::resource('/categories', CategoryController::class);
    Route::resource('/brands', BrandController::class);

    Route::resource('/products', ProductController::class);

    Route::resource('/options', OptionController::class);

    // Route::resource('/orders', CategoryController::class);
    // Route::resource('/roles', RolesController::class);

});
