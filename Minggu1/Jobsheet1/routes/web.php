<?php

use Illuminate\Support\Facades\Route;  // Mengimpor kelas Route untuk mendefinisikan rute
use App\Http\Controllers\ItemController; // Mengimpor ItemController untuk digunakan dalam rute

Route::get('/hello', function () {
    return 'Hello World';
});

Route::get('/world', function () {
    return 'World';
});

Route::get('/home', function () {
    return 'Selamat Datang';
});

Route::get('/user/{name}', function ($name) {
    return 'Nama saya '.$name;
    });

    Route::get('/posts/{post}/comments/{comment}', function
($postId, $commentId) {
 return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});


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
