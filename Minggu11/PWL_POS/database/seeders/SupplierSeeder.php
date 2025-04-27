<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data_supplier = [
            [
                'supplier_kode' => 'SP01',
                'supplier_nama' => 'PT Bina Makmur',
                'supplier_alamat' => 'Jl. Rafflesia 30 Surabaya',
                'created_at' => Carbon::now()
            ],
            [
                'supplier_kode' => 'SP02',
                'supplier_nama' => 'PT Adiguna Jaya Sentosa',
                'supplier_alamat' => 'Jl. Haji Abdul Muis No. 8, Surabaya',
                'created_at' => Carbon::now()
            ],
            [
                'supplier_kode' => 'SP03',
                'supplier_nama' => 'PT Wijaya Karya',
                'supplier_alamat' => 'Jl. M.T Haryono No. 1 Surabaya',
                'created_at' => Carbon::now()
            ],
        ];

        DB::table('m_supplier')->insert($data_supplier);
    }
}