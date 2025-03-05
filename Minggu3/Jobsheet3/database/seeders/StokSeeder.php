<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    public function run(): void
    {
        $stok = [];

        for ($i = 1; $i <= 15; $i++) {
            $stok[] = [
                'stok_id' => $i,
                'barang_id' => $i, // Pastikan barang_id ada di m_barang
                'user_id' => rand(1, 3),
                'stok_tanggal' => Carbon::now()->subDays(rand(1, 30))->toDateTimeString(),
                'jumlah' => rand(1, 50),
            ];
        }

        DB::table('t_stok')->insert($stok);
    }
}
