<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DetailTransaksiSeeder extends Seeder
{
    public function run()
    {
        $detailTransaksis = [
            [
                'transaksi_id' => 1,
                'barang_id' => 1,
                'jumlah_barang' => 2,
                'harga_jual' => 12000,
                'subtotal' => 24000,
                'tanggal_pembelian' => Carbon::now()->subDays(5)
            ],
            [
                'transaksi_id' => 1,
                'barang_id' => 3,
                'jumlah_barang' => 1,
                'harga_jual' => 10000,
                'subtotal' => 10000,
                'tanggal_pembelian' => Carbon::now()->subDays(5)
            ]
        ];

        DB::table('detail_transaksis')->insert($detailTransaksis);
    }
        public function show($id)
{
    // Cari transaksi berdasarkan id
    $transaksi = Transaksi::with(['pembeli', 'barang'])->findOrFail($id);

    return view('transaksi.show', compact('transaksi'));
}
    }
