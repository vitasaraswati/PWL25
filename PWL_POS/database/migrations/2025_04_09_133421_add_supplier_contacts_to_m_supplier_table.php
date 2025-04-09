<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('m_supplier', function (Blueprint $table) {
            $table->string('no_telp')->nullable()->after('supplier_alamat');
            $table->string('email')->nullable()->after('no_telp');
        });
    }

    public function down()
    {
        Schema::table('m_supplier', function (Blueprint $table) {
            $table->dropColumn('no_telp');
            $table->dropColumn('email');
        });
    }
};
