<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // ID lokal Indonesia

        for ($i = 1; $i <= 5; $i++) { 
            DB::table('t_pelanggan')->insert([
                'nama_pelanggan'  => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'no_hp' => '08' . $faker->randomNumber(9, true), 
                'alamat' => $faker->address,
            ]);
        }
    }
}
