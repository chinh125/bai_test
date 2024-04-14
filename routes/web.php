<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
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
    return view('welcome');
});
Route::get('/product',[ProductController::class,'show'])->name('home');
Route::match(['get','post'],'/product/store',[ProductController::class,'store'])->name('product-add');
Route::match(['get','post'],'/product/update/{id}',[ProductController::class,'edit'])->name('product-update');
Route::get('/delete/{id}',[ProductController::class,'delete'])->name('delete');
