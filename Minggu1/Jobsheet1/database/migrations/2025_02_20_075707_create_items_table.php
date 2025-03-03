<?php

use Illuminate\Database\Migrations\Migration; //mengimpor kelas Migration dari Laravel.
use Illuminate\Database\Schema\Blueprint; //mengimpor kelas Blueprint, yang digunakan untuk mendefinisikan struktur tabel dalam migration
use Illuminate\Support\Facades\Schema; //mengimpor Schema untuk berinteraksi dengan database

return new class extends Migration //Membuat migration dengan menggunakan Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //definisi fungsi up saat migration dijalankan
    {
        Schema::create('items', function (Blueprint $table) { //Membuat tabel baru dengan nama items 
            $table->id(); //membuat kolom id sbg primary key 
            $table->string('name'); // membuat kolom name dengan tipe data VARCHAR string 
            $table->text('description'); //membuat kolom description dengan tipe data TEXT
            $table->timestamps(); //menambahkan dua kolom otomatis: created_at dan updated_at untuk mencatat waktu pembuatan dan pembaruan data.

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items'); //menghapus tabel items jika ada.
    }
};
