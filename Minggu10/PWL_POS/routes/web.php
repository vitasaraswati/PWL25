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
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Models\KategoriModel;

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
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/user/update-photo', [UserController::class, 'updatePhoto']);


    // Route Data User (khusus Admin)
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index']);              // Halaman utama pengguna
            Route::post('/list', [UserController::class, 'list']);          // Data untuk datatables
            // AJAX
            Route::get('/create_ajax', [UserController::class, 'create_ajax']);        // Form tambah via Ajax
            Route::post('/ajax', [UserController::class, 'store_ajax']);              // Simpan via Ajax
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);       // Form edit via Ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);   // Update via Ajax
            Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);       // Detail via Ajax
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);  // Konfirmasi hapus via Ajax
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Hapus via Ajax
            // Import & Export
            Route::get('import', [UserController::class, 'import']);            // Form upload excel
            Route::post('import_ajax', [UserController::class, 'import_ajax']);  // Import Excel via Ajax
            Route::get('export_excel', [UserController::class, 'export_excel']); // Export ke Excel
            Route::get('export_pdf', [UserController::class, 'export_pdf']);    // Export ke PDF

        });
    });

    // Route Data Level (Admin)
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::prefix('level')->group(function () {
            Route::get('/', [LevelController::class, 'index']);              // Halaman utama level
            Route::post('/list', [LevelController::class, 'list']);          // Data untuk datatables
            // AJAX
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']);        // Form tambah via Ajax
            Route::post('/ajax', [LevelController::class, 'store_ajax']);              // Simpan via Ajax
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);       // Form edit via Ajax
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);   // Update via Ajax
            Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);       // Detail via Ajax
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);  // Konfirmasi hapus via Ajax
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Hapus via Ajax
            // Import & Export
            Route::get('/import', [LevelController::class, 'import']);                  // Form upload excel
            Route::post('/import_ajax', [LevelController::class, 'import_ajax']);       // Import Excel via Ajax
            Route::get('/export_excel', [LevelController::class, 'export_excel']);      // Export ke Excel
            Route::get('/export_pdf', [LevelController::class, 'export_pdf']);          // Export ke PDF

        });
    });

    // Route Data Kategori (Admin & Manajer)
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index']);              // Halaman utama kategori
            Route::post('/list', [KategoriController::class, 'list']);          // Data untuk datatables
            // AJAX
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);        // Form tambah via Ajax
            Route::post('/ajax', [KategoriController::class, 'store_ajax']);              // Simpan via Ajax
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);       // Form edit via Ajax
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);   // Update via Ajax
            Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);       // Detail via Ajax
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);  // Konfirmasi hapus via Ajax
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Hapus via Ajax
            // Import & Export
            Route::get('import', [KategoriController::class, 'import']);            // Form upload excel
            Route::post('import_ajax', [KategoriController::class, 'import_ajax']);  // Import Excel via Ajax
            Route::get('export_excel', [KategoriController::class, 'export_excel']); // Export ke Excel
            Route::get('export_pdf', [KategoriController::class, 'export_pdf']);    // Export ke PDF

        });
    });

    // Route Data Barang (khusus staff, admin, dan manajer)
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index']);                // Menampilkan daftar barang
            Route::post('/list', [BarangController::class, 'list']);            // Data barang untuk DataTables
            Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']); // Detail barang via Ajax
            Route::get('/{id}', [BarangController::class, 'show']);             // Menampilkan detail barang
        });
    });

    // Route Data Barang (Admin & Manajer)
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'barang'], function () {
            Route::get('/', [BarangController::class, 'index']);                // Halaman utama barang
            Route::post('/list', [BarangController::class, 'list']);            // Data untuk DataTables
            //AJAX
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Form tambah barang via Ajax
            Route::post('/ajax', [BarangController::class, 'store_ajax']);      // Simpan barang baru via Ajax
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Form edit barang via Ajax
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Update barang via Ajax
            Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']); // Detail barang via Ajax
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Konfirmasi hapus barang via Ajax
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Hapus barang via Ajax
            // Import & Export
            Route::get('import', [BarangController::class, 'import']);         // Form upload excel
            Route::post('import_ajax', [BarangController::class, 'import_ajax']); // Import Excel via Ajax
            Route::get('export_excel', [BarangController::class, 'export_excel']); // Export ke Excel
            Route::get('export_pdf', [BarangController::class, 'export_pdf']);   // Export ke PDF
        });
    });

    // Route Data Supplier (Admin & Manajer)
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', [SupplierController::class, 'index']);              // Halaman utama supplier
            Route::post('/list', [SupplierController::class, 'list']);          // Data untuk datatables
            // AJAX
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);        // Form tambah via Ajax
            Route::post('/ajax', [SupplierController::class, 'store_ajax']);              // Simpan via Ajax
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);       // Form edit via Ajax
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);   // Update via Ajax
            Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);       // Detail via Ajax
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);  // Konfirmasi hapus via Ajax
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Hapus via Ajax
            // Import & Export
            Route::get('import', [SupplierController::class, 'import']);            // Form upload excel
            Route::post('import_ajax', [SupplierController::class, 'import_ajax']);  // Import Excel via Ajax
            Route::get('export_excel', [SupplierController::class, 'export_excel']); // Export ke Excel
            Route::get('export_pdf', [SupplierController::class, 'export_pdf']);    // Export ke PDF

        });
    });

    // Route Data Stok (Admin & Manajer)
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'stok'], function () {
            Route::get('/', [StokController::class, 'index']);                  // Halaman utama stok
            Route::post('/list', [StokController::class, 'list']);              // Data untuk DataTables
            //AJAX
            Route::get('/create_ajax', [StokController::class, 'create_ajax']); // Form tambah stok via AJAX
            Route::post('/ajax', [StokController::class, 'store_ajax']);        // Simpan stok via AJAX
            Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']); // Detail stok via AJAX
            Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']); // Form edit stok via AJAX
            Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']); // Update stok via AJAX
            Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); // Konfirmasi hapus stok via AJAX
            Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // Hapus stok via AJAX
            // Impor dan Ekspor
            Route::get('/import', [StokController::class, 'import']);          // Form upload Excel
            Route::post('/import_ajax', [StokController::class, 'import_ajax']); // Impor stok via AJAX
            Route::get('/export_excel', [StokController::class, 'export_excel']); // Ekspor ke Excel
            Route::get('/export_pdf', [StokController::class, 'export_pdf']);    // Ekspor ke PDF

        });
    });

    // Route Data Penjualan (Admin, Manajer, Staf)
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'penjualan'], function () {
            Route::get('/', [PenjualanController::class, 'index'])->name('penjualan.index');       // Halaman utama penjualan
            Route::post('/list', [PenjualanController::class, 'list'])->name('penjualan.list');    // Data untuk DataTables
            // AJAX
            Route::get('/create_ajax', [PenjualanController::class, 'create_ajax'])->name('penjualan.create_ajax'); // Form tambah penjualan via AJAX
            Route::post('/ajax', [PenjualanController::class, 'store_ajax'])->name('penjualan.store_ajax');        // Simpan penjualan via AJAX
            Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax'])->name('penjualan.show_ajax'); // Detail penjualan via AJAX
            Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax'])->name('penjualan.edit_ajax'); // Form edit penjualan via AJAX
            Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax'])->name('penjualan.update_ajax'); // Update penjualan via AJAX
            Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax'])->name('penjualan.delete_ajax'); // Konfirmasi hapus penjualan via AJAX
            Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax'])->name('penjualan.delete_ajax_post'); // Hapus penjualan via AJAX
            // Impor dan Ekspor
            Route::get('/import', [PenjualanController::class, 'import'])->name('penjualan.import');          // Form upload Excel
            Route::post('/import_ajax', [PenjualanController::class, 'import_ajax'])->name('penjualan.import_ajax'); // Impor penjualan via AJAX
            Route::get('/export_excel', [PenjualanController::class, 'export_excel'])->name('penjualan.export_excel'); // Ekspor ke Excel
            Route::get('/export_pdf', [PenjualanController::class, 'export_pdf'])->name('penjualan.export_pdf');    // Ekspor ke PDF
        });
    });
});