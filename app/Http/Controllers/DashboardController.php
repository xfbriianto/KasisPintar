<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User; // Jika Anda ingin menghitung total pengguna
use App\Models\Pembeli; // Model untuk pembeli
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil total pengguna
        $totalUsers = User::count();

        // Ambil total pembeli
        $totalPembeli = Pembeli::count(); // Hitung total pembeli dari model Pembeli

        // Ambil transaksi terbaru
        $recentTransactions = Transaksi::with('pembeli') // Mengambil transaksi dengan relasi pembeli
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('totalUsers', 'totalPembeli', 'recentTransactions'));
    }

    public function storeTransaction(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'kode_pembeli' => 'required',
            'nama_pembeli' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'kode_transaksi' => 'required',
            'jumlah_barang' => 'required|integer',
            'total_harga' => 'required|numeric',
        ]);

        // Cek apakah pembeli sudah ada, jika tidak, buat pembeli baru
        $pembeli = Pembeli::firstOrCreate(
            ['kode_pembeli' => $request->kode_pembeli], // Cek berdasarkan kode pembeli
            [
                'nama_pembeli' => $request->nama_pembeli,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
            ]
        );

        // Tambahkan transaksi
        Transaksi::create([
            'kode_transaksi' => $request->kode_transaksi,
            'jumlah_barang' => $request->jumlah_barang,
            'total_harga' => $request->total_harga,
            'tanggal_transaksi' => now(),
            'pembeli_id' => $pembeli->id, // Hubungkan transaksi dengan pembeli
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan.');
    }
}