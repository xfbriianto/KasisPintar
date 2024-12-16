<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        // Pastikan data pembeli dan barang sudah ada
        $pembeli = DB::table('pembelis')->first();
        $barang = DB::table('barangs')->first();

        if (!$pembeli || !$barang) {
            $this->command->warn('Harap seed pembeli dan barang terlebih dahulu');
            return;
        }

        DB::table('transaksis')->insert([
            'kode_transaksi' => 'T001',
            'pembeli_id' => $pembeli->id,
            'kode_barang' => $barang->kode_barang,
            'jumlah_barang' => 2,
            'total_harga' => 24000,
            'tanggal_transaksi' => Carbon::now(),
            'status' => 'selesai',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}