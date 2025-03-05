<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $penjualan = [];

        for ($i = 1; $i <= 15; $i++) {
            $penjualan[] = [
                'penjualan_id' => $i,
                'pembeli' => $faker->unique()->name(),
                'penjualan_kode' => $faker->unique()->word(),
                'penjualan_tanggal' => Carbon::now()->subDays(rand(1, 30))->toDateTimeString(),
                'user_id' => rand(1, 3),
                'barang_id' => rand(1, 10), // Pastikan barang_id ada dalam tabel m_barang
            ];
        }

        DB::table('t_penjualan')->insert($penjualan);
    }
}
