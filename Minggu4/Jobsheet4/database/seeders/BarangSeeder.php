<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_barang')->insert([
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'BRG001',
                'barang_nama' => 'Samsung Smart TV',
                'harga_beli' => 3000000,
                'harga_jual' => 3500000
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'BRG002',
                'barang_nama' => 'Air Conditioner Sharp',
                'harga_beli' => 4000000,
                'harga_jual' => 4200000
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 1,
                'barang_kode' => 'BRG003',
                'barang_nama' => 'Hair Dryer Dyson',
                'harga_beli' => 4000000,
                'harga_jual' => 4500000
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode' => 'BRG004',
                'barang_nama' => 'Cardigan Rajut',
                'harga_beli' => 120000,
                'harga_jual' => 125000
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 2,
                'barang_kode' => 'BRG005',
                'barang_nama' => 'Jaket Polos',
                'harga_beli' => 150000,
                'harga_jual' => 155000
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 2,
                'barang_kode' => 'BRG006',
                'barang_nama' => 'Voal',
                'harga_beli' => 400000,
                'harga_jual' => 550000
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 3,
                'barang_kode' => 'BRG007',
                'barang_nama' => 'Sarden',
                'harga_beli' => 15000,
                'harga_jual' => 20000
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 3,
                'barang_kode' => 'BRG008',
                'barang_nama' => 'Selai Strawberry',
                'harga_beli' => 15000,
                'harga_jual' => 17000
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 3,
                'barang_kode' => 'BRG009',
                'barang_nama' => 'Mie Instan',
                'harga_beli' => 3500,
                'harga_jual' => 5000
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 4,
                'barang_kode' => 'BRG010',
                'barang_nama' => 'Air Mineral 1L',
                'harga_beli' => 5000,
                'harga_jual' => 8000
            ],
            [
                'barang_id' => 11,
                'kategori_id' => 4,
                'barang_kode' => 'BRG011',
                'barang_nama' => 'Kopi Aren', // ✅ Tambah koma di sini!
                'harga_beli' => 12000,
                'harga_jual' => 18000
            ],
            [
                'barang_id' => 12,
                'kategori_id' => 4,
                'barang_kode' => 'BRG012',
                'barang_nama' => 'Jasmine Tea', // ✅ Tambah koma di sini!
                'harga_beli' => 15000,
                'harga_jual' => 20000
            ],
            [
                'barang_id' => 13,
                'kategori_id' => 5,
                'barang_kode' => 'BRG013',
                'barang_nama' => 'Paracetamol 500mg',
                'harga_beli' => 2500,
                'harga_jual' => 5000
            ],
            [
                'barang_id' => 14,
                'kategori_id' => 5,
                'barang_kode' => 'BRG014',
                'barang_nama' => 'Vitamin C 1000mg',
                'harga_beli' => 10000,
                'harga_jual' => 15000
            ],
            [
                'barang_id' => 15,
                'kategori_id' => 5,
                'barang_kode' => 'BRG015',
                'barang_nama' => 'Antiseptik Cair 100ml',
                'harga_beli' => 18000,
                'harga_jual' => 25000
            ],
        ]);
    }
}
