<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua id pelanggan
        $pelangganIds = DB::table('t_pelanggan')->pluck('id_pelanggan');

        // Loop sesuai jumlah pelanggan, pairing 1:1
        foreach ($pelangganIds as $pelangganId) {
            DB::table('t_transaksi')->insert([
                'id_pelanggan'      => $pelangganId,
                'tanggal_transaksi' => $faker->dateTimeBetween('-1 year', 'now'),
                'total_transaksi'   => $faker->numberBetween(50000, 5000000),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }
    }
}
