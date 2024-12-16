<?php

namespace Database\Seeders;

// database/seeders/KategoriSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            ['nama_kategori' => 'Makanan'],
            ['nama_kategori' => 'Minuman'],
            ['nama_kategori' => 'Sembako'],
            ['nama_kategori' => 'Elektronik'],
            ['nama_kategori' => 'Lain-lain']
        ];

        DB::table('kategoris')->insert($kategoris);
    }
}
