<?php

// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            KategoriSeeder::class,
            BarangSeeder::class,
            SupplierSeeder::class,
            PembeliSeeder::class,
            TransaksiSeeder::class,
            DetailTransaksiSeeder::class,
            DiskonSeeder::class
        ]);
    }
}