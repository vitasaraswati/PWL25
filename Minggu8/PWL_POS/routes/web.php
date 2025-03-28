<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

use App\Http\Controllers\LevelController; 
use App\Http\Controllers\KategoriController; 
use App\Http\Controllers\BarangController; 
use App\Http\Controllers\SupplierController; 
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\AuthController; 
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

//JOBSHEET 7 
//praktikum 1 - no 5 
Route::pattern('id', '[0-9]+');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
// Rute Autentikasi
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

//Route Register akun 
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister']);

Route::middleware(['auth'])->group(function () { //artinya semua route di dalam group ini harus login
    Route::get('/', [WelcomeController::class, 'index']);

    // Route Data User (khusus Admin)
    Route::middleware(['authorize:ADM'])->group(function(){
        Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']); // Halaman utama pengguna
        Route::post('/list', [UserController::class, 'list']); // Data untuk datatables
        Route::get('/create', [UserController::class, 'create']); // Form tambah pengguna
        Route::post('/', [UserController::class, 'store']); // Simpan pengguna baru
        Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Form tambah via Ajax
        Route::post('/ajax', [UserController::class, 'store_ajax']); // Simpan via Ajax
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Form edit via Ajax
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Update via Ajax
        Route::get('/{id}', [UserController::class, 'show']); // Detail pengguna
        Route::get('/{id}/edit', [UserController::class, 'edit']); // Form edit pengguna
        Route::put('/{id}', [UserController::class, 'update']); // Update pengguna
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Konfirmasi hapus Ajax
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Hapus via Ajax
        Route::delete('/{id}', [UserController::class, 'destroy']); // Hapus pengguna
        });
    });

    // Route Data Level User (Admin & Manajer)
    Route::middleware(['authorize:ADM'])->group(function(){
        Route::group(['prefix' => 'level'], function () {
        Route::get('/', [LevelController::class, 'index']); // Halaman utama level
        Route::post('/list', [LevelController::class, 'list']); // Data untuk datatables
        Route::get('/create', [LevelController::class, 'create']); // Form tambah level
        Route::post('/', [LevelController::class, 'store']); // Simpan level baru
        Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // Form tambah via Ajax
        Route::post('/ajax', [LevelController::class, 'store_ajax']); // Simpan via Ajax
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // Form edit via Ajax
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // Update via Ajax
        Route::get('/{id}', [LevelController::class, 'show']); // Detail level
        Route::get('/{id}/edit', [LevelController::class, 'edit']); // Form edit level
        Route::put('/{id}', [LevelController::class, 'update']); // Update level
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Konfirmasi hapus Ajax
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Hapus via Ajax
        Route::delete('/{id}', [LevelController::class, 'destroy']); // Hapus level
        });
    });

    // Route Data Kategori (Admin & Manajer)
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::group(['prefix' => 'kategori'], function () {
        Route::get('/', [KategoriController::class, 'index']); // Halaman utama kategori
        Route::post('/list', [KategoriController::class, 'list']); // Data untuk datatables
        Route::get('/create', [KategoriController::class, 'create']); // Form tambah kategori
        Route::post('/', [KategoriController::class, 'store']); // Simpan kategori baru
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // Form tambah via Ajax
        Route::post('/ajax', [KategoriController::class, 'store_ajax']); // Simpan via Ajax
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // Form edit via Ajax
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // Update via Ajax
        Route::get('/{id}', [KategoriController::class, 'show']); // Detail kategori
        Route::get('/{id}/edit', [KategoriController::class, 'edit']); // Form edit kategori
        Route::put('/{id}', [KategoriController::class, 'update']); // Update kategori
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // Konfirmasi hapus Ajax
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Hapus via Ajax
        Route::delete('/{id}', [KategoriController::class, 'destroy']); // Hapus kategori
        });
    });

    // Route Data Supplier (Admin & Manajer)
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', [SupplierController::class, 'index']); // Halaman utama supplier
        Route::post('/list', [SupplierController::class, 'list']); // Data untuk datatables
        Route::get('/create', [SupplierController::class, 'create']); // Form tambah supplier
        Route::post('/', [SupplierController::class, 'store']); // Simpan supplier baru
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Form tambah via Ajax
        Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Simpan via Ajax
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // Form edit via Ajax
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // Update via Ajax
        Route::get('/{id}', [SupplierController::class, 'show']); // Detail supplier
        Route::get('/{id}/edit', [SupplierController::class, 'edit']); // Form edit supplier
        Route::put('/{id}', [SupplierController::class, 'update']); // Update supplier
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Konfirmasi hapus Ajax
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Hapus via Ajax
        Route::delete('/{id}', [SupplierController::class, 'destroy']); // Hapus supplier
        });
    });

    // Route Data Barang (khusus staff)
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function(){
        Route::group(['prefix' => 'barang'], function () {
        Route::get('/barang', [BarangController::class, 'index']); // Halaman utama barang untuk staff
        Route::post('/barang/list', [BarangController::class, 'list']); // Data barang untuk staff
        Route::get('/barang/{id}', [BarangController::class, 'show']); // Detail barang untuk staff
        });
    });

    // Route Data Barang (Admin & Manajer)
    Route::middleware(['authorize:ADM,MNG'])->group(function(){
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang/list', [BarangController::class, 'list']);
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // ajax form create
        Route::post('/barang_ajax', [BarangController::class, 'store_ajax']); // ajax store
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // ajax form edit
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // ajax update
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // ajax delete
        
        Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
        Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
        });
    });