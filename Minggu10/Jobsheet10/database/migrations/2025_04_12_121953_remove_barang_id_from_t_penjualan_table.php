<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveBarangIdFromTPenjualanTable extends Migration
{
    public function up()
    {
        Schema::table('t_penjualan', function (Blueprint $table) {
            // Hapus kolom barang_id
            $table->dropColumn('barang_id');
        });
    }

    public function down()
    {
        Schema::table('t_penjualan', function (Blueprint $table) {
            // Tambahkan kembali kolom barang_id jika migrasi dibatalkan (rollback)
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->foreign('barang_id')->references('barang_id')->on('m_barang')->onDelete('restrict');
        });
    }
}