<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToTStokTable extends Migration
{
    public function up()
    {
        Schema::table('t_stok', function (Blueprint $table) {
            // Tambahkan constraint unik untuk kombinasi barang_id, user_id, dan stok_tanggal
            $table->unique(['barang_id', 'user_id', 'stok_tanggal'], 'unique_stok_combination');
        });
    }

    public function down()
    {
        Schema::table('t_stok', function (Blueprint $table) {
            // Hapus constraint unik jika migrasi dibatalkan
            $table->dropUnique('unique_stok_combination');
        });
    }
}