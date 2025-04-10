<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUniqueConstraintToBarangIdOnlyOnTStokTable extends Migration
{
    public function up()
    {
        Schema::table('t_stok', function (Blueprint $table) {
            // Hapus constraint unik lama (barang_id, stok_tanggal)
            $table->dropUnique('unique_stok_barang_tanggal');

            // Tambahkan constraint unik baru (hanya barang_id)
            $table->unique('barang_id', 'unique_stok_barang_id');
        });
    }

    public function down()
    {
        Schema::table('t_stok', function (Blueprint $table) {
            // Hapus constraint unik baru
            $table->dropUnique('unique_stok_barang_id');

            // Kembalikan constraint unik lama
            $table->unique(['barang_id', 'stok_tanggal'], 'unique_stok_barang_tanggal');
        });
    }
}