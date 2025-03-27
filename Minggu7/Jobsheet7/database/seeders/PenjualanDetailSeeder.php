<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                $data[] = [
                    'penjualan_id' => $i,
                    'barang_id' => $i,
                    'harga' => random_int(10000, 50000),
                    'jumlah' => random_int(1, 10),
                ];
            }
        }

        DB::table('t_penjualan_detail')->insert($data);
    }
}