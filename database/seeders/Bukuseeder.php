<?php

namespace Database\Seeders;

use App\Models\Buku;
use Illuminate\Database\Seeder;

class Bukuseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 10; $i++) {
            Buku::create([
                'judul' => $faker->sentence,
                'pengarang' => $faker->name,
                'tanggal_publikasi' => $faker->date
            ]);
        }
    }
}
