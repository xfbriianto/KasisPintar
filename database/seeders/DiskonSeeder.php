<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        // Hapus data sebelumnya (opsional)
        DB::table('diskons')->truncate();

        $diskons = [
            [ // Tambahkan nama diskon
                'tanggal_mulai' => Carbon::now()->subDays(30),
                'tanggal_selesai' => Carbon::now()->addDays(30),
                'keterangan' => 'Diskon untuk semua produk musim panas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tanggal_mulai' => Carbon::now()->subDays(15),
                'tanggal_selesai' => Carbon::now()->addDays(15),
                'keterangan' => 'Diskon besar-besaran akhir tahun',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tanggal_mulai' => Carbon::now()->subDays(7),
                'tanggal_selesai' => Carbon::now()->addDays(7),
                'keterangan' => 'Diskon untuk produk pilihan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('diskons')->insert($diskons);
    }
}