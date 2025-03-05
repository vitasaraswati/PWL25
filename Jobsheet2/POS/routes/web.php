<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; //mendefinisikan route home 
use App\Http\Controllers\ProductController; //mendefinisikan route product 
use App\Http\Controllers\UserController; //mendefinisikan route user 
use App\Http\Controllers\SalesController; //mendefinisikan route sales 

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

//1. ROUTE HALAMAN HOME 
Route::get('/home', [HomeController::class, 'index']);

//2. ROUTE HALAMAN PRODUCT DGN PREFIX 
Route::prefix('/category')->group(function () {
    Route::get('/food-beverage', [ProductController::class, 'foodBeverage']);
    Route::get('/beauty-health', [ProductController::class, 'beautyHealth']);
    Route::get('/home-care', [ProductController::class, 'homeCare']);
    Route::get('/baby-kid', [ProductController::class, 'babyKid']);
});

//3. ROUTE USER 
Route::get('/user/{id}/name/{name}', [UserController::class, 'show']);


//4. ROUTE SALES/PENJUALAN 
Route::get('/sales', [SalesController::class, 'index']);

Route::get('', function () {
    return view('welcome');
});


