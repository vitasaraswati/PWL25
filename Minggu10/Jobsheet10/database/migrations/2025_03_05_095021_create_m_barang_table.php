<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_barang', function (Blueprint $table) {
            $table->unsignedBigInteger('barang_id')->autoIncrement();
            $table->unsignedBigInteger('kategori_id')->index();
            $table->string('barang_kode', 20)->unique();
            $table->string('barang_nama', 100); // Pastikan kolom ini ada
            $table->integer('harga_beli', false, true); // harga beli dengan tipe integer
            $table->integer('harga_jual', false, true); // harga jual dengan tipe integer
            $table->timestamps();

            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_barang');
    }
};