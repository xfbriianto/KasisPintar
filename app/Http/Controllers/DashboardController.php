<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembeli;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama
     */
    public function index()
    {
        // Statistik Ringkas
        $statistik = $this->getStatistikRingkas();

        // Grafik Penjualan
        $grafikPenjualan = $this->getGrafikPenjualan();

        // Transaksi Terbaru
        $transaksiTerbaru = $this->getTransaksiTerbaru();

        // Stok Barang Rendah
        $stokRendah = $this->getStokBarangRendah();

        return view('dashboard.index', [
            'statistik' => $statistik,
            'grafikPenjualan' => $grafikPenjualan,
            'transaksiTerbaru' => $transaksiTerbaru,
            'stokRendah' => $stokRendah
        ]);
    }

    /**
     * Mendapatkan statistik ringkas
     */
    private function getStatistikRingkas()
    {
        return [
            'total_barang' => Barang::count(),
            'total_pembeli' => Pembeli::count(),
            'total_transaksi' => Transaksi::count(),
            'total_pendapatan' => Transaksi::sum('total_harga')
        ];
    }

    /**
     * Mendapatkan data grafik penjualan bulanan
     */
    private function getGrafikPenjualan()
    {
        $penjualan = Transaksi::select(
            DB::raw('MONTH(tanggal_transaksi) as bulan'),
            DB::raw('SUM(total_harga) as total_penjualan')
        )
        ->whereYear('tanggal_transaksi', Carbon::now()->year)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        $labels = [];
        $data = [];

        // Nama bulan dalam bahasa Indonesia
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        foreach ($penjualan as $item) {
            $labels[] = $namaBulan[$item->bulan];
            $data[] = $item->total_penjualan;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Mendapatkan transaksi terbaru
     */
    private function getTransaksiTerbaru()
    {
        return Transaksi::with(['pembeli', 'barangs'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Mendapatkan barang dengan stok rendah
     */
    private function getStokBarangRendah()
    {
        return Barang::where('stok', '<=', 10)
            ->orderBy('stok', 'asc')
            ->get();
    }

    /**
     * Menampilkan laporan penjualan
     */
    public function laporanPenjualan()
    {
        // Laporan penjualan bulanan
        $laporanPenjualan = Transaksi::select(
            DB::raw('MONTH(tanggal_transaksi) as bulan'),
            DB::raw('YEAR(tanggal_transaksi) as tahun'),
            DB::raw('COUNT(*) as jumlah_transaksi'),
            DB::raw('SUM(total_harga) as total_penjualan')
        )
        ->groupBy('bulan', 'tahun')
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan', 'desc')
        ->get();

        return view('dashboard.laporan-penjualan', [
            'laporanPenjualan' => $laporanPenjualan
        ]);
    }

    /**
     * Menampilkan grafik penjualan
     */
    public function grafikPenjualan()
    {
        $grafikPenjualan = $this->getGrafikPenjualan();

        return view('dashboard.grafik-penjualan', [
            'grafik' => $grafikPenjualan
        ]);
    }
}