<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUniqueConstraintOnTStokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_stok', function (Blueprint $table) {
            // Hapus constraint unik lama (barang_id, user_id, stok_tanggal)
            $table->dropUnique('unique_stok_combination');

            // Tambahkan constraint unik baru (hanya barang_id dan stok_tanggal)
            $table->unique(['barang_id', 'stok_tanggal'], 'unique_stok_barang_tanggal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_stok', function (Blueprint $table) {
            // Hapus constraint unik baru
            $table->dropUnique('unique_stok_barang_tanggal');

            // Kembalikan constraint unik lama
            $table->unique(['barang_id', 'user_id', 'stok_tanggal'], 'unique_stok_combination');
        });
    }
}