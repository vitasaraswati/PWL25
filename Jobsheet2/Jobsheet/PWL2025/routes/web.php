<?php

use Illuminate\Support\Facades\Route;  // Mengimpor kelas Route untuk mendefinisikan rute
use App\Http\Controllers\ItemController; // Mengimpor ItemController untuk digunakan dalam rute

use App\Http\Controllers\WelcomeController; //Mengimpor WelcomeController untuk  mendefinisikan rute
use App\Http\Controllers\PageController; ///Mengimpor PageController untuk  mendefinisikan rute

use App\Http\Controllers\HomeController; //Mengimpor HomeController untuk  mendefinisikan rute
use App\Http\Controllers\AboutController; //Mengimpor AboutController untuk  mendefinisikan rute
use App\Http\Controllers\ArticleController; ///Mengimpor ArticleController untuk  mendefinisikan rute
use App\Http\Controllers\PhotoController; ///Mengimpor PhotoController untuk  mendefinisikan rute
//1.BASIC ROUTING

Route::get('/hello', function () {
    return 'Hello World';
});

Route::get('/world', function () {
    return 'World';
});

Route::get('/home', function () {
    return 'Selamat Datang';
});

// Route untuk "/about" menampilkan NIM dan Nama
Route::get(uri: '/about', action: function (): string {
    return 'NIM: 2341760082 - Nama: Vita Eka Saraswati';
});

//2. ROUTE PARAMETERS
//route name 
Route::get('/user/{name}', function ($name) {
    return 'Nama saya '.$name;
    });

//route lebih dari 1 parameter
Route::get('/posts/{post}/comments/{comment}', function
($postId, $commentId) {
 return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});


// Route untuk menampilkan daftar artikel
Route::get('/articles', function (): string {
    $articles = [
        1 => 'Artikel 1: Cara Belajar Laravel untuk Pemula',
        2 => 'Artikel 2: Panduan Dasar Routing di Laravel',
        3 => 'Artikel 3: Mengenal Blade Template di Laravel',
        4 => 'Artikel 4: Cara Menggunakan Controller dan Middleware',
        5 => 'Artikel 5: Database Migration dan Eloquent ORM'
    ];

    $output = "<h2>Daftar Artikel</h2><ul>";
    foreach ($articles as $id => $title) {
        $output .= "<li><a href='/articles/{$id}'>{$title}</a></li>";
    }
    $output .= "</ul>";

    return $output;
});

// Route untuk menampilkan artikel berdasarkan ID
Route::get(uri: '/articles/{id}', action: function ($id): string {
    $articles = [
        1 => 'Artikel 1: Cara Belajar Laravel untuk Pemula',
        2 => 'Artikel 2: Panduan Dasar Routing di Laravel',
        3 => 'Artikel 3: Mengenal Blade Template di Laravel',
        4 => 'Artikel 4: Cara Menggunakan Controller dan Middleware',
        5 => 'Artikel 5: Database Migration dan Eloquent ORM'
    ];

    if (array_key_exists(key: $id, array: $articles)) {
        return "Halaman Artikel dengan ID {$id} - " . $articles[$id];
    } else {
        return "Artikel dengan ID {$id} tidak ditemukan.";
    }
});



//3. OPTIONAL PARAMETERS
    //Memanggil route user sekaligus mengirimkan parameter berupa nama user
Route::get(uri: '/user/{name?}', action: function ($name=null): string {
    return 'Nama saya, '. $name;
});

//Memanggil route user sekaligus mengirimkan parameter berupa nama user yang nilai nya di set
Route::get(uri: '/user/{name?}', action: function ($name="John"): string {
    return 'Nama saya, '. $name;
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

Route::get('/hello', [WelcomeController::class,'hello']); //menambahkan controller pada route selelah definisi action 

//Controller untuk penambahan index, about, controller 
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'about']);
Route::get('/articles/{id}', [ArticleController::class, 'articles']);
Route::resource('photos', PhotoController::class);


//Membuat Routing untuk View 
Route::get('/greeting', [WelcomeController::class,
    'greeting']); 