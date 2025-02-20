<?php

use Illuminate\Support\Facades\Route;  // Mengimpor kelas Route untuk mendefinisikan rute
use App\Http\Controllers\ItemController; // Mengimpor ItemController untuk digunakan dalam rute

/*

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

Route::get('/', function () { // Mendefinisikan rute untuk halaman utama "/"
    return view('welcome'); // Menampilkan tampilan 'welcome'
});

Route::resource('items', ItemController::class); // Membuat rute resource untuk ItemController
