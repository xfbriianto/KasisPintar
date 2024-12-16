<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembeli;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total
        $totalBarang = Barang::count();
        $totalPembeli = Pembeli::count();
        $totalTransaksi = Transaksi::count();

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with('pembeli')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Grafik transaksi bulanan
        $transaksiPerBulan = Transaksi::select(
            DB::raw('MONTH(tanggal_transaksi) as bulan'),
            DB::raw('SUM(total_harga) as total_penjualan')
        )
        ->whereYear('tanggal_transaksi', Carbon::now()->year )
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        $bulanTransaksi = [];
        $nilaiTransaksi = [];

        foreach ($transaksiPerBulan as $transaksi) {
            $bulanTransaksi[] = $transaksi->bulan;
            $nilaiTransaksi[] = $transaksi->total_penjualan;
        }

        return view('dashboard', compact('totalBarang', 'totalPembeli', 'totalTransaksi', 'transaksiTerbaru', 'bulanTransaksi', 'nilaiTransaksi'));
    }
}