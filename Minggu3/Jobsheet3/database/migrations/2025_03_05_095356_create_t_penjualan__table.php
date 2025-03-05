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
        Schema::create('t_penjualan', function (Blueprint $table) {
            $table->unsignedBigInteger('penjualan_id')->autoIncrement();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('barang_id')->index(); // Foreign key to m_barang
            $table->string('pembeli', 50);
            $table->string('penjualan_kode', 20);
            $table->date('penjualan_tanggal');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('m_user'); //Define foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_penjualan');
    }
};