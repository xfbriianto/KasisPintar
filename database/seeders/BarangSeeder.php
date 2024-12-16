<?php

namespace Database\Seeders;

// database/seeders/BarangSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run()
    {
        $barangs = [
            [
                'kode_barang' => 'BR001', 
                'kategori_id' => 1, 
                'nama_barang' => 'Beras Premium', 
                'harga_jual' => 12000, 
                'harga_dasar' => 10000, 
                'stok' => 100, 
                'diskon' => 5,
                'tipe_barang' => 'Karung 25KG'
            ],
            [
                'kode_barang' => 'MG001', 
                'kategori_id' => 2, 
                'nama_barang' => 'Minyak Goreng', 
                'harga_jual' => 14000, 
                'harga_dasar' => 12000, 
                'stok' => 50, 
                'diskon' => 10,
                'tipe_barang' => 'Botol 1L'
            ],
            // Tambahkan barang lainnya sesuai kebutuhan
        ];

        DB::table('barangs')->insert($barangs);
    }
}
